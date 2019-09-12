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

    Saint Just-Saint Rambert le 15/09/2019
</div>
<br><br>
<div align="center" id="titre">
    <h1 class="titre">Attestation de Paiement</h1>
</div>
<br><br>

<div id="texte" class="texte">

    Je soussignée CHEVALIER Charlène, Trésorière de l’association : <br>  <b><h3>FJEP Gymnastique St Just-St Rambert</h3></b>  Certifie que l'adhésion au club de gymnastique de
    <b>{{$nom}} {{$prenom}}</b> résidant {{$adresse}} , {{$cp}} {{$ville}}.<br><br>

    Pour la saison du 01/07/2019 au 30/06/2020 le montant  de {{$montant}} € à été réglé en totalité par {{$nom_responsable}} {{$prenom_responsable}}.<br><br>
    Pour faire valoir ce que de droit.





</div><br><br><br>
<div align="right">CHEVALIER Charlène.<br><br>
    <img width ="200px" src={{public_path('signa/signazerty.png')}} "></img></div>
</body>

</html>
