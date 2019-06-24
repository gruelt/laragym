@extends('mails.email')


@section('content')


    Bonjour ,<br>
    <br>
    Un groupe à été affecté à {{ $prenom }} {{ $nom }} .<br>

    vous pouvez vous connecter pour le consulter.<br><br>








    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" style="border-radius: 3px;" bgcolor="#e9703e"><a href="{{ env('APP_URL') }}/responsable/gymnastes/{{$id}}" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; text-decoration: none;border-radius: 3px; padding: 12px 18px; border: 1px solid #e9703e; display: inline-block;">Consulter &rarr;</a></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>




    Cordialement.

@stop
