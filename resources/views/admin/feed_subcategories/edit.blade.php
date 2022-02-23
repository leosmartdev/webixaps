@extends('layouts/contentLayoutMaster')
@section('title', 'Feed Subcategories')
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
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">

                        <form action="{{ route('admin.feed_subcategories.update', $feed_subcategory->id) }}" method="post" enctype="multipart/form-data">
                        @method('PATCH')
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
                                                        <option  {{ ($feed_subcategory->country_id == $country->id) ? 'selected' : '' }} value="{{ $country->id }}" data-cc="{{ $country->country_code }}">{{ $country->country_code }} - {{ $country->country_name }}</option>
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
                                                        <option {{ ($feed_category->id == $feed_subcategory->feed_category_id) ? 'selected' : '' }} value="{{ $feed_category->id }}">{{ $feed_category->feed_category_name }}</option>
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
                                                <div class="position-relative ">
                                                <input type="text" id="feed_subcategory_name" value="{{ $feed_subcategory->feed_subcategory_name }}" class="form-control" name="feed_subcategory_name" placeholder="Enter Feed Category Name">
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
                                                        <option {{ ($feed_subcategory->sort_by == "epc") ? 'selected' : '' }}  value="epc"> EPC </option>
                                                        <option {{ ($feed_subcategory->sort_by == "rating") ? 'selected' : '' }} value="rating"> Rating </option>
                                                        <option {{ ($feed_subcategory->sort_by == "alphabetical") ? 'selected' : '' }} value="alphabetical"> Alphabetical </option>
                                                        <option {{ ($feed_subcategory->sort_by == "created") ? 'selected' : '' }} value="created"> Campaign Created </option>
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
                                                        <option {{ ($feed_subcategory->sort_order == "asc") ? 'selected' : '' }} value="asc"> Ascending </option>
                                                        <option {{ ($feed_subcategory->sort_order == "desc") ? 'selected' : '' }} value="desc"> Descending </option>
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


            });
        </script>

@endsection