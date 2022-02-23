<?php

namespace App\Http\Controllers\Admin;

use App\FeedSite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedSiteController extends Controller
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
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=>"Feed Site List"]
        ];
        return view('admin/feed_sites/index', [
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
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['link'=>"/admin/feed_sites",'name'=>"Feed Site List"] ,['name'=>"Add Feed Site"]
        ];
        return view('admin/feed_sites/create', [
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
            'feed_site_name' => 'required|min:3|max:100',
            'feed_site_domain' => 'required|min:3|max:100',
        ]);

        $feed_site = new FeedSite([
            'feed_site_name' => $request->get('feed_site_name'),
            'feed_site_domain' => $request->get('feed_site_domain'),
            'feed_site_status' => $request->get('feed_site_status')
        ]);

        $feed_site->save();

        return redirect('admin/feed_sites')->with('success', 'New Feed Site Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        //
        $breadcrumbs = [
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['link'=>"/admin/feed_sites",'name'=>"Feed Site List"] ,['name'=>"Edits Feed Site"]
        ];
        $feed_site = FeedSite::find($id);

        return view('admin/feed_sites/edit', [
            'breadcrumbs' => $breadcrumbs,
            'feed_site' => $feed_site
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
            'feed_site_name' => 'required|min:3|max:100',
            'feed_site_domain' => 'required|min:3|max:100',
        ]);
        $feed_site = FeedSite::find($id);
        $feed_site->feed_site_name = $request->get('feed_site_name');
        $feed_site->feed_site_domain = $request->get('feed_site_domain');
        $feed_site->feed_site_status = $request->get('feed_site_status');
        $feed_site->save();

        return redirect()->back()->with('success', 'Feed Site Updated!');
    }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   *
   * @return false|string
   */
  public function destroy($id)
  {
    FeedSite::find($id)->delete();

    return json_encode(array('statusCode' => 200));
  }

  public function feed_site_ajax_list()
  {
    $feed_sites = FeedSite::all();
    $feed_sitesJson = json_encode($feed_sites);

    return $feed_sitesJson;
  }
}
