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
	public function getCategoriesByParent($parent_id);
	public function getItemsByCategory($categoryID);
	public function getBackCategoryByID($id);
    public function getCategories();
    public function categoryDetail($id);
    public function getsetmenu();
    public function getitem($id);
    public function searchItem($id);
}