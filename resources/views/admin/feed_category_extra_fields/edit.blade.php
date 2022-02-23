@extends('layouts/contentLayoutMaster')
@section('title', 'Feed Categories Extra Field')
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

    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{ route('admin.feed_category_extra_fields.update', $feed_category_extra_field->id) }}"
                                  method="post"
                                  enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <span>Field Label</span>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="position-relative ">
                                                        <input type="text" id="feed_category_field_label"
                                                               value="{{ $feed_category_extra_field->feed_category_field_label }}"
                                                               class="form-control" name="feed_category_field_label"
                                                               placeholder="Field Label">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <span>Field Type</span>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="position-relative">
                                                        <select class="form-control select-with-show" id="feed_category_field_type" name="feed_category_field_type">
                                                            <option {{ ($feed_category_extra_field->feed_category_field_type == "TextField:Normal")?"selected":"" }} value="TextField:Normal"> Text Field </option>
                                                            <option {{ ($feed_category_extra_field->feed_category_field_type == "TextField:Number")?"selected":"" }} value="TextField:Number"> Text Field (Type: Number) </option>
                                                            <option {{ ($feed_category_extra_field->feed_category_field_type == "TextField:Email")?"selected":"" }} value="TextField:Email"> Text Field (Type: Email) </option>
                                                            <option {{ ($feed_category_extra_field->feed_category_field_type == "TextField:URL")?"selected":"" }} value="TextField:URL"> Text Field (Type: URL) </option>
                                                            <option {{ ($feed_category_extra_field->feed_category_field_type == "TextField:Date")?"selected":"" }} value="TextField:Date"> Text Field (Type: Datepicker) </option>
                                                            <option {{ ($feed_category_extra_field->feed_category_field_type == "Options:Select")?"selected":"" }} value="Options:Select" data-show="Options">Select Option</option>
                                                            <option {{ ($feed_category_extra_field->feed_category_field_type == "Options:Radio")?"selected":"" }} value="Options:Radio" data-show="Options">Radio Option</option>
                                                            <option {{ ($feed_category_extra_field->feed_category_field_type == "Options:Checkbox")?"selected":"" }} value="Options:Checkbox" data-show="Options">Checkbox Option</option>
                                                            <option {{ ($feed_category_extra_field->feed_category_field_type == "Textarea")?"selected":"" }} value="Textarea">Text Area</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <span>Field Options</span>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="position-relative ">
                                                        <textarea class="form-control" name="feed_category_field_options" rows="5" id="optionvalues">{{$feed_category_extra_field->feed_category_field_options}}</textarea>
                                                        <p><small class="text-muted">Note: value|Label</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3">
                                                    <span>Is Field Required?</span>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="position-relative ">
                                                        <div class="custom-control custom-switch custom-control-inline">
                                                            <input type="hidden" value="off" name="feed_category_field_required" />
                                                            <input type="checkbox" {{ ($feed_category_extra_field->feed_category_field_required == "on") ? "checked": ""  }} class="custom-control-input" value="on" id="feed_category_field_required" name="feed_category_field_required" />
                                                            <label class="custom-control-label" for="feed_category_field_required">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="float-right">
                                                <button type="reset"
                                                        class="btn btn-large btn-outline-warning mr-1 mb-1">Reset
                                                </button>
                                                <button type="submit" class="btn btn-large btn-primary mr-1 mb-1">
                                                    Submit
                                                </button>
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
