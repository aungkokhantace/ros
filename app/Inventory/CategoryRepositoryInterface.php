<?php
namespace App\Inventory;

interface CategoryRepositoryInterface
{
    public function SelectParentId($id);
    public function getGroup($groups);
    public function getParentCate();
    public function getCalss($classes);
}