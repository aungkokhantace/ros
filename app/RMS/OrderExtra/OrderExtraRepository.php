<?php

namespace App\RMS\OrderExtra;



class OrderExtraRepository implements OrderExtraRepositoryInterface {


   public function delete($order_detail_id){
     
   }

   public function getAddonPrice($addon_id){
      $addon_price = DB::table('addon_on')->where('id',$addon_id)->where('status',1)->first();
      return $addon_price->price;
   }


}