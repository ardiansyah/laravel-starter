@extends('layouts.default')

@section('content')
<div class="col-lg-12">
    <h1 class="page-header">Group</h1>
</div>
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="/users/role/create" class="btn btn-primary">Tambah Group</a>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td class="text-center" style="width: 200px">
                                <div class="btn-group">
                                    <a href="/users/role/edit/{{$role->id}}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                    <a href="/users/role/delete/{{$role->id}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center">No Data</td>
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
