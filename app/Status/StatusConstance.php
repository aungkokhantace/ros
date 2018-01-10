<?php namespace App\Status;

/**
 * Created by PhpStorm.
 * User: william
 * Date: 7/13/2017
 * Time: 1:11 PM
 */
class StatusConstance
{
    //Order Status
    const ORDER_CREATE_STATUS                   = 1;//Order create Status
    const ORDER_PAID_STATUS                     = 2; //Order Paid Status
    const ORDER_CANCEL_STATUS                   = 3; //Order Cancel Status

    //Order Detail Status
    const ORDER_DETAIL_COOKING_STATUS           = 1; //Order Detail Cooking Status
    const ORDER_DETAIL_COOKED_STATUS            = 2; //Order Detail Cooked Status
    const ORDER_DETAIL_COOKING_DONE_STATUS      = 3; //Order Detail Cooking Done Status
    const ORDER_DETAIL_DELIEVERED_STATUS        = 4; //Order Detail Taken By Waiter Status
    const ORDER_DETAIL_COMPLETED_STATUS         = 5; //Order Detail Completed Status
    const ORDER_DETAIL_KITCHEN_CANCEL_STATUS    = 6; //Order Detail CANCEL Status
    const ORDER_DETAIL_CUSTOMER_CANCEL_STATUS   = 7; //Order Detail CANCEL Status

    //Order Set Menu Status
    const ORDER_SETMENU_COOKING_STATUS          = 1; //Order Set Menu Cooking Status
    const ORDER_SETMENU_COOKED_STATUS           = 2; //Order Set Menu Cooked Status
    const ORDER_SETMENU_COOKING_DONE_STATUS     = 3; //Order Set Menu Cooking Done Status
    const ORDER_SETMENU_KITCHEN_CANCEL_STATUS   = 6; //Order Set Menu Cancel Status

    //Table Status
    const TABLE_AVAILABLE_STATUS                = 0; //TABLE AVAILABLE STATUS
    const TABLE_UNAVAILABLE_STATUS              = 1; //TABLE UNAVAILABLE STATUS
    const TABLE_WARNING_STATUS                  = 2; //TABLE WARNING STATUS
    const TABLE_WAITING_STATUS                  = 3; //TABLE WAITING STATUS

    //Table Active Status
    const TABLE_ACTIVE_STATUS                   = 1; //TABLE AVAILABLE STATUS
    const TABLE_INACTIVE_STATUS                 = 0; //TABLE AVAILABLE STATUS

     //Room Active Status
    const ROOM_ACTIVE_STATUS                    = 1; //TABLE AVAILABLE STATUS
    const ROOM_INACTIVE_STATUS                  = 0; //TABLE AVAILABLE STATUS

    //Booking Status
    const BOOKING_DEFAULT_STATUS                = 0; //BOOKING DEFAULT STATUS
    const BOOKING_WARNING_STATUS                = 2; //BOOKING WARNING STATUS
    const BOOKING_WAITING_STATUS                = 3; //BOOKING WAITING STATUS
    const BOOKING_DONE_STATUS                   = 4; //BOOKING DONE STATUS

    //Room Status
    const ROOM_AVAILABLE_STATUS                 = 0; //ROOM AVAILABLE STATUS
    const ROOM_UNAVAILABLE_STATUS               = 1; //ROOM UNAVAILABLE STATUS

    //Order Extra Status
    const ORDER_EXTRA_AVAILABLE_STATUS          = 1; //ORDER EXTRA AVAILABLE STATUS
    const ORDER_EXTRA_UNAVAILABLE_STATUS        = 0; //ORDER EXTRA UNAVAILABLE STATUS

    //Item Status
    const ITEM_AVAILABLE_STATUS                 = 1; //ITEM AVAILABLE STATUS
    const ITEM_UNAVAILABLE_STATUS               = 0; //ITEM UNAVAILABLE STATUS

    //User Status
    const USER_AVAILABLE_STATUS                 = 1; //USER AVAILABLE STATUS
    const USER_UNAVAILABLE_STATUS               = 0; //USER UNAVAIABLE STATUS
}