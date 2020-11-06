<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DetOficinaE;
class DetOficinaEController extends Controller
{
    //

    public function index(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
        $refe = DetOficinaE::join('oficinas','det_oficinae.id_oficina','=','oficinas.id')   
        ->select('det_oficinae.id_oficina','oficinas.nombre as nomM')
        ->distinct('det_oficinae.id_oficina')
        ->orderBy('oficinas.nombre','asc')->paginate(15);
        }
        else{
            $refe = DetOficinaE::join('oficinas','det_oficinae.id_oficina','=','oficinas.id')  
            ->join('equipos','det_oficinae.id_equipo','=','equipos.id')         
            ->join('ref_equipos','equipos.id_refequipo','=','ref_equipos.id')         
            ->join('tp_equipos','ref_equipos.id_tpequipo','=','tp_equipos.id')         
            ->join('personas','equipos.id_responsable','=','personas.id')         
            ->select('personas.nombreFull as respo','tp_equipos.nombre','det_oficinae.id','det_oficinae.id_oficina','oficinas.nombre as nomM','ref_equipos.nombre as tpEquipo','equipos.serial','equipos.desc','equipos.id as idEquipo')
            ->where('det_oficinae.id_oficina',$buscar)
            ->orderBy('oficinas.nombre','asc')->paginate(15);
        }        
        return [
            'pagination' => [
                'total'        => $refe->total(),
                'current_page' => $refe->currentPage(),
                'per_page'     => $refe->perPage(),
                'last_page'    => $refe->lastPage(),
                'from'         => $refe->firstItem(),
                'to'           => $refe->lastItem(),
            ],
            'refe' => $refe
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();



            $idOficina = $request->idOficina;
            $detalles = $request->data;            //Array de detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetOficinaE();
                $detalle->id_oficina = $idOficina;
                $detalle->id_equipo = $det['id'];        
                $detalle->save();
            }          

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function destroy(Request $request)
    {
        $equipo = DetOficinaE::findOrFail($request->id);
        $equipo->delete();
    
    }

}
