<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/24/2016
 * Time: 10:20 AM
 */

namespace App\RMS\Member;


interface MemberRepositoryInterface
{
    public function getAllMemberType();
    public function getCategoryModel();
    public function store($paramObj,$fav);
    public function getMemberModel();
    public function getAllItem();
    public function selectCat();
    public function delete($id);
    public function getMemberModelById($id);
    public function update($paramObj,$fav);
    public function getCategories();
    public function getItems();
}