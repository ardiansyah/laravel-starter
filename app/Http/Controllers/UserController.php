<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Sentinel;
use Flash;

class UserController extends Controller
{

    protected $request;

    public function __construct(Request $request)
    {
        parent::__construct();

        $this->request = $request;
    }

    public function getIndex()
    {
        if( ! $this->hasPermission('manage.user')) {
            return response()->view('errors.401', [], 401);
        }

        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function getCreate()
    {
        if( ! $this->hasPermission('create.user') ) {
            return response()->view('errors.401', [], 401);
        }

        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    public function postCreate()
    {
        $input = $this->request->all();

        $this->validate($this->request, [
           'first_name' => 'required',
           'email' => 'required|email',
           'roles' => 'required',
           'password' => 'required|confirmed'
       ]);

       try {
           $user = Sentinel::registerAndActivate([
               'first_name' => $this->request->get('first_name'),
               'email' => $this->request->get('email'),
               'password' =>$this->request->get('password'),
           ]);

           if($this->request->get('superuser')){
               $this->addSuperUser($user)->save();
           }

           $user->roles()->attach($this->request->get('roles'));

           foreach ($permissions = $this->request->get('permissions')  as $key => $value) {
               if($value == '1'){
                   if(isset($user->permissions[$key])){
                       $user->updatePermission($key)->save();
                   }
                   $user->addPermission($key)->save();
               }elseif($value == ''){
                   if(isset($user->permissions[$key])){
                       $user->updatePermission($key, false)->save();
                   }
                   $user->addPermission($key, false)->save();
               }else{
                   $user->removePermission($key)->save();
               }
           }

           Flash::success('Data berhasil ri rubah');

           return redirect('/user/edit/'.$user->id);

       }catch(Exception $e){

           return redirect()->back()->with($e->getMessage());
       }

    }

    public function getEdit($id)
    {
        if( ! $this->hasPermission('edit.user')) {
            return response()->view('errors.401', [], 401);
        }

        if($this->user->id == $id)
            return redirect('/user/myaccount/'.$id);

        $roles = Role::all();
        $user = User::find($id);

        list($permissions, $values) = array_divide($user->permissions);
        return view('user.edit', compact('user', 'roles', 'permissions'));
    }

    public function postEdit($id)
    {
        $input = $this->request->all();

        $rules = [
            'first_name' => 'required',
            'email' => 'required|email',
            'roles' => 'required'
        ];

        if($this->request->get('password')){
            $rules = array_add($rules, 'password', 'required|confirmed');
        }

        $this->validate($this->request, $rules);

        try{

            $user = User::find($id);
            $input = [
                'first_name' => $this->request->get('first_name'),
                'email' => $this->request->get('email')
            ];

            if($this->request->get('password')){
                $input = array_add($input, 'password', $this->request->get('password'));
            }

            Sentinel::update($user, $input);

            if($this->request->get('superuser')){
                $this->addSuperUser($user);
            }else{
                $this->removeSuperUser($user);
            }

            $user->roles()->sync($this->request->get('roles'));

            foreach ($permissions = $this->request->get('permissions')  as $key => $value) {
                if($value == '1'){
                    if(isset($user->permissions[$key])){
                        $user->updatePermission($key)->save();
                    }
                    $user->addPermission($key)->save();
                }elseif($value == ''){
                    if(isset($user->permissions[$key])){
                        $user->updatePermission($key, false)->save();
                    }
                    $user->addPermission($key, false)->save();
                }else{
                    $user->removePermission($key)->save();
                }
            }

            Flash::success('Data berhasil ri rubah');

            return redirect()->back();

        }catch(Exception $e){

        }

    }

    public function getDelete($id)
    {
        if( ! $this->hasPermission('delete.user')) {
            return response()->view('errors.401', [], 401);
        }

        $user = User::find($id);
        $user->delete();
        Flash::success('Data berhasil ri rubah');
        return redirect('/user');
    }

    public function getMyaccount($id)
    {
        $user = User::find($id);
        return view('user.myaccount', compact('user'));
    }

    public function postMyaccount($id)
    {
        $input = $this->request->all();

        $rules = [
            'first_name' => 'required',
            'email' => 'required|email',
        ];

        if($this->request->get('password')){
            $rules = array_add($rules, 'password', 'required|confirmed');
        }

        $this->validate($this->request, $rules);

        try{

            $user = User::find($id);
            $input = [
                'first_name' => $this->request->get('first_name'),
                'email' => $this->request->get('email')
            ];

            if($this->request->get('password')){
                $input = array_add($input, 'password', $this->request->get('password'));
            }

            Sentinel::update($user, $input);

            Flash::success('Data berhasil ri rubah');

            return redirect()->back();

        }catch(Exception $e){

        }
    }

    public function addSuperUser($user)
    {
        $user->addPermission('superuser');

        return $user->save();
    }

    public function removeSuperUser($user)
    {
        $user->removePermission('superuser');

        return $user->save();
    }

}
