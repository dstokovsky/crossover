<!-- resources/views/tasks/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->
    @permission('create.report')
    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- Display Report Create/Edit Form -->
        {!! Form::open(['url' => 'reports']) !!}
        @include('reports.form', ['submitButtonText' => 'Add'])
        {!! Form::close() !!}
    </div>
    @endpermission

    <!-- Current Tasks -->
    @if (count($reports) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Reports
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>MRN</th>
                        <th>Patient</th>
                        <th>Procedure</th>
                        <th>Date</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <!-- Medical Record Number or report id -->
                                <td class="table-text">
                                    <div>{{ $report->id }}</div>
                                </td>
                                <!-- User Name -->
                                <td class="table-text">
                                    @permission('view.user')
                                    <div><a href="{{ url('patients/' . $report->userId . '/view') }}">{{ $report->userName }}</a></div>
                                    @else
                                    <div>{{ $report->userName }}</div>
                                    @endpermission
                                </td>
                                <!-- Goal of Report -->
                                <td class="table-text">
                                    <div>{{ str_limit($report->procedure, 50) }}</div>
                                </td>
                                <!-- Report's Date -->
                                <td class="table-text">
                                    <div>{{ date('F d, Y H:i', strtotime($report->created_at)) }}</div>
                                </td>

                                <td>    
                                    @permission('view.report')
                                    <a href="{{ url('reports/' . $report->id . '/view') }}" class="btn btn-default"><i class="fa fa-btn fa-user"></i>View</a>
                                    @endpermission

                                    @permission('update.report')
                                    <a href="{{ url('reports/' . $report->id . '/edit') }}" class="btn btn-success"><i class="fa fa-btn fa-plus"></i>Edit</a>
                                    @endpermission

                                    @permission('send.report')
                                    <a href="{{ url('reports/' . $report->userId . '/send') }}" class="btn btn-success"><i class="fa fa-btn fa-envelope"></i>Send Pass Code</a>
                                    @endpermission

                                    @permission('export.pdf.report')
                                    <a href="{{ url('reports/' . $report->id . '/pdf') }}" class="btn btn-success"><i class="fa fa-btn fa-refresh"></i>Export to PDF</a>
                                    @endpermission

                                    @permission('export.mail.report')
                                    <a href="{{ url('reports/' . $report->id . '/mail') }}" class="btn btn-success"><i class="fa fa-btn fa-envelope"></i>Mail Me</a>
                                    @endpermission

                                    @permission('delete.report')
                                    <a href="{{ url('reports/' . $report->id . '/delete') }}" class="btn btn-danger"><i class="fa fa-btn fa-trash"></i>Delete</a>
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    
        {!! $reports->links() !!}
    @endif
@endsection