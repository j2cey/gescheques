@extends('app')

@section('app_content')
    <cheques-show :cheque_prop="{{ $cheque->toJson() }}" :actionvalues_prop="{{ $actionvalues }}" :hasexecrole_prop="{{ $hasexecrole }}" :userprofile_prop="{{ $userprofile }}"></cheques-show>
@endsection
