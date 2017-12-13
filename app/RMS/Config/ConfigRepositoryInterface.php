<?php

/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 5/27/2016
 * Time: 4:49 PM
 */
namespace App\RMS\Config;
interface ConfigRepositoryInterface
{
    public function find($id);
    public function insert_config($paramObj);
    public function update_config($paramObj);
    public function getAllConfig();
    public function insert_config_log($tempObj);
}