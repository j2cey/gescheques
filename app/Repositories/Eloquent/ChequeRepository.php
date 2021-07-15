<?php


namespace App\Repositories\Eloquent;


use App\Search\Queries\Search;
use App\Search\Queries\ChequeSearch;
use App\Http\Requests\ISearchFormRequest;
use App\Repositories\Contracts\IChequeRepositoryContract;

class ChequeRepository implements IChequeRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function search(ISearchFormRequest $request): Search
    {
        return new ChequeSearch(
            $request->requestParams(), $request->requestOrder()
        );
    }
}
