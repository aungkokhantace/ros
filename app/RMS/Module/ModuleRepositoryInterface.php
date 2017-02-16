<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/29/2016
 * Time: 4:44 PM
 */

namespace App\RMS\Module;


interface ModuleRepositoryInterface
{
    public function store($paramObj);
    public function getModules();
    public function getModuleById($id);
    public function update($paramObj);
}