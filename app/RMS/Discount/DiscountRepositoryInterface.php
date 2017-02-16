<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 3/24/2016
 * Time: 1:53 PM
 */

namespace App\RMS\Discount;


interface DiscountRepositoryInterface
{
    public function getAllUser();
    public function store($paramObj);
    public function discount_delete($id);
    public function getItem();
    public function discount_edit($id);
    public function update($paramObj);

}
