@extends('layouts.default')

@section('content')
<?php use Illuminate\Support\Str; ?>
<div class="col-lg-12">
    <h1 class="page-header">Edit User</h1>
</div>
<div class="col-lg-12">
    <div class="panel panel-default">
        <!-- <div class="panel-heading">
            <a href="#" class="btn btn-primary">Tambah Group</a>
        </div> -->
        {!! Form::open(['files' => 'true']) !!}
        <div class="panel-body">
            <div class="row">
                <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Nama Pengguna</label>
                <input type="text" name="first_name" class="form-control" placeholder="Nama" value="{{$user->first_name}}">
            </div>
            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" value="{{$user->email}}">
            </div>
            <div class="form-group col-md-6">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group col-md-6">
                <label for="exampleInputPassword1">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <!--<label>Foto</label>-->
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                        <img data-src="" src="{{ sizeof($user->getMedia()) !== 0 ? $user->getMedia()[0]->getUrl() : '' }}" alt="...">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                    <div>
                        <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" name="avatar"></span>
                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                    </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <!-- <label for="exampleInputPassword1">Confirm Password</label> -->
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="1" name="superuser" {{ isset($user->permissions['superuser']) ? 'checked' : '' }} {{ $user->hasAccess('superuser') ? 'disabled' : '' }}>

                        Super User
                    </label>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputPassword1">Role</label>
                @foreach($roles as $role)
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="{{$role->id}}" name="roles[]" {{ $user->roles->contains($role->id) ? 'checked' : '' }}>

                        {{$role->name}}
                    </label>
                </div>
                @endforeach
            </div>
            <div class="form-group col-md-12">
                <label for="exampleInputPassword1">Permissions</label>

                <div class="row" style="padding: 15px 25px;">
                @foreach(Permission::render() as $key => $permissions)

                    <div class="col-md-6 permissions">
                        <label class="permissions-label"><a data-toggle="collapse" href="#{{ $key }}" aria-expanded="false"> {{ $key }} </a></label>
                        <div id="{{ $key }}" class="collapse">
                        @foreach($permissions as $permission)
                            <label for="Form-field-User-permissions-cms.manage_layouts"> {{ Str::title($permission) }} </label>
                            <div
                                data-control="balloon-selector"
                                id=""
                                class="control-balloon-selector {{ $user->hasAccess('superuser') ? 'disabled' : 'control-disabled' }}"
                                data-trigger-action="disable"
                                data-trigger='[name="superuser"]'
                                data-trigger-condition="checked">
                                <ul>
                                    <li data-value="1" class=" {{ isset($user->permissions[$permission]) && $user->permissions[$permission] == true ? 'active' : '' }} ">Allow</li>
                                    <li data-value="inherit" class=" {{ ! isset($user->permissions[$permission]) ? 'active' : '' }} ">Inherit</li>
                                    <li data-value="" class=" {{ isset($user->permissions[$permission]) && !$user->permissions[$permission] ? 'active' : '' }} ">Deny</li>
                                </ul>

                                <input type="hidden" name="permissions[{{ $permission }}]" value="{{ isset($user->permissions[$permission]) ? $user->permissions[$permission] : 'inherit' }}"/>
                            </div>
                        @endforeach
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
            </div>
        </div>

        <div class="panel-footer">
            <button class="btn btn-primary">Simpan</button>
            <a class="btn btn-default" href="/users/user">Kembali</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@stop
