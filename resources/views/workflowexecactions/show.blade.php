@extends('app')

@section('app_content')
<workflow-execaction :execaction_prop="{{ $workflowexecaction->toJson() }}"></workflow-execaction>
@endsection
