<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/28/2016
 * Time: 11:51 AM
 */

namespace App\RMS\Item;


interface ItemRepositoryInterface
{
    public function store($paramObj);
    public function ChooseCat();
    public function selectParent();
    public function selectSub();

    //  Testing for multilevel
        public function selectCat();
    //  Testing for multilevel
    public function find($id);


    public function getAllItemName();
    public function allCat();
    public function updateItem($paramObj);
    public function updateAllItem($paramObj);
    public function delete($id);
    public function itemenabled($id);
    public function itemdisabled($id);
}