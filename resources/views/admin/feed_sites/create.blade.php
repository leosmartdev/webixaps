@extends('layouts/contentLayoutMaster')
@section('title', 'Feed Sites')
@section('content')
<!-- Basic Horizontal form layout section start -->
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">

                        <form action="{{ route('admin.feed_sites.store') }}" method="post">
                        @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Feed Site Name</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative ">
                                                    <input type="text" id="feed_site_name" class="form-control" name="feed_site_name" placeholder="Enter Feed Site Name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Feed Site Domain</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative ">
                                                    <input type="text" id="feed_site_domain" class="form-control" name="feed_site_domain" placeholder="Enter Feed Site Domain">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span class="text-bold-600">Feed Site Status</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative ">
                                                    <select name="feed_site_status"  class="form-control">
                                                       <option value="active"> Active </option>
                                                       <option value="inactive"> Inactive </option>
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