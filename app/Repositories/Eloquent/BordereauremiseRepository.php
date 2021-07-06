<?php


namespace App\Repositories\Eloquent;

use App\Search\Queries\Search;
use App\Search\Queries\BordereauremiseSearch;
use App\Http\Requests\ISearchFormRequest;
use App\Repositories\Contracts\IBordereauremiseRepositoryContract;

class BordereauremiseRepository implements IBordereauremiseRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function search(ISearchFormRequest $request): Search
    {
        return new BordereauremiseSearch(
            $request->requestParams(), $request->requestOrder()
        );
    }
}
