@extends('layouts/contentLayoutMaster')
@section('title', 'Feed Subcategories')
@section('content')
<!-- Basic Horizontal form layout section start -->
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">

                        <form action="{{ route('admin.feed_subcategories.store') }}" method="post">
                        @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>Country</span>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control" id="country_id" name="country_id">
                                                    <option> Select Country </option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}" data-cc="{{ $country->country_code }}">{{ $country->country_code }} - {{ $country->country_name }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" id="cc" name="cc">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>Feed Category</span>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control" id="feed_category_id" name="feed_category_id">
                                                    <option> Select Feed Category </option>
                                                    @foreach($feed_categories as $feed_category)
                                                        <option value="{{ $feed_category->id }}">{{ $feed_category->feed_category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>Feed Subcategory Name</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="country-code pb-1 text-bold-600"><span id="cc-preview"> </span> - </div>
                                                <div class="position-relative ">
                                                    <input type="text" id="feed_subcategory_name" class="form-control" name="feed_subcategory_name" placeholder="Enter Feed Category Name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>Feed Subcategory Sort By</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative ">
                                                    <select class="form-control" id="sort_by" name="sort_by">
                                                        <option value="epc"> EPC </option>
                                                        <option value="rating"> Rating </option>
                                                        <option value="alphabetical"> Alphabetical </option>
                                                        <option value="created"> Campaign Created </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>Feed Subcategory Sort Direction</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative">
                                                    <select class="form-control" id="sort_order" name="sort_order">
                                                        <option value="asc"> Ascending </option>
                                                        <option value="desc"> Descending </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="float-right">
                                            
                                            <button type="reset" class="btn btn-large btn-outline-warning mr-1 mb-1">Reset</button>
                                            <button type="submit" class="btn btn-large btn-primary mr-1 mb-1">Submit</button>
                                        </div>
                                    </div>
   
                            
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('page-script')
        <!-- Page js files -->

        <script>
            $(document).ready(function(){
                $("#country_id").change(function(){
                    
                    var country_code = $(this).find(':selected').data('cc');
             
                    $("#cc").val(country_code);
                    $("#cc-preview").html(country_code);
                });

            });
        </script>

@endsection