<?php namespace App\RMS\User;

/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/21/2016
 * Time: 3:51 PM
 */
interface UserRepositoryInterface
{
    public function store($paramObj);
    public function getUsers();
    public function getRoles();
    public function delete_users($id,$deleted_by);
    public function active($id);
    public function inactive($id);
    public function getID($id);
    public function updateWithUserType($id,$name,$userType,$updated_by);
    public function update($id,$name,$updated_by);
    public function changeDisableToEnable($id,$cur);
    public function changeEnableToDisable($id);
    public function getIdForStaffId($id);
    public function getUsersForStaffId($id);
    public function updateProfile($paramObj);
    public function getKitchens();

}