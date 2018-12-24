<?php
namespace App\RMS\Orderdetail;
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/24/2016
 * Time: 4:27 PM
 */
interface OrderdetailRepositoryInterface
{
	public function store($paramObj);
	public function getCategoriesByParent($parent_id,$shift_id);
	public function getItemsByCategory($categoryID);
	public function getBackCategoryByID($id,$shift_id);
    public function getCategories();
    public function categoryDetail($id);
    public function getsetmenu($shift_id);
    public function getSetItemBySetID($id);
    public function getitem($id);
    public function searchItem($id);
    public function getorder($id);
    public function getaddon($id);
    public function cashier($id);
    public function getaddonAmount($id);
    public function getContinent($itemID);
    public function getdetail($id);
    public function orderTable($id);
    public function orderRoom($id);
}