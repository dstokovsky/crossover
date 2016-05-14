@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- Display User Create/Edit Form -->
        {!! Form::open(['url' => $url]) !!}
        @include('users.form', ['submitButtonText' => 'Add'])
        {!! Form::close() !!}
    </div>

    <!-- Current Patients -->
    @if (count($users) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current {{ ucfirst($url) }}
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        @if ($phone)
                            <th>Phone</th>
                        @endif
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <!-- user id -->
                                <td class="table-text">
                                    <div>{{ $user->id }}</div>
                                </td>
                                <!-- User Name -->
                                <td class="table-text">
                                    <div>{{ $user->name }}</div>
                                </td>
                                <!-- User Email -->
                                <td class="table-text">
                                    <div>{{ $user->email }}</div>
                                </td>
                                @if ($phone)
                                    <!-- User Phone -->
                                    <td class="table-text">
                                        <div>{{ phone_format($user->phone, 'US') }}</div>
                                    </td>
                                @endif

                                <td>
                                    <a href="{{ url($url . '/' . $user->id . '/view') }}" class="btn btn-default"><i class="fa fa-btn fa-user"></i>View</a>
                                    <a href="{{ url($url . '/' . $user->id . '/edit') }}" class="btn btn-success"><i class="fa fa-btn fa-plus"></i>Edit</a>
                                    @if ($sendPassCode)
                                    <a href="{{ url('patients/' . $user->id . '/send') }}" class="btn btn-success"><i class="fa fa-btn fa-envelope"></i>Send Pass Code</a>
                                    @endif
                                    @if ($user->id !== 1 && Auth::user()->id !== $user->id)
                                    <a href="{{ url($url . '/' . $user->id . '/delete') }}" class="btn btn-danger"><i class="fa fa-btn fa-trash"></i>Delete</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    
        {!! $users->links() !!}
    @endif
@endsection