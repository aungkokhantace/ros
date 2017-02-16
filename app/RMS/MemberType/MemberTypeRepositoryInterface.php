<?php
/**
 * Created by PhpStorm.
 * User: Dell Inspiron
 * Date: 3/24/2016
 * Time: 10:38 AM
 */

namespace App\RMS\MemberType;


interface MemberTypeRepositoryInterface
{
    public function getAllType();
    public function All();
    public function store($paramObj);
    public function member_type_edit($id);
    public function member_type_delete($id);
    public function update($paramObj);
    public function check_member($id);
}