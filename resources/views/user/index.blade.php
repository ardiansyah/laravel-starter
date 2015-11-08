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
            <table class="table table-bordered" id="datatable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>First Name</th>
                            <th>Email</th>
                            <th>created_at</th>
                            <th>updated_at</th>
                            <th></th>
                        </tr>
                    </thead>
                    
                </table>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>
<script id="details-template" type="text/x-handlebars-template">
    <table class="table">
        <tr>
            <th width="10%">Groups:</th>
            <td>
                @{{#join roles ", "}}
                    @{{name}}
                @{{/join}}
            </td>
        </tr>
        <tr>
            <th>Permissions:</th>
            <td>
                @{{#permissions permissions }}
                    
                @{{/permissions}}
               
            </td>
        </tr>
    </table>
</script>
@stop

@section('scripts')
<script>
    var template = Handlebars.compile($("#details-template").html());
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/users/user/datatable',
        columns: [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": '',
                // orderable: false, searchable: false
            },
            {data: 'first_name', name: 'first_name'},
            {data: 'email', name: 'email'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
    $('#datatable').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        
        Handlebars.registerHelper( "join", function( array, sep, options ) {
            return array.map(function( item ) {
                return options.fn( item );
            }).join( sep );
        });
        
        Handlebars.registerHelper('permissions', function(items, options) {
            var n = 0;
            var out = "<div class='row'><div class='col-md-3'>";
    
            $.each(items, function(i, v){
                out = out + "<p>" + i + " = "+ v +"</p>"
                if(n % 1 == 4){
                     out = out + "</div><div class='col-md-3'>"
                }
                n++;
            })
            
            return out + "</div></div>";
        });

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( template(row.data()) ).show();
            tr.addClass('shown');
        }
    });
</script>
@stop