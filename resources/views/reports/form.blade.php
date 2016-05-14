<!-- New Report Form -->
<div class="form-group">
    {!! Form::label('report_user', 'Patient') !!}
    {!! Form::hidden('user_id', isset($report->user->id) ? $report->user->id : null, ['id' => 'user_id']) !!}
    {!! Form::text('report_user', isset($report->user->name) ? $report->user->name : null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('procedure', 'Procedure') !!}
    {!! Form::text('procedure', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('statement', 'Statement') !!}
    {!! Form::text('statement', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('findings', 'Findings') !!}
    {!! Form::text('findings', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('impression', 'Impression') !!}
    {!! Form::text('impression', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('conclusion', 'Conclusion') !!}
    {!! Form::textarea('conclusion', null, ['class' => 'form-control']) !!}
</div>

<!-- Add Report Button -->
<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
</div>