<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = DB::table('tickets')
            ->join('users', 'tickets.user_id', '=', 'users.id')
            ->join('buses', 'tickets.bus_id', '=', 'buses.id')
            ->join('paths', 'tickets.path_id', '=', 'paths.id')
            ->join('cities', 'paths.city_of_origin', '=', 'cities.id')
            ->join('cities as cities2', 'paths.city_of_destination', '=', 'cities2.id')
            ->select('tickets.id', 'users.name as user_name', 'users.nickname as nickname' ,
            'users.phone as phone', 'buses.name as bus_name', 'buses.plate as plate','tickets.seat as seat', 'tickets.price as price',
            'cities.name as city_of_origin', 'cities2.name as city_of_destination')
            ->get();

            return $tickets;
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
            'user_id' => 'required',
            'bus_id' => 'required',
            'path_id' => 'required',
            'seat' => 'required',
            'price' => 'required',
        ]);

        Ticket::create($request->all());

        return response()->json([
            'message' => 'Ticket criado com sucesso!'
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
        $tickets = DB::table('tickets')
            ->join('users', 'tickets.user_id', '=', 'users.id')
            ->join('buses', 'tickets.bus_id', '=', 'buses.id')
            ->join('paths', 'tickets.path_id', '=', 'paths.id')
            ->join('cities', 'paths.city_of_origin', '=', 'cities.id')
            ->join('cities as cities2', 'paths.city_of_destination', '=', 'cities2.id')
            ->select('tickets.id', 'users.name as user_name', 'users.nickname as nickname' ,
            'users.phone as phone', 'buses.name as bus_name', 'buses.plate as plate', 
            'tickets.seat as seat', 'tickets.price as price',
            'cities.name as city_of_origin', 'cities2.name as city_of_destination')
            ->where('tickets.id', $id)
            ->get();

            return $tickets;
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
            'user_id' => 'required',
            'bus_id' => 'required',
            'path_id' => 'required',
            'seat' => 'required',
            'price' => 'required',
        ]);

        $ticket = Ticket::find($id);
        $ticket->update($request->all());

        return response()->json([
            'message' => 'Ticket atualizado com sucesso!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();

        return response()->json([
            'message' => 'Ticket deletado com sucesso!'
        ]);
    }
}
