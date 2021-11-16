<?php

namespace App\Http\Controllers;


use App\Models\Member;
use App\Models\user;
use App\Models\Schedule;
use App\Models\Salon;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    
    public function getAll($id){
        $id = intval($id);
        $agendas = [];
        $user = User::find($id);
        $salones = Salon::orderBy('id', 'DESC')->get();
        $salones_aux = [];
        $historial = [];
        foreach ($salones as $key => $salon) {
            foreach ($salon->agendas as $key1 => $agenda) {
                $date = strtotime($agenda->date.' '.$agenda->end);
                $day = strtotime(date('Y-m-d H:i:s'));
                $agenda->status = $day >= $date ? 'danger':'success';
                $agenda->sub_aforo = count($agenda->curso->members);
                foreach ($agenda->curso->members as $key2 => $member) {
                    if($user->id == $member->user_id || $user->rol_id == 1){
                        array_push($salones_aux, $salon);
                        break;
                    }
                }
            }
        }

        $pruebas = array_unique($salones_aux);

        return response()->json($pruebas, 200);
    }
}
