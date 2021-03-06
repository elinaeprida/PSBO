<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\User;

class AlumniController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alumnis = Alumni::orderBy('id', 'desc')->get();
        $users = User::all();
        return view('admin.alumni.alumni', compact('alumnis', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('admin.alumni.create', compact('users'));
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
            'angkatan' => 'required',
            'spesialisasi' => 'required',
            'jabatan' => 'required',
            'perusahaan' => 'required',
            'domisili_pekerjaan' => 'required',
            'domisili_asal' => 'required',
            'instagram' => 'required',
            'linkedin' => 'required',
            'github' => 'required',
        ]);
        
        $alumni = Alumni::create($request->all());

        return redirect()->route('admin_alumni');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_role(User $user)
    {
        return view('admin.alumni.editrole', compact('user'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_role(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required',
        ]);

        $user->update([
            'role' => $request->role,
        ]);
        
        return redirect()->route('admin_alumni');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alumni $alumni)
    {
        Alumni::destroy($alumni->id);
        return redirect('/admin/alumni');
    }
}
