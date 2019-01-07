<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 5/6/2016
 * Time: 10:57 AM
 */

namespace App\RMS\Continent;


interface ContinentRepositoryInterface
{
    public function getContinent();
    public function getCategories();
    public function getContinentID($id);
    public function store($paramObj,$syncData);
    public function update($paramObj,$syncData);
    public function deleteContinent($id);
  
}