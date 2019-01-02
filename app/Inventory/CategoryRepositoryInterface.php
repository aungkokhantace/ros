<?php
namespace App\Inventory;

interface CategoryRepositoryInterface
{

    public function SelectParentId($id);

    public function getParentCate();
}