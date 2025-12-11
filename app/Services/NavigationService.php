<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class NavigationService
{
    public static function getNavigationItems()
    {
        $user = Auth::user();
        $navigation = [];

        // Always show dashboard
        $navigation[] = [
            'title' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'fas fa-home',
            'active' => request()->routeIs('admin.dashboard')
        ];

        // Role-based navigation
        if ($user->seller) {
            $navigation = array_merge($navigation, self::getSellerNavigation());
        }

        if ($user->accountant) {
            $navigation = array_merge($navigation, self::getAccountantNavigation());
        }

        if ($user->manufacturer) {
            $navigation = array_merge($navigation, self::getManufacturerNavigation());
        }

        if ($user->salesman) {
            $navigation = array_merge($navigation, self::getSalesmanNavigation());
        }

        if ($user->warehouse) {
            $navigation = array_merge($navigation, self::getWarehouseNavigation());
        }

        if ($user->deliveryman) {
            $navigation = array_merge($navigation, self::getDeliverymanNavigation());
        }

        // Common items for all roles
        $navigation = array_merge($navigation, self::getCommonNavigation());

        return $navigation;
    }

    private static function getSellerNavigation()
    {
        return [
            [
                'title' => 'Products',
                'route' => 'seller.products.index',
                'icon' => 'fas fa-box',
                'active' => request()->routeIs('seller.products.*')
            ],
            [
                'title' => 'Categories',
                'route' => 'seller.categories.index',
                'icon' => 'fas fa-tags',
                'active' => request()->routeIs('seller.categories.*')
            ],
            [
                'title' => 'Employees',
                'icon' => 'fas fa-users',
                'submenu' => [
                    [
                        'title' => 'Accountant',
                        'route' => 'seller.employees.accountant.index',
                        'icon' => 'fas fa-calculator',
                        'active' => request()->routeIs('seller.employees.accountant.*')
                    ],
                    [
                        'title' => 'Salesman',
                        'route' => 'seller.employees.salesman.index',
                        'icon' => 'fas fa-handshake',
                        'active' => request()->routeIs('seller.employees.salesman.*')
                    ],
                    [
                        'title' => 'Warehouse',
                        'route' => 'seller.employees.warehouse.index',
                        'icon' => 'fas fa-warehouse',
                        'active' => request()->routeIs('seller.employees.warehouse.*')
                    ],
                    [
                        'title' => 'Delivery Man',
                        'route' => 'seller.employees.delivery.index',
                        'icon' => 'fas fa-truck',
                        'active' => request()->routeIs('seller.employees.delivery.*')
                    ]
                ]
            ],
            [
                'title' => 'Orders',
                'route' => 'seller.orders.index',
                'icon' => 'fas fa-shopping-cart',
                'active' => request()->routeIs('seller.orders.*')
            ],
            [
                'title' => 'B2B Inquiries',
                'route' => 'seller.inquiries.index',
                'icon' => 'fas fa-comments',
                'active' => request()->routeIs('seller.inquiries.*')
            ],
            [
                'title' => 'Analytics',
                'route' => 'seller.analytics.index',
                'icon' => 'fas fa-chart-line',
                'active' => request()->routeIs('seller.analytics.*')
            ],
            [
                'title' => 'Promotions',
                'route' => 'seller.promotions.index',
                'icon' => 'fas fa-percentage',
                'active' => request()->routeIs('seller.promotions.*')
            ]
        ];
    }

    private static function getAccountantNavigation()
    {
        return [
            [
                'title' => 'Orders & Invoices',
                'route' => 'accountant.orders.index',
                'icon' => 'fas fa-file-invoice',
                'active' => request()->routeIs('accountant.orders.*')
            ],
            [
                'title' => 'Financial Reports',
                'route' => 'accountant.reports.index',
                'icon' => 'fas fa-chart-bar',
                'active' => request()->routeIs('accountant.reports.*')
            ]
        ];
    }

    private static function getManufacturerNavigation()
    {
        return [
            [
                'title' => 'Products',
                'route' => 'manufacturer.products.index',
                'icon' => 'fas fa-industry',
                'active' => request()->routeIs('manufacturer.products.*')
            ],
            [
                'title' => 'Categories',
                'route' => 'manufacturer.categories.index',
                'icon' => 'fas fa-tags',
                'active' => request()->routeIs('manufacturer.categories.*')
            ],
            [
                'title' => 'Orders',
                'route' => 'manufacturer.orders.index',
                'icon' => 'fas fa-shopping-cart',
                'active' => request()->routeIs('manufacturer.orders.*')
            ],
            [
                'title' => 'Bulk Orders',
                'route' => 'manufacturer.bulk-orders.index',
                'icon' => 'fas fa-boxes',
                'active' => request()->routeIs('manufacturer.bulk-orders.*')
            ]
        ];
    }

    private static function getSalesmanNavigation()
    {
        return [
            [
                'title' => 'Leads',
                'route' => 'salesman.leads.index',
                'icon' => 'fas fa-user-plus',
                'active' => request()->routeIs('salesman.leads.*')
            ],
            [
                'title' => 'Customers',
                'route' => 'salesman.customers.index',
                'icon' => 'fas fa-users',
                'active' => request()->routeIs('salesman.customers.*')
            ]
        ];
    }

    private static function getWarehouseNavigation()
    {
        return [
            [
                'title' => 'Inventory',
                'route' => 'warehouse.inventory.index',
                'icon' => 'fas fa-boxes',
                'active' => request()->routeIs('warehouse.inventory.*')
            ],
            [
                'title' => 'Shipments',
                'route' => 'warehouse.shipments.index',
                'icon' => 'fas fa-shipping-fast',
                'active' => request()->routeIs('warehouse.shipments.*')
            ]
        ];
    }

    private static function getDeliverymanNavigation()
    {
        return [
            [
                'title' => 'Deliveries',
                'route' => 'deliveryman.deliveries.index',
                'icon' => 'fas fa-truck',
                'active' => request()->routeIs('deliveryman.deliveries.*')
            ],
            [
                'title' => 'Route Planning',
                'route' => 'deliveryman.routes.index',
                'icon' => 'fas fa-route',
                'active' => request()->routeIs('deliveryman.routes.*')
            ]
        ];
    }

    private static function getCommonNavigation()
    {
        return [
            [
                'title' => 'Messages',
                'route' => 'admin.messages.index',
                'icon' => 'fas fa-envelope',
                'active' => request()->routeIs('admin.messages.*')
            ],
            [
                'title' => 'Settings',
                'route' => 'admin.settings.index',
                'icon' => 'fas fa-cog',
                'active' => request()->routeIs('admin.settings.*')
            ]
        ];
    }
}