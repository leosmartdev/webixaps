@extends('layouts/contentLayoutMaster')
@section('title', 'Countries')
@section('content')
<!-- Basic Horizontal form layout section start -->
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">

                        <form action="{{ route('admin.countries.store') }}" method="post">
                        @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>Country Name</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative ">
                                                    <input type="text" id="country_name" class="form-control" name="country_name" placeholder="Enter Country Name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <span>Country Code</span>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="position-relative ">
                                                    <input type="text" id="country_code" pattern="[A-Z]*" class="form-control" name="country_code" maxLength="3" minLength="2" placeholder="Enter Country Code">
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