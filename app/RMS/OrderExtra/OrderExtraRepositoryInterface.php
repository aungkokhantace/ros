<?php
namespace App\RMS\OrderExtra;
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/24/2016
 * Time: 4:27 PM
 */
interface OrderExtraRepositoryInterface
{
	public function delete($order_detail_id);
	public function getAddonPrice($addon_id);
}