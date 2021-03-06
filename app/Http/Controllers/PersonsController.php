<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Persons;
use App\Http\Requests\CreatePersonsRequest;
use App\Http\Requests\UpdatePersonsRequest;
use Illuminate\Http\Request;



class PersonsController extends Controller {
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
	 * Display a listing of persons
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
	    $persons = \Cache::rememberForever('persons', function (){

            $persons = Persons::all();
	        return $persons;
	    });  
		return view('persons.index', compact('persons'));
	}

	/**
	 * Show the form for creating a new persons
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
        $gender = Persons::$gender;

	    return view('persons.create', compact('gender'));
	}

	/**
	 * Store a newly created persons in storage.
	 *
     * @param CreatePersonsRequest|Request $request
	 */
	public function store(CreatePersonsRequest $request)
	{
	    
		Persons::create($request->all());

		\Cache::forget('persons');

		return redirect()->route('persons.index');
	}

	/**
	 * Show the form for editing the specified persons.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$persons = Persons::find($id);
	    
	    
        $gender = Persons::$gender;

		return view('persons.edit', compact('persons', 'gender'));
	}

	/**
	 * Update the specified persons in storage.
     * @param UpdatePersonsRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdatePersonsRequest $request)
	{
		$persons = Persons::findOrFail($id);

		$persons->update($request->all());
        
		\Cache::forget('persons');

		return redirect()->route('persons.index');
	}

	/**
	 * Remove the specified persons from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Persons::destroy($id);

		\Cache::forget('persons');

		return redirect()->route('persons.index');
	}


}
