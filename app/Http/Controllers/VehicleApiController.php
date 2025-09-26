<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicle = Vehicle::with('typeVehicle')
                    ->with([
                        'visits' => function ($visits) {
                            $visits->whereNull('departure_date');
                        }
                    ])
                    ->orderBy('car_plate','asc')->get();
        return response()->json([
            'data' => $vehicle,
            'message' => 'lista'
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validamos los datos
        $request->validate([
            'car_plate' => 'required|unique:vehicles,car_plate|regex:/^[A-Z]{3}[0-9]{3}$/' ,
            'type_vehicle_id' => 'required|exists:type_vehicles,id',
        ]);

        //creamos el vehiculo
        $vehicle = Vehicle::create($request->all());
        return response()->json([
            'data' => $vehicle,
            'message' => 'creado'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->update($request->all());
        return response()->json([
            'data' => $vehicle,
            'message' => 'actualizado'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->delete();
        return response()->json([
            'message' => 'eliminado'
        ],200);
    }

    

}
