<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')
            ->select(
                'id',
                'name',
                'nickname',
                'email',
                'phone'
            )
            ->get();
        return $users;
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
            'name' => 'required',
            'nickname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'type' => 'required',
        ]);
        User::create($request->all());

        return response()->json([
            'message' => 'Usuário criado com sucesso!'
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
        $users = DB::table('users')
            ->select(
                'id',
                'name',
                'nickname',
                'email',
                'phone'
            )
            ->where('id', '=', $id)
            ->get();

        return $users;
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
            'name' => 'required',
            'nickname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'type' => 'required',
        ]);

        $user = User::find($id);
        $user->update($request->all());

        $newUser = DB::table('users')
            ->select(
                'id',
                'name',
                'nickname',
                'email',
                'phone'
            )
            ->where('id', '=', $id)
            ->get();

        return $newUser;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'message' => 'Usuário deletado com sucesso!'
        ]);
    }
}
