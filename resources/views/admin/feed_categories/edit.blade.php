@extends('layouts/contentLayoutMaster')
@section('title', 'Feed Categories')
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

                        <form action="{{ route('admin.feed_categories.update', $feed_category->id) }}" method="post" enctype="multipart/form-data">
                        @method('PATCH')
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
                                                <input type="text" id="feed_category_name" value="{{ $feed_category->feed_category_name }}" class="form-control" name="feed_category_name" placeholder="Enter Feed Category Name">
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
        <div class="col-md-12 col-12">
            <div class="card">
              <div class="card-header">
                  <h4 class="card-title">{{ $feed_category->feed_category_name }} Extra Fields </h4>
                  <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#large"> Add Extra Field </a>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <div class="table-responsive">
                          <table class="table mb-0 table-striped">
                              <thead class="thead-dark">
                                <tr>
                                  <th scope="col">Field Label</th>
                                  <th scope="col">Field Name</th>
                                  <th scope="col">Field Type</th>
                                  <th scope="col">Required</th>
                                  <th scope="col">Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                              @if(!$fcf->isEmpty())
                              @foreach($fcf as $fc)
                              <tr>
                                <td> {{ $fc->label }} </td>
                                <td> {{ $fc->name }} </td>
                                <td> {{ $fc->type }} </td>
                                <td> {{ $fc->required }} </td>
                                <td>
                                  <a href="{{ route('admin.feed_category_extra_fields.edit',$fc->id)}}" class="btn mr-1 btn-primary btn-sm waves-effect waves-light">Edit</a>
                                  <form class="d-inline" action="{{ route('admin.feed_category_extra_fields.destroy', $fc->id)}}" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <button class="btn mr-1 btn-danger btn-sm waves-effect waves-light" type="submit">Delete</button>
                                  </form>
                                </td>
                              </tr>
                              @endforeach
                            @else
                                <em> - </em>
                            @endif
                            </tbody>

                          </table>
                      </div>
                  </div>
              </div>
                {{-- Modal --}}
                <div class="modal fade text-left" id="large" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel17" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel17">Add Feed Category Extra Fields</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-content">
            
                                  <div class="card-body">
                                    <form action="{{ route('admin.feed_category_extra_fields.store') }}" method="post"  enctype="multipart/form-data">
                                      @csrf
                                    <input type="hidden" name="feed_category_id" value="{{ $feed_category->id }}">
                                      <div class="form-body">
                                        <div class="row">
                                          <div class="col-12">
                                            <div class="form-group row">
                                              <div class="col-md-4">
                                                <span><strong>Field Label: </strong></span>
                                              </div>
                                              <div class="col-md-8">
                                                <div class="position-relative">
                                                  <input type="text" id="feed_category_field_label" class="form-control" name="feed_category_field_label" placeholder="Field Label">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group row">
                                              <div class="col-md-4">
                                                <span><strong>Field Name: </strong></span>
                                              </div>
                                              <div class="col-md-8">
                                                <div class="position-relative">
                                                  <input type="text" readonly id="feed_category_field_name" class="form-control" name="feed_category_field_name" placeholder="Field Name">
                                                  <small  class="text-muted"> NOTE: no spaces, no numbers, replace space by underscore </small>
                                                </div>
                                              </div>
                                            </div>
                        
                                            <div class="form-group row">
                                              <div class="col-md-4">
                                                <span><strong>Field Label Help: </strong></span>
                                              </div>
                                              <div class="col-md-8">
                                                <div class="position-relative">
                                                  <input type="text" id="feed_category_field_label_help" class="form-control" name="feed_category_field_label_help" placeholder="Field Label Help">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="form-group row">
                                              <div class="col-md-4">
                                                <span><strong>Field Type: </strong></span>
                                              </div>
                                              <div class="col-md-8">
                                                <div class="position-relative">
                                                  <select class="form-control select-with-show" id="feed_category_field_type" name="feed_category_field_type">
                                                    <option value="TextField:Normal"> Text Field </option>
                                                    <option value="TextField:Number"> Text Field (Type: Number) </option>
                                                    <option value="TextField:Email"> Text Field (Type: Email) </option>
                                                    <option value="TextField:URL"> Text Field (Type: URL) </option>
                                                    <option value="TextField:Date"> Text Field (Type: Datepicker) </option>
                                                    <option value="Options:Select" data-show="Options">Select Option</option>
                                                    <option value="Options:Radio" data-show="Options">Radio Option</option>
                                                    <option value="Options:Checkbox" data-show="Options">Checkbox Option</option>
                                                    <option value="Textarea">Text Area</option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                        
                                            <div id="Options">
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <span><strong>Field Options: </strong></span>
                                                      </div>
                                                      <div class="col-md-8">
                                                          <textarea class="form-control" name="feed_category_field_options" rows="5" id="optionvalues"></textarea>
                                                          <p><small class="text-muted">Note: value|Label</small></p>
                                                      </div>
                                                </diV>
                                            </div>
                                            <div class="form-group row">
                                              <div class="col-md-4">
                                                <span><strong>Is Field Required?: </strong></span>
                                              </div>
                                              <div class="col-md-8">
                                                <div class="form-label-group">
                                                  <div class="custom-control custom-switch custom-control-inline">
                                                    <input type="hidden" value="off" name="feed_category_field_required" />
                                                    <input type="checkbox" class="custom-control-input" value="on" id="feed_category_field_required" name="feed_category_field_required" />
                                                    <label class="custom-control-label" for="feed_category_field_required">
                                                    </label>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                            <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
    </div>
</section>
@endsection
@section('page-script')
        <!-- Page js files -->

        <script type="text/javascript">
            $(document).ready(function(){
        
                var slug = function(str) {
                        var $slug = '';
                        var trimmed = $.trim(str);
                        $slug = trimmed.replace(/[^a-z0-9-]/gi, '_').
                        replace(/-+/g, '-').
                        replace(/^-|-$/g, '');
                        return $slug.toLowerCase();
                    }
        
                $("#feed_category_field_label").change(function(){
                    $('#feed_category_field_name').val(slug($(this).val()));
                });
  
        
            });
        </script>

@endsection