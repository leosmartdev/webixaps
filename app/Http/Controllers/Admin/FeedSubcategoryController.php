<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\FeedCategory;
use App\FeedSubcategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedSubcategoryController extends Controller
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
      ['link' => "/admin/dashboard", 'name' => "Dashboard"],
      ['name' => "Feed Subcategory List"]
    ];

    return view(
      'admin/feed_subcategories/index',
      [
        'breadcrumbs' => $breadcrumbs
      ]
    );
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
      ['link' => "/admin/dashboard", 'name' => "Dashboard"],
      ['link' => "/admin/feed_subcategories", 'name' => "Feed Subcategory List"],
      ['name' => "Add Feed Subcategory"]
    ];
    $countries = Country::all();
    $feed_categories = FeedCategory::all();

    return view(
      'admin/feed_subcategories/create',
      [
        'breadcrumbs'     => $breadcrumbs,
        'countries'       => $countries,
        'feed_categories' => $feed_categories
      ]
    );
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
    //
    $request->validate(
      [
        'feed_subcategory_name' => 'required|min:3|max:100'
      ]
    );

    $feed_subcategory = new FeedSubcategory(
      [
        'feed_subcategory_name' => $request->get('cc') . ' - ' . $request->get('feed_subcategory_name'),
        'country_id'            => $request->get('country_id'),
        'feed_category_id'      => $request->get('feed_category_id'),
        'sort_by'               => $request->get('sort_by'),
        'sort_order'            => $request->get('sort_order')
      ]
    );

    $feed_subcategory->save();

    return redirect('admin/feed_subcategories')->with('success', 'New Feed Subcategory Added!');
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
    //
    $breadcrumbs = [
      ['link' => "/admin/dashboard", 'name' => "Dashboard"],
      ['link' => "/admin/feed_subcategories", 'name' => "Feed Subcategory List"],
      ['name' => "Edit Feed Subcategory"]
    ];
    $feed_subcategory = FeedSubcategory::find($id);
    $countries = Country::all();
    $feed_categories = FeedCategory::all();

    return view(
      'admin/feed_subcategories/edit',
      [
        'breadcrumbs'      => $breadcrumbs,
        'feed_subcategory' => $feed_subcategory,
        'countries'        => $countries,
        'feed_categories'  => $feed_categories
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
    //

    $feed_subcategory = FeedSubcategory::find($id);
    $feed_subcategory->feed_subcategory_name = $request->get('feed_subcategory_name');
    $feed_subcategory->country_id = $request->get('country_id');
    $feed_subcategory->feed_category_id = $request->get('feed_category_id');
    $feed_subcategory->sort_by = $request->get('sort_by');
    $feed_subcategory->sort_order = $request->get('sort_order');
    $feed_subcategory->save();

    return redirect()->back()->with('success', 'Feed Subcategory Updated!');
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
    FeedSubcategory::find($id)->delete();

    return json_encode(['statusCode' => 200]);
  }

  public function feed_subcategory_ajax_list()
  {
    $feed_subcategories = FeedSubcategory::getFeedSubCategories();

    return json_encode($feed_subcategories);
  }

  public function find_subcategories(Request $request)
  {
    $feed_subcategories = FeedSubcategory::findFeedSubCategories(
      $request->get('country_id'),
      $request->get('feed_category_id')
    );

    return json_encode($feed_subcategories);
  }

  private function fopen_utf8($filename)
  {
    $encoding = '';
    $handle = fopen($filename, 'r');
    $bom = fread($handle, 2);
    //  fclose($handle);
    rewind($handle);

    if ($bom === chr(0xff) . chr(0xfe) || $bom === chr(0xfe) . chr(0xff)) {
      // UTF16 Byte Order Mark present
      $encoding = 'UTF-16';
    } else {
      $file_sample = fread($handle, 1000) + 'e'; //read first 1000 bytes
      // + e is a workaround for mb_string bug
      rewind($handle);

      $encoding = mb_detect_encoding(
        $file_sample,
        'UTF-8, UTF-7, ASCII, EUC-JP,SJIS, eucJP-win, SJIS-win, JIS, ISO-2022-JP'
      );
    }
    if ($encoding) {
      stream_filter_append($handle, 'convert.iconv.' . $encoding . '/UTF-8');
    }

    return ($handle);
  }

  private function import_feed_categories()
  {

    $categories = array(
      array('category_name' => 'DK - All', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'SE - All', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'NO - All', 'country_name' => 'Norway', 'name' => 'Loans'),
      array('category_name' => 'NO - Creditcards', 'country_name' => 'Norway', 'name' => 'Credit Cards'),
      array('category_name' => 'SE - Creditcards', 'country_name' => 'Sweden', 'name' => 'Credit Cards'),
      array('category_name' => 'DK - Creditcards', 'country_name' => 'Denmark', 'name' => 'Credit Cards'),
      array('category_name' => 'SE - Snabblån', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'SE - Mikrolån', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'SE - SMSlån', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'DK - Kviklån', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - Forbrugslån', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - SMS lån', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'NO - Smålån', 'country_name' => 'Norway', 'name' => 'Loans'),
      array('category_name' => 'NO - Forbrukslån', 'country_name' => 'Norway', 'name' => 'Loans'),
      array('category_name' => 'DK - Ekspres bank', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - Leasy koncernen', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - Home', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'SE - Home', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'NO - Leasy', 'country_name' => 'Norway', 'name' => 'Loans'),
      array('category_name' => 'NO - Lån med nemid', 'country_name' => 'Norway', 'name' => 'Loans'),
      array('category_name' => 'NO - Lån uden nemid', 'country_name' => 'Norway', 'name' => 'Loans'),
      array('category_name' => 'SE - Lån med nemid', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'DK - Lån med nemid', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - Lån uden nemid', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - Gratis lån', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - Basisbank', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'SE - Betalningsanmärkningar', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'DK - Creditcard Mix', 'country_name' => 'Denmark', 'name' => 'Credit Cards'),
      array('category_name' => 'NO - Home', 'country_name' => 'Norway', 'name' => 'Loans'),
      array('category_name' => 'DK - Spar Nord', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - Santander', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - hurtigste udbetaling', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - Samlelån', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - Forbrugslån 100.000 plus', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - Lån uden lønseddel', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'FI - All', 'country_name' => 'Finland', 'name' => 'Loans'),
      array('category_name' => 'FI - Quickloans', 'country_name' => 'Finland', 'name' => 'Loans'),
      array('category_name' => 'FI - Consumerloans', 'country_name' => 'Finland', 'name' => 'Loans'),
      array('category_name' => 'FI - Flexible Credit', 'country_name' => 'Finland', 'name' => 'Loans'),
      array('category_name' => 'FI - Creditcatds', 'country_name' => 'Finland', 'name' => 'Credit Cards'),
      array('category_name' => 'SE - Lån uden nemid', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'DK - Mikrolån', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - Email tilbud 23', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - Email tilbud 20', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - Email tilbud 18', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'SE - P2P', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'SE - Lån Utan UC', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'SE - Låneformedlare', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'SE - Långivare', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'SE - Email tilbud 18', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'SE - Email tilbud 20', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'SE - Email tilbud 23', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'NO - Email tilbud 18', 'country_name' => 'Norway', 'name' => 'Loans'),
      array('category_name' => 'NO - Email tilbud 20', 'country_name' => 'Norway', 'name' => 'Loans'),
      array('category_name' => 'NO - Email tilbud 23', 'country_name' => 'Norway', 'name' => 'Loans'),
      array('category_name' => 'ES - All', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'ES - Creditcards', 'country_name' => 'Spain', 'name' => 'Credit Cards'),
      array('category_name' => 'DK - Nye lån LP', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'DK - 3 Lån', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'ES - Homepage', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'PL - All', 'country_name' => 'Poland', 'name' => 'Loans'),
      array('category_name' => 'MX - All', 'country_name' => 'Mexico', 'name' => 'Loans'),
      array('category_name' => 'PL - Small loans', 'country_name' => 'Poland', 'name' => 'Loans'),
      array('category_name' => 'PL - Payday loans', 'country_name' => 'Poland', 'name' => 'Loans'),
      array('category_name' => 'PL - Loans without checking', 'country_name' => 'Poland', 'name' => 'Loans'),
      array('category_name' => 'PL - Consumer loans', 'country_name' => 'Poland', 'name' => 'Loans'),
      array('category_name' => 'PL - SMS loan', 'country_name' => 'Poland', 'name' => 'Loans'),
      array('category_name' => 'PL - Loans under 21 y.o', 'country_name' => 'Poland', 'name' => 'Loans'),
      array('category_name' => 'ES - coche aval', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'MX - Creditcards', 'country_name' => 'Mexico', 'name' => 'Credit Cards'),
      array('category_name' => 'ES- Acepta ASNEF', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'ES-Prestamos pequeños', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'ES-Grandes prestamos', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'ES-2000', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'ES-500', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'ES-5000', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'ES-3000', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'ES-SIN NOMINA', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'NO - Refinansiering', 'country_name' => 'Norway', 'name' => 'Loans'),
      array('category_name' => 'DK - RKI lån', 'country_name' => 'Denmark', 'name' => 'Loans'),
      array('category_name' => 'FI - Home', 'country_name' => 'Finland', 'name' => 'Loans'),
      array('category_name' => 'DK - Home', 'country_name' => 'Denmark', 'name' => 'Job'),
      array('category_name' => 'DK - A-kasser', 'country_name' => 'Denmark', 'name' => 'Job'),
      array('category_name' => 'DK - All', 'country_name' => 'Denmark', 'name' => 'Hosting'),
      array('category_name' => 'DK - Home', 'country_name' => 'Denmark', 'name' => 'Hosting'),
      array('category_name' => 'DK - All', 'country_name' => 'Denmark', 'name' => 'Broadbands'),
      array('category_name' => 'DK - Home', 'country_name' => 'Denmark', 'name' => 'Broadbands'),
      array('category_name' => 'DK - All', 'country_name' => 'Denmark', 'name' => 'Job'),
      array('category_name' => 'DK - All', 'country_name' => 'Denmark', 'name' => 'Credit Cards'),
      array('category_name' => 'DK - All', 'country_name' => 'Denmark', 'name' => 'Mobil'),
      array('category_name' => 'DK - All', 'country_name' => 'Denmark', 'name' => 'Dating'),
      array('category_name' => 'DK - All', 'country_name' => 'Denmark', 'name' => 'Casino'),
      array('category_name' => 'DK - All', 'country_name' => 'Denmark', 'name' => 'Magazines'),
      array('category_name' => 'DK - testing Dating', 'country_name' => 'Denmark', 'name' => 'Dating'),
      array('category_name' => 'SE - Weekend loans', 'country_name' => 'Sweden', 'name' => 'Loans'),
      array('category_name' => 'MX - prest.pequeños 500-10.000 ', 'country_name' => 'Mexico', 'name' => 'Loans'),
      array('category_name' => 'MX - prest grandes 100.000-300.000', 'country_name' => 'Mexico', 'name' => 'Loans'),
      array('category_name' => 'MX - prest medianos 10.000-100.000', 'country_name' => 'Mexico', 'name' => 'Loans'),
      array('category_name' => 'MX - Homepage', 'country_name' => 'Mexico', 'name' => 'Loans'),
      array('category_name' => 'ES - Los que convierten', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'ES-9000', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'ES - 10000', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'ES - DIFICILES', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'ES - CREZU', 'country_name' => 'Spain', 'name' => 'Loans'),
      array('category_name' => 'holadinero mexico', 'country_name' => 'Mexico', 'name' => 'Loans'),
      array('category_name' => 'mx - creditea', 'country_name' => 'Mexico', 'name' => 'Loans'),
      array('category_name' => 'MX - los que convierten', 'country_name' => 'Mexico', 'name' => 'Loans'),
      array('category_name' => 'ES - SIN NOMINA', 'country_name' => 'Spain', 'name' => 'Loans')
    );

    foreach ($categories as $category) {
      $country = Country::where('country_name', '=', $category['country_name'])->first();
      $feed_category = FeedCategory::where('feed_category_name', '=', $category['name'])->first();

      $feed_subcategory = new FeedSubcategory(
        [
          'feed_subcategory_name' => $category['category_name'],
          'country_id'            => $country->id,
          'feed_category_id'      => $feed_category->id
        ]
      );

      $feed_subcategory->save();
    }
  }

}
