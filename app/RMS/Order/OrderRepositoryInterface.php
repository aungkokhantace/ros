<?php
namespace App\RMS\Order;
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/24/2016
 * Time: 4:27 PM
 */
interface OrderRepositoryInterface
{

    public function getInvoice($id);
    public function getVoucher();
    public function orderTable();
    public function orderRoom();
    public function orderExtra();
    public function getFoodListDetail($order_id,$order_status);
}