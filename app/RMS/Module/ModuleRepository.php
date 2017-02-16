<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/29/2016
 * Time: 4:45 PM
 */

namespace App\RMS\Module;


use App\RMS\ReturnMessage;
use App\RMS\Utility;

class ModuleRepository implements ModuleRepositoryInterface
{
    public function store($paramObj){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addCreatedBy($paramObj);
            $tempObj->save();

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function getModules(){
        $modules = Module::whereNull('deleted_at')->get();
        return $modules;
    }

    public function getModuleById($id){
        $module = Module::find($id);
        return $module;
    }

    public function update($paramObj){
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $tempObj = Utility::addUpdatedBy($paramObj);
            $tempObj->save();

            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(\Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }
}