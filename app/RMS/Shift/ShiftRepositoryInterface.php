<?php

/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 6/8/2016
 * Time: 10:22 AM
 */

namespace App\RMS\Shift;
interface ShiftRepositoryInterface
{
	public function getDayShiftID($shift_name);
	public function getShiftCategoryID($id);
	public function getShiftUserID($id);
    public function store($paramObj);
   
}