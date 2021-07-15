<?php

namespace App\Http\Requests\Bordereau;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\ISearchFormRequest;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FetchRequest
 * @package App\Http\Requests\Bordereau
 *
 * @property string|null $createdat_du
 * @property string|null $createdat_au
 */
class FetchRequest extends FormRequest implements ISearchFormRequest
{
    use SearchRequest;

    /**
     * @inheritDoc
     */
    protected function orderByFields(): array
    {
        return ['uuid'];
    }

    /**
     * @inheritDoc
     */
    protected function defaultOrderByField(): string
    {
        return 'uuid';
    }

    protected function getCustomPayload()
    {
        $payload = "";
        //$payload = $this->addToPayload($payload, 'search', $this->search);
        $payload = $this->addToPayload($payload, 'createdat_du', substr($this->createdat_du, 0, 10));
        $payload = $this->addToPayload($payload, 'createdat_au', substr($this->createdat_au, 0, 10));

        $payload = $this->addToPayload($payload, 'statut', $this->statut);

        return $payload;
    }
}
