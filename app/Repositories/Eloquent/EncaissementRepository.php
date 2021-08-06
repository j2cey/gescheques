<?php

namespace App\Repositories\Eloquent;

use App\Search\Queries\Search;
use App\Http\Requests\ISearchFormRequest;
use App\Search\Queries\EncaissementSearch;
use App\Repositories\Contracts\IEncaissementRepositoryContract;

class EncaissementRepository implements IEncaissementRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function search(ISearchFormRequest $request): Search
    {
        return new EncaissementSearch(
            $request->requestParams(), $request->requestOrder()
        );
    }
}
