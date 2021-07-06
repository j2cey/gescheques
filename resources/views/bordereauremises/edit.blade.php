@extends('app')

@section('app_content')
    <bordereauremise-show :bordereauremise_prop="{{ $bordereauremise->toJson() }}" :actionvalues_prop="{{ $actionvalues }}" :hasexecrole_prop="{{ $hasexecrole }}" :userprofile_prop="{{ $userprofile }}"></bordereauremise-show>
@endsection
