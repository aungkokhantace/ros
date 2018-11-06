<?php
/**
 * Created by PhpStorm.
 * User: UNiQUE
 * Date: 3/24/2016
 * Time: 2:36 PM
 */

namespace App\RMS\CSV;


interface CSVRepositoryInterface
{
	public function create_add_on($data,$restaurant_id,$branch_id);
  

}