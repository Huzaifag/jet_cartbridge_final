<?php

namespace App\Models;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
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

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    // public function creator()
    // {
    //     return $this->belongsTo(Employee::class, 'created_by');
    // }

    public function getMainImageAttribute()
    {
        return $this->images[0] ?? 'default-product.jpg';
    }

    public function activePromotion()
    {
        return $this->hasOneThrough(
            Promotion::class,
            PromotionRule::class,
            'applicable_product_id',
            'id',
            'id',
            'promotion_id'
        )->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategory()
    {
        return Category::find( $this->category_id ) ?? 'No Category';
    }

    // public function promotions()
    // {
    //     return $this->belongsToMany(Promotion::class, 'promotion_product');
    // }
}
