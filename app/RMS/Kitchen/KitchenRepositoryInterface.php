<?php

/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 6/8/2016
 * Time: 10:22 AM
 */

namespace App\RMS\Kitchen;
interface KitchenRepositoryInterface
{
    public function store($paramObj);
    public function update($paramObj);
    public function delete($id);
    public function check_category($id);
    public function check_staff($id);
}