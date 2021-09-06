@extends('app', ['page_title' => "Détails Chèques " . $cheque->BankName_formatted . ' - ' . $cheque->NREC_BANK_MVT_ID])

@section('app_content')
    <cheques-show :cheque_prop="{{ $cheque->toJson() }}" :actionvalues_prop="{{ $actionvalues }}" :userprofiles_prop="{{ $userprofiles }}"></cheques-show>
@endsection
