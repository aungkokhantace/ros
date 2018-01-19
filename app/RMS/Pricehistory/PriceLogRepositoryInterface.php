<?php


namespace App\RMS\Pricehistory;

interface PriceLogRepositoryInterface
{
   public function getPricehistory($type,$id);
}