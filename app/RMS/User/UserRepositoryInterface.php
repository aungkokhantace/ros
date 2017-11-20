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
    public function getID($id);
    public function updateWithUserType($id,$name,$staffId,$userType,$kitchenId,$updated_by);
    public function update($id,$name,$staffId,$updated_by);
    public function changeDisableToEnable($id,$cur);
    public function changeEnableToDisable($id);
    public function getIdForStaffId($id);
    public function getUsersForStaffId();
    public function updateProfile($paramObj);
    public function getKitchens();

}