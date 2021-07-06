<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Workflow\HasWorkflowsOrActions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Bordereauremise
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $fichier_source
 * @property Carbon $date_remise
 * @property string $numero_transaction
 * @property string $localisation
 * @property string $changement_dernier_tarift
 * @property string $montant_total
 *
 * @property Carbon $date_depot_agence
 * @property integer $montant_depose_agence
 * @property string $scan_bordereau
 * @property string $commentaire_agence
 *
 * @property string $localisation_titre
 * @property string $modepaiement_titre
 * @property string $bordereauremise_type_titre
 * @property string $bordereauremise_type_code
 * @property string $workflow_currentstep_code
 * @property string $workflow_currentstep_titre
 *
 * @property integer|null $bordereauremise_loc_id
 * @property integer|null $bordereauremise_modepaie_id
 * @property integer|null $bordereauremise_type_id
 *
 * @property integer|null $bordereauremise_etat_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Bordereauremise extends BaseModel implements Auditable
{
    use HasFactory, HasWorkflowsOrActions, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $table = 'bordereauremises';
    //protected $with = ['localisation'];

    #region Eloquent Relationships

    public function localisation() {
        return $this->belongsTo(BordereauremiseLoc::class, 'bordereauremise_loc_id');
    }

    public function modepaiement() {
        return $this->belongsTo(BordereauremiseModepaie::class, 'bordereauremise_modepaie_id');
    }

    public function type() {
        return $this->belongsTo(BordereauremiseType::class, 'bordereauremise_type_id');
    }

    public function etat() {
        return $this->belongsTo(BordereauremiseEtat::class, 'bordereauremise_etat_id');
    }

    public function lignes() {
        return $this->hasMany(BordereauremiseLigne::class,'bordereauremise_id');
    }

    public function workflowexecs() {
        return $this->hasMany(WorkflowExec::class, 'model_id')
            ->where('model_type', 'App\Models\Bordereauremise');
        //->whereNotNull('current_step_id');
    }

    public function workflowexec() {
        return $this->hasOne(WorkflowExec::class, 'model_id')
            ->where('model_type', 'App\Models\Bordereauremise')
            ->latest();
        //->whereNotNull('current_step_id');
    }

    #endregion

    #region Custom functions

    public function setEtat() {
        // "Attente Traitement", 'code' => "state_1"
        // "Traitement En Cours", 'code' => "state_2"
        // "Validé Sans Ecart", 'code' => "state_3"
        // "Validé Avec Ecart Positif", 'code' => "state_4"
        // "Validé Avec Ecart Négatif", 'code' => "state_5"
        // "Rejété", 'code' => "state_6"

        $nb_all = 0;
        $nb_en_attente = 0;
        $nb_en_cours = 0;
        $nb_valide = 0;
        $nb_valide_pos = 0;
        $nb_valide_neg = 0;
        $nb_rejetes = 0;

        foreach ($this->lignes as $ligne) {
            $nb_all += 1;
            if ($ligne->etat->code === "state_1") {
                $nb_en_attente += 1;
            } elseif ($ligne->etat->code === "state_2") {
                $nb_en_cours += 1;
            } elseif ($ligne->etat->code === "state_3") {
                $nb_valide += 1;
            } elseif ($ligne->etat->code === "state_4") {
                $nb_valide_pos += 1;
            } elseif ($ligne->etat->code === "state_5") {
                $nb_valide_neg += 1;
            } else {
                $nb_rejetes += 1;
            }
        }

        if ($nb_all === $nb_rejetes) {
            $this->bordereauremise_etat_id = BordereauremiseEtat::coded('state_6')->first()->id;
        } elseif ($nb_all === $nb_valide_neg) {
            $this->bordereauremise_etat_id = BordereauremiseEtat::coded('state_5')->first()->id;
        } elseif ($nb_all === $nb_valide_pos) {
            $this->bordereauremise_etat_id = BordereauremiseEtat::coded('state_4')->first()->id;
        } elseif ($nb_all === $nb_valide) {
            $this->bordereauremise_etat_id = BordereauremiseEtat::coded('state_3')->first()->id;
        } elseif ($nb_all === $nb_en_cours) {
            $this->bordereauremise_etat_id = BordereauremiseEtat::coded('state_2')->first()->id;
        } else {
            $this->bordereauremise_etat_id = BordereauremiseEtat::coded('state_1')->first()->id;
        }

    }

    #endregion

    public static function boot(){
        parent::boot();

        // Avant creation
        self::creating(function($model){
            // on initialise l état
            $model->bordereauremise_etat_id = BordereauremiseEtat::coded('state_1')->first()->id;
        });

        // Après création
        self::created(function($model){

            /*$workflows = $model->workflows();
            if ($workflows) {
                foreach ($workflows as $workflow) {
                    $workflow->execworkflow();
                }
            }*/
            // Launch workflows
            $model->launchWorkflows();

            // Launch actions
            $model->launchWorkflowActions();
        });
    }
}
