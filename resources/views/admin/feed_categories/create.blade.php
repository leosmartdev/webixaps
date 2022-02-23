@extends('layouts/contentLayoutMaster')
@section('title', 'Feed Categories')
@section('content')
<!-- Basic Horizontal form layout section start -->
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">

                        <form action="{{ route('admin.feed_categories.store') }}" method="post">
                        @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>Feed Category Name</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative ">
                                                    <input type="text" id="feed_category_name" class="form-control" name="feed_category_name" placeholder="Enter Feed Category Name">
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