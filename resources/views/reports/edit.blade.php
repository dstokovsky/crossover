@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->
    <h2 class="title">Medical Record Number #{{ $report->id }}</h2>
    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- Display User Create/Edit Form -->
        {!! Form::model($report, ['method' => 'POST', 'action' => ['ReportController@store', $report->id]]) !!}
        @include('reports.form', ['submitButtonText' => 'Save'])
        {!! Form::close() !!}
        
    </div>
@endsection