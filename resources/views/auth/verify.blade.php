@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verification de votre adresse Email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Avant de continuer, vérifiez votre boite mail, un lien de validation vous y a été envoyé.') }}
                    {{ __('Pas de mail reçu ?') }}  <a href="{{ route('verification.resend') }}">{{ __('Re-envoyer') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
