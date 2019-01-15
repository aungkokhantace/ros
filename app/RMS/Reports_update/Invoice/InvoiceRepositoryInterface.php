<?php 
namespace App\RMS\Reports_update\Invoice;

/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/18/2016
 * Time: 9:35 AM
 */
interface InvoiceRepositoryInterface
{

    public function getorder($id);
    public function getaddon($id);
    public function getaddonAmount($id);
    public function getContinent();
    public function getdetail($id);
    public function orderTable($id);
    public function orderRoom($id);
    public function cashier($id);

}