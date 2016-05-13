@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->
    <h2 class="title">{{ $user->name }}</h2>
    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- Display User Create/Edit Form -->
        {!! Form::model($user, ['method' => 'POST', 'action' => [$user->is('operator') ? 'OperatorController@store' : 'PatientController@store', $user->id]]) !!}
        @include('users.form', ['submitButtonText' => 'Save'])
        {!! Form::close() !!}
        
    </div>
@endsection