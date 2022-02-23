<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Country;
use Validator;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=>"Country List"]
        ];
        return view('admin/countries/index', [
            'breadcrumbs' => $breadcrumbs
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['link'=>"/admin/countries",'name'=>"Country List"] ,['name'=>"Add Country"]
        ];
        return view('admin/countries/create', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'country_name'         => 'required|min:3|max:100',
            'country_code'          => 'required|min:2|max:3',
        ]);
        
        $country = new Country([
            'country_name' => $request->get('country_name'),
            'country_code' => $request->get('country_code'),
        ]);

        $country->save();

        return redirect('admin/countries')->with('success', 'New Country Added!');

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
    public function edit($id)
    {
        //
        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['link'=>"/admin/countries",'name'=>"Country List"] ,['name'=>"Edit Country"]
        ];
        $country = Country::find($id);

        return view('admin/countries/edit', [
            'breadcrumbs' => $breadcrumbs,
            'country' => $country
        ]);
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
        //
        $request->validate([
            'country_name'         => 'required|min:3|max:100',
            'country_code'          => 'required|min:2|max:3',
        ]);
        
        $country = Country::find($id);
        $country->country_name = $request->get('country_name');
        $country->country_code = $request->get('country_code');
        $country->save();

        return redirect()->back()->with('success', 'Country Updated!');

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

    public function country_ajax_list(){

        $countries = Country::all();
        $countriesJson = json_encode($countries);
        
        return $countriesJson;
    }
}
