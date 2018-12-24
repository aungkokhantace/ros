<?php
Route::get('logo', 'headerController@logo');
Route::group(['middleware' => 'web'], function () {
    Route::get('/', function () {
        if (Auth::guard('Cashier')->user())
        {
            if (Auth::guard('Cashier')->user()->role_id == 4) {
                return redirect()->action('Cashier\DashboardController@dashboard');
            } elseif (Auth::guard('Cashier')->user()->role_id == 1 || Auth::guard('Cashier')->user()->role_id == 2 || Auth::guard('Cashier')->user()->role_id == 3) {
                return redirect()->action('Backend\DashboardController@dashboard');
            } else {
                return view('cashier.auth.login');
            }
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
            //End User

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

            });
            //End item

            //start set
            Route::group(['middleware'=>'setMenu:Cashier'],function(){
                Route::get('SetMenu/index', 'Cashier\Setmenu\SetMenuController@index');

            });
            //end set

            //Start Member Type
            // Route::group(['middleware'=>'memberType:Cashier'],function(){
            //     Route::get('MemberType/index', 'Cashier\Member\MemberTypeController@index');
            //     Route::get('MemberType/create', 'Cashier\Member\MemberTypeController@create');
            //     Route::post('MemberType/store', 'Cashier\Member\MemberTypeController@store');
            //     Route::get('MemberType/edit/{id}', 'Cashier\Member\MemberTypeController@edit');
            //     Route::post('MemberType/update', 'Cashier\Member\MemberTypeController@update');
            //     Route::get('MemberType/delete/{id}', 'Cashier\Member\MemberTypeController@delete');

            // });
            //End  member_type

            //Start Member
            // Route::group(['middleware'=>'member:Cashier'],function(){
            //     Route::get('Member/create', 'Cashier\Member\MemberController@create');
            //     Route::post('Member/store', 'Cashier\Member\MemberController@store');
            //     Route::get('Member/index', 'Cashier\Member\MemberController@index');
            //     Route::get('Member/delete/{id}', 'Cashier\Member\MemberController@delete');
            //     Route::get('Member/edit/{id}', 'Cashier\Member\MemberController@edit');
            //     Route::post('Member/update', 'Cashier\Member\MemberController@update');

            // });
            //End Member

            //Start config
            // Route::group(['middleware'=>'generalSetting:Cashier'],function(){
            //     Route::get('Config/general_config', 'Cashier\Config\ConfigController@general_config');
            //     Route::get('Config/edit/{id}', 'Cashier\Config\ConfigController@edit');
            //     Route::post('Config/store', 'Cashier\Config\ConfigController@store');
            //     Route::post('Config/update', 'Cashier\Config\ConfigController@update');
            //     Route::get('Config/delete/{id}', 'Cashier\Config\ConfigController@delete');
            //     Route::get('Profile/company_profile','Cashier\Config\ProfileController@profile');
            //     Route::post('Profile/update','Cashier\Config\ProfileController@update');
            //     Route::post('Profile/store','Cashier\Config\ProfileController@store');
            // });
            //End config

            //Report
            Route::group(['middleware'=>'report:Cashier'],function(){

                Route::get('invoice','Cashier\Invoice\InvoiceController@invoiceList');
                Route::get('ajaxRequest','Cashier\Invoice\InvoiceController@ajaxRequest');
                Route::get('invoice/ajaxInvoiceRequest','Cashier\Invoice\InvoiceController@ajaxInvoiceRequest');
                Route::get('invoice/detail/{id}','Cashier\Invoice\InvoiceController@invoicedetail');
                Route::get('invoice/detail/print/{id}','Cashier\Invoice\InvoiceController@invoicePrint');
                Route::get('invoice/paid/{id}','Cashier\Invoice\InvoiceController@invoicePaid');
                Route::get('invoice/paid/ajaxPaymentRequest/{id}','Cashier\Invoice\InvoiceController@ajaxPaymentRequest');
                Route::post('invoice/add_paid','Cashier\Invoice\InvoiceController@invoiceAddpaid');
                Route::get('invoice/cancel','Cashier\Invoice\InvoiceController@invoiceCancel');
                Route::get('invoice/cancel/{id}','Cashier\Invoice\InvoiceController@orderCancel');
                Route::get('invoice/sort/time/increase','Cashier\Invoice\InvoiceController@invoiceTimeIncrease');
                Route::get('invoice/sort/time/decrease','Cashier\Invoice\InvoiceController@invoiceTimeDecrease');
                Route::get('invoice/sort/price/increase','Cashier\Invoice\InvoiceController@invoicePriceIncrease');
                Route::get('invoice/sort/price/decrease','Cashier\Invoice\InvoiceController@invoicePriceDecrease');
                Route::get('invoice/sort/order/increase','Cashier\Invoice\InvoiceController@invoiceOrderIncrease');
                Route::get('invoice/sort/order/decrease','Cashier\Invoice\InvoiceController@invoiceOrderDecrease');
                Route::get('ajaxInvoiceTimeIncrease','Cashier\Invoice\InvoiceController@ajaxInvoiceTimeIncrease');
                Route::get('ajaxInvoiceTimeDecrease','Cashier\Invoice\InvoiceController@ajaxInvoiceTimeDecrease');
                Route::get('ajaxInvoicePriceIncrease','Cashier\Invoice\InvoiceController@ajaxInvoicePriceIncrease');
                Route::get('ajaxInvoicePriceDecrease','Cashier\Invoice\InvoiceController@ajaxInvoicePriceDecrease');
                Route::get('ajaxInvoiceOrderIncrease','Cashier\Invoice\InvoiceController@ajaxInvoiceOrderIncrease');
                Route::get('ajaxInvoiceOrderDecrease','Cashier\Invoice\InvoiceController@ajaxInvoiceOrderDecrease');
                Route::get('invoice/manager/confirm/{username}/{password}','Cashier\Invoice\InvoiceController@checkManager');

                // Start Tender Transaction
                Route::post('transaction_tenders/storeCash','Cashier\TransactionTenders\TransactionTendersController@storeCash');
                Route::post('transaction_tenders/storeCard','Cashier\TransactionTenders\TransactionTendersController@storeCard');
                Route::post('transaction_tenders/delete','Cashier\TransactionTenders\TransactionTendersController@delete');
                Route::post('transaction_tenders/updateFoc','Cashier\TransactionTenders\TransactionTendersController@updateFoc');
                Route::post('transaction_tenders/deleteFoc','Cashier\TransactionTenders\TransactionTendersController@deleteFoc');
                //End Tender Transaction
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

            //Make Order
            Route::group(['middleware'=>'order:Cashier'],function(){

                Route::get('MakeOrder','Cashier\ListViewController@index');
                Route::post('MakeOrder/store','Cashier\ListViewController@store');
                Route::get('MakeOrder/edit/{id}','Cashier\ListViewController@edit');
                Route::post('MakeOrder/update','Cashier\ListViewController@update');
                Route::get('MakeOrder/takeAway','Cashier\ListViewController@takeAway');
                Route::get('MakeOrder/tables','Cashier\ListViewController@tables');
                Route::get('MakeOrder/table/{id}','Cashier\ListViewController@orderTable');
                Route::post('MakeOrder/transfer','Cashier\ListViewController@transfer');
                Route::get('MakeOrder/rooms','Cashier\ListViewController@rooms');
                Route::get('MakeOrder/room/{id}','Cashier\ListViewController@orderRoom');
                Route::get('MakeOrder/getCategories/{parent}/{shift}','Cashier\ListViewController@getCategories');
                Route::get('MakeOrder/getSetMenu/{shift}','Cashier\ListViewController@getSetMenu');
                Route::get('MakeOrder/backCategory/{id}','Cashier\ListViewController@backCategory');
                Route::get('MakeOrder/item/{id}/{take}','Cashier\ListViewController@item');
                Route::post('MakeOrder/order_detail/delete','Cashier\ListViewController@delete');
                Route::get('MakeOrder/setMenu/{id}/{take}','Cashier\ListViewController@setMenu');
                Route::get('MakeOrder/continent/{itemID}/{continentID}','Cashier\ListViewController@continent');
                // Route::get('MakeOrder/category','Cashier\ListViewController@category');
                // Route::get('MakeOrder/setmenu','Cashier\ListViewController@setmenu');
                // Route::get('MakeOrder/categorydetail/{id}','Cashier\ListViewController@categoryDetail');
                // Route::get('MakeOrder/SearchItem/{id}','Cashier\ListViewController@searchItem');
                // Route::get('MakeOrder/add/{id}/{type}','Cashier\ListViewController@add');
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

             //Start Log Middleware
            Route::group(['middleware'=>'log:Cashier'],function(){
                Route::get('Pricehistory/{type?}/{id?}','Cashier\Log\PricelogController@search');
                Route::get('Confighistory','Cashier\Log\ConfiglogController@index');
                Route::get('Discounthistory','Cashier\Log\DiscountlogController@index');
                Route::get('SyncApi','Cashier\Log\ApilistController@sync');
                Route::get('MakeApi','Cashier\Log\ApilistController@make');
                Route::get('DownloadApi','Cashier\Log\ApilistController@down');
            });

            Route::group(['middleware' => 'shift:Cashier'], function () {
                Route::get('DayStart/index', 'Cashier\DayStart\DayStartController@index');
                Route::get('DayStart/create', 'Cashier\DayStart\DayStartController@create');
                Route::post('DayStart/store', 'Cashier\DayStart\DayStartController@store');
                Route::get('DayStart/delete/{id}', 'Cashier\DayStart\DayStartController@delete');
                Route::get('DayStart/end/{id}', 'Cashier\DayStart\DayStartController@dayend');
                Route::get('DayStart/Shift/{daycode}/{id}/{status}', 'Cashier\DayStart\DayStartController@orderShift');
                Route::get('Shift/index', 'Cashier\Shift\ShiftController@index');
                Route::get('Shift/create', 'Cashier\Shift\ShiftController@create');
                Route::post('Shift/store', 'Cashier\Shift\ShiftController@store');
                Route::get('Shift/delete/{id}', 'Cashier\Shift\ShiftController@delete');
                Route::get('Shift/last_update/{id}', 'Cashier\Shift\ShiftController@last_update');
                Route::get('Shift/Permission/{id}', 'Cashier\Shift\ShiftController@permission');
                Route::post('Shift/Permission/update', 'Cashier\Shift\ShiftController@shift_update');
                // Route::get('Shift/{shift}', 'Cashier\Shift\ShiftController@Shift');
                // Route::post('Shift/update', 'Cashier\Shift\ShiftController@update');
            });
            //end shift

            //End Kitchen Setup
            Route::get('Unauthorized','Cashier\DashboardController@authorized');
       });
    });

    Route::group(['prefix' => 'Backend'], function(){
        Route::group(['middleware' => 'custom:Cashier'], function(){

            Route::get('logout', 'Backend\Auth\AuthController@logout');
            Route::get('userAuth', 'Backend\Staff\UserController@getAuthUser');
            Route::get('updateDataBeforeLogout', 'Backend\Staff\UserController@updateDataBeforeLogout');
            Route::group(['middleware' => 'dashboard:Cashier'],function(){
                Route::get('Dashboard','Backend\DashboardController@dashboard');
            });


        //Start User
        Route::group(['middleware' => 'staff:Cashier'],function(){
            Route::get('Staff/ajaxRequest/{id}','Backend\Staff\UserController@ajaxRequest');
            Route::get('Staff/index', 'Backend\Staff\UserController@index');
            Route::get('Staff/create', 'Backend\Staff\UserController@create');
            Route::post('Staff/store', 'Backend\Staff\UserController@store');
            Route::get('Staff/edit/{id}', 'Backend\Staff\UserController@edit');
            Route::post('Staff/update', 'Backend\Staff\UserController@update');
            Route::get('Staff/delete/{id}', 'Backend\Staff\UserController@delete');
            Route::get('Staff/active/{id}', 'Backend\Staff\UserController@active');
            Route::get('Staff/inactive/{id}', 'Backend\Staff\UserController@inactive');
            Route::get('Password/{id}','Backend\Staff\UserController@profile');
            Route::post('Password/Change','Backend\Staff\UserController@updateProfile');

             //Start Permission
            Route::get('Permission/index','Backend\Module\ModuleController@index');
    
            //End Permission
        });
                //End User

        //Staff Role
        Route::group(['middleware'=>'staffType:Cashier'],function(){
            Route::get('StaffType/index', 'Backend\Staff\RoleController@index');
        });


        //Start Member Type
        Route::group(['middleware'=>'memberType:Cashier'],function(){
            Route::get('MemberType/index', 'Backend\Member\MemberTypeController@index');
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
            Route::get('Member/index', 'Backend\Member\MemberController@index');
            Route::get('Member/delete/{id}', 'Cashier\Member\MemberController@delete');
            Route::get('Member/edit/{id}', 'Cashier\Member\MemberController@edit');
            Route::post('Member/update', 'Cashier\Member\MemberController@update');
        });
        //End Member


        //Start Kitchen Setup
        Route::group(['middleware'=>'kitchen:Cashier'],function(){
            Route::get('Kitchen/index','Backend\Kitchen\KitchenController@index');
            Route::get('Kitchen/create','Backend\Kitchen\KitchenController@create');
            Route::post('Kitchen/store','Backend\Kitchen\KitchenController@store');
            Route::get('Kitchen/edit/{id}','Backend\Kitchen\KitchenController@edit');
            Route::post('Kitchen/update','Backend\Kitchen\KitchenController@update');
            Route::get('Kitchen/delete/{id}','Backend\Kitchen\KitchenController@delete');
        });


        //Start Category Routes
        Route::group(['middleware'=>'category:Cashier'],function(){
            Route::get('Category/index', 'Backend\Category\CategoryController@index');
            Route::get('Category/create', 'Backend\Category\CategoryController@create');
            Route::post('Category/store', 'Backend\Category\CategoryController@store');
            Route::get('Category/delete/{id}', 'Backend\Category\CategoryController@delete');
            Route::get('Category/edit/{id}', 'Backend\Category\CategoryController@edit');
            Route::post('Category/update', 'Backend\Category\CategoryController@update');
            Route::get('cat_enabled/{id}', 'Backend\Category\CategoryController@catenabled');
            Route::get('cat_disabled/{id}', 'Backend\Category\CategoryController@catdisabled');
            Route::get('Branch/ajaxRequest/{id}', 'Backend\Category\CategoryController@ajax');
        });
       //End Category Routes


        //Start item
        Route::group(['middleware'=>'item:Cashier'],function(){
            Route::get('Item/index', 'Backend\Item\ItemController@index');
            Route::get('Item/create', 'Backend\Item\ItemController@create');
            Route::post('Item/store', 'Backend\Item\ItemController@store');
            Route::get('Item/edit/{id}', 'Backend\Item\ItemController@edit');
            Route::post('Item/update', 'Backend\Item\ItemController@update');
            Route::get('Item/delete/{id}', 'Backend\Item\ItemController@delete');
            Route::get('Item/item_enabled/{id}','Backend\Item\ItemController@itemenabled');
            Route::get('Item/item_disabled/{id}', 'Backend\Item\ItemController@itemdisabled');
            Route::get('category/ajaxRequest/{id}', 'Backend\Item\ItemController@ajax');
            Route::get('get_body/ajaxRequest/{branch_id}/{restaurant?}','Backend\Item\ItemController@renderFunction');
            Route::get('Remark/ajaxRequest/{id}', 'Backend\Item\ItemController@Remarkajax');

        });
        //End item



         //extra food
        Route::group(['middleware'=>'addon:Cashier'],function(){
            Route::get('AddOn/index', 'Backend\Addon\AddonController@index');
            Route::get('AddOn/create', 'Backend\Addon\AddonController@create');
            Route::post('AddOn/store', 'Backend\Addon\AddonController@store');
            Route::get('AddOn/edit/{id}', 'Backend\Addon\AddonController@edit');
            Route::post('AddOn/update', 'Backend\Addon\AddonController@update');
            Route::get('AddOn/delete/{id}', 'Backend\Addon\AddonController@delete');
            Route::get('get_addon/ajaxRequest/{branch_id}/{restaurant_id}', 'Backend\Addon\AddonController@ajax');
            

        });
        //end extra food

        //start set
        Route::group(['middleware'=>'setMenu:Cashier'],function(){
            Route::get('SetMenu/index', 'Backend\Setmenu\SetMenuController@index');
            Route::get('SetMenu/create', 'Backend\Setmenu\SetMenuController@create');
            Route::post('SetMenu/store', 'Backend\Setmenu\SetMenuController@store');
            Route::get('SetMenu/edit/{id}', 'Backend\Setmenu\SetMenuController@edit');
            Route::post('SetMenu/update', 'Backend\Setmenu\SetMenuController@update');
            Route::get('SetMenu/delete/{id}', 'Backend\Setmenu\SetMenuController@delete');
            Route::get('get_menu_body/ajaxRequest/{branch_id}/{restaurant_id?}','Backend\Setmenu\SetMenuController@render_SetMenu');

        });
        //end set

         //start Table Route
        Route::group(['middleware'=>'table:Cashier'],function(){
            Route::get('Table/create', 'Backend\Table\TableController@create');
            Route::get('Table/index', 'Backend\Table\TableController@index');
            Route::post('Table/store', 'Backend\Table\TableController@store');
            Route::get('Table/edit/{id}', 'Backend\Table\TableController@edit');
            Route::post('Table/update', 'Backend\Table\TableController@update');
            Route::get('Table/delete/{id}', 'Backend\Table\TableController@delete');
            Route::get('Table/table_enabled/{id}', 'Cashier\Table\TableController@table_enabled');
            Route::get('Table/active/{id}', 'Backend\Table\TableController@active');
            Route::get('Table/inactive/{id}', 'Backend\Table\TableController@inactive');
            Route::get('get_location/ajaxRequest/{branch_id}/{restaurant_id?}', 'Backend\Table\TableController@ajax');

        });
        //End table


         //Start Room
        Route::group(['middleware'=>'room:Cashier'],function(){
            Route::get('Room/index', 'Backend\Room\RoomController@index');
            Route::get('Room/create', 'Backend\Room\RoomController@create');
            Route::post('Room/store', 'Backend\Room\RoomController@store');
            Route::get('Room/edit/{id}', 'Backend\Room\RoomController@edit');
            Route::post('Room/update', 'Backend\Room\RoomController@update');
            Route::get('Room/delete/{ids}', 'Backend\Room\RoomController@delete');
            Route::get('Room/room_enabled/{id}', 'Backend\Room\RoomController@roomenabled');
            Route::get('Room/active/{id}', 'Backend\Room\RoomController@active');
            Route::get('Room/inactive/{id}', 'Backend\Room\RoomController@inactive');
            
        });
        //End Room

         Route::group(['middleware' => 'table:Cashier'], function(){
            Route::get('Location/index','Backend\Table\LocationController@index');
            Route::get('Location/create','Backend\Table\LocationController@create');
            Route::post('Location/store','Backend\Table\LocationController@store');
            Route::get('Location/edit/{id}','Backend\Table\LocationController@edit');
            Route::post('Location/update','Backend\Table\LocationController@update');
            Route::get('Location/delete/{id}','Backend\Table\LocationController@delete');
        });

        //Start config
        Route::group(['middleware'=>'generalSetting:Cashier'],function(){
            Route::get('Config/general_config', 'Backend\Config\ConfigController@general_config');
            Route::get('Config/edit/{id}', 'Backend\Config\ConfigController@edit');
            Route::post('Config/store', 'Backend\Config\ConfigController@store');
            Route::post('Config/update', 'Backend\Config\ConfigController@update');
            Route::get('Config/delete/{id}', 'Backend\Config\ConfigController@delete');
            Route::get('Profile/company_profile','Backend\Config\ProfileController@profile');
            Route::post('Profile/update','Backend\Config\ProfileController@update');
            Route::post('Profile/store','Backend\Config\ProfileController@store');
        });
        //End config
        


        //Start Discount
        Route::group(['middleware'=>'discount:Cashier'],function(){
            Route::get('Discount/index', 'Backend\Discount\DiscountController@index');
            Route::get('Discount/create','Backend\Discount\DiscountController@create');
            Route::post('Discount/store', 'Backend\Discount\DiscountController@store');
            Route::get('discount_price/{id}', 'Backend\Discount\DiscountController@price');
            Route::get('discount', 'Backend\Discount\DiscountController@selectitem');
            Route::get('Discount/edit/{id}', 'Backend\Discount\DiscountController@edit');
            Route::post('Discount/update', 'Backend\Discount\DiscountController@update');
            Route::get('Discount/delete/{id}', 'Backend\Discount\DiscountController@delete');
            Route::get('/prices/{id}', ['as' => 'prices', 'uses' => 'Backend\Discount\DiscountController@price']);
        });
        //End Discount
       
        //Order
        Route::group(['middleware'=>'orderList:Cashier'],function(){
            //Route::get('OrderView/index','Backend\Invoice\OrderViewController@index');
            Route::get('OrderView/ajaxRequest','Backend\Invoice\OrderViewController@ajaxRequest');
            Route::get('FoodOrderList/Detail/{order_id}/{order_status}','Backend\Invoice\OrderViewController@detail');
        });


         //Report
        Route::group(['middleware'=>'report:Cashier'],function(){

            Route::get('invoice','Backend\Invoice\InvoiceController@invoiceList');
            Route::get('ajaxSearchRequest','Backend\Invoice\InvoiceController@SearchRequest');
            Route::get('ajaxSearchTimeIncreaseRequest','Backend\Invoice\InvoiceController@TimeIncreaseRequest');
            Route::get('ajaxSearchTimeDecreaseRequest','Backend\Invoice\InvoiceController@TimeDecreaseRequest');
            Route::get('ajaxSearchPriceIncreaseRequest','Backend\Invoice\InvoiceController@PriceIncreaseRequest');
            Route::get('ajaxSearchPriceDecreaseRequest','Backend\Invoice\InvoiceController@PriceDecreaseRequest');
            Route::get('ajaxSearchCancelRequest','Backend\Invoice\InvoiceController@CancelRequest');
            Route::get('ajaxRequest','Backend\Invoice\InvoiceController@ajaxRequest');
            Route::get('invoice/ajaxInvoiceRequest','Backend\Invoice\InvoiceController@ajaxInvoiceRequest');
            Route::get('invoice/detail/{id}','Backend\Invoice\InvoiceController@invoicedetail');
            Route::get('invoice/detail/print/{id}','Backend\Invoice\InvoiceController@invoicePrint');
            Route::get('invoice/paid/{id}','Backend\Invoice\InvoiceController@invoicePaid');
            Route::get('invoice/paid/ajaxPaymentRequest/{id}','Backend\Invoice\InvoiceController@ajaxPaymentRequest');
            Route::post('invoice/add_paid','Backend\Invoice\InvoiceController@invoiceAddpaid');
            Route::get('invoice/cancel','Backend\Invoice\InvoiceController@invoiceCancel');
            Route::get('invoice/cancel/{id}','Backend\Invoice\InvoiceController@orderCancel');
            Route::get('invoice/sort/time/increase','Backend\Invoice\InvoiceController@invoiceTimeIncrease');
            Route::get('invoice/sort/time/decrease','Backend\Invoice\InvoiceController@invoiceTimeDecrease');
            Route::get('invoice/sort/price/increase','Backend\Invoice\InvoiceController@invoicePriceIncrease');
            Route::get('invoice/sort/price/decrease','Backend\Invoice\InvoiceController@invoicePriceDecrease');
            Route::get('invoice/sort/order/increase','Backend\Invoice\InvoiceController@invoiceOrderIncrease');
            Route::get('invoice/sort/order/decrease','Backend\Invoice\InvoiceController@invoiceOrderDecrease');
            Route::get('ajaxInvoiceTimeIncrease','Backend\Invoice\InvoiceController@ajaxInvoiceTimeIncrease');
            Route::get('ajaxInvoiceTimeDecrease','Backend\Invoice\InvoiceController@ajaxInvoiceTimeDecrease');
            Route::get('ajaxInvoicePriceIncrease','Backend\Invoice\InvoiceController@ajaxInvoicePriceIncrease');
            Route::get('ajaxInvoicePriceDecrease','Backend\Invoice\InvoiceController@ajaxInvoicePriceDecrease');
            Route::get('ajaxInvoiceOrderIncrease','Backend\Invoice\InvoiceController@ajaxInvoiceOrderIncrease');
            Route::get('ajaxInvoiceOrderDecrease','Backend\Invoice\InvoiceController@ajaxInvoiceOrderDecrease');
            Route::get('invoice/manager/confirm/{username}/{password}','Backend\Invoice\InvoiceController@checkManager');

            //Sale Summary Report & Excel Download
            Route::get('saleSummaryReport','Backend\Report\SaleSummaryReportController@saleSummary');
            Route::get('SaleSummaryExport', 'Backend\Report\SaleSummaryReportController@saleSummaryExport');
            Route::get('dailysale/{day}/{month}','Backend\Report\SaleSummaryReportController@dailySale');
            Route::get('dailySaleExport/{day}/{month}','Backend\Report\SaleSummaryReportController@dailySaleExport');
            Route::post('searchDailySummary','Backend\Report\SaleSummaryReportController@searchDailySummary');
            Route::get('searchDailySummaryExport/{start_date}/{end_date}','Backend\Report\SaleSummaryReportController@searchDailySummaryExport');
            Route::get('saleSummaryReport/{checked}', 'Backend\Report\SaleSummaryReportController@saleSummaryReportWithCheck');
            
           
            Route::get('monthlySaleSummaryExport','Backend\Report\SaleSummaryReportController@monthlySaleSummaryExport'); 
            Route::post('searchMonthlySummary', 'Backend\Report\SaleSummaryReportController@searchMonthlySummary');
            Route::get('searchMonthlySummaryExport/{from_month}/{to_month}','Backend\Report\SaleSummaryReportController@searchMonthlySummaryExport');
            Route::get('monthlySale/{year}/{month}', 'Backend\Report\SaleSummaryReportController@monthlySale');
            Route::get('monthlySaleExport/{year}/{month}', 'Backend\Report\SaleSummaryReportController@monthlySaleExport');

            Route::get('yearlySaleSummaryExport','Backend\Report\SaleSummaryReportController@yearlySaleSummaryExport');    
            Route::post('searchYearlySummary','Backend\Report\SaleSummaryReportController@searchYearlySummary');
            Route::get('searchYearlySummaryExport/{from_year}','Backend\Report\SaleSummaryReportController@searchYearSummaryExport');
            Route::get('yearlySale/{year}','Backend\Report\SaleSummaryReportController@yearlySale');
            Route::get('yearlySaleExport/{year}','Backend\Report\SaleSummaryReportController@yearlySaleExport');


        });


         
        //Start Booking
        Route::group(['middleware'=>'booking:Cashier'],function(){
            Route::get('Booking/index','Backend\Booking\BookingController@index');
            Route::get('Booking/create','Backend\Booking\BookingController@create');
            Route::post('Booking/search','Backend\Booking\BookingController@search');

            Route::post('Booking/store','Backend\Booking\BookingController@store');
            Route::get('Booking/edit/{id}','Backend\Booking\BookingController@edit');
            Route::post('Booking/update','Backend\Booking\BookingController@update');
            Route::get('Booking/delete/{id}','Backend\Booking\BookingController@delete');
            Route::get('Booking/ajaxBookingRequest','Cashier\Booking\BookingController@ajaxBookingRequest');
            Route::get('Booking/capacity/{table}{room}','Cashier\Booking\BookingController@checkCapacity');

            Route::get('Booking/getTables/{date}/{time}','Cashier\Booking\BookingController@getTables');
            Route::get('Booking/getRooms/{date}/{time}','Cashier\Booking\BookingController@getRooms');

            Route::post('Booking/bookingEdit','Cashier\Booking\BookingController@bookingEdit');
            Route::get('Booking/tableListView','Backend\Booking\BookingController@table_list_view');
            Route::get('Booking/roomListView','Backend\Booking\BookingController@room_list_view');
            Route::get('Booking/tableRequest','Backend\Booking\BookingController@tableRequest');
            Route::get('Booking/roomRequest','Backend\Booking\BookingController@roomRequest');


            Route::get('MakeOrder','Backend\ListViewController@index');
            Route::get('MakeOrder/category','Cashier\ListViewController@category');
            Route::get('MakeOrder/setmenu','Cashier\ListViewController@setmenu');
            Route::get('MakeOrder/categorydetail/{id}','Cashier\ListViewController@categoryDetail');
            Route::get('MakeOrder/SearchItem/{id}','Cashier\ListViewController@searchItem');
            Route::get('MakeOrder/add/{id}/{type}','Cashier\ListViewController@add');
        });
        //End Booking

      //Sale Report & Excel Download
            Route::get('saleReport', 'Backend\Report\SaleReportController@saleReport');
            Route::get('saleAjaxRequest', 'Backend\Report\SaleReportController@ajaxRequest');
            Route::get('SaleExport', 'Backend\Report\SaleReportController@saleExport');
      
       // Search Report for Sale & Excel Download
            Route::post('search_report', 'Backend\Report\SaleReportController@search_detail');
            Route::get('searchAjaxRequest', 'Backend\Report\SaleReportController@searchAjaxRequest');
            Route::get('SaleExportDetail/{from}/{to}', 'Backend\Report\SaleReportController@SaleExportDetail');
             //Item Report & Excel Download
            Route::get('itemReport', 'Backend\Report\ReportController@itemReport');
            Route::get('downloadItemReport', 'Backend\Report\ReportController@downloadItemReport');

             
             //Item Report With Date & Excel Download
            Route::post('itemReportWithDate', 'Backend\Report\ReportController@itemReportWithDate');
            Route::get('downloadItemReportWithDate/{start_date}/{end_date}', 'Backend\Report\ReportController@downloadItemReportWithDateWithNull');
            Route::get('downloadItemReportWithDate/{start_date}/{end_date}/{number}', 'Backend\Report\ReportController@downloadItemReportWithDateAndNumber');
            Route::get('downloadItemReportWithDate/{start_date}/{end_date}/{from_amount}/{to_amount}', 'Backend\Report\ReportController@downloadItemReportWithDateAndAmount');
            Route::get('downloadItemReportWithDate/{start_date}/{end_date}/{number}/{from_amount}/{to_amount}', 'Backend\Report\ReportController@downloadItemReportWithAll');

         

          //Favourite Set Menu & Excel Download
            Route::get('favourite_set_menus', 'Backend\Report\ReportController@favourite_set_menus');
            Route::get('downloadsubReport', 'Backend\Report\ReportController@downloadsubReport');

             //Favourite Set Date Report & Excel Download
            Route::post('fav_set_date_report', 'Backend\Report\ReportController@fav_set_date_report');
            Route::get('downloadsubReportWithDate/{start_date}/{end_date}', 'Backend\Report\ReportController@downloadsubReportWithDateWithNull');
            Route::get('downloadsubReportWithDate/{start_date}/{end_date}/{number}', 'Backend\Report\ReportController@downloadsubReportWithDate');
             Route::get('Unauthorized','Backend\DashboardController@authorized');


        Route::group(['middleware' => 'shift:Cashier'], function () {
           
            Route::get('Shift/index', 'Backend\Shift\ShiftController@index');
            Route::get('Shift/create', 'Backend\Shift\ShiftController@create');
            Route::post('Shift/store', 'Backend\Shift\ShiftController@store');
            Route::get('Shift/edit/{id}','Backend\Shift\ShiftController@edit');
            Route::post('Shift/update','Backend\Shift\ShiftController@update');
            Route::get('Shift/delete/{id}', 'Backend\Shift\ShiftController@delete');
            Route::get('Shift/last_update/{id}', 'Backend\Shift\ShiftController@last_update');
            Route::get('Shift/Permission/{id}', 'Backend\Shift\ShiftController@permission');
            Route::post('Shift/Permission/update', 'Backend\Shift\ShiftController@shift_update');
           
        });
        //end shift

        //Sale Summary Detail Report (Daily/Monthly/Yearly) & Excel Download
            Route::get('saleSummaryDetailReport/{checked}', 'Backend\Report\CategorySaleSummaryReportController@saleSummaryDetailReport');
            Route::get('saleSummaryMonthlyDetailExport', 'Cashier\Report\CategorySaleSummaryReportController@saleSummaryMonthlyDetailExport');



         //Start Log Middleware
        Route::group(['middleware'=>'log:Cashier'],function(){
            Route::get('Pricehistory/{type?}/{id?}','Backend\Log\PricelogController@search');
            Route::get('Confighistory','Backend\Log\ConfiglogController@index');
            Route::get('Discounthistory','Backend\Log\DiscountlogController@index');
            Route::get('SyncApi','Backend\Log\ApilistController@sync');
            Route::get('MakeApi','Backend\Log\ApilistController@make');
            Route::get('DownloadApi','Backend\Log\ApilistController@down');
        });


        /*-----------for csv import-----------*/
         //csv import
        Route::group(['middleware'=>'csv:Cashier'],function(){
            Route::get('import','Backend\CSV\CSVImportController@import');
            Route::post('import/store','Backend\CSV\CSVImportController@store');

           
           
        });
        //end csv import


        //Start Remark
        Route::group(['middleware'=>'remark:Cashier'],function(){
            Route::get('Remark/index', 'Backend\Remark\RemarkController@index');
            Route::get('Remark/create', 'Backend\Remark\RemarkController@create');
            Route::post('Remark/store', 'Backend\Remark\RemarkController@store');
            Route::get('Remark/edit/{id}', 'Backend\Remark\RemarkController@edit');
            Route::post('Remark/update', 'Backend\Remark\RemarkController@update');
            Route::get('Remark/delete/{ids}', 'Backend\Remark\RemarkController@delete');
          
            Route::get('Remark/active/{id}', 'Backend\Remark\RemarkController@active');
            Route::get('Remark/inactive/{id}', 'Backend\Remark\RemarkController@inactive');

        });
        //End remark
       

            
            
        });
        //end   
        
         Route::get('csv', 'Backend\Report\ReportController@favourite_set_menus');
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
Route::post('api/v1/user', 'syncAPIController@user');//fns
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
Route::post('api/v1/booking_table','syncAPIController@booking_table');
Route::post('api/v1/booking_room','syncAPIController@booking_room');
Route::post('api/v1/promotion','syncAPIController@promotion');
Route::post('api/v1/promotion_item','syncAPIController@promotionItem');
Route::post('api/v1/syncs_table','syncAPIController@getSyncsTable');
Route::post('api/v1/syncs', 'syncAPIController@sync_table');

//API Post Method
Route::post('api/v1/login', 'makeAPIController@login');
//First Time Login
Route::post('api/v1/first_time_login', 'makeAPIController@first_time_login');

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
Route::post('api/v1/frontend_log','makeAPIController@frontend_log');

Route::post('api/v1/download_voucher','downloadApiController@download_voucher');
Route::post('api/v1/download_voucher_detail','downloadApiController@download_voucher_detail');
Route::post('api/v1/order_table','downloadApiController@order_table');
Route::post('api/v1/order_room','downloadApiController@order_room');

Route::post('api/v1/download_order_table_with_order_id','downloadApiController@order_table_with_order_id');
Route::post('api/v1/download_order_room_with_order_id','downloadApiController@order_room_with_order_id');
Route::post('api/v1/download_order_table_status','downloadApiController@download_order_table_status');