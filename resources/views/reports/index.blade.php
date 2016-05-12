<!-- resources/views/tasks/index.blade.php -->

@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New Task Form -->
        <form action="{{ url('reports') }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}

            <!-- Task Name -->
            <div class="form-group">
                <label for="report-user-id" class="col-sm-3 control-label">User</label>

                <div class="col-sm-6">
                    <input type="text" name="user_id" id="report-user-id" class="form-control">
                </div>
            </div>
            <div class="form-group">    
                <label for="report-procedure" class="col-sm-3 control-label">Procedure</label>
                
                <div class="col-sm-6">
                    <input type="text" name="procedure" id="report-procedure" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="report-statement" class="col-sm-3 control-label">Statement</label>
                
                <div class="col-sm-6">
                    <input type="text" name="statement" id="report-statement" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="report-findings" class="col-sm-3 control-label">Findings</label>
                
                <div class="col-sm-6">
                    <input type="text" name="findings" id="report-findings" class="form-control">
                </div>
            </div>
            <div class="form-group">    
                <label for="report-impression" class="col-sm-3 control-label">Impression</label>
                
                <div class="col-sm-6">
                    <input type="text" name="impression" id="report-impression" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="report-conclusion" class="col-sm-3 control-label">Conclusion</label>
                
                <div class="col-sm-6">
                    <textarea name="conclusion" id="report-conclusion" class="form-control"></textarea>
                </div>
            </div>

            <!-- Add Report Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add Report
                    </button>
                </div>
            </div>
        </form>
    </div>

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
                        <th>User</th>
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
                                    <div>{{ $report->user()->name }}</div>
                                </td>

                                <td>
                                    <form action="{{ url('reports/'.$report->id) }}" method="POST">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}

                                        <button type="submit" id="delete-task-{{ $report->id }}" class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection