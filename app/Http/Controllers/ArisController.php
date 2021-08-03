<?php

namespace App\Http\Controllers;

use App\Models\Aris;
use Illuminate\Http\Request;

class ArisController extends Controller
{
    public function getchequeinfos($ref) {
        $rslt = Aris::getChequeInfos($ref);
        dd($rslt);
    }
}
