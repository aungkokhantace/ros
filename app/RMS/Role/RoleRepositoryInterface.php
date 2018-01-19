<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/21/2016
 * Time: 4:24 PM
 */

namespace App\RMS\Role;


interface RoleRepositoryInterface
{
    public function getRoles();
    public function getPermissionWithModules();
    public function store($name,$description,$permission,$id);
    public function update($id,$name,$description,$permission,$updated_by);
    public function getID($id);
    public function delete_role($id,$deleted_by);
    public function check_staff($id);
}