<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Path;
use Illuminate\Support\Facades\DB;

class PathController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $paths = DB::table('paths')
            ->join('cities', 'paths.city_of_origin', '=', 'cities.id')
            ->join('cities as cities2', 'paths.city_of_destination', '=', 'cities2.id')
            ->select('paths.id as id','paths.departure_time as departure_time','paths.arrival_time as arrival_time',
             'cities.name as city_of_origin', 'cities2.name as city_of_destination')
            ->get();

        return $paths;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'city_of_origin' => 'required',
            'city_of_destination' => 'required',
            'departure_time' => 'required',
            'arrival_time' => 'required',
        ]);
        Path::create($request->all());

        return response()->json([
            'message' => 'Trajeto criado com sucesso!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paths = DB::table('paths')
            ->join('cities', 'paths.city_of_origin', '=', 'cities.id')
            ->join('cities as cities2', 'paths.city_of_destination', '=', 'cities2.id')
            ->select('paths.id as id','paths.departure_time as departure_time','paths.arrival_time as arrival_time',
             'cities.name as city_of_origin', 'cities2.name as city_of_destination')
            ->where('paths.id', $id)
            ->get();

            return $paths;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $request->validate([
            'city_of_origin' => 'required',
            'city_of_destination' => 'required',
            'departure_time' => 'required',
            'arrival_time' => 'required',
        ]);

        $path = Path::find($id);
        $path->update($request->all());

        $newPath = DB::table('paths')
            ->join('cities', 'paths.city_of_origin', '=', 'cities.id')
            ->join('cities as cities2', 'paths.city_of_destination', '=', 'cities2.id')
            ->select('paths.*', 'cities.name as city_of_origin', 'cities2.name as city_of_destination')
            ->where('paths.id', $id)
            ->get();


        return $newPath;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Path::destroy($id);
        return response()->json([
            'message' => 'Trajeto deletado com sucesso!'
        ]);
    }
}
