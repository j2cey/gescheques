@extends('app')

@section('app_content')
    <workflow-exec :exec_prop="{{ $workflowexec->toJson() }}" :actionvalues_prop="{{ $actionvalues }}"></workflow-exec>
@endsection
