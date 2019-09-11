<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Facture</title>
{{--    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">--}}
</head>
<body>

<style>
    /*html **/
    /*{*/
    /*    font-size: 1em !important;*/
    /*    color: #000 !important;*/
    /*    font-family: Arial !important;*/
    /*}*/
    h1.titre
    {
        color: Black ;

    }
</style>



<img width ="200px" src={{public_path('images/full.png')}} "></img><br>
    <div id="entete">
    Association à but non lucratif loi 1901<br>
<b>RNA</b> :  W421000727<br>
<b>SIRET</b> : 34913192000010<br>
    <br>
    Salle Pierre ROYER<br>
    10 Rue des Ecoles<br>
    42170 Saint-Just-Saint-Rambert<br>
    06-61-46-83-15<br>
    </div>
<br><br>
<div align="right">
    Saint Just-Saint Rambert le xx/xx/xx
</div>
<br><br>
<div align="center" id="titre">
    <h1 class="titre">Attestation de Paiement</h1>
</div>
<br><br>

<div id="texte" class="texte">

    Je soussignée CHEVALIER Charlène, Trésorière de l’association  <b>FJEP Gymnastique St Just-St Rambert</b> certifie que l'adhésion au club de gymnastique de<br><br><br>
    <b>{{$nom}} {{$prenom}}</b><br> {{$adresse}} <br>{{$cp}} {{$ville}}<br><br>
    à été payée en totalité par {{$nom_responsable}} {{$prenom_responsable}} .<br>
    Pour faire valoir ce que de droit.




</div>
</body>


