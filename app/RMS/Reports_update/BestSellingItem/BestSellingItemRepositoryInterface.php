<?php 
namespace App\RMS\Reports_update\BestSellingItem;

/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/18/2016
 * Time: 9:35 AM
 */
interface BestSellingItemRepositoryInterface
{
    
  public function bestItem($from_date,$to_date,$number,$from_amount,$to_amount);
   
    
    
}