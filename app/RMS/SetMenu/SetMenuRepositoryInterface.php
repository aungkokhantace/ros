<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 5/6/2016
 * Time: 11:06 AM
 */

namespace App\RMS\SetMenu;


interface SetMenuRepositoryInterface
{
    public function getCategories();
    public function getItems();
    public function getContinent();
    public function getKitchen();
    public function store($paramObj,$items);
    public function getSetItem();
    public function getAllItem();
    public function delete($id);
    public function getAllSet();
    public function setMenuUpdate($paramObj,$item,$oldprice);
    public function itemUpdate($paramObj,$item,$oldprice);
    public function getOldName($id);
    public function getAllNames();
}
