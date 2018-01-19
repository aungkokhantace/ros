<?php
namespace App\RMS\Invoice;
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/24/2016
 * Time: 4:27 PM
 */
interface InvoiceRepositoryInterface
{
    public function getinvoice();
    public function getinvoiceCancel();
    public function getCard();
    public function getPayment($id);
    public function getdetail($id);
    public function getaddon($id);
    public function getorder($id);
    public function getaddonAmount($id);
    public function orderTable($id);
    public function orderRoom($id);
    public function cashier($id);
    public function addpaid($id);
    public function updateOrder($paramObj);
    public function update($id,$input,$refund);
}