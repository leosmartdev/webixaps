<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\FeedCategory;
use App\FeedCategoryExtraField;

class FeedCategoryController extends Controller
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
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['name'=>"Feed Category List"]
        ];
        return view('admin/feed_categories/index', [
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
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['link'=>"/admin/feed_categories",'name'=>"Feed Category List"] ,['name'=>"Add Feed Category"]
        ];
        return view('admin/feed_categories/create', [
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
            'feed_category_name'         => 'required|min:3|max:100'
        ]);
        
        $feed_category = new FeedCategory([
            'feed_category_name' => $request->get('feed_category_name')
        ]);

        $feed_category->save();

        return redirect('admin/feed_categories')->with('success', 'New Feed Category Added!');
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
            ['link'=>"/admin/dashboard",'name'=>"Dashboard"], ['link'=>"/admin/feed_categories",'name'=>"Feed Category List"] ,['name'=>"Edit Feed Category"]
        ];
        $feed_category = FeedCategory::find($id);
        $fcf = array();
        $fcf = FeedCategoryExtraField::getFields($id, array());
        return view('admin/feed_categories/edit', [
            'breadcrumbs' => $breadcrumbs,
            'feed_category' => $feed_category,
            'fcf' => $fcf
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
            'feed_category_name'         => 'required|min:3|max:100'
        ]);
        
        $feed_category = FeedCategory::find($id);
        $feed_category->feed_category_name = $request->get('feed_category_name');
        $feed_category->save();

        return redirect()->back()->with('success', 'Feed Category Updated!');
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

    public function feed_category_ajax_list(){
        $feed_categories = FeedCategory::all();
        $feed_categoriesJson = json_encode($feed_categories);
        
        return $feed_categoriesJson;
    }
}
