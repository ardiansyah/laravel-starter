@extends('layouts.default')

@section('content')
<?php use Illuminate\Support\Str; ?>
<div class="col-lg-12">
    <h1 class="page-header">Tambah Group</h1>
</div>
<div class="col-lg-12">
    <div class="panel panel-default">
        <!-- <div class="panel-heading">
            <a href="#" class="btn btn-primary">Tambah Group</a>
        </div> -->
        {!! Form::open() !!}
        <div class="panel-body">
            <div class="row">
                <div class="form-group col-md-12">
                    <label>Nama Group</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <div class="form-group col-md-12">
                <label for="exampleInputPassword1">Permissions</label>

                <div class="row" style="padding: 15px 25px;">
                    @foreach(Permission::render() as $key => $permissions)

                        <div class="col-md-6 permissions" id="">
                            <label class="permissions-label"> <a data-toggle="collapse" href="#{{ $key }}" aria-expanded="false"> {{ $key }} </a></label>
                            <div id="{{ $key }}" class="collapse">
                            @foreach($permissions as $permission)

                                <label for="Form-field-User-permissions-cms.manage_layouts"> {{ Str::title($permission) }} </label>
                                <div
                                    data-control="balloon-selector"
                                    id=""
                                    class="control-balloon-selector"
                                    data-trigger-action="disable"
                                    data-trigger='[name="superuser"]'
                                    data-trigger-condition="checked">
                                    <ul>
                                        <li data-value="1" class="">Allow</li>
                                        <li data-value="" class="active">Deny</li>
                                    </ul>

                                    <input type="hidden" name="permissions[{{ $permission }}]" value="inherit"/>
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
            <a class="btn btn-default" href="/users/role">Kembali</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@stop
