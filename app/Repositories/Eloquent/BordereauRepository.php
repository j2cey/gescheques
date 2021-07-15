<?php


namespace App\Repositories\Eloquent;

use App\Search\Queries\Search;
use App\Search\Queries\BordereauSearch;
use App\Http\Requests\ISearchFormRequest;
use App\Repositories\Contracts\IBordereauRepositoryContract;

class BordereauRepository implements IBordereauRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function search(ISearchFormRequest $request): Search
    {
        return new BordereauSearch(
            $request->requestParams(), $request->requestOrder()
        );
    }
}
