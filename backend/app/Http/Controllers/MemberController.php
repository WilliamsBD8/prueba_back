<?php

namespace App\Http\Controllers;
use App\Models\Member;
use App\Models\Curso;
use Illuminate\Http\Request;

class MemberController extends Controller
{
  public function getAll($id){
    
    $cursos = Curso::orderBy('id', 'DESC')->get();
    $aux_cursos = [];
    foreach ($cursos as $key => $curso) {
      $curso->agendas;
      foreach ($curso->members as $llave => $member) {
        $member->user;
        if($member->user_id == $id){
          array_push($aux_cursos, $curso);
        }
      }
    }
    return response()->json($aux_cursos, 200);
  }

  public function create(Request $request){

    $user_id = intval($request['user_id']);
    $curso_id = $request['curso_id'];
    $curso = Member::where(['user_id' => $user_id, 'curso_id' => $curso_id])->first();
    if(!empty($curso))
      return response()->json([
        "status" => false,
        "message" => $curso->user->name." ya se encuentra registrado al curso ".$curso->curso->name
      ]);
    $data['user_id'] = $user_id;
    $data['curso_id'] = $curso_id;
    $member = Member::create($data);
    $cursos = Curso::orderBy('id', 'DESC')->get();
    foreach ($cursos as $key => $value) {
        foreach ($value->members as $key => $user) {
            $user->user;
        }
    }
    return response()->json([$cursos, "status" => true]);
  }

  public function delete($id){

    Member::where(['id' => $id])->delete();
    $cursos = Curso::orderBy('id', 'DESC')->get();
    foreach ($cursos as $key => $value) {
        foreach ($value->members as $key => $user) {
            $user->user;
        }
    }
    return response()->json($cursos, 200);

  }

}
