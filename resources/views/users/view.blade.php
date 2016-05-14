@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->
    <div class="panel-body">
        <h2 class="title">{{ $user->name }} Profile</h2>
        <table class="table table-striped task-table">
            <!-- Table Headings -->
            <thead>
                <th colspan="2">&nbsp;</th>
            </thead>

            <!-- Table Body -->
            <tbody>
                <tr>
                    <td class="table-text">
                        <div><strong>#ID</strong></div>
                    </td>
                    <td class="table-text">
                        <div>{{ $user->id }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="table-text">
                        <div><strong>Name</strong></div>
                    </td>
                    <td class="table-text">
                        <div>{{ $user->name }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="table-text">
                        <div><strong>Email</strong></div>
                    </td>
                    <td class="table-text">
                        <div>{{ $user->email }}</div>
                    </td>
                </tr>
                @if ($user->is('patient'))
                <tr>
                    <td class="table-text">
                        <div><strong>Phone</strong></div>
                    </td>
                    <td class="table-text">
                        <div>{{ phone_format($user->phone, 'US') }}</div>
                    </td>
                </tr>
                @endif
                <tr>
                    <td colspan="2">
                        <a href="{{ url($url . '/' . $user->id . '/edit') }}" class="btn btn-success"><i class="fa fa-btn fa-plus"></i>Edit</a>
                        @if ($sendPassCode)
                        <a href="{{ url('patients/' . $user->id . '/send') }}" class="btn btn-success"><i class="fa fa-btn fa-envelope"></i>Send Pass Code</a>
                        @endif
                        @if ($user->id !== 1 && Auth::user()->id !== $user->id)
                        <a href="{{ url($url . '/' . $user->id . '/delete') }}" class="btn btn-danger"><i class="fa fa-btn fa-trash"></i>Delete</a>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection