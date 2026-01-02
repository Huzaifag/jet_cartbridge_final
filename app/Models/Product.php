<?php

namespace App\Models;

use App\Models\Promotion;
use App\Models\Seller;
use App\Models\Salesman;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'manufacturer_id',
        'owner_type',
        'owner_id',
        'name',
        'slug',
        'description',
        'b2c_price',
        'b2c_compare_price',
        'b2b_price',
        'b2b_moq',
        'stock_quantity',
        'category',
        'brand',
        'model',
        'specifications',
        'images',
        'status',
        'is_featured',
        'rating',
        'verification_status',
        'category_id',
    ];

    protected $casts = [
        'specifications' => 'array',
        'images' => 'array',
        'b2c_price' => 'decimal:2',
        'b2c_compare_price' => 'decimal:2',
        'b2b_price' => 'decimal:2',
        'rating' => 'decimal:1',
    ];

    protected $with = ['category'];

    /**
     * Polymorphic relationship to the product owner (Seller, Manufacturer, or Salesman)
     */
    public function owner()
    {
        // Check if polymorphic columns exist
        if (Schema::hasColumn('products', 'owner_type') && Schema::hasColumn('products', 'owner_id')) {
            return $this->morphTo();
        }
        
        // Fallback to legacy relationships
        if ($this->seller_id) {
            return $this->seller();
        } elseif ($this->manufacturer_id) {
            return $this->manufacturer();
        }
        
        return null;
    }

    /**
     * Legacy relationship - kept for backward compatibility
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Legacy relationship - kept for backward compatibility
     */
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    /**
     * Get the actual owner model (Seller, Manufacturer, or Salesman)
     */
    public function getOwnerModelAttribute()
    {
        return $this->owner;
    }

    /**
     * Get the owner type in a human-readable format
     */
    public function getOwnerTypeNameAttribute()
    {
        switch ($this->owner_type) {
            case 'App\\Models\\Seller':
                return 'Seller';
            case 'App\\Models\\Manufacturer':
                return 'Manufacturer';
            case 'App\\Models\\Salesman':
                return 'Salesman';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get the owner's display name
     */
    public function getOwnerNameAttribute()
    {
        if (!$this->owner) {
            return 'Unknown Owner';
        }

        switch ($this->owner_type) {
            case 'App\\Models\\Seller':
                return $this->owner->company_name ?? $this->owner->name ?? 'Seller';
            case 'App\\Models\\Manufacturer':
                return $this->owner->company_name ?? $this->owner->name ?? 'Manufacturer';
            case 'App\\Models\\Salesman':
                return $this->owner->user->name ?? 'Salesman';
            default:
                return 'Unknown Owner';
        }
    }

    /**
     * Scope to filter products by owner type
     */
    public function scopeByOwnerType($query, $ownerType)
    {
        if (Schema::hasColumn('products', 'owner_type')) {
            return $query->where('owner_type', $ownerType);
        }
        
        // Fallback for legacy structure
        if ($ownerType === 'App\\Models\\Seller') {
            return $query->whereNotNull('seller_id');
        } elseif ($ownerType === 'App\\Models\\Manufacturer') {
            return $query->whereNotNull('manufacturer_id');
        }
        
        return $query->whereRaw('1 = 0');
    }

    /**
     * Scope to filter products by specific owner
     */
    public function scopeByOwner($query, $ownerType, $ownerId)
    {
        if (Schema::hasColumn('products', 'owner_type') && Schema::hasColumn('products', 'owner_id')) {
            return $query->where('owner_type', $ownerType)->where('owner_id', $ownerId);
        }
        
        // Fallback for legacy structure
        if ($ownerType === 'App\\Models\\Seller') {
            return $query->where('seller_id', $ownerId);
        } elseif ($ownerType === 'App\\Models\\Manufacturer') {
            return $query->where('manufacturer_id', $ownerId);
        }
        
        return $query->whereRaw('1 = 0');
    }

    /**
     * Scope to include products accessible by the provided owner (seller, salesman, manufacturer).
     * Seller <-> salesman share products; a salesman can see their seller's and sibling salesmen's products.
     */
    public function scopeAccessibleBy($query, array $owner)
    {
        // Check if polymorphic columns exist, if not fall back to legacy columns
        if (!Schema::hasColumn('products', 'owner_type') || !Schema::hasColumn('products', 'owner_id')) {
            return $this->scopeAccessibleByLegacy($query, $owner);
        }

        $ownerSets = [];

        if ($owner['role'] === 'seller') {
            $ownerSets[] = [
                'type' => Seller::class,
                'ids' => [$owner['model']->id],
            ];

            $salesmanIds = $owner['model']->salesmen()->pluck('id')->all();
            if (!empty($salesmanIds)) {
                $ownerSets[] = [
                    'type' => Salesman::class,
                    'ids' => $salesmanIds,
                ];
            }
        } elseif ($owner['role'] === 'salesman') {
            $ownerSets[] = [
                'type' => Salesman::class,
                'ids' => [$owner['model']->id],
            ];

            $sellerId = $owner['model']->seller_id;
            if ($sellerId) {
                $ownerSets[] = [
                    'type' => Seller::class,
                    'ids' => [$sellerId],
                ];
            }

            $peerSalesmanIds = $owner['model']->seller
                ? $owner['model']->seller->salesmen()->pluck('id')->all()
                : [];

            if (!empty($peerSalesmanIds)) {
                $ownerSets[] = [
                    'type' => Salesman::class,
                    'ids' => $peerSalesmanIds,
                ];
            }
        } else {
            $ownerSets[] = [
                'type' => $owner['type'],
                'ids' => [$owner['model']->id],
            ];
        }

        return $query->where(function ($q) use ($ownerSets) {
            foreach ($ownerSets as $set) {
                $q->orWhere(function ($qq) use ($set) {
                    $qq->where('owner_type', $set['type'])
                        ->whereIn('owner_id', $set['ids']);
                });
            }
        });
    }

    /**
     * Legacy version of scopeAccessibleBy for backward compatibility
     */
    public function scopeAccessibleByLegacy($query, array $owner)
    {
        if ($owner['role'] === 'seller') {
            return $query->where('seller_id', $owner['model']->id);
        } elseif ($owner['role'] === 'manufacturer') {
            return $query->where('manufacturer_id', $owner['model']->id);
        } elseif ($owner['role'] === 'salesman') {
            // For salesman, show products from their seller
            $sellerId = $owner['model']->seller_id ?? null;
            if ($sellerId) {
                return $query->where('seller_id', $sellerId);
            }
        }
        
        return $query->whereRaw('1 = 0'); // Return no results if no valid owner
    }

    public function getMainImageAttribute()
    {
        return $this->images[0] ?? 'default-product.jpg';
    }

    public function getImageUrlAttribute()
    {
        if (!empty($this->images) && is_array($this->images)) {
            return asset('storage/' . $this->images[0]);
        }
        return 'https://via.placeholder.com/300x200?text=Product';
    }

    public function getPriceAttribute()
    {
        // Return B2C price if available, otherwise B2B price
        return $this->b2c_price ?? $this->b2b_price;
    }

    public function getFormattedPriceAttribute()
    {
        if ($this->b2c_price) {
            return '$' . number_format($this->b2c_price, 2);
        } elseif ($this->b2b_price) {
            return '$' . number_format($this->b2b_price, 2) . ' (B2B)';
        }
        return 'Price on request';
    }

    public function activePromotion()
    {
        return $this
            ->hasOneThrough(
                Promotion::class,
                PromotionRule::class,
                'applicable_product_id',
                'id',
                'id',
                'promotion_id'
            )
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategory()
    {
        return Category::find($this->category_id) ?? 'No Category';
    }

    // public function promotions()
    // {
    //     return $this->belongsToMany(Promotion::class, 'promotion_product');
    // }
}
