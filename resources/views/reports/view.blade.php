@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->
    <div class="panel-body">
        <h2 class="title"> Medical Record Number #{{ $report->id }}</h2>
        <table class="table table-striped task-table">
            <!-- Table Headings -->
            <thead>
                <th colspan="2">&nbsp;</th>
            </thead>

            <!-- Table Body -->
            <tbody>
                <tr>
                    <td class="table-text">
                        <div><strong>Patient</strong></div>
                    </td>
                    <td class="table-text">
                        @permission('view.user')
                        <div><a href="{{ url('patients/' . $report->user->id . '/view') }}">{{ $report->user->name }}</a></div>
                        @else
                        <div>{{ $report->user->name }}</div>
                        @endpermission
                    </td>
                </tr>
                <tr>
                    <td class="table-text">
                        <div><strong>Procedure</strong></div>
                    </td>
                    <td class="table-text">
                        <div>{{ $report->procedure }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="table-text">
                        <div><strong>Statement</strong></div>
                    </td>
                    <td class="table-text">
                        <div>{{ $report->statement }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="table-text">
                        <div><strong>Findings</strong></div>
                    </td>
                    <td class="table-text">
                        <div>{{ $report->findings }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="table-text">
                        <div><strong>Impression</strong></div>
                    </td>
                    <td class="table-text">
                        <div>{{ $report->impression }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="table-text">
                        <div><strong>Conclusion</strong></div>
                    </td>
                    <td class="table-text">
                        <div>{{ $report->conclusion }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="table-text">
                        <div><strong>Created</strong></div>
                    </td>
                    <td class="table-text">
                        <div>{{ date('F d, Y H:i', strtotime($report->created_at)) }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        @permission('update.report')
                        <a href="{{ url('reports/' . $report->id . '/edit') }}" class="btn btn-success"><i class="fa fa-btn fa-plus"></i>Edit</a>
                        @endpermission

                        @permission('send.report')
                        <a href="{{ url('reports/' . $report->user->id . '/send') }}" class="btn btn-success"><i class="fa fa-btn fa-envelope"></i>Send Pass Code</a>
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
            </tbody>
        </table>
    </div>
@endsection