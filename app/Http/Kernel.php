<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
        ],


        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'custom' => \App\Http\Middleware\CustomMiddleware::class,
        'dashboard'=>\App\Http\Middleware\DashboardMiddleware::class,
        'apiguard' => \Chrisbjr\ApiGuard\Http\Middleware\ApiGuard::class,
        'staff' =>\App\Http\Middleware\StaffMiddleware::class,
        'staffType' =>\App\Http\Middleware\StaffTypeMiddleware::class,
        'category' =>\App\Http\Middleware\CategoryMiddleware::class,
        'item' =>\App\Http\Middleware\ItemMiddleware::class,
        'addon'=>\App\Http\Middleware\AddonMiddleware::class,
        'discount'=>\App\Http\Middleware\DiscountMiddleware::class,
        'setMenu'=>\App\Http\Middleware\SetMenuMiddleware::class,
        'memberType'=>\App\Http\Middleware\MemberTypeMiddleware::class,
        'member'=>\App\Http\Middleware\MemberMiddleware::class,
        'table'=>\App\Http\Middleware\TableMiddleware::class,
        'room'=>\App\Http\Middleware\RoomMiddleware::class,
        'booking'=>\App\Http\Middleware\BookingMiddleware::class,
        'generalSetting'=>\App\Http\Middleware\GeneralSettingMiddleware::class,
        'report'=>\App\Http\Middleware\ReportMiddleware::class,
        'promotion'=>\App\Http\Middleware\PromotionMiddleware::class,
        'orderList'=>\App\Http\Middleware\OrderListMiddleware::class,
        'kitchen'=>\App\Http\Middleware\KitchenMiddleware::class,
        'profile'=>\App\Http\Middleware\ProfileMiddleware::class,
        'log'=>\App\Http\Middleware\LogMiddleware::class,
        'shift'=>\App\Http\Middleware\ShiftMiddleware::class,
        'order'=>\App\Http\Middleware\OrderMiddleware::class,
        'remark'=>\App\Http\Middleware\RemarkMiddleware::class,

        'best_item'=>\App\Http\Middleware\BestSellingItemReportMiddleware::class,
        'best_category'=>\App\Http\Middleware\BestSellingCategoryReport::class,
        'best_set'=>\App\Http\Middleware\BestSellingSetReport::class,
        'table_report'=>\App\Http\Middleware\ReportByTable::class,
        'invoice_cancel_report'=>\App\Http\Middleware\invoice_cancel::class,
        
    ];
}
