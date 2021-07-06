<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Workflow\HasWorkflowsOrActions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BordereauremiseLigne
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer|null $bordereauremise_id
 * @property string|null $reference
 * @property string|null $classe_paiement
 * @property integer|null $montant
 *
 * @property Carbon $date_valeur_finance
 * @property integer|null $montant_depose_finance
 * @property string|null $commentaire_finance
 *
 * @property bool $rejet_finances
 * @property string|null $motif_rejet_finances
 *
 * @property integer|null $bordereauremise_etat_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class BordereauremiseLigne extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable, HasWorkflowsOrActions;
    protected $guarded = [];

    #region Eloquent Relationships

    public function bordereau() {
        return $this->belongsTo(Bordereauremise::class, 'bordereauremise_id');
    }

    public function etat() {
        return $this->belongsTo(BordereauremiseEtat::class, 'bordereauremise_etat_id');
    }

    #endregion

    #region Custom functions

    public function setEtat() {

        if ($this->rejet_finances) {
            // "Rejété", 'code' => "6"
            $this->bordereauremise_etat_id = BordereauremiseEtat::coded('state_6')->first()->id;
        } elseif ($this->montant > $this->montant_depose_finance) {
            // "Validé Avec Ecart Négatif", 'code' => "5"
            $this->bordereauremise_etat_id = BordereauremiseEtat::coded('state_5')->first()->id;
        } elseif ($this->montant < $this->montant_depose_finance) {
            // "Validé Avec Ecart Positif", 'code' => "4"
            $this->bordereauremise_etat_id = BordereauremiseEtat::coded('state_4')->first()->id;
        } elseif ($this->montant === $this->montant_depose_finance) {
            // "Validé Sans Ecart", 'code' => "3"
            $this->bordereauremise_etat_id = BordereauremiseEtat::coded('state_3')->first()->id;
        } elseif ($this->bordereau->date_depot_agence) {
            // "Traitement En Cours", 'code' => "2"
            $this->bordereauremise_etat_id = BordereauremiseEtat::coded('state_2')->first()->id;
        } else {
            // "Attente Traitement", 'code' => "1"
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

            // Launch workflows
            $model->launchWorkflows();

            // Launch actions
            $model->launchWorkflowActions();
        });

        // Avant enregistrement
        self::saving(function($model){
            // Formaliser le rejet (le cas échéant)
            if ($model->rejet_finances) {
                // on met le montant à zéro
                $model->montant_depose_finance = 0;
                // on récupère la date du jour
                $model->date_valeur_finance = Carbon::now();
            }

            // on met à jour l 'état de la ligne
            $model->setEtat();
        });

        // Après enregistrement
        self::saved(function($model){
            // on met à jour l 'état du bordereau de la ligne
            $model->bordereau->setEtat();
        });
    }
}
