<?php

namespace App\Http\Controllers\Admin;

use App\FeedCategoryExtraField;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedCategoryExtraFieldController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate(
      [
        'feed_category_id'             => 'required',
        'feed_category_field_name'     => 'required',
        'feed_category_field_type'     => 'required',
        'feed_category_field_label'    => 'required',
        'feed_category_field_required' => 'required'
      ]
    );

    $feed_category = new FeedCategoryExtraField(
      [
        'feed_category_id'               => $request->get('feed_category_id'),
        'feed_category_field_name'       => $request->get('feed_category_field_name'),
        'feed_category_field_type'       => $request->get('feed_category_field_type'),
        'feed_category_field_label'      => $request->get('feed_category_field_label'),
        'feed_category_field_label_help' => $request->get('feed_category_field_label_help'),
        'feed_category_field_required'   => $request->get('feed_category_field_required')
      ]
    );

    $feed_category->save();
    if ($request->has('feed_category_field_options')) {
      $new_feed_category = FeedCategoryExtraField::find($feed_category->id);
      $new_feed_category->feed_category_field_options = $request->get('feed_category_field_options');

      $new_feed_category->save();
    }

    return redirect('admin/feed_categories/' . $request->get('feed_category_id') . '/edit')->with(
      'success',
      'New Field Added to your Feed Category!'
    );
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $feed_category_extra_field = FeedCategoryExtraField::find($id);

    $breadcrumbs = [
      ['link' => "/admin/dashboard", 'name' => "Dashboard"],
      ['link' => "/admin/feed_categories", 'name' => "Feed Category List"],
      ['name' => "Edit Feed Category Extra Field"]
    ];

    return view(
      'admin/feed_category_extra_fields/edit',
      [
        'breadcrumbs'               => $breadcrumbs,
        'feed_category_extra_field' => $feed_category_extra_field
      ]
    );
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int                      $id
   *
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $request->validate(
      [
        'feed_category_field_type'     => 'required',
        'feed_category_field_label'    => 'required',
        'feed_category_field_required' => 'required'
      ]
    );
    $feed_category_extra_field = FeedCategoryExtraField::find($id);
    $feed_category_extra_field->feed_category_field_type = $request->get('feed_category_field_type');
    $feed_category_extra_field->feed_category_field_label = $request->get('feed_category_field_label');
    $feed_category_extra_field->feed_category_field_required = $request->get('feed_category_field_required');
    $feed_category_extra_field->feed_category_field_options = $request->get('feed_category_field_options');
    $feed_category_extra_field->save();

    return redirect('admin/feed_categories/' . $feed_category_extra_field->feed_category_id . '/edit')->with(
      'success',
      'Field Edited!'
    );
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $pcf = FeedCategoryExtraField::find($id);
    if (!$pcf) {
      return back();
    }
    $feed_category_id = $pcf->feed_category_id;
    $pcf->delete();

    return redirect('admin/feed_categories/' . $feed_category_id . '/edit')->with(
      'success',
      'Feed Category Extra Field Deleted!'
    );
  }
}
