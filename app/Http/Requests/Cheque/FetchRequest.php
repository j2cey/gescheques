<?php

namespace App\Http\Requests\Cheque;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\ISearchFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class FetchRequest extends FormRequest implements ISearchFormRequest
{
    use SearchRequest;

    /**
     * @inheritDoc
     */
    protected function orderByFields(): array
    {
        return ['ACC_CODE', 'CHEQUE_NB'];
    }

    /**
     * @inheritDoc
     */
    protected function defaultOrderByField(): string
    {
        return 'ACC_CODE';
    }

    protected function getCustomPayload()
    {
        $payload = "";
        //$payload = $this->addToPayload($payload, 'search', $this->search);
        $payload = $this->addToPayload($payload, 'createdat_du', substr($this->createdat_du, 0, 10));
        $payload = $this->addToPayload($payload, 'createdat_au', substr($this->createdat_au, 0, 10));

        $payload = $this->addToPayload($payload, 'statut', $this->statut);
        $payload = $this->addToPayload($payload, 'etatrappro', $this->etatrappro);
        $payload = $this->addToPayload($payload, 'agence', $this->agence);

        return $payload;
    }
}
