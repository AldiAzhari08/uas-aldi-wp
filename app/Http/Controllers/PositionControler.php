<?php

namespace App\Http\Controllers;
use App\Models\Positions;
use Illuminate\Http\Request;

class PositionControler extends Controller
{
    public function index()
    {
        $title = "Data Positions";
        $positions = Positions::orderBy('id','asc')->paginate(5);
        return view('positions.index', compact(['positions', 'title']));
    }
    public function create()
    {
        $title = "Tambah Data Positions";
        return view('positions.create', compact('title'));
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
            'keterangan',
            'alias',
        ]);
        
        positions::create($request->post());

        return redirect()->route('positions.index')->with('success','positin has been created successfully.');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\$positions  $$positions
    * @return \Illuminate\Http\Response
    */
    public function show(positions $positions)
    {
        return view('positions.show',compact('$positions'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\$positions  $$positions
    * @return \Illuminate\Http\Response
    */
    public function edit(positions $positions)
    {
        return view('positions.edit',compact('$positions'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\$positions  $$positions
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);
        
        $positions->fill($request->post())->save();

        return redirect()->route('companies.index')->with('success','Company Has Been updated successfully');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Company  $company
    * @return \Illuminate\Http\Response
    */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success','Company has been deleted successfully');
    }
}
