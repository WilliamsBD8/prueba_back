<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use App\Models\Schedule;
use App\Models\Member;
use App\Models\Salon;
use App\Models\Curso;

use App\Http\Controllers\Controller;

use DateTime;

class ScheduleController extends Controller
{
    public function getAll($id){
        $id = intval($id);
        $cursos = [];
        $agendas = [];
        $miembros = Member::where('user_id', $id)->orderBy('id', 'ASC')->get();
        $salones = Salon::orderBy('id', 'DESC')->get();
        foreach ($miembros as $key => $miembro) {
            array_push($cursos, $miembro->curso);
            foreach ($miembro->curso->agendas as $llave => $agenda) {
                $agenda->salon;
                $agenda->sub_aforo = count($agenda->curso->members);
                array_push($agendas, $agenda);
            }
        }

        return response()->json([$agendas, $salones, $cursos], 200);
    }

    public function create(Request $request){

        $agendas = Schedule::where('date', $request['date'])
            ->where('salon_id', $request['salon_id'])->get();
        $exist = false;
        if(!empty($agendas)){
            foreach ($agendas as $key => $value) {
                if(
                    strtotime($request['start']) > strtotime($value->start)
                    && strtotime($request['start']) < strtotime($value->end)
                    || strtotime($request['end']) > strtotime($value->start)
                    && strtotime($request['end']) < strtotime($value->end)
                ){
                    $exist = true;
                    $agenda = $value;
                }
            }
        }
        if($exist)
            return response()->json(['message' => 'Salon ocupado el dia '.$agenda->date.' desde '.$agenda->start.' hasta '.$agenda->end, 'status' => false]);
            
        if(strtotime($request['date']) < strtotime(date('Y-m-d')))
            return response()->json(['message' => 'Fecha minima permitida '.date('Y-m-d H:i:s'), 'status' => false]);
        
        $date_start = new DateTime($request['date'].' '.$request['start'].':00');
        $date_end = new DateTime($request['date'].' '.$request['end'].':00');
        $diferencia = $date_start->diff($date_end);
        if($diferencia->invert)
            return response()->json(['message' => 'La hora inicial no puede ser mayor a la hora que termina', 'status' => false]);
        if($diferencia->h == 0)
            return response()->json(['message' => 'Estancia minima de 1 hora', 'status' => false]);
        if($diferencia->h >= 3){
            if($diferencia->i > 0)
                return response()->json(['message' => 'Estancia maxima de 3 horas', 'status' => false]);
        }
        $data['date']   = $request['date'];
        $data['start']   = $request['start'];
        $data['end']   = $request['end'];
        $data['salon_id']   = $request['salon_id'];
        $data['curso_id']   = $request['curso_id'];

        $agenda = Schedule::create($data);
        $agenda = Schedule::find($agenda->id);
        $agenda->curso;
        $agenda->salon;
        $agenda->sub_aforo = count($agenda->curso->members);
        return response()->json(['agenda' => $agenda, 'status' => true]);
        

    }

    public function edit(Request $request){

        $id = $request['id'];
        $agendas = Schedule::where('date', $request['date'])
            ->where('salon_id', $request['salon_id'])->get();
        $exist = false;
        if(!empty($agendas)){
            foreach ($agendas as $key => $value) {
                if($value->id != $id){
                    if(
                        strtotime($request['start']) > strtotime($value->start)
                        && strtotime($request['start']) < strtotime($value->end)
                        || strtotime($request['end']) > strtotime($value->start)
                        && strtotime($request['end']) < strtotime($value->end)
                    ){
                        $exist = true;
                        $agenda = $value;
                    }
                    // return response()->json(['message' => $exist, 'status' => false]);
                }
            }
        }
        if($exist)
            return response()->json(['message' => 'Salon ocupado el dia '.$agenda->date.' desde '.$agenda->start.' hasta '.$agenda->end, 'status' => false]);
            
        if(strtotime($request['date']) < strtotime(date('Y-m-d')))
            return response()->json(['message' => 'Fecha minima permitida '.date('Y-m-d'), 'status' => false]);
            
            // return response()->json(['message' => $request['date'].' '.$request['start'].':00', 'status' => false]);
            $date_start = new DateTime($request['date'].' '.$request['start']);
            $date_end = new DateTime($request['date'].' '.$request['end']);
            $diferencia = $date_start->diff($date_end);
        if($diferencia->invert)
            return response()->json(['message' => 'La hora inicial no puede ser mayor a la hora que termina', 'status' => false]);
        if($diferencia->h == 0)
            return response()->json(['message' => 'Estancia minima de 1 hora', 'status' => false]);
        if($diferencia->h >= 3){
            if($diferencia->i > 0)
                return response()->json(['message' => 'Estancia maxima de 3 horas', 'status' => false]);
        }
        $data['date']   = $request['date'];
        $data['start']   = $request['start'];
        $data['end']   = $request['end'];
        $data['salon_id']   = $request['salon_id'];
        $data['curso_id']   = $request['curso_id'];

        Schedule::find($id)->update($data);
        $schedule = Schedule::find($id);
        $schedule->curso;
        $schedule->salon;
        $schedule->sub_aforo = count($schedule->curso->members);
        return response()->json($schedule, 200);

    }

    public function delete($id){
        Schedule::find($id)->delete();
        return response()->json([
            'message' => "Successfully deleted",
            'success' => true
        ], 200);
    }
}
