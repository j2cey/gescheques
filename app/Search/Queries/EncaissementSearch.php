<?php


namespace App\Search\Queries;


use App\Models\Encaissement;
use Illuminate\Database\Eloquent\Builder;

class EncaissementSearch extends Search
{
    use EloquentSearch;

    /**
     * @inheritDoc
     */
    protected function query(): Builder
    {
        $query = Encaissement::query();

        if ($this->params->search->hasFilter()) {
            $search = $this->params->search->search;
            $query
                ->where('PaymentKey', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('ReceiptNum', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('Reference', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('PaymentID', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('CustomerNo', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('OSS360_PaymentClass', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('BankName', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('BankName_formatted', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('AccountNumber', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('Initial_TotalAmountPaid', 'like', '%'.$this->params->search->search.'%')
                ->orWhere('Final_TotalAmountPaid', 'like', '%'.$this->params->search->search.'%')
                ->orWhereHas('agence', function (Builder $q) use ($search) {
                    $q->where('LocationName', 'like', '%'.$search.'%');
                })
            ;
        }

        return $query;
    }
}
