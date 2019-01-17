<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Start
        $this->app->bind('App\RMS\Role\RoleRepositoryInterface','App\RMS\Role\RoleRepository');
        $this->app->bind('App\RMS\User\UserRepositoryInterface','App\RMS\User\UserRepository');
        $this->app->bind('App\RMS\Category\CategoryRepositoryInterface','App\RMS\Category\CategoryRepository');
        $this->app->bind('App\RMS\Item\ItemRepositoryInterface','App\RMS\Item\ItemRepository');
        $this->app->bind('App\RMS\Addon\AddonRepositoryInterface','App\RMS\Addon\AddonRepository');
        $this->app->bind('App\RMS\SetMenu\SetMenuRepositoryInterface','App\RMS\SetMenu\SetMenuRepository');
        $this->app->bind('App\RMS\MemberType\MemberTypeRepositoryInterface','App\RMS\MemberType\MemberTypeRepository');
        $this->app->bind('App\RMS\Member\MemberRepositoryInterface','App\RMS\Member\MemberRepository');
        $this->app->bind('App\RMS\Table\TableRepositoryInterface','App\RMS\Table\TableRepository');
        $this->app->bind('App\RMS\Room\RoomRepositoryInterface','App\RMS\Room\RoomRepository');
        $this->app->bind('App\RMS\Report\ReportRepositoryInterface','App\RMS\Report\ReportRepository');
        $this->app->bind('App\RMS\Config\ConfigRepositoryInterface','App\RMS\Config\ConfigRepository');
        $this->app->bind('App\RMS\Profile\ProfileRepositoryInterface','App\RMS\Profile\ProfileRepository');
        $this->app->bind('App\RMS\Promotion\PromotionRepositoryInterface','App\RMS\Promotion\PromotionRepository');
        $this->app->bind('App\RMS\Discount\DiscountRepositoryInterface','App\RMS\Discount\DiscountRepository');
        $this->app->bind('App\RMS\Kitchen\KitchenRepositoryInterface','App\RMS\Kitchen\KitchenRepository');
        $this->app->bind('App\RMS\Order\OrderRepositoryInterface','App\RMS\Order\OrderRepository');
        $this->app->bind('App\RMS\Invoice\InvoiceRepositoryInterface','App\RMS\Invoice\InvoiceRepository');
        $this->app->bind('App\RMS\SaleSummary\SaleSummaryRepositoryInterface','App\RMS\SaleSummary\SaleSummaryRepository');
        $this->app->bind('App\RMS\Sale\SaleRepositoryInterface','App\RMS\Sale\SaleRepository');
        $this->app->bind('App\RMS\CategorySaleSummary\CategorySaleSummaryRepositoryInterface','App\RMS\CategorySaleSummary\CategorySaleSummaryRepository');
        $this->app->bind('App\RMS\SetKitchen\SetKitchenRepositoryInterface','App\RMS\SetKitchen\SetKitchenRepository');
        $this->app->bind('App\RMS\Orderdetail\OrderdetailRepositoryInterface','App\RMS\Orderdetail\OrderdetailRepository');
        $this->app->bind('App\RMS\Location\LocationRepositoryInterface','App\RMS\Location\LocationRepository');
        $this->app->bind('App\RMS\Module\ModuleRepositoryInterface','App\RMS\Module\ModuleRepository');
        $this->app->bind('App\RMS\Booking\BookingRepositoryInterface','App\RMS\Booking\BookingRepository');
        $this->app->bind('App\RMS\Pricehistory\PriceLogRepositoryInterface','App\RMS\Pricehistory\PriceLogRepository');
        $this->app->bind('App\RMS\Transactiontender\TenderRepositoryInterface','App\RMS\Transactiontender\TenderRepository');
        $this->app->bind('App\RMS\DayStart\DayStartRepositoryInterface','App\RMS\DayStart\DayStartRepository');
        $this->app->bind('App\RMS\Shift\ShiftRepositoryInterface','App\RMS\Shift\ShiftRepository');
        $this->app->bind('App\RMS\InvoiceBackend\InvoiceBackendRepositoryInterface','App\RMS\InvoiceBackend\InvoiceBackendRepository');

        $this->app->bind('App\RMS\Remark\RemarkRepositoryInterface','App\RMS\Remark\RemarkRepository');

        $this->app->bind('App\RMS\Item_Remark\RemarkRepositoryInterface','App\RMS\Item_Remark\Item_RemarkRepository');

        $this->app->bind('App\RMS\Continent\ContinentRepositoryInterface','App\RMS\Continent\ContinentRepository');


        $this->app->bind('App\RMS\Reports_update\Invoice\InvoiceRepositoryInterface','App\RMS\Reports_update\Invoice\InvoiceRepository');

        $this->app->bind('App\RMS\Reports_update\BestSellingItem\BestSellingItemRepositoryInterface','App\RMS\Reports_update\BestSellingItem\BestSellingItemRepository');

        $this->app->bind('App\RMS\Reports_update\BestSellingCategory\BestSellingCategoryRepositoryInterface','App\RMS\Reports_update\BestSellingCategory\BestSellingCategoryRepository');

        $this->app->bind('App\RMS\Reports_update\BestSellingSet\BestSellingSetRepositoryInterface','App\RMS\Reports_update\BestSellingSet\BestSellingSetRepository');

        //End
    }
}
