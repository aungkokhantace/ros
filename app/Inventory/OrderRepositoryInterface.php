<?php
namespace App\Inventory;

interface OrderRepositoryInterface
{

    public function getOrderById($id);
}