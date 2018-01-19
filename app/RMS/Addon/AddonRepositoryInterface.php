<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 4/28/2016
 * Time: 11:49 AM
 */

namespace App\RMS\Addon;


interface AddonRepositoryInterface
{
    public function getAllType();
    public function store($paramObj);
    public function extra_delete($id);
    public function extra_edit($id);
    public function update($paramObj,$oldprice);
    public function updateall($paramObj,$oldprice);
    public function getOldName($id);
    public function getAllNames();
}