<?php

namespace App\Http\Controllers;

use App\Models\BordereauremiseEtat;
use App\Models\BordereauremiseLigne;
use App\Models\Bordereauremise;
use App\Models\WorkflowStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        return view('dashboard.index');
    }

    public function fetch() {
        $all_par_etat = DB::table('bordereauremise_lignes')
            ->select('bordereauremise_etat_id', DB::raw('count(*) as total'))
            ->groupBy('bordereauremise_etat_id')
            ->get();
        /*$all_par_etape = DB::table('bordereauremises')
            ->select('workflow_currentstep_code', DB::raw('count(*) as total'))
            ->groupBy('workflow_currentstep_code')
            ->get();*/
        $all_lignes = BordereauremiseLigne::with(['bordereau','etat'])->get();

        $all_par_etat_code = [
            "state_1" => 0,
            "state_2" => 0,
            "state_3" => 0,
            "state_4" => 0,
            "state_5" => 0,
            "state_6" => 0,
        ];

        foreach ($all_par_etat as $item) {
            foreach ($all_par_etat_code as $key => $value) {
                $curr_etat = BordereauremiseEtat::coded($key)->first();
                if ($curr_etat->id === $item->bordereauremise_etat_id) {
                    $all_par_etat_code[$key] += $item->total;
                }
            }
        }

        $all_par_etape_code = [
            "step_0" => [
                'total' => 0,
                'reste' => 0,
                'rate' => 0,
            ],
            "step_1" => [
                'total' => 0,
                'reste' => 0,
                'rate' => 0,
            ],
            "step_end" => [
                'total' => 0,
                'reste' => 0,
                'rate' => 0,
            ],
        ];

        $nb_all = 0;
        foreach ($all_lignes as $ligne) {
            if ($ligne->bordereau->workflow_currentstep_code === "0") {
                // traitement terminé
                $all_par_etape_code['step_end']['total'] += 1;
            } else {
                // traitement en cours ou en attente
                if ($ligne->etat->code === "state_1") {
                    // en attente de traitement
                    $all_par_etape_code[$ligne->bordereau->workflow_currentstep_code]['reste'] += 1;
                } else {
                    // partiellement traité
                    $all_par_etape_code[$ligne->bordereau->workflow_currentstep_code]['total'] += 1;
                }
                /*$all_par_etape_code[$ligne->bordereau->workflow_currentstep_code]['rate'] = ($all_par_etape_code[$ligne->bordereau->workflow_currentstep_code]['reste'] > 0 ?
                    $all_par_etape_code[$ligne->bordereau->workflow_currentstep_code]['total'] / $all_par_etape_code[$ligne->bordereau->workflow_currentstep_code]['reste'] :
                    0);*/
            }
            $nb_all += 1;
        }

        //dd($all_par_etape_code);

        $all_par_etape_code['step_end']['reste'] = $nb_all - $all_par_etape_code['step_end']['total'];
        $all_par_etape_code['step_end']['rate'] = ($nb_all > 0 ? ($all_par_etape_code['step_end']['total'] / $nb_all) * 100 : 0);

        //$all_par_etape_code['step_0']['total'] = $nb_all - $all_par_etape_code['step_0']['reste'];
        $all_par_etape_code['step_0']['rate'] = ($nb_all > 0 ? ($all_par_etape_code['step_0']['reste'] / $nb_all) * 100 : 0);

        //$step_1_all = $all_par_etape_code['step_0']['total'];
        //$all_par_etape_code['step_1']['total'] = $step_1_all - $all_par_etape_code['step_1']['reste'];
        $all_par_etape_code['step_1']['rate'] = ($nb_all > 0 ? ($all_par_etape_code['step_1']['reste'] / $nb_all) * 100 : 0);

        /*foreach ($all_par_etape as $item) {
            foreach ($all_par_etape_code as $key => $value) {
                //$curr_step = WorkflowStep::coded($key)->first();
                if ($key === $item->workflow_currentstep_code) {
                    $all_par_etape_code[$key]['total'] += $item->total;
                }
            }
        }*/

        //dd($all_par_etat_code, $all_par_etape_code);
        return ['all_par_etat' => $all_par_etat_code, 'all_par_etape' => $all_par_etape_code];
    }

    public function fetchagence($id) {
        $bordereaux_on_loc_ids = Bordereauremise::where('bordereauremise_loc_id', $id)->pluck('id','id')->toArray();
        $all_par_etat = DB::table('bordereauremise_lignes')
            ->whereIn('bordereauremise_id', $bordereaux_on_loc_ids)
            ->select('bordereauremise_etat_id', DB::raw('count(*) as total'))
            ->groupBy('bordereauremise_etat_id')
            ->get();
        /*$all_par_etape = DB::table('bordereauremises')
            ->select('workflow_currentstep_code', DB::raw('count(*) as total'))
            ->groupBy('workflow_currentstep_code')
            ->get();*/
        $all_lignes = BordereauremiseLigne::with(['bordereau','etat'])->get();

        $all_par_etat_code = [
            "state_1" => 0,
            "state_2" => 0,
            "state_3" => 0,
            "state_4" => 0,
            "state_5" => 0,
            "state_6" => 0,
        ];

        foreach ($all_par_etat as $item) {
            foreach ($all_par_etat_code as $key => $value) {
                $curr_etat = BordereauremiseEtat::coded($key)->first();
                if ($curr_etat->id === $item->bordereauremise_etat_id) {
                    $all_par_etat_code[$key] += $item->total;
                }
            }
        }

        return $all_par_etat_code;
    }
}
