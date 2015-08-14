@extends('layouts.default')

@section('content')
<div class="col-lg-12">
    <h1 class="page-header">User</h1>
</div>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="/users/user/create" class="btn btn-primary">Tambah User</a>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>

                            <th>Nama</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{$user->first_name}}</td>
                            <td>{{$user->email}}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="/users/user/edit/{{$user->id}}" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                    <a href="/users/user/delete/{{$user->id}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="no-data"> No Data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>

@stop
