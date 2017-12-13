<?php
namespace App\RMS\Permission;

use App\RMS\Utility;
use Illuminate\Support\Facades\DB;
use App\User;
use App\RMS\Permission\Permission;

class PermissionRepository
{
    public function getModuleArr($role_id)
    {
        $getList    = Permission::select('module_id')
                    ->where('role_id',$role_id)
                    ->whereNull('deleted_at')
                    ->get()
                    ->toArray();
        return $getList;
    }
}