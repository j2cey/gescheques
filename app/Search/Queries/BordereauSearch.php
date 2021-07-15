<?php

namespace App\Search\Queries;

use Carbon\Carbon;
use App\Models\Bordereau;
use Illuminate\Database\Eloquent\Builder;

class BordereauSearch extends Search
{
    use EloquentSearch;

    /**
     * @inheritDoc
     */
    protected function query(): Builder
    {
        $query = Bordereau::query();
        $user = auth()->user();

        //dd($this);

        if ($this->params->search->hasFilter()) {
            $createddaterange = $this->getCreatedDateRangeCrit($this->params->search->search);
            //$localisation = $this->getLocalisationCrit($this->params->search->search);
            //$type = $this->getTypeCrit($this->params->search->search);
            $statut = $this->getStatutCrit($this->params->search->search);
            //dd($createddaterange,$localisation,$statut);
            if ($createddaterange) {
                $dt_deb = Carbon::createFromFormat('Y-m-d', $createddaterange[0])->addDay()->format('Y-m-d');
                $dt_fin = Carbon::createFromFormat('Y-m-d', $createddaterange[1])->addDay()->format('Y-m-d');
                //dd($dt_deb,$dt_fin);
                $query
                    ->whereBetween('created_at', [$dt_deb,$dt_fin]);
            }
            if ($statut) {
                $query
                    ->whereHas('workflowexec', function (Builder $q) use ($statut) {
                        $q->where('current_step_id', $statut);
                    });
                /*->with('workflowexec', function ($q, $statut) {
                    $q->where('workflowexec.current_step_id', '=', $statut);
                });*/
            }
            //$query->with('localisation');
        }

        return $query;
    }

    private function getCreatedDateRangeCrit($search) {
        $search_arr = explode('|', $search);
        $dateremise_range = null;
        foreach ($search_arr as $crit) {
            $crit_arr = explode(':', $crit);
            if ($crit_arr[0] === "createdat_du") {
                $dateremise_range[0] = $crit_arr[1];
            } elseif ($crit_arr[0] === "createdat_au") {
                $dateremise_range[1] = $crit_arr[1];
            }
        }
        return is_null($dateremise_range) ? null : (count($dateremise_range) === 2 ? $dateremise_range : null);
    }
    private function getLocalisationCrit($search) {
        $search_arr = explode('|', $search);
        $localisation = null;
        foreach ($search_arr as $crit) {
            $crit_arr = explode(':', $crit);
            if ($crit_arr[0] === "localisation") {
                $localisation = $crit_arr[1];
            }
        }
        return $localisation;
    }

    private function getTypeCrit($search) {
        $search_arr = explode('|', $search);
        $type = null;
        foreach ($search_arr as $crit) {
            $crit_arr = explode(':', $crit);
            if ($crit_arr[0] === "type") {
                $type = $crit_arr[1];
            }
        }
        return $type;
    }

    private function getStatutCrit($search) {
        $search_arr = explode('|', $search);
        $statut = null;
        foreach ($search_arr as $crit) {
            $crit_arr = explode(':', $crit);
            if ($crit_arr[0] === "statut") {
                $statut = $crit_arr[1];
            }
        }
        return $statut;
    }
}
