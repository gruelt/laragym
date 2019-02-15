@extends('layouts.default')


@section('title')
    Liste des Adhérents
@stop

@section('content')

    <table id="mydatatable" class="display" style="width:100%">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Uid</th>
            <th>Etat</th>
            <th>Modifier</th>

        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Uid</th>
            <th>Etat</th>
            <th>Modifier</th>

        </tr>
        </tfoot>
    </table>

@stop

@section('script')
    <script>
        $(document).ready(function() {

            var table = $('#mydatatable').DataTable( {
                ajax: {
                    url: '/api/user',
                    dataSrc: ''
                },
                "columns": [
                    { "data": "name" },
                    { "data": "firstname" },
                    { "data": "ldapuid" },
                    { "data": "etat",
                        "render": function(data, type, row, meta) {
                            if (row.etat === 'actif')
                            {
                                return "<span class=\"badge badge-success\">"+row.etat+"</span>";
                            }
                            else
                            {
                                return "<span class=\"badge badge-secondary\">"+row.etat+"</span>";
                            }

                        }
                    },
                    {
                        "data": "weblink",
                        "render": function(data, type, row, meta){

                            data = '<a href="/admin/user/' + row.id + '">Consulter </a>';

                            return data;
                        }
                    }
                ]
            } );


            /**Autoreload **/
            // setInterval( function () {
            //     table.ajax.reload();
            // }, 2000 );
        } );
    </script>
@stop