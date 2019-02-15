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

            <th>Genre</th>
            <th>Compétitif</th>
            <th>Modifier</th>

        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>

            <th>Genre</th>
            <th>Compétitif</th>
            <th>Modifier</th>

        </tr>
        </tfoot>
    </table>

@stop

@section('script')
    <script>
        $(document).ready(function() {

            // Setup - add a text input to each footer cell
            $('#mydatatable thead tr').clone(true).appendTo( '#mydatatable thead' );
            $('#mydatatable thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );


            var table = $('#mydatatable').DataTable( {
                ajax: {
                    url: '/api/admin/gymnastes',
                    dataSrc: ''
                },
                "columns": [
                    { "data": "nom" },
                    { "data": "prenom" },
                    { "data": "genre",
                        "render": function(data, type, row, meta) {
                            if (row.genre_id === '1')
                            {
                                return "<span class=\"badge badge-info\">Masculin</span>";
                            }
                            else
                            {
                                return "<span class=\"badge badge-danger\">Feminin</span>";
                            }

                        }
                    },
                    { "data": "Compétitif",
                        "render": function(data, type, row, meta) {
                            if (row.competitif === '1')
                            {
                                return "<span class=\"badge badge-success\">Compétitif</span>";
                            }
                            else
                            {
                                return "<span class=\"badge badge-danger\">Loisirs</span>";
                            }

                        }
                    },
                    {
                        "data": "weblink",
                        "render": function(data, type, row, meta){

                            data = '<a href="/admin/gymnastes/' + row.id + '">Consulter </a>';

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