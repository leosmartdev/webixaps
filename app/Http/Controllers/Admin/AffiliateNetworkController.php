<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AffiliateNetwork;


class AffiliateNetworkController extends Controller
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
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=>"Affiliate Network List"]
        ];
        return view('admin/affiliate_networks/index', [
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
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['link'=>"/admin/affiliate_networks",'name'=>"Affiliate Network List"] ,['name'=>"Add Affiliate Network"]
        ];
        return view('admin/affiliate_networks/create', [
            'breadcrumbs' => $breadcrumbs,
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
            'affiliate_network_name' => 'required',
            'affiliate_network_parameter'  => 'required',
            'affiliate_network_postback_parameters'  => 'required',
        ]);
        
        $affiliate_network = new AffiliateNetwork([
            'affiliate_network_name' => $request->get('affiliate_network_name'),
            'affiliate_network_parameter' => $request->get('affiliate_network_parameter'),
            'affiliate_network_postback_parameters' => $request->get('affiliate_network_postback_parameters')
        ]);

        $affiliate_network->save();

        return redirect('admin/affiliate_networks')->with('success', 'New Affiliate Network Added!');
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
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['link'=>"/admin/affiliate_networks",'name'=>"Affiliate Network List"] ,['name'=>"Edit Affiliate Network"]
        ];
        $affiliate_network = AffiliateNetwork::find($id);

        return view('admin/affiliate_networks/edit', [
            'breadcrumbs' => $breadcrumbs,
            'affiliate_network' => $affiliate_network
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
            'affiliate_network_name'         => 'required',
            'affiliate_network_parameter'          => 'required',
            'affiliate_network_postback_parameters'          => 'required',
        ]);
        
        $affiliate_network = AffiliateNetwork::find($id);
        $affiliate_network->affiliate_network_name = $request->get('affiliate_network_name');
        $affiliate_network->affiliate_network_parameter = $request->get('affiliate_network_parameter');
        $affiliate_network->affiliate_network_postback_parameters = $request->get('affiliate_network_postback_parameters');
        $affiliate_network->save();

        return redirect()->back()->with('success', 'Affiliate Network Updated!');
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

    public function affiliate_networks_ajax_list(){

        $affiliate_networks = AffiliateNetwork::all();
        $affiliate_networksJson = json_encode($affiliate_networks);
        
        return $affiliate_networksJson;
    }

}
