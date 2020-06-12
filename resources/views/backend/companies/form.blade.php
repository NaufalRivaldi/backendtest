@extends('backend/layout')
@section('content')
<section class="content-header">
    <h1>Company</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{ $company->page_title }}</li>
    </ol>
</section>
<!-- Main content -->
<section id="main-content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ $company->page_title }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <form action="{{ ($company->page_type == 'create')?route('company.store'):route('company.update') }}" method="POST" id="company-form" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @if($company->page_type == 'edit')
                            <input type="hidden" name="id" value="{{ $company->data->id }}">
                        @endif
                        <div id="form-name" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Name</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                <input type="text" name="name" class="form-control validate[required, maxSize[100], custom[onlyLetterSp]]" data-prompt-position="bottomLeft:0,11" value="{{ ($company->page_type == 'create')?old('name'):$company->data->name }}">
                            </div>
                        </div>

                        <div id="form-email" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Email</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                <input type="email" name="email" class="form-control validate[required, custom[email], maxSize[100]]" data-prompt-position="bottomLeft:0,11" value="{{ ($company->page_type == 'create')?old('email'):$company->data->email }}">
                            </div>
                        </div>

                        <div id="form-postcode" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Postcode</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-content">
                                <input type="text" name="postcode" class="form-control postcode validate[required, maxSize[7], custom[number]]" data-prompt-position="bottomLeft:0,11" value="{{ ($company->page_type == 'create')?old('postcode'):$company->data->postcode }}">
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <button type="button" class="btn btn-primary searchPostCode">Search</button>
                            </div>
                        </div>

                        <div id="form-prefecture" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Prefecture</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                <select name="prefecture_id" id="prefecture" class="form-control prefecture validate[required]" data-prompt-position="bottomLeft:0,11">
                                    <option value="">== Select ==</option>
                                    @foreach($prefecture as $row)
                                    <option value="{{ $row->id }}" {{ ($company->page_type == 'create')?'':($company->data->prefecture_id == $row->id)?'selected':'' }}>{{ $row->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="form-city" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">City</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                <input type="text" name="city" class="form-control city validate[required, maxSize[100]]" data-prompt-position="bottomLeft:0,11" value="{{ ($company->page_type == 'create')?old('city'):$company->data->city }}">
                            </div>
                        </div>

                        <div id="form-local" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Local</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                <input type="text" name="local" class="form-control local validate[required, maxSize[100]]" data-prompt-position="bottomLeft:0,11" value="{{ ($company->page_type == 'create')?old('local'):$company->data->local }}">
                            </div>
                        </div>

                        <div id="form-street-address" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Street Address</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                <textarea name="street_address" id="street_address" class="form-control street_address">{{ ($company->page_type == 'create')?old('street_address'):$company->data->street_address }}</textarea>
                            </div>
                        </div>

                        <div id="form-business-hour" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Business Hour</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                <input type="text" name="business_hour" class="form-control business_hour validate[maxSize[45]]" data-prompt-position="bottomLeft:0,11" value="{{ ($company->page_type == 'create')?old('business_hour'):$company->data->business_hour }}">
                            </div>
                        </div>

                        <div id="form-regular-holiday" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Regular Holiday</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                <input type="number" name="regular_holiday" class="form-control regular_holiday validate[custom[number], maxSize[45]]" data-prompt-position="bottomLeft:0,11" value="{{ ($company->page_type == 'create')?old('regular_holiday'):$company->data->regular_holiday }}">
                            </div>
                        </div>

                        <div id="form-phone" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Phone</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                <input type="text" name="phone" class="form-control phone validate[custom[phone], maxSize[15]]" data-prompt-position="bottomLeft:0,11" value="{{ ($company->page_type == 'create')?old('phone'):$company->data->phone }}">
                            </div>
                        </div>

                        <div id="form-fax" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Fax</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                <input type="text" name="fax" class="form-control fax validate[custom[phone], maxSize[15]]" data-prompt-position="bottomLeft:0,11" value="{{ ($company->page_type == 'create')?old('fax'):$company->data->fax }}">
                            </div>
                        </div>

                        <div id="form-url" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">Url</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                <input type="text" name="url" class="form-control url validate[custom[url], maxSize[100]]" data-prompt-position="bottomLeft:0,11" value="{{ ($company->page_type == 'create')?old('url'):$company->data->url }}">
                            </div>
                        </div>

                        <div id="form-license-number" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <strong class="field-title">License Number</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                <input type="text" name="license_number" class="form-control license_number validate[custom[onlyLetterNumber], maxSize[100]]" data-prompt-position="bottomLeft:0,11" value="{{ ($company->page_type == 'create')?old('license_number'):$company->data->license_number }}">
                            </div>
                        </div>

                        <div id="form-phone" class="form-group">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                                <span class="label label-danger label-required">Required</span>
                                <strong class="field-title">Image</strong>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                                @if($company->page_type == 'create')
                                    <input type="file" name="image" class="form-control validate[required]" data-prompt-position="bottomLeft:0,11"><br>
                                    <img src="{{ asset('img/no-image/no-image.jpg') }}" alt="no-image" width="20%">
                                @else
                                    <input type="file" name="image" class="form-control" data-prompt-position="bottomLeft:0,11">
                                    <small class="text-danger">Replace with new image if you want to change image.</small><br><br>
                                    <img src="{{ asset($company->data->image) }}" alt="no-image" width="20%">
                                    <input type="hidden" name="imageOld" value="{{ $company->data->image }}">
                                @endif
                            </div>
                        </div>

                        <div id="form-button" class="form-group no-border">
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="margin-top: 20px;">
                                <button type="submit" name="submit" id="send" class="btn btn-primary">{{ ($company->page_type == 'create')?'Submit':'Save' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection

@section('title', 'Company | ' . env('APP_NAME',''))

@section('body-class', 'custom-select')

@section('css-scripts')
@endsection

@section('js-scripts')
<script src="{{ asset('bower_components/bootstrap/js/tooltip.js') }}"></script>
<!-- validationEngine -->
<script src="{{ asset('js/3rdparty/validation-engine/jquery.validationEngine-en.js') }}"></script>
<script src="{{ asset('js/3rdparty/validation-engine/jquery.validationEngine.js') }}"></script>
<script src="{{ asset('js/backend/companies/form.js') }}"></script>

<script>
    $(document).ready(function(){
        // autofill
        $('.searchPostCode').on('click', function(){
            let postcode = $('.postcode').val();
            
            $.ajax({
                url: "{{ route('company.postcode') }}",
                type: "GET",
                dataType: 'JSON',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'postcode': postcode
                },
                success: function(result){
                    // setvalue
                    $('.prefecture').val(result.prefectureId);
                    $('.city').val(result.data.city);
                    $('.local').val(result.data.local);
                }
            });
        });
    });
</script>
@endsection
