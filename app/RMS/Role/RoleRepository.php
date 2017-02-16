<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/21/2016
 * Time: 4:26 PM
 */

namespace App\RMS\Role;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\RMS\Permission\Permission;
use App\RMS\ReturnMessage;
class RoleRepository implements RoleRepositoryInterface
{
    public function getRoles(){
        $roles = Role::all();
        return $roles;
    }

    public function getPermissionWithModules(){
        $permissions    = Permission::leftjoin('modules','modules.id','=','permissions.module_id')
                            ->select('modules.module','permissions.role_id')->get();

        return $permissions;
    }

    public function store($name,$description,$permission,$id)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            $id = DB::table('roles')->insertGetId(['name' => $name,'description' => $description,'created_by'=>$id]);
            foreach ($permission as $p) {
                DB::table('permissions')
                    ->insert(['role_id' => $id, 'module_id' => $p]);
            }
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }

    public function getID($id){
        $role = Role::find($id);
        return $role;
    }

    public function delete_role($id,$deleted_by){
        $new_string = explode(',', $id);
        foreach ($new_string as $id) {
            Role::find($id)->delete();
            DB::table('roles')->where('id',$id)->update(['deleted_by'=>$deleted_by]);
            Permission::where('role_id',$id)->delete();
        }
    }

    public function update($id,$name, $description, $permission,$updated_by)
    {
        $returnedObj = array();
        $returnedObj['aceplusStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;

        try {
            DB::table('roles')->where('id', Input::get('id'))->update(['name' => $name, 'description' => $description,
                'updated_by'=>$updated_by]);
            if (isset($permission)) {
                DB::table('permissions')->where('role_id', $id)->delete();
                foreach ($permission as $p) {
                    DB::table('permissions')->insert(['role_id' => $id, 'module_id' => $p]);
                }
            }
            $returnedObj['aceplusStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        }
        catch(Exception $e){

            $returnedObj['aceplusStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }


    }

    public function check_staff($id){
        $subcategory = DB::table('users')->where('role_id', '=', $id)->first();//check whether there are users of this user_type
        return $subcategory;
    }
}