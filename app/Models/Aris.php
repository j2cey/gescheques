<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aris extends Model
{
    use HasFactory;

    public static function getChequeInfos($reference) {
        //return DB::connection("sqlsrv")->statement('exec _Encaissements_soumis_pour_chequesimpayes @reference='.$reference);
        $dbname = DB::connection('sqlsrv')->getDatabaseName();
        return DB::connection("sqlsrv")->select('EXEC dbo._Encaissements_soumis_pour_chequesimpayes ?', array($reference));
    }
}
