<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str; 

use App\Models\Curso;
use App\Models\User;
use App\Models\Member;

use App\Http\Controllers\Controller;

class CursosController extends Controller
{
    public function getAll(){
        $cursos = Curso::orderBy('id', 'DESC')->get();
        foreach ($cursos as $key => $value) {
            foreach ($value->members as $key => $user) {
                $user->user;
            }
        }
        $users = User::orderBy('id', 'DESC')->get();
        $teachers = [];
        $students = [];
        foreach ($users as $key => $user) {
            if($user->rol_id == 2)
                array_push($teachers, $user);
                elseif ($user->rol_id == 3)
                array_push($students, $user);
        }
        return response()->json([$cursos, $teachers, $students], 200);
    }

    public function create(Request $request){

        $data['name']   = $request['name'];
        $data['code']   = Str::random(6);

        $curso = Curso::create($data);

        $curso = Curso::find($curso->id);

        
        $member['user_id'] = $request['teacher'];
        $member['curso_id'] = $curso->id;
        
        Member::create($member);
        foreach ($curso->members as $key => $user) {
            $user->user;
        }

        return response()->json($curso, 200);

    }

    public function edit(Request $request){

        $id = $request['id'];
        $data['name']   = $request['name'];
        Curso::find($id)->update($data);
        Member::find($id)->update(['user_id' => $request['teacher']]);
        $curso = Curso::find($id);
        foreach ($curso->members as $key => $user) {
            $user->user;
        }
        return response()->json($curso, 200);

    }

    public function delete($id){
        Curso::find($id)->delete();
        $cursos = Curso::orderBy('id', 'DESC')->get();
        foreach ($cursos as $key => $value) {
            foreach ($value->members as $key => $user) {
                $user->user;
            }
        }
        return response()->json([
            'message' => "Successfully deleted",
            'success' => true
        ], 200);
    }
}

