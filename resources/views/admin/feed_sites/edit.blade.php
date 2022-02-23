@extends('layouts/contentLayoutMaster')
@section('title', 'Feed Site')
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

                        <form action="{{ route('admin.feed_sites.update', $feed_site->id) }}" method="post" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>Feed Site Name</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative ">
                                                <input type="text" id="feed_site_name" value="{{ $feed_site->feed_site_name }}" class="form-control" name="feed_site_name" placeholder="Enter Feed Site Name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>Feed Site Domain</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative ">
                                                <input type="text" id="feed_site_domain" value="{{ $feed_site->feed_site_domain }}" class="form-control" name="feed_site_domain" placeholder="Enter Feed Site Domain">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>Feed Site Status</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative ">
                                                    <select name="feed_site_status"  class="form-control">
                                                    <option {{ ($feed_site->get('feed_site_status') == "active")?"selected":"" }} value="active"> Active </option>
                                                    <option {{ ($feed_site->get('feed_site_status') == "inactive")?"selected":"" }} value="inactive"> Inactive </option>
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