@extends('app', ['page_title' => "Workflows - Diagramme"])

@section('app_content')
    <flowchart-vue :workflow_prop="{{ $workflow->toJson() }}" :nodes_prop="{{ $nodes->toJson() }}" :approverslist_prop="{{ $approverslist->toJson() }}" :connections_prop="{{ json_encode($connections) }}"></flowchart-vue>
@endsection
