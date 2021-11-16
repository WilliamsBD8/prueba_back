<?php

namespace App\Http\Controllers\Salones;

use Illuminate\Support\Str; 

use App\Models\Salon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalonsController extends Controller
{
    public function getAll(){
        $salons = Salon::orderBy('id', 'DESC')->get();
        return response()->json($salons, 200);
    }

    public function create(Request $request){

        $data['name']   = $request['name'];
        $data['aforo']  = $request['aforo'];
        $data['code']   = Str::random(6);

        $salon = Salon::create($data);

        return response()->json($salon, 200);

    }

    public function edit(Request $request){

        $id = $request['id'];

        $data['name']   = $request['name'];
        $data['aforo']  = $request['aforo'];
        Salon::find($id)->update($data);
        $salon = Salon::find($id);
        return response()->json($salon, 200);

    }

    public function delete($id){
        Salon::find($id)->delete();
        return response()->json([
            'message' => "Successfully deleted",
            'success' => true
        ], 200);
    }
}
