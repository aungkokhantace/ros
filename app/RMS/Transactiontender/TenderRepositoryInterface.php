<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 4/28/2016
 * Time: 11:49 AM
 */

namespace App\RMS\Transactiontender;


interface TenderRepositoryInterface
{
	public function getTenderByCode($code);
	public function getOrderStatus($order_id);
    public function store($paramObj);
    public function update($paramObj);
    public function delete($paramObj);
    public function getTenderPayment($order_id);
    public function getTenderByOrder($order_id,$order_payment);
}