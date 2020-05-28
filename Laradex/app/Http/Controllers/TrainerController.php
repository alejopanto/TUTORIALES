<?php

namespace Laradex\Http\Controllers;

use Laradex\Trainer;
use Illuminate\Http\Request;
use Laradex\Http\Requests\StoreTrainerRequest;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin', 'user']);

        $trainers = Trainer::all();

        return view('trainers.index', compact('trainers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('trainers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainerRequest $request)
    {
              
        if($request -> hasFile('avatar')){
            $file = $request->file('avatar');
            $name = time().$file->getClientOriginalName();
            $file -> move(public_path().'/images/',$name);
        }
        $trainer = new Trainer();
        $trainer -> name = $request->input('name');
        $trainer -> description = $request->input('description');
        $trainer -> slug = $request->input('slug');
        $trainer -> avatar = $name;
        $trainer -> save();
        
        //return  'Saved';
        
        return redirect()->route('trainers.index')->with('status', 'Entrenador Creado Correctamente');

        //return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Trainer $trainer)//por $id o por $slug
    {
        //$trainer = Trainer::where('slug', '=', $slug)-> firstOrFail();
        //$trainer = Trainer::find($id);
        
        return view('trainers.show', compact('trainer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Trainer $trainer)
    {
        //$trainer = Trainer::where('slug', '=', $slug)-> firstOrFail();
        return view('trainers.edit', compact('trainer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trainer $trainer)
    {
        //$trainer = Trainer::where('slug', '=', $slug)-> firstOrFail();
        
        $trainer->fill($request->except('avatar'));
            if($request -> hasFile('avatar')){
                $file = $request->file('avatar');
                $name = time().$file->getClientOriginalName();
                $trainer->avatar = $name;
                $file -> move(public_path().'/images/',$name);
            }
        $trainer->save();
        return redirect()->route('trainers.show', [$trainer])->with('status', 'Entrenador Actaualizado Correctamente');
        //return 'Update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trainer $trainer)
    {
        //$trainer = Trainer::where('slug', '=', $slug)-> firstOrFail();
        
        $file_path = public_path().'/images/'.$trainer->avatar;
        \File::delete($file_path);

        $trainer -> delete();
        return redirect()->route('trainers.index')->with('status', 'Entrenador Eliminado Correctamente');; 
    }
}
