<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/6/2016
 * Time: 10:57 AM
 */

namespace App\RMS\Remark;


interface RemarkRepositoryInterface
{
    public function store($paramObj);
    public function getRemark();
    public function getRemarkById($id);
    public function update($paramObj);
    public function deleteRemarkData($Remark_id);
  
}