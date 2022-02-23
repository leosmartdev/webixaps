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
                        <a class="nav-link d-flex py-75 disabled" id="campaign-pill-specific-details" data-toggle="pill"
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
                <form action="{{ route('admin.campaigns.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="campaign-vertical-general"
                                         aria-labelledby="campaign-pill-general" aria-expanded="true">
                                        <h4 class="mb-2"> General Information </h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                        <span class="text-bold-600">Country</span>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select class="form-control find-subcategories" id="country_id"
                                                                name="country_id">
                                                            <option> Select Country</option>
                                                            @foreach($countries as $country)
                                                                <option value="{{ $country->id }}"
                                                                        {{ old('country_id') == $country->id ? 'selected' : '' }} data-cn="{{ $country->country_name }}">{{ $country->country_code }}
                                                                    - {{ $country->country_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" required name="country_name"
                                                               id="country_name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                        <span class="text-bold-600">Feed Category</span>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select class="form-control find-subcategories"
                                                                id="feed_category_id" name="feed_category_id">
                                                            <option> Select Feed Category</option>
                                                            @foreach($feed_categories as $feed_category)
                                                                <option value="{{ $feed_category->id }}"
                                                                        {{ old('feed_category_id') == $feed_category->id ? 'selected' : '' }} data-fcn="{{ $feed_category->feed_category_name }}">{{ $feed_category->feed_category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" required name="feed_category_name"
                                                               id="feed_category_name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                        <span class="text-bold-600">Feed Sub-Category</span>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="spinner-border initHide"
                                                             id="feed-subcategory-loader" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                        <select id="feed-subcategory" required
                                                                class="select2 form-control" name="feed_subcategories[]"
                                                                multiple="multiple">
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
                                                            <input type="text" id="campaign_name"
                                                                   value="{{old('campaign_name', "")}}" required
                                                                   class="form-control" name="campaign_name"
                                                                   placeholder="Enter Campaign Name">
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
                                                            <input type="text" id="clean_url"
                                                                   value="{{old('clean_url', "")}}" required
                                                                   class="form-control" name="clean_url"
                                                                   placeholder="Enter Clean URL">
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
                                                        <select class="form-control" id="affiliate_network_id"
                                                                name="affiliate_network_id">
                                                            <option> Select Affiliate Network</option>
                                                            @foreach($affiliate_networks as $affiliate_network)
                                                                <option value="{{ $affiliate_network->id }}" {{ old('affiliate_network_id') == $affiliate_network->id ? 'selected' : '' }}>{{ $affiliate_network->affiliate_network_name }}</option>
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
                                                            <input type="text" id="affiliate_network_url"
                                                                   value="{{old('affiliate_network_url', "")}}" required
                                                                   class="form-control" name="affiliate_network_url"
                                                                   placeholder="Enter Affiliate Network URL">
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
                                                            <input type="text" id="campaign_initial_epc" required
                                                                   class="form-control" name="campaign_initial_epc"
                                                                   value="{{old('campaign_initial_epc', 0)}}"
                                                                   placeholder="Enter Initial EPC">
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
                                                            <input type="text" id="rating" required class="form-control"
                                                                   name="rating" value="{{old('rating', 100)}}"
                                                                   placeholder="Enter Rating">
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
                                                            <input type="file" required id="campaign_logo"
                                                                   class="campaign_logo" name="campaign_logo"
                                                                   accept="image/*"/>
                                                            <label class="custom-file-label" for="campaign_logo">Choose
                                                                file; Size: 200px x 127px</label>
                                                        </div>
                                                        <div class="campaign_logo_preview"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="campaign-media"
                                         aria-labelledby="campaign-pill-media" aria-expanded="true">
                                        <h4 class="mb-2"> Campaign Media </h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                        <span class="text-bold-600">Campaign Ribbon</span>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select class="form-control" id="campaign_ribbon"
                                                                name="campaign_ribbon">
                                                            <option> Select Campaign Ribbon</option>
                                                            <option value="Nyhed"> Nyhed</option>
                                                            <option value="Anbefalet"> Anbefalet</option>
                                                            <option value="Populær"> Populær</option>
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
                                                            <input type="file" id="campaign_banner_small"
                                                                   class="campaign_banner_small"
                                                                   name="campaign_banner_small" accept="image/*"/>
                                                            <label class="custom-file-label"
                                                                   for="campaign_banner_small">Choose file; Size: 300px
                                                                x 250px</label>
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
                                                            <input type="file" id="campaign_banner_medium"
                                                                   class="campaign_banner_medium"
                                                                   name="campaign_banner_medium" accept="image/*"/>
                                                            <label class="custom-file-label"
                                                                   for="campaign_banner_medium">Choose file; Size: 468px
                                                                x 60px</label>
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
                                                            <input type="file" id="campaign_banner_large"
                                                                   class="campaign_banner_large"
                                                                   name="campaign_banner_large" accept="image/*"/>
                                                            <label class="custom-file-label"
                                                                   for="campaign_banner_large">Choose file; Size: 728px
                                                                x 90px</label>
                                                        </div>
                                                        <div class="campaign_banner_large_preview"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="campaign-display-settings"
                                         aria-labelledby="campaign-pill-display-settings" aria-expanded="true">
                                        <h4 class="mb-2"> Campaign Display Settings </h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                        <span class="text-bold-600">Display Settings</span>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select class="form-control" id="display_setting"
                                                                name="display_setting">
                                                            <option value="display_to_all"> Display to all (Default)
                                                            </option>
                                                            <option value="do_not_display"> Do not Display</option>
                                                            <option value="show_only_on"> Display only on</option>
                                                            <option value="do_not_show_on"> Display on all Except
                                                            </option>
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
                                                                <a class="nav-link active" id="home-tab-fill"
                                                                   data-toggle="tab" href="#home-fill" role="tab"
                                                                   aria-controls="home-fill" aria-selected="true">Display
                                                                    only on</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="profile-tab-fill"
                                                                   data-toggle="tab" href="#profile-fill" role="tab"
                                                                   aria-controls="profile-fill" aria-selected="false">Display
                                                                    on all EXCEPT</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content pt-1">
                                                            <div class="tab-pane active" id="home-fill" role="tabpanel"
                                                                 aria-labelledby="home-tab-fill">
                                                                <select id="display_only_on"
                                                                        class="select2 form-control"
                                                                        name="display_only_on[]" multiple="multiple">
                                                                    @foreach($feed_sites as $feed_site)
                                                                        <option value="{{ $feed_site->id }}">{{ $feed_site->feed_site_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="tab-pane" id="profile-fill" role="tabpanel"
                                                                 aria-labelledby="profile-tab-fill">
                                                                <select id="display_on_all_except"
                                                                        class="select2 form-control"
                                                                        name="display_on_all_except[]"
                                                                        multiple="multiple">
                                                                    @foreach($feed_sites as $feed_site)
                                                                        <option value="{{ $feed_site->id }}">{{ $feed_site->feed_site_name }}</option>
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
                                <div class="row">
                                    <div class="col-12">
                                        <div class="float-right mb-1">
                                            <button type="reset" class="btn btn-large btn-outline-warning mr-1 mb-1">
                                                Reset
                                            </button>
                                            <button type="submit" class="btn btn-large btn-primary mr-1 mb-1">Submit
                                            </button>
                                        </div>
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
      $(document).ready(function () {
        function setCountryName() {
          $("#country_name").val($("#country_id").find(':selected').data('cn'));
        }

        function setFeedCategoryName() {
          $("#feed_category_name").val($("#feed_category_id").find(':selected').data('fcn'));
        }

        function loadFeedSubcategories() {
          $("#feed-subcategory").hide();
          $("#feed-subcategory-loader").show();
          var country_id = $("#country_id").val();
          var feed_category_id = $("#feed_category_id").val();
          $.ajax({
            url: "/admin/feed_subcategories/find_subcategories",
            type: "get", //send it through get method
            dataType: "json",
            data: {
              country_id: country_id,
              feed_category_id: feed_category_id
            },
            success: function (response) {
              if (response.length > 0) {
                var selOpts;

                $.each(response, function (k, v) {
                  var id = v.id;
                  var val = v.feed_subcategory_name;

                  selOpts += "<option value='" + id + "'>" + val + "</option>";
                });

                $('#feed-subcategory').append(selOpts);
              }

              //Do Something
              $("#feed-subcategory").show();
              $("#feed-subcategory-loader").hide();
            },
            error: function (xhr) {
              //Do Something to handle error
              $("#feed-subcategory").show();
              $("#feed-subcategory-loader").hide();
            }
          });
        }

        $.when().then(setCountryName()).then(setFeedCategoryName()).then(loadFeedSubcategories());

        $("#country_id").change(function () {
          setCountryName()
        });

        $("#feed_category_id").change(function () {
          setFeedCategoryName()
        });

        $(".find-subcategories").change(function () {
          loadFeedSubcategories()
        });

        var imagesPreview = function (input, placeToInsertImagePreview) {
          if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
              var reader = new FileReader();

              reader.onload = function (event) {
                $($.parseHTML('<img class="img-responsive">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
              }

              reader.readAsDataURL(input.files[i]);
            }
          }

        };

        $('#campaign_logo').on('change', function () {
          $(".campaign_logo_preview").empty();
          imagesPreview(this, 'div.campaign_logo_preview');
        });

        $('#campaign_banner_small').on('change', function () {
          $(".campaign_banner_small_preview").empty();
          imagesPreview(this, 'div.campaign_banner_small_preview');
        });
        $('#campaign_banner_medium').on('change', function () {
          $(".campaign_banner_medium_preview").empty();
          imagesPreview(this, 'div.campaign_banner_medium_preview');
        });
        $('#campaign_banner_large').on('change', function () {
          $(".campaign_banner_large_preview").empty();
          imagesPreview(this, 'div.campaign_banner_large_preview');
        });
      });
    </script>
@endsection
