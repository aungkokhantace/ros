<?php
/**
 * Created by PhpStorm.
 * User: UNiQUE
 * Date: 3/24/2016
 * Time: 2:36 PM
 */

namespace App\RMS\Category;


interface CategoryRepositoryInterface
{
    public function find($id);
    public function ChooseCat();
    public function selectCat();
    public function findcat($id);
    public function enabledmulti($id);
    public function disabledmulti($id);
    public function getAllCategory();
    public function getMainCategory();
    public function store($paramObj);
    public function editCategory($id);
    public function subCategory($send_id);
    public function deleteCategory($id);
    public function updateAllCategory($paramObj);
    public function updateCategory($paramObj);
    public function getAllCategoryName();
    public function item($id);
    public function catenabled($id);
    public function catdisabled($id);
    public function getKitchen();
    public function getKitchenByCat($catID);

}