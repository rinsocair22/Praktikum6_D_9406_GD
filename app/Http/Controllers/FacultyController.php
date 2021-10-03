<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\http\\Controllers\Controller;
use App\Faculty;
use Mail;
use App\Mail\FacultyMail;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculties = Faculty::orderBy('id', 'ASC')->get();
        
        return view('facultyCRUD.index', compact('faculties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('facultyCRUD.create');
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
            'nama_fakultas' => 'required',
        ]);

        Faculty::create($request->all());

        return redirect()->route('faculties.index')
        ->with('success','Item created successfully.');

        ///Mengirimkan Email
        try{
        $detail = [
        'body' =>$request->nama_fakultas,
        ];
        Mail::to('rionicolaus22@gmail.com')->send(new FacultyMail($detail)); 
        /// redirect jika sukses menyimpan data
        return redirect()->route('faculties.index')
        ->with('success','Item created successfully.');
        }catch(Exception $e){
        return redirect()->route('faculties.index')->with('success','Item Created Successfully but cannot send the email');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $faculties = Faculty::find($id);
        return view('facultyCRUD.show',compact('faculties'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faculties = Faculty::find($id);
        return view('facultyCRUD.edit',compact('faculties'));
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
            'nama_fakultas'=>'required',
        ]);

        Faculty::find($id)->update($request->all());

        return redirect()->route('faculties.index')
                        ->with('success','Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Faculty::find($id)->delete();

        return redirect()->route('faculties.index')
                        ->with('success','Item deleted successfully');
    }
}
