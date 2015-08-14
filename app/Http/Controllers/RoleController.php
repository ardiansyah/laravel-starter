<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Flash;
use Setting;

class RoleController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        parent::__construct();

        $this->request = $request;
    }

    public function getIndex()
    {
        Setting::set('app.name', 'My Starter');
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }

    public function getCreate()
    {
        return view('role.create');
    }

    public function postCreate()
    {
        $this->validate($this->request, [
            'name' => 'required|unique:roles,name',
            // 'name' => 'unique:roles,slug',
        ]);

        try{

            $role = Role::create([
                'name' => $this->request->get('name'),
                'slug' => str_slug($this->request->get('name')),
            ]);

            foreach ($permissions = $this->request->get('permissions')  as $key => $value) {
                if($value == '1'){
                    if(isset($role->permissions[$key])){
                        $role->updatePermission($key)->save();
                    }
                    $role->addPermission($key)->save();
                }else{
                    $role->removePermission($key)->save();
                }
            }

            return redirect('/users/role');

        }catch(Exception $e){

        }
    }

    public function getEdit($id)
    {
        $role = Role::find($id);

        return view('role.edit', compact('role'));
    }

    public function postEdit($id, Request $request)
    {
        // return $request->all();
        $this->validate($this->request, [
            'name' => 'required|unique:roles,name,'.$id
        ]);

        try{

            $role = Role::find($id);
            $role->fill($this->request->all());
            $role->save();

            foreach ($permissions = $this->request->get('permissions')  as $key => $value) {
                if($value == '1'){
                    if(isset($role->permissions[$key])){
                        $role->updatePermission($key)->save();
                    }
                    $role->addPermission($key)->save();
                }else{
                    $role->removePermission($key)->save();
                }
            }

            Flash::success('Data berhasil ri rubah');

            return redirect()->back();

        }catch(Exception $e){

        }

    }

    public function getDelete($id)
    {
        Role::destroy($id);

        return redirect()->back();
    }
}
