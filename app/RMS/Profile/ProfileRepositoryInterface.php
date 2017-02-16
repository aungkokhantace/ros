<?php


namespace App\RMS\Profile;

interface ProfileRepositoryInterface
{
   public function All();
   public function updateAll($paramObj);
   public function updatelogo($paramObj);
   public function updatemobilelogo($paramObj);
   public function update($paramObj);
   public function getAllProfile();
   public function save($paramObj);
   public function saveall($paramObj);
   public function savelogo($paramObj);
   public function savemobilelogo($paramObj);
}