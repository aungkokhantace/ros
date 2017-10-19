<?php

Route::get('master',function() {

    return view('cashier.layouts.master');
});
Route::get('logo', 'headerController@logo');
Route::group(['middleware' => 'web'], function () {
    Route::get('/', function () {
        if (Auth::guard('Cashier')->user())
        {
            return redirect()->action('Cashier\DashboardController@dashboard');
        }else{
            return view('cashier.auth.login');
        }
    });
    Route::get('login', 'Cashier\Auth\AuthController@getLoginForm');
    Route::post('login', 'Cashier\Auth\AuthController@postDataForCashierLogin');

    Route::group(['prefix' => 'Cashier'], function(){
        Route::get('logout', 'Cashier\Auth\AuthController@logout');

        Route::group(['middleware' => 'custom:Cashier'], function(){
            Route::get('logout', 'Cashier\Auth\AuthController@logout');
            Route::get('userAuth', 'Cashier\Staff\UserController@getAuthUser');
            Route::get('updateDataBeforeLogout', 'Cashier\Staff\UserController@updateDataBeforeLogout');
            Route::group(['middleware' => 'dashboard:Cashier'],function(){
                Route::get('Dashboard','Cashier\DashboardController@dashboard');
            });

            //Start User
            Route::group(['middleware' => 'staff:Cashier'],function(){
                Route::get('Staff/index', 'Cashier\Staff\UserController@index');
                Route::get('Staff/create', 'Cashier\Staff\UserController@create');
                Route::post('Staff/store', 'Cashier\Staff\UserController@store');
                Route::get('Staff/edit/{id}', 'Cashier\Staff\UserController@edit');
                Route::post('Staff/update', 'Cashier\Staff\UserController@update');
                Route::get('Staff/delete/{id}', 'Cashier\Staff\UserController@delete');
                Route::get('Password/{id}','Cashier\Staff\UserController@profile');
                Route::post('Password/Change','Cashier\Staff\UserController@updateProfile');

                //Start Permission
                Route::get('Permission/index','Cashier\Module\ModuleController@index');
                Route::get('Permission/create','Cashier\Module\ModuleController@create');
                Route::post('Permission/store','Cashier\Module\ModuleController@store');
                Route::get('Permission/edit/{id}','Cashier\Module\ModuleController@edit');
                Route::post('Permission/update','Cashier\Module\ModuleController@update');
                //End Permission
            });
            //End User
           
            //Staff Role
            Route::group(['middleware'=>'staffType:Cashier'],function(){
                Route::get('StaffType/index', 'Cashier\Staff\RoleController@index');
                Route::get('StaffType/create', 'Cashier\Staff\RoleController@create');
                Route::post('StaffType/store', 'Cashier\Staff\RoleController@store');
                Route::get('StaffType/edit/{id}', 'Cashier\Staff\RoleController@edit');
                Route::post('StaffType/update', 'Cashier\Staff\RoleController@update');
                Route::get('StaffType/delete/{id}', 'Cashier\Staff\RoleController@delete');
            });

            //Start Category Routes
            Route::group(['middleware'=>'category:Cashier'],function(){
                Route::get('Category/index', 'Cashier\Category\CategoryController@index');
                Route::get('Category/create', 'Cashier\Category\CategoryController@create');
                Route::post('Category/store', 'Cashier\Category\CategoryController@store');
                Route::get('Category/delete/{id}', 'Cashier\Category\CategoryController@delete');
                Route::get('Category/edit/{id}', 'Cashier\Category\CategoryController@edit');
                Route::post('Category/update', 'Cashier\Category\CategoryController@update');
                Route::get('cat_enabled/{id}', 'Cashier\Category\CategoryController@catenabled');
                Route::get('cat_disabled/{id}', 'Cashier\Category\CategoryController@catdisabled');
            });
           //End Category Routes

            //Start item
            Route::group(['middleware'=>'item:Cashier'],function(){

                Route::get('Item/index', 'Cashier\Item\ItemController@index');
                Route::get('Item/create', 'Cashier\Item\ItemController@create');
                Route::post('Item/store', 'Cashier\Item\ItemController@store');
                Route::get('Item/edit/{id}', 'Cashier\Item\ItemController@edit');
                Route::post('Item/update', 'Cashier\Item\ItemController@update');
                Route::get('Item/delete/{id}', 'Cashier\Item\ItemController@delete');
                Route::get('Item/item_enabled/{id}','Cashier\Item\ItemController@itemenabled');
                Route::get('Item/item_disabled/{id}', 'Cashier\Item\ItemController@itemdisabled');

            });
            //End item

            //extra food
            Route::group(['middleware'=>'addon:Cashier'],function(){
                Route::get('AddOn/index', 'Cashier\Addon\AddonController@index');
                Route::get('AddOn/create', 'Cashier\Addon\AddonController@create');
                Route::post('AddOn/store', 'Cashier\Addon\AddonController@store');
                Route::get('AddOn/edit/{id}', 'Cashier\Addon\AddonController@edit');
                Route::post('AddOn/update', 'Cashier\Addon\AddonController@update');
                Route::get('AddOn/delete/{id}', 'Cashier\Addon\AddonController@delete');
            });
            //end extra food

            //Start Discount
            Route::group(['middleware'=>'discount:Cashier'],function(){
                Route::get('Discount/index', 'Cashier\Discount\DiscountController@index');
                Route::get('Discount/create','Cashier\Discount\DiscountController@create');
                Route::post('Discount/store', 'Cashier\Discount\DiscountController@store');
                Route::get('discount_price/{id}', 'Cashier\Discount\DiscountController@price');
                Route::get('discount', 'Cashier\Discount\DiscountController@selectitem');
                Route::get('Discount/edit/{id}', 'Cashier\Discount\DiscountController@edit');
                Route::post('Discount/update', 'Cashier\Discount\DiscountController@update');
                Route::get('Discount/delete/{id}', 'Cashier\Discount\DiscountController@delete');
                Route::get('/prices/{id}', ['as' => 'prices', 'uses' => 'Cashier\Discount\DiscountController@price']);
            });
            //End Discount

            //start set
            Route::group(['middleware'=>'setMenu:Cashier'],function(){
                Route::get('SetMenu/index', 'Cashier\Setmenu\SetMenuController@index');
                Route::get('SetMenu/create', 'Cashier\Setmenu\SetMenuController@create');
                Route::post('SetMenu/store', 'Cashier\Setmenu\SetMenuController@store');
                Route::get('SetMenu/edit/{id}', 'Cashier\Setmenu\SetMenuController@edit');
                Route::post('SetMenu/update', 'Cashier\Setmenu\SetMenuController@update');
                Route::get('SetMenu/delete/{id}', 'Cashier\Setmenu\SetMenuController@delete');

            });
            //end set

            //Start Member Type
            Route::group(['middleware'=>'memberType:Cashier'],function(){
                Route::get('MemberType/index', 'Cashier\Member\MemberTypeController@index');
                Route::get('MemberType/create', 'Cashier\Member\MemberTypeController@create');
                Route::post('MemberType/store', 'Cashier\Member\MemberTypeController@store');
                Route::get('MemberType/edit/{id}', 'Cashier\Member\MemberTypeController@edit');
                Route::post('MemberType/update', 'Cashier\Member\MemberTypeController@update');
                Route::get('MemberType/delete/{id}', 'Cashier\Member\MemberTypeController@delete');

            });
            //End  member_type

            //Start Member
            Route::group(['middleware'=>'member:Cashier'],function(){
                Route::get('Member/create', 'Cashier\Member\MemberController@create');
                Route::post('Member/store', 'Cashier\Member\MemberController@store');
                Route::get('Member/index', 'Cashier\Member\MemberController@index');
                Route::get('Member/delete/{id}', 'Cashier\Member\MemberController@delete');
                Route::get('Member/edit/{id}', 'Cashier\Member\MemberController@edit');
                Route::post('Member/update', 'Cashier\Member\MemberController@update');

            });
            //End Member

            //Start Room
            Route::group(['middleware'=>'room:Cashier'],function(){
                Route::get('Room/index', 'Cashier\Room\RoomController@index');
                Route::get('Room/create', 'Cashier\Room\RoomController@create');
                Route::post('Room/store', 'Cashier\Room\RoomController@store');
                Route::get('Room/edit/{id}', 'Cashier\Room\RoomController@edit');
                Route::post('Room/update', 'Cashier\Room\RoomController@update');
                Route::get('Room/delete/{ids}', 'Cashier\Room\RoomController@delete');

            });
            //End Room

            Route::group(['middleware' => 'table:Cashier'], function(){
                Route::get('Location/index','Cashier\Table\LocationController@index');
                Route::get('Location/create','Cashier\Table\LocationController@create');
                Route::post('Location/store','Cashier\Table\LocationController@store');
                Route::get('Location/edit/{id}','Cashier\Table\LocationController@edit');
                Route::post('Location/update','Cashier\Table\LocationController@update');
                Route::get('Location/delete/{id}','Cashier\Table\LocationController@delete');
            });

            //start Table Route
            Route::group(['middleware'=>'table:Cashier'],function(){
                Route::get('Table/create', 'Cashier\Table\TableController@create');
                Route::get('Table/index', 'Cashier\Table\TableController@index');
                Route::post('Table/store', 'Cashier\Table\TableController@store');
                Route::get('Table/edit/{id}', 'Cashier\Table\TableController@edit');
                Route::post('Table/update', 'Cashier\Table\TableController@update');
                Route::get('Table/delete/{id}', 'Cashier\Table\TableController@delete');

            });
            //End table

       
            //Start Booking
            Route::group(['middleware'=>'booking:Cashier'],function(){
                Route::get('Booking/index','Cashier\Booking\BookingController@index');
                Route::get('Booking/create','Cashier\Booking\BookingController@create');
                Route::post('Booking/search','Cashier\Booking\BookingController@search');

                Route::post('Booking/store','Cashier\Booking\BookingController@store');
                Route::get('Booking/edit/{id}','Cashier\Booking\BookingController@edit');
                Route::post('Booking/update','Cashier\Booking\BookingController@update');
                Route::get('Booking/delete/{id}','Cashier\Booking\BookingController@delete');
                Route::get('Booking/ajaxBookingRequest','Cashier\Booking\BookingController@ajaxBookingRequest');
                Route::get('Booking/capacity/{table}{room}','Cashier\Booking\BookingController@checkCapacity');

                Route::get('Booking/getTables/{date}/{time}','Cashier\Booking\BookingController@getTables');
                Route::get('Booking/getRooms/{date}/{time}','Cashier\Booking\BookingController@getRooms');

                Route::post('Booking/bookingEdit','Cashier\Booking\BookingController@bookingEdit');
                Route::get('Booking/tableListView','Cashier\Booking\BookingController@table_list_view');
                Route::get('Booking/roomListView','Cashier\Booking\BookingController@room_list_view');
                Route::get('Booking/tableRequest','Cashier\Booking\BookingController@tableRequest');
                Route::get('Booking/roomRequest','Cashier\Booking\BookingController@roomRequest');


                Route::get('MakeOrder','Cashier\ListViewController@index');
                Route::get('MakeOrder/category','Cashier\ListViewController@category');
                Route::get('MakeOrder/setmenu','Cashier\ListViewController@setmenu');
                Route::get('MakeOrder/categorydetail/{id}','Cashier\ListViewController@categoryDetail');
                Route::get('MakeOrder/SearchItem/{id}','Cashier\ListViewController@searchItem');
                Route::get('MakeOrder/add/{id}/{type}','Cashier\ListViewController@add');
            });
            //End Booking

            //Start config
            Route::group(['middleware'=>'generalSetting:Cashier'],function(){
                Route::get('Config/general_config', 'Cashier\Config\ConfigController@general_config');
                Route::get('Config/edit/{id}', 'Cashier\Config\ConfigController@edit');
                Route::post('Config/store', 'Cashier\Config\ConfigController@store');
                Route::post('Config/update', 'Cashier\Config\ConfigController@update');
                Route::get('Config/delete/{id}', 'Cashier\Config\ConfigController@delete');
                Route::get('Profile/company_profile','Cashier\Config\ProfileController@profile');
                Route::post('Profile/update','Cashier\Config\ProfileController@update');
                Route::post('Profile/store','Cashier\Config\ProfileController@store');
                Route::get('Pricehistory/{type?}/{id?}','Cashier\Log\PricelogController@search');
            });
            //End config

            //Report
            Route::group(['middleware'=>'report:Cashier'],function(){

                Route::get('invoice','Cashier\Invoice\InvoiceController@invoiceList');
                 Route::get('ajaxRequest','Cashier\Invoice\InvoiceController@ajaxRequest');
                Route::get('invoice/ajaxInvoiceRequest','Cashier\Invoice\InvoiceController@ajaxInvoiceRequest');
                Route::get('invoice/detail/{id}','Cashier\Invoice\InvoiceController@invoicedetail');
                Route::get('invoice/detail/print/{id}','Cashier\Invoice\InvoiceController@invoicePrint');
                Route::get('invoice/paid/{id}','Cashier\Invoice\InvoiceController@invoicePaid');
                Route::post('invoice/add_paid','Cashier\Invoice\InvoiceController@invoiceAddpaid');
                Route::get('invoice/cancel','Cashier\Invoice\InvoiceController@invoiceCancel');
                Route::get('invoice/cancel/{id}','Cashier\Invoice\InvoiceController@orderCancel');
                Route::get('invoice/manager/confirm/{username}/{password}','Cashier\Invoice\InvoiceController@checkManager');

                //Sale Summary Report & Excel Download
                Route::get('saleSummaryReport','Cashier\Report\SaleSummaryReportController@saleSummary');
                Route::get('SaleSummaryExport', 'Cashier\Report\SaleSummaryReportController@saleSummaryExport');
                Route::get('dailysale/{day}/{month}','Cashier\Report\SaleSummaryReportController@dailySale');
                Route::get('dailySaleExport/{day}/{month}','Cashier\Report\SaleSummaryReportController@dailySaleExport');
                Route::post('searchDailySummary','Cashier\Report\SaleSummaryReportController@searchDailySummary');
                Route::get('searchDailySummaryExport/{start_date}/{end_date}','Cashier\Report\SaleSummaryReportController@searchDailySummaryExport');
                Route::get('saleSummaryReport/{checked}', 'Cashier\Report\SaleSummaryReportController@saleSummaryReportWithCheck');
                
               
                Route::get('monthlySaleSummaryExport','Cashier\Report\SaleSummaryReportController@monthlySaleSummaryExport'); 
                Route::post('searchMonthlySummary', 'Cashier\Report\SaleSummaryReportController@searchMonthlySummary');
                Route::get('searchMonthlySummaryExport/{from_month}/{to_month}','Cashier\Report\SaleSummaryReportController@searchMonthlySummaryExport');
                Route::get('monthlySale/{year}/{month}', 'Cashier\Report\SaleSummaryReportController@monthlySale');
                Route::get('monthlySaleExport/{year}/{month}', 'Cashier\Report\SaleSummaryReportController@monthlySaleExport');

                Route::get('yearlySaleSummaryExport','Cashier\Report\SaleSummaryReportController@yearlySaleSummaryExport');    
                Route::post('searchYearlySummary','Cashier\Report\SaleSummaryReportController@searchYearlySummary');
                Route::get('yearlySale/{year}','Cashier\Report\SaleSummaryReportController@yearlySale');
                Route::get('yearlySaleExport/{year}','Cashier\Report\SaleSummaryReportController@yearlySaleExport');

               
                //Item Report & Excel Download
                Route::get('itemReport', 'Cashier\Report\ReportController@itemReport');
                Route::get('downloadItemReport', 'Cashier\Report\ReportController@downloadItemReport');

                //Item Report With Date & Excel Download
                Route::post('itemReportWithDate', 'Cashier\Report\ReportController@itemReportWithDate');
                Route::get('downloadItemReportWithDate/{start_date}/{end_date}', 'Cashier\Report\ReportController@downloadItemReportWithDateWithNull');
                Route::get('downloadItemReportWithDate/{start_date}/{end_date}/{number}', 'Cashier\Report\ReportController@downloadItemReportWithDateAndNumber');
                Route::get('downloadItemReportWithDate/{start_date}/{end_date}/{from_amount}/{to_amount}', 'Cashier\Report\ReportController@downloadItemReportWithDateAndAmount');
                Route::get('downloadItemReportWithDate/{start_date}/{end_date}/{number}/{from_amount}/{to_amount}', 'Cashier\Report\ReportController@downloadItemReportWithAll');


                //Favourite Set Menu & Excel Download
                Route::get('favourite_set_menus', 'Cashier\Report\ReportController@favourite_set_menus');
                Route::get('downloadsubReport', 'Cashier\Report\ReportController@downloadsubReport');

                //Favourite Set Date Report & Excel Download
                Route::post('fav_set_date_report', 'Cashier\Report\ReportController@fav_set_date_report');
                Route::get('downloadsubReportWithDate/{start_date}/{end_date}', 'Cashier\Report\ReportController@downloadsubReportWithDateWithNull');
                Route::get('downloadsubReportWithDate/{start_date}/{end_date}/{number}', 'Cashier\Report\ReportController@downloadsubReportWithDate');

                

                //Sale Report & Excel Download
                Route::get('saleReport', 'Cashier\Report\SaleReportController@saleReport');
                 Route::get('SaleExport', 'Cashier\Report\SaleReportController@saleExport');

                // Search Report for Sale & Excel Download
                Route::post('search_report', 'Cashier\Report\SaleReportController@search_detail');
                Route::get('SaleExportDetail/{from}/{to}', 'Cashier\Report\SaleReportController@SaleExportDetail');

                //Category saleSummaryDetailReport & Excel Download
                Route::get('saleSummaryDetailReport', 'Cashier\Report\CategorySaleSummaryReportController@DailyDetailReport');
                Route::get('saleSummaryDailyDetailExport', 'Cashier\Report\CategorySaleSummaryReportController@saleSummaryDailyDetailExport');

                //Sale Summary Detail Report With Date & Excel Download
                Route::post('saleSummaryDetailReportWithDate', 'Cashier\Report\CategorySaleSummaryReportController@saleSummaryDetailReportWithDate');
                Route::get('saleSummaryDailyDetailExportWithDate/{from}/{to}/{child}', 'Cashier\Report\CategorySaleSummaryReportController@saleSummaryDailyDetailExportWithDate');

                //Sale Summary Detail Report (Daily/Monthly/Yearly) & Excel Download
                Route::get('saleSummaryDetailReport/{checked}', 'Cashier\Report\CategorySaleSummaryReportController@saleSummaryDetailReport');
                Route::get('saleSummaryMonthlyDetailExport', 'Cashier\Report\CategorySaleSummaryReportController@saleSummaryMonthlyDetailExport');

                Route::get('saleSummaryYearlyDetailExport', 'Cashier\Report\CategorySaleSummaryReportController@saleSummaryYearlyDetailExport');

                Route::post('saleSummaryYearlyDetailReportWithDate/{checked}', 'Cashier\Report\CategorySaleSummaryReportController@saleSummaryYearlyDetailReportWithDate');

                Route::get('saleSummaryYearlyDetailExportWithDate/{year}/{child}', 'Cashier\Report\CategorySaleSummaryReportController@saleSummaryYearlyDetailExportWithDate');

                Route::post('saleSummaryMonthlyDetailReportWithDate/{checked}', 'Cashier\Report\CategorySaleSummaryReportController@saleSummaryMonthlyDetailReportWithDate');

                Route::get('saleSummaryMonthlyDetailExportWithDate/{from}/{to}/{child}', 'Cashier\Report\CategorySaleSummaryReportController@saleSummaryMonthlyDetailExportWithDate');

               
               //Start Favourite Food Report
                Route::get('memberFavaourite', 'Cashier\Report\FavouriteFoodReportController@favReportView');
                Route::get('memberFavaourite/{type}', 'Cashier\Report\FavouriteFoodReportController@filterByMemberType');
                Route::get('downloadFavourite/{typeId}', 'Cashier\Report\FavouriteFoodReportController@downloadExcelWithID');
                Route::get('downloadFavourite/{typeId}', 'Cashier\Report\FavouriteFoodReportController@downloadExcelWithID');
                //End Favourite Food Report
            });

            //Promotions
            Route::group(['middleware'=>'promotion:Cashier'],function() {
                Route::get('Promotion/create', 'Cashier\Promotion\PromotionController@create');
                Route::get('Promotion/index', 'Cashier\Promotion\PromotionController@index');
                Route::post('Promotion/store', 'Cashier\Promotion\PromotionController@store');
                Route::get('Promotion/edit/{id}', 'Cashier\Promotion\PromotionController@edit');
                Route::post('Promotion/update', 'Cashier\Promotion\PromotionController@update');
                Route::get('Promotion/delete/{id}', 'Cashier\Promotion\PromotionController@delete');
            });

            //Order
            Route::group(['middleware'=>'orderList:Cashier'],function(){

                Route::get('OrderView/index','Cashier\Invoice\OrderViewController@index');
                Route::get('OrderView/ajaxRequest','Cashier\Invoice\OrderViewController@ajaxRequest');
                Route::get('FoodOrderList/Detail/{order_id}/{order_status}','Cashier\Invoice\OrderViewController@detail');
            });

            //Start Kitchen Setup
            Route::group(['middleware'=>'kitchen:Cashier'],function(){
                Route::get('Kitchen/index','Cashier\Kitchen\KitchenController@index');
                Route::get('Kitchen/create','Cashier\Kitchen\KitchenController@create');
                Route::post('Kitchen/store','Cashier\Kitchen\KitchenController@store');
                Route::get('Kitchen/edit/{id}','Cashier\Kitchen\KitchenController@edit');
                Route::post('Kitchen/update','Cashier\Kitchen\KitchenController@update');
                Route::get('Kitchen/delete/{id}','Cashier\Kitchen\KitchenController@delete');


            });
            //End Kitchen Setup
            Route::get('Unauthorized','Cashier\DashboardController@authorized');
       });
    });
    Route::group(['prefix' => 'Kitchen'], function () {
        Route::get('logout', 'Cashier\Auth\AuthController@logout');
        Route::group(['middleware' => 'custom:Cashier'], function () {
            Route::get('kitchen', 'Kitchen\OrderViewController@tableView');
            Route::get('kitchen/design', 'Kitchen\OrderViewController@tableViewDesign');
            Route::get('kitchen/ajaxOrderRequest', 'Kitchen\OrderViewController@ajaxOrderRequest');
            Route::get('kitchen/ajaxRequest','Kitchen\OrderViewController@ajaxRequest');
            Route::get('getCompleteID','Kitchen\OrderViewController@tableView');
            Route::get('getStartID','Kitchen\OrderViewController@tableView');

            Route::get('kitchen/ajaxRequestProduct','Kitchen\OrderViewController@ajaxRequestProduct');
            Route::get('getCompleteID/{item_id}/{setmenu_id}', 'Kitchen\OrderViewController@update');
            Route::get('getStartID/{item_id}/{setmenu_id}', 'Kitchen\OrderViewController@start');
            Route::get('getStart/ajaxRequest/{item_id}/{setmenu_id}', 'Kitchen\OrderViewController@itemStart');

            Route::get('productView/CookedItem/{item_id}', 'Kitchen\OrderViewController@CookedItemFromProductView');
            Route::get('productView/CookingItem/{item_id}', 'Kitchen\OrderViewController@CookingItemFromProductView');

            Route::get('productView/CookedSetMenuItem/{id}','Kitchen\OrderViewController@CookedSetMenuItemFromProductView');
            Route::get('productView/CookingSetMenuItem/{id}','Kitchen\OrderViewController@CookingSetMenuItemFromProductView');


            Route::post('getCancelID/TableView', 'Kitchen\OrderViewController@CancelUpdateFromTableView');
            Route::post('getCancelID/ProductView', 'Kitchen\OrderViewController@CancelUpdateFromProductView');
            Route::get('productView', 'Kitchen\OrderViewController@productView');
            Route::get('test', 'Kitchen\HomeController@pricesPage');
            Route::get('test-values', 'Kitchen\HomeController@pricesValues');
        });
    });
});


//API Get Method

Route::get('api/v1/kitchen_cancel','makeAPIController@kitchen_cancel');
Route::get('api/v1/order_status','makeAPIController@order_status');
Route::get('api/v1/setmenu_order_status','makeAPIController@setmenu_order_status');
//syncControll
Route::post('api/v1/user', 'syncAPIController@user');
Route::post('api/v1/category','syncAPIController@category');
Route::post('api/v1/addon','syncAPIController@addon');
Route::post('api/v1/item', 'syncAPIController@item');
Route::post('api/v1/continent', 'syncAPIController@continent');
Route::post('api/v1/set_menu','syncAPIController@set_menu');
Route::post('api/v1/set_item','syncAPIController@set_item');
Route::post('api/v1/config','syncAPIController@config');
Route::post('api/v1/table','syncAPIController@table');
Route::post('api/v1/room','syncAPIController@room');
Route::post('api/v1/member','syncAPIController@member');
Route::post('api/v1/discount','syncAPIController@discount');
Route::post('api/v1/booking','syncAPIController@booking');
Route::post('api/v1/promotion','syncAPIController@promotion');
Route::post('api/v1/promotion_item','syncAPIController@promotionItem');
Route::post('api/v1/syncs_table','syncAPIController@getSyncsTable');
Route::post('api/v1/syncs', 'syncAPIController@sync_table');

//API Post Method
Route::post('api/v1/login', 'makeAPIController@login');

Route::post('api/v1/create_voucher','makeAPIController@create_voucher');
Route::post('api/v1/add_new_to_voucher','makeAPIController@add_new_to_voucher');
Route::post('api/v1/cancel','makeAPIController@cancel');
Route::post('api/v1/table_status','makeAPIController@table_status');
Route::post('api/v1/room_status','makeAPIController@room_status');
Route::post('api/v1/table_transfer','makeAPIController@table_transfer');
Route::post('api/v1/room_transfer','makeAPIController@room_transfer');
Route::post('api/v1/take','makeAPIController@take');
Route::post('api/v1/check_cancel_status','makeAPIController@check_cancel_status');
Route::post('api/v1/invoice/member','makeAPIController@member_update');
Route::post('api/v1/customer_cancel','makeAPIController@customer_cancel');
Route::post('api/v1/post_kitchen_cancel','makeAPIController@post_kitchen_cancel');
Route::post('api/v1/order_status','makeAPIController@order_status');

Route::post('api/v1/download_voucher','downloadApiController@download_voucher');
Route::post('api/v1/download_voucher_detail','downloadApiController@download_voucher_detail');
Route::post('api/v1/order_table','downloadApiController@order_table');
Route::post('api/v1/order_room','downloadApiController@order_room');

Route::post('api/v1/download_order_table_with_order_id','downloadApiController@order_table_with_order_id');
Route::post('api/v1/download_order_room_with_order_id','downloadApiController@order_room_with_order_id');
Route::post('api/v1/download_order_table_status','downloadApiController@download_order_table_status');
