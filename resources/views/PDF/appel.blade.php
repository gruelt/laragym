<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>{{ $title }}</title>
 <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>

<style>
    table {
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }

    th {
        height: 90px;
    }
    td.vide{
        width:20;
    }

</style>

@php
    //Nombre de colonnes
    $colonnes=30;

    //array des jours
    $jours[1]="Lundi";
    $jours[2]="Mardi";
    $jours[3]="Mercredi";
    $jours[4]="Jeudi";
    $jours[5]="Vendredi";
    $jours[6]="Samedi";
    $jours[7]="Dimanche";


@endphp
<body>
<h1>{{ $heading}}</h1>

<h2></h2>

<div >
    <h2>{!!  $equipe['niveau_libelle']!!}</h2>
    <h4>Entraineur :<br>{!!  $equipe['coach']!!}</h4>
</div>

<div align="right">

    @foreach ($horaires as $horaire)
        {{$jours[$horaire->jour_id]}} - {{$horaire->heure_debut}}H{{$horaire->minute_debut}} / {{$horaire->heure_fin}}H{{$horaire->minute_fin}} <br>
    @endforeach
    <modify-horaire-modal></modify-horaire-modal>
</div>


<table  class="table">
    <tr><th>Nom</th><th>Prénom</th><th>Année</th>
        @for ($i = 0; $i < $colonnes; $i++)
            <th>&nbsp;</th>
        @endfor




    </tr>
@foreach ($gyms as $gym)
        @php
    $year = explode('-',$gym->date_naissance);

@endphp

    <tr>
        <td>{{strtoupper($gym->nom)}}</td>
        <td>{{$gym->prenom}}</td>
        <td>{{$year[0]}}</td>


        @for ($i = 0; $i < $colonnes; $i++)
            <td class="vide">&nbsp;</td>
        @endfor

    </tr>
@endforeach
</table>

</body>

{{--<script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>--}}

</html>
