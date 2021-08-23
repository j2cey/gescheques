@extends('app')

@section('app_content')
    <flowchart-vue :workflow_prop="{{ $workflow->toJson() }}" :nodes_prop="{{ $nodes->toJson() }}" :approvers_prop="{{ $approvers->toJson() }}" :connections_prop="{{ json_encode($connections) }}"></flowchart-vue>
@endsection
