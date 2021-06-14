<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Alumni $alumni)
    {
        if (Auth::user()->alumni === NULL){
            return view('alumni.create', compact('alumni'));
        } else {
            return view('alumni.alumniprofile', compact('alumni'));
        }
        // dd($alumnis=Alumni::all());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Alumni $alumni)
    {
        return view('alumni.create', compact('alumni'));
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

        $alumni->update(['avatar' => $request->file('avatar')->store('alumni/avatar', 'public')]);
        return redirect()->route('profile');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Alumni $alumni)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Alumni $alumni)
    {
        return view('alumni.alumniedit', compact('alumni'));
        // return redirect()->route('alumniedit', ['id' => $id]);
        // dd($alumni->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alumni $alumni)
    {
        $request->validate([
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

        $alumni->update([
            'angkatan' => $request->angkatan,
            'spesialisasi' => $request->spesialisasi,
            'jabatan' => $request->jabatan,
            'perusahaan' => $request->perusahaan,
            'domisili_pekerjaan' => $request->domisili_pekerjaan,
            'domisili_asal' => $request->domisili_asal,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'github' => $request->github,
        ]);
        
        
        if($request->has('user')) {
            $alumni->user()->detach();
            foreach($request->user as $key => $value) {
                $alumni->user()->attach($value);
            }
        }

       if($request->hasFile('avatar')) {
            $storedImg = $alumni->avatar;
            $alumni->update(['article_img' => $request->file('avatar')->store('alumni/avatar', 'public')]);
            if(Storage::exists('public/' . $alumni->avatar)) {
                Storage::delete('public/' . $storedImg);
            }
        }

        return redirect()->route('profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
