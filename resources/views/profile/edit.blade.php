@extends('layouts.main')

@section('title', 'Meu perfil')

@section('content')

    {{-- SUBSTITUIÇÃO DO X-SLOT HEADER --}}
@section('page_title')
    <h2 class="h4 my-4">
        {{ __('Meu Perfil') }}
    </h2>
@endsection

{{-- CONTAINER PRINCIPAL (Bootstrap) --}}
<div class="row justify-content-center my-5">
    <div class="col-lg-10">

        {{-- GRUPO 1: INFORMAÇÕES DO PERFIL --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body p-4 p-sm-5">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        {{-- GRUPO 2: ATUALIZAR SENHA --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body p-4 p-sm-5">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- GRUPO 3: DELETAR CONTA --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body p-4 p-sm-5">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
