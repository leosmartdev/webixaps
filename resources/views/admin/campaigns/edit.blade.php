@extends('layouts/contentLayoutMaster')
@section('title', 'Campaigns')
@section('vendor-style')
        <!-- vendor css files -->
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('content')
@if ($errors->any())
<div class="alert alert-danger" role="alert">
  <h4 class="alert-heading">Error</h4>
  <p class="mb-0">
    {{ $errors }}
  </p>
</div>
@endif
@if (session('success'))
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Success</h4>
    <p class="mb-0">
    {{ session('success') }}
    </p>
</div>
@endif
<!-- Basic Horizontal form layout section start -->
<section id="page-campaign-settings">

    <div class="row">
      <!-- left menu section -->
      <div class="col-md-3 mb-2 mb-md-0">
        <ul class="nav nav-pills flex-column mt-md-0 mt-1">
          <li class="nav-item">
            <a class="nav-link d-flex py-75 active" id="campaign-pill-general" data-toggle="pill"
              href="#campaign-vertical-general" aria-expanded="true">
              <i class="feather icon-globe mr-50 font-medium-3"></i>
              Campaign General Information
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex py-75" id="campaign-pill-media" data-toggle="pill"
              href="#campaign-media" aria-expanded="false">
              <i class="feather icon-image mr-50 font-medium-3"></i>
              Campaign Media
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex py-75" id="campaign-pill-specific-details" data-toggle="pill"
              href="#campaign-specific-details" aria-expanded="false">
              <i class="feather icon-plus-square mr-50 font-medium-3"></i>
              Campaign Specific Details
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex py-75" id="campaign-pill-display-settings" data-toggle="pill"
              href="#campaign-display-settings" aria-expanded="false">
              <i class="fa fa-cog mr-50 font-medium-3"></i>
              Campaign Display Settings
            </a>
          </li>
        </ul>
      </div>
      <!-- right content section -->
      <div class="col-md-9">
        <form action="{{ route('admin.campaigns.update', $campaign->id) }}" method="post" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="campaign-vertical-general" aria-labelledby="campaign-pill-general" aria-expanded="true">
                                <h4 class="mb-2"> General Information </h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Country</span>
                                            </div>
                                            <div class="col-md-9">
                                                <select disabled class="form-control find-subcategories" id="country_id" name="country_id">
                                                        <option value="{{ $campaign->country_id }}"> {{ $campaign->country_name }} </option>

                                                </select>
                                                <input type="hidden" required name="country_name" id="country_name" value="{{ $campaign->country_name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Feed Category</span>
                                            </div>
                                            <div class="col-md-9">
                                                <select disabled class="form-control find-subcategories" id="feed_category_id" name="feed_category_id">
                                                    <option value="{{ $campaign->feed_category_id }}"> {{ $campaign->feed_category_name }} </option>
                                                </select>
                                                <input type="hidden" required name="feed_category_name" id="feed_category_name" value="{{ $campaign->feed_category_name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Feed Sub-Category</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="spinner-border initHide" id="feed-subcategory-loader" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                  </div>
                                                <select id="feed-subcategory" required class="select2 form-control" name="feed_subcategories[]" multiple="multiple">
                                                    @foreach($final_feed_subcategories as $feed_subcategory)

                                                        <option  @if(!is_null($feed_subcategory['campaign_feed_subcategory_id'])) selected data-cfsid="{{ $feed_subcategory['campaign_feed_subcategory_id'] }}" @endif value="{{ $feed_subcategory['id'] }}"> {{ $feed_subcategory['feed_subcategory_name'] }} </option>

                                                     @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Campaign Name</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative ">
                                                    <input type="text" id="campaign_name" value="{{ $campaign->campaign_name }}" required class="form-control" name="campaign_name" placeholder="Enter Campaign Name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Clean URL</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative">
                                                    <input type="text" id="clean_url" value="{{ $campaign->clean_url }}" required class="form-control" name="clean_url" placeholder="Enter Clean URL">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Affiliate Network</span>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control" id="affiliate_network_id" name="affiliate_network_id">
                                                    <option> Select Affiliate Network </option>
                                                    @foreach($affiliate_networks as $affiliate_network)
                                                        <option {{ ($affiliate_network->id == $campaign->affiliate_network_id) ? 'selected' : '' }}  value="{{ $affiliate_network->id }}">{{ $affiliate_network->affiliate_network_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Affiliate Network URL</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative">
                                                    <input type="text" id="affiliate_network_url" value="{{ $campaign->affiliate_network_url }}"  required class="form-control" name="affiliate_network_url" placeholder="Enter Affiliate Network URL">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Initial EPC</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative">
                                                    <input type="text" id="campaign_initial_epc" required class="form-control" name="campaign_initial_epc" value="{{ $campaign->campaign_initial_epc }}" placeholder="Enter Initial EPC">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Rating</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative">
                                                    <input type="text" id="rating" required class="form-control" name="rating" value="{{ $campaign->rating }}" placeholder="Enter Rating">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Campaign Logo</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="custom-file">
                                                    <input type="file" id="campaign_logo" class="campaign_logo" name="campaign_logo" accept="image/*" />
                                                    <label class="custom-file-label" for="campaign_logo">Choose file; Size: 200px x 127px</label>
                                                </div>
                                                <div class="campaign_logo_preview"><img src="/storage/campaign_logo/{{  $campaign->campaign_logo }}" alt="Campaign Logo" height="40" width="130"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="campaign-media" aria-labelledby="campaign-pill-media" aria-expanded="true">
                                <h4 class="mb-2"> Campaign Media </h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Campaign Ribbon</span>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control" id="campaign_ribbon" name="campaign_ribbon">
                                                    <option> Select Campaign Ribbon </option>
                                                    <option {{ ($campaign->campaign_ribbon == "Nyhed") ? 'selected' : '' }} value="Nyhed"> Nyhed </option>
                                                    <option {{ ($campaign->campaign_ribbon == "Anbefalet") ? 'selected' : '' }} value="Anbefalet"> Anbefalet </option>
                                                    <option {{ ($campaign->campaign_ribbon == "Populær") ? 'selected' : '' }} value="Populær"> Populær </option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Campaign Banner (Small)</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="custom-file">
                                                    <input type="file" id="campaign_banner_small" class="campaign_banner_small" name="campaign_banner_small" accept="image/*" />
                                                    <label class="custom-file-label" for="campaign_banner_small">Choose file; Size: 300px x 250px</label>
                                                </div>
                                                <div class="campaign_banner_small_preview"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Campaign Banner (Medium)</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="custom-file">
                                                    <input type="file" id="campaign_banner_medium" class="campaign_banner_medium" name="campaign_banner_medium" accept="image/*" />
                                                    <label class="custom-file-label" for="campaign_banner_medium">Choose file; Size: 468px x 60px</label>
                                                </div>
                                                <div class="campaign_banner_medium_preview"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Campaign Banner (Large)</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="custom-file">
                                                    <input type="file" id="campaign_banner_large" class="campaign_banner_large" name="campaign_banner_large" accept="image/*" />
                                                    <label class="custom-file-label" for="campaign_banner_large">Choose file; Size: 728px x 90px</label>
                                                </div>
                                                <div class="campaign_banner_large_preview"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="campaign-specific-details" aria-labelledby="campaign-pill-specific-details" aria-expanded="true">
                                <h4 class="mb-2"> Campaign Specific Details </h4>
                                <div class="row">
                                    @if(!$fields->isEmpty())
                                        @foreach($fields as $field)
                                            @switch($field->type)
                                                @case("TextField:Normal")
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <div class="col-md-3">
                                                            <span class="text-bold-600">{{ $field->label }}</span>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="position-relative">
                                                            <input type="text" value="{{ isset($campaign_extra_field_value[$field->name])? $campaign_extra_field_value[$field->name] :"" }}" id="{{ $field->name }}" class="form-control" @if ($field->required == "on") required @endif name="campaign_extra_field_value[{{ $field->name }}]" placeholder="{{ $field->label }}">
                                                                <small class="text-muted"> {{ $field->help }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                                @case("TextField:Number")
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <div class="col-md-3">
                                                            <span class="text-bold-600">{{ $field->label }}</span>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="position-relative">
                                                                <input type="text" value="{{ isset($campaign_extra_field_value[$field->name])? $campaign_extra_field_value[$field->name] :"" }}" id="{{ $field->name }}" @if ($field->required == "on") required @endif class="form-control numText" name="campaign_extra_field_value[{{ $field->name }}]" placeholder="{{ $field->label }}">
                                                                <small class="text-muted"> {{ $field->help }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                                @case("TextField:Email")
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <div class="col-md-3">
                                                            <span class="text-bold-600">{{ $field->label }}</span>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="position-relative">
                                                                <input type="email" value="{{ isset($campaign_extra_field_value[$field->name])? $campaign_extra_field_value[$field->name] :"" }}" id="{{ $field->name }}" @if ($field->required == "on") required @endif class="form-control" name="campaign_extra_field_value[{{ $field->name }}]" placeholder="{{ $field->label }}">
                                                                <small class="text-muted"> {{ $field->help }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                                @case("TextField:URL")
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <div class="col-md-3">
                                                            <span class="text-bold-600">{{ $field->label }}</span>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="position-relative">
                                                                <input type="text"  value="{{ isset($campaign_extra_field_value[$field->name])? $campaign_extra_field_value[$field->name] :"" }}" id="{{ $field->name }}" class="form-control" @if ($field->required == "on") required @endif name="campaign_extra_field_value[{{ $field->name }}]" placeholder="{{ $field->label }}">
                                                                <small class="text-muted"> {{ $field->help }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                                @case("TextField:Date")
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <div class="col-md-3">
                                                            <span class="text-bold-600">{{ $field->label }}</span>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="position-relative">
                                                                <input type="text" value="{{ isset($campaign_extra_field_value[$field->name])? $campaign_extra_field_value[$field->name] :"" }}" id="{{ $field->name }}" @if ($field->required == "on") required @endif class="form-control pickadate-months-year" name="campaign_extra_field_value[{{ $field->name }}]" placeholder="{{ $field->label }}">
                                                                <small class="text-muted"> {{ $field->help }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                                @case("Options:Select")
                                                @php
                                                   $options = explode(PHP_EOL, $field->options);
                                                @endphp
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <div class="col-md-3">
                                                            <span class="text-bold-600">{{ $field->label }}</span>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="position-relative">
                                                                <select name="campaign_extra_field_value[{{ $field->name }}]"  class="form-control">
                                                                    @foreach ($options as $option)
                                                                        @php $opt = explode("|", $option); @endphp
                                                                        <option {{ (isset($campaign_extra_field_value[$field->name]) && $opt[0] == $campaign_extra_field_value[$field->name])?"selected":"" }} value="{{ $opt[0]}}"> {{ $opt[1] }} </option>
                                                                    @endforeach
                                                                </select>
                                                                <small class="text-muted"> {{ $field->help }} </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                                @case("Textarea")
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        <div class="col-md-3">
                                                            <span class="text-bold-600">{{ $field->label }}</span>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="position-relative">


                                                            <textarea wrap name="campaign_extra_field_value[{{ $field->name }}]" rows="5"  class="form-control">{{isset($campaign_extra_field_value[$field->name])?preg_replace('/[\s\t\n]{2,}/',' ',$campaign_extra_field_value[$field->name]):""}}</textarea>

                                                                <small class="text-muted"> {{ $field->help }} </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                            @endswitch
                                        @endforeach
                                    @else
                                    <div>
                                      <div class="text-center" colspan="3"> No Fields Available </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="campaign-display-settings" aria-labelledby="campaign-pill-display-settings" aria-expanded="true">
                                <h4 class="mb-2"> Campaign Display Settings </h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Display Settings</span>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control" id="display_setting" name="display_setting">
                                                    <option {{ ($campaign->display_setting == "display_to_all") ? 'selected' : '' }} value="display_to_all"> Display to all (Default) </option>
                                                    <option {{ ($campaign->display_setting == "do_not_display") ? 'selected' : '' }} value="do_not_display"> Do not Display </option>
                                                    <option {{ ($campaign->display_setting == "show_only_on") ? 'selected' : '' }} value="show_only_on"> Display only on </option>
                                                    <option {{ ($campaign->display_setting == "do_not_show_on") ? 'selected' : '' }} value="do_not_show_on"> Display on all Except </option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                                    <li class="nav-item">
                                                      <a class="nav-link active" id="home-tab-fill" data-toggle="tab" href="#home-fill" role="tab"
                                                        aria-controls="home-fill" aria-selected="true">Display only on</a>
                                                    </li>
                                                    <li class="nav-item">
                                                      <a class="nav-link" id="profile-tab-fill" data-toggle="tab" href="#profile-fill" role="tab"
                                                        aria-controls="profile-fill" aria-selected="false">Display on all EXCEPT</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content pt-1">
                                                    <div class="tab-pane active" id="home-fill" role="tabpanel" aria-labelledby="home-tab-fill">
                                                        <select id="display_only_on" class="select2 form-control" name="display_only_on[]" multiple="multiple">
                                                            @foreach($final_feed_display_ons as $final_feed_display_on)

                                                            <option data-campaign-id="{{ $campaign->id }}" @if(!is_null($final_feed_display_on['campaign_feed_site_id'])) selected data-cfsid="{{ $final_feed_display_on['campaign_feed_site_id'] }}" @endif value="{{ $final_feed_display_on['id'] }}"> {{ $final_feed_display_on['feed_site_name'] }} </option>

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="tab-pane" id="profile-fill" role="tabpanel" aria-labelledby="profile-tab-fill">
                                                        <select id="display_on_all_except" class="select2 form-control" name="display_on_all_except[]" multiple="multiple">
                                                            @foreach($final_feed_display_on_excepts as $final_feed_display_on_except)

                                                            <option data-campaign-id="{{ $campaign->id }}" @if(!is_null($final_feed_display_on_except['campaign_feed_site_id'])) selected data-cfsid="{{ $final_feed_display_on_except['campaign_feed_site_id'] }}" @endif value="{{ $final_feed_display_on_except['id'] }}"> {{ $final_feed_display_on_except['feed_site_name'] }} </option>

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-12">
                            <div class="float-right mb-1">
                                <button type="reset" class="btn btn-large btn-outline-warning mr-1 mb-1">Reset</button>
                                <button type="submit" class="btn btn-large btn-primary mr-1 mb-1">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
      </div>
    </div>
</section>

@endsection
@section('vendor-script')
        <!-- vendor files -->
        <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/forms/select/form-select2.js')) }}"></script>
  <script>
    $(document).ready(function(){



        var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img class="img-responsive">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

        };

        $('#campaign_logo').on('change', function() {
            $(".campaign_logo_preview").empty();
            imagesPreview(this, 'div.campaign_logo_preview');
        });

        $('#campaign_banner_small').on('change', function() {
            $(".campaign_banner_small_preview").empty();
            imagesPreview(this, 'div.campaign_banner_small_preview');
        });
        $('#campaign_banner_medium').on('change', function() {
            $(".campaign_banner_medium_preview").empty();
            imagesPreview(this, 'div.campaign_banner_medium_preview');
        });
        $('#campaign_banner_large').on('change', function() {
            $(".campaign_banner_large_preview").empty();
            imagesPreview(this, 'div.campaign_banner_large_preview');
        });

        $('#feed-subcategory').on('select2:unselect', function (e) {

            if(!confirm("Do you really want to delete campaign feed subcategory?")) {
                return false;
            }

            e.preventDefault();
            var id = e.params.data.element.dataset.cfsid;
            // var id = $(this).attr('data-id');
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;

            $.ajax(
            {
                url: "/admin/campaign_feed_subcategories/"+id,
                type: 'DELETE',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (){
                    alert("Campaign Feed Subcategory removed!");
                },
                error: function (error) {
                    alert('error; ' + eval(error));
                }
            });
            return false;
        });

        // DELETE FUNCTION

        $('#display_only_on').on('select2:unselect', function (e) {

            if(!confirm("Do you really want to delete feed site on display settings?")) {
                return false;
            }

            e.preventDefault();
            var id = e.params.data.element.dataset.cfsid;
            // var id = $(this).attr('data-id');
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;

            $.ajax(
            {
                url: "/admin/campaign_display_settings/"+id,
                type: 'DELETE',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (){
                    alert("Feed site on display settings removed!");
                },
                error: function (error) {
                    alert('error; ' + eval(error));
                }
            });
            return false;
        });

        $('#display_only_on').on('select2:select', function (e) {
            // Do something
            e.preventDefault();
            var id = e.params.data.id;
            var campaign_id = e.params.data.element.dataset.campaignId;
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax(
            {
                url: "/admin/campaign_display_settings/",
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    "campaign_id":campaign_id,
                    "type":"display_only_on"
                },
                success: function (){
                    alert("Campaign display settings updated!");
                },
                error: function (error) {
                    alert('error; ' + eval(error));
                }
            });

            return false;


        });

        $('#display_on_all_except').on('select2:unselect', function (e) {

            if(!confirm("Do you really want to delete feed site on display settings?")) {
                return false;
            }

            e.preventDefault();
            var id = e.params.data.element.dataset.cfsid;
            // var id = $(this).attr('data-id');
            var token = $("meta[name='csrf-token']").attr("content");
            var url = e.target;

            $.ajax(
            {
                url: "/admin/campaign_display_settings/"+id,
                type: 'DELETE',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (){
                    alert("Feed site on display settings removed!");
                },
                error: function (error) {
                    alert('error; ' + eval(error));
                }
            });
            return false;
        });

        $('#display_on_all_except').on('select2:select', function (e) {
            // Do something
            e.preventDefault();
            var id = e.params.data.id;
            var campaign_id = e.params.data.element.dataset.campaignId;
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax(
            {
                url: "/admin/campaign_display_settings/",
                type: 'POST',
                data: {
                    "id": id,
                    "_token": token,
                    "campaign_id":campaign_id,
                    "type":"display_on_all_except"
                },
                success: function (){
                    alert("Campaign display settings updated!");
                },
                error: function (error) {
                    alert('error; ' + eval(error));
                }
            });

            return false;


        });






    });
</script>
@endsection
