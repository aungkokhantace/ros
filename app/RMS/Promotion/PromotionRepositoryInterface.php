<?php


namespace App\RMS\Promotion;

interface PromotionRepositoryInterface
{
    public function All();
    public function store($paramObj,$sell_item);
    public function delete($id);
    public function update($paramObj, $sell_item);
}