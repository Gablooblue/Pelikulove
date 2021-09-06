@extends('layouts.app')

@section('template_title')
	Add New Video
@endsection

@section('head')
@endsection

@section('content')
<div class="container">
        <div class="row">
		<div class="col-lg-10 offset-lg-1">
                <div class="card">
                    <div class="card-header">
                        <div class="div-title" style="display: flex; justify-content: space-between; align-items: center;">
                            Add New Video
                            <div class="pull-right">
                                <a href="{{ url('blackbox-admin') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Blackbox Admin">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    <span class="hidden-sm hidden-xs">Back to </span>
                                    <span class="hidden-xs">Blackbox Admin</span>
                                </a>
                                <br>
                                <a href="{{ url('/blackbox-admin/category/' . $category->id) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Category">
                                    <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                                    <span class="hidden-sm hidden-xs">Back to </span>
                                    <span class="hidden-xs">Category</span>
                                </a>
                            </div>
                        </div>
                        <hr>
                    </div>

                    {!! Form::text('formType', 'blackbox-admin-new-cat', array('id' => 'formType', 'class' => 'form-control', 'hidden')) !!}
                    
                    {!! Form::open(array('route' => ['vodsmanagement.storeVod', $category->id], 'method' => 'POST', 'new-vod' => 'form', 'class' => 'needs-validation')) !!}
                    
                    {!! csrf_field() !!}

                    <div class="card-body div-payment-methods">		
                        <div class="form-group has-feedback row {{ $errors->has('title') ? ' has-error ' : '' }}">
                            {!! Form::label('title', 'Video Title:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::text('title', old('title'), array('id' => 'title', 'class' => 'form-control', 'placeholder' => 'Video Title', 'required')) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="title">
                                            
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>	

                        <div class="form-group has-feedback row {{ $errors->has('short_title') ? ' has-error ' : '' }}"
                            data-toggle="tooltip" data-html="true" title="Used in areas that are better for short texts (ie: Blackbox Video pop-up text)">
                            {!! Form::label('short_title', 'Video Short Title:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::text('short_title', old('short_title'), array('id' => 'short_title', 'class' => 'form-control', 'placeholder' => 'Video Short Title', 'required')) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="short_title">
                                            {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('short_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('short_title') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>
                                   
                        <div class="form-group has-feedback row {{ $errors->has('category_id') ? ' has-error ' : '' }}">
                            {!! Form::label('category_id', 'Category:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="custom-select form-control" name="category_id" id="category_id">
                                        @if ($vodCategories)
                                            @if (!isset($category))
                                                @php $category=$vodCategories[0] @endphp
                                            @endif
                                            @foreach($vodCategories as $vodCategory)
                                                <option value="{{ $vodCategory->id }}" 
                                                    @if ($category->id == $vodCategory->id)
                                                     selected 
                                                    @endif
                                                    >
                                                    {{ $vodCategory->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="category_id">
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('category_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                  

                        <div class="form-group has-feedback row {{ $errors->has('vorder') ? ' has-error ' : '' }}">
                            {!! Form::label('vorder', 'Video Order:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="custom-select form-control vorder" name="vorder" id="vorder">
                                    </select>
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="vorder">
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('vorder'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('vorder') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}"
                            data-toggle="tooltip" data-html="true" title="Used as the main description on the Video Watch Page <br><br>Using html such as br for break line, hr for horizontal line and a href for hyper links">
                            {!! Form::label('description', 'HTML Description:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::textarea('description', old('description'), array('id' => 'description', 'class' => 'form-control', 'placeholder' => 'This Video is about... <br> <hr> <a href="google.com">Click here for google</a>')) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="description">
                                            <i class="fa fa-fw fa-pencil" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>  

                        <div class="form-group has-feedback row {{ $errors->has('description_2') ? ' has-error ' : '' }}"
                            data-toggle="tooltip" data-html="true" title="Used in the Blackbox Video pop-up text (Max 250 chars) <br><br>Used for the description on social media links">
                            {!! Form::label('description_2', 'Text Description:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::textarea('description_2', old('description_2'), array('id' => 'description_2', 'class' => 'form-control', 'placeholder' => 'This Video is about...')) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="description_2">
                                            <i class="fa fa-fw fa-pencil" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('description_2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description_2') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>  

                        {{-- <div class="form-group has-feedback row {{ $errors->has('information') ? ' has-error ' : '' }}">
                            {!! Form::label('information', 'Information:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::textarea('information', old('information'), array('id' => 'information', 'class' => 'form-control', 'placeholder' => 'Casts, Directors, etc...', 'required')) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="information">
                                            <i class="fa fa-fw fa-pencil" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('information'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('information') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>   --}}

                        {{-- <div class="form-group has-feedback row {{ $errors->has('maturity_rating') ? ' has-error ' : '' }}">
                            {!! Form::label('maturity_rating', 'MTRCB Rating:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::text('maturity_rating', old('maturity_rating'), array('id' => 'maturity_rating', 'class' => 'form-control', 'placeholder' => 'ie: PG-13')) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="maturity_rating">
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('maturity_rating'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('maturity_rating') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>  --}}
                        
                        <div class="form-group has-feedback row {{ $errors->has('year_released') ? ' has-error ' : '' }}">
                            {!! Form::label('year_released', 'Year Released:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::input('number', 'year_released', old('year_released'), array('id' => 'year_released', 'class' => 'form-control', 'placeholder' => 'ie: 2020', 'min' => '1000', 'max' => '3000')) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="year_released">
                                            {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('year_released'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('year_released') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div> 
                        
                        <div class="form-group has-feedback row {{ $errors->has('duration') ? ' has-error ' : '' }}">
                            {!! Form::label('duration', 'Video Duration:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::input('number', 'duration', old('duration'), array('id' => 'duration', 'class' => 'form-control', 'placeholder' => '120 mins', 'min' => '1', 'max' => '999', 'required')) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="duration">
                                            {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('duration'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('duration') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div> 
                                   
                        <div class="form-group has-feedback row {{ $errors->has('hidden') ? ' has-error ' : '' }}"
                            data-toggle="tooltip" data-html="true" title="Hide video from showing on all catalogs">
                            {!! Form::label('hidden', 'Unlisted:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                {{-- <div class=""> --}}
                                    {{-- @php $checkHidden = 'checked'; if($vodCategory->hidden != 1) $checkHidden = '' @endphp --}}
                                    {!! Form::input('checkbox', 'hidden', old('hidden'), array('id' => 'hidden', 'class' => 'form-control', 'style' => 'width: 20px; height: 100%;')) !!} 
                                {{-- </div> --}}
                                @if ($errors->has('hidden'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hidden') }}</strong>
                                    </span>
                                @endif  
                            </div>
                        </div>  
                                   
                        <div class="form-group has-feedback row {{ $errors->has('private') ? ' has-error ' : '' }}"
                            data-toggle="tooltip" data-html="true" title="Restrict Video Access to Moderators and Admins Only">
                            {!! Form::label('private', 'Private:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                {{-- <div class=""> --}}
                                    {{-- @php $checkPrivate = 'checked'; if($vodCategory->private != 1) $checkPrivate = '' @endphp --}}
                                    {!! Form::input('checkbox', 'private', old('private'), array('id' => 'private', 'class' => 'form-control', 'style' => 'width: 20px; height: 100%;')) !!} 
                                {{-- </div> --}}
                                @if ($errors->has('private'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('private') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div> 
                                   
                        <div class="form-group has-feedback row {{ $errors->has('donate_btn') ? ' has-error ' : '' }}"
                            data-toggle="tooltip" data-html="true" title="Adds the Donation Snippet to the bottom of the description section">
                            {!! Form::label('donate_btn', 'Donation Button:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                {{-- <div class=""> --}}
                                    {{-- @php $checkDonate = 'checked'; if($vodCategory->donate_btn != 1) $checkDonate = '' @endphp --}}
                                    {!! Form::input('checkbox', 'donate_btn', old('donate_btn'), array('id' => 'donate_btn', 'class' => 'form-control', 'style' => 'width: 20px; height: 100%;')) !!} 
                                {{-- </div> --}}
                                @if ($errors->has('donate_btn'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('donate_btn') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>   

                        <div class="form-group has-feedback row {{ $errors->has('thumbnail') ? ' has-error ' : '' }}"
                            data-toggle="tooltip" data-html="true" title="Image Scale Ratio must be 16:9 <br><br>Supported Image formats: bmp gif ico cur jpg jpeg jfif pjpeg pjp png svg tif tiff webp <br><br>The default image is VOD-Placeholder-4.jpg">
                            {!! Form::label('thumbnail', 'Thumbnail File Name:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::text('thumbnail', 'VOD-Placeholder-4.jpg', array('id' => 'thumbnail', 'class' => 'form-control', 'placeholder' => 'image-thumbnail.jpg', 'required')); !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="thumbnail">
                                            {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('thumbnail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('thumbnail') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>     

                        <div class="form-group has-feedback row {{ $errors->has('video') ? ' has-error ' : '' }}"
                            data-toggle="tooltip" data-html="true" title="Leaving this empty will prevent the video from being displayed on the catalog <br>File name must not have special characters except for periods, dashes and underscores">
                            {!! Form::label('video', 'Video File Name:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::text('video', old('video'), array('id' => 'video', 'class' => 'form-control', 'placeholder' => 'sample-video.mp4')); !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="video">
                                            {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('video'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('video') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>    
                        
                        <div class="form-group has-feedback row {{ $errors->has('transcript') ? ' has-error ' : '' }}"
                            data-toggle="tooltip" data-html="true" title="Subtitle file must be on .vtt format <br>File name must not have special characters except for periods, dashes and underscores">
                            {!! Form::label('transcript', 'Subtitle File Name:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::text('transcript', old('transcript'), array('id' => 'transcript', 'class' => 'form-control', 'placeholder' => 'sample-transcript.vtt')); !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="transcript">
                                            {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('transcript'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('transcript') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>  
                                   
                        <div class="form-group has-feedback row {{ $errors->has('paid') ? ' has-error ' : '' }}">
                            {!! Form::label('paid', 'Availability:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="custom-select form-control" name="paid" id="paid">
                                        <option value=0>Free</option>
                                        <option value=1>Paid</option>
                                    </select>
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="paid">
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('paid'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('paid') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="paid-div card rounded m-2" style="display: none;"> 
                            <div class="card-body">       
                                
                                <h4 class="mb-0 pb-0">                                    
                                    Service Form
                                </h4>
                                <hr class="">
                            
                                <div class="form-group has-feedback row {{ $errors->has('s_name') ? ' has-error ' : '' }}">
                                    {!! Form::label('s_name', 'Service Name:', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                        {!! Form::text('s_name', old('s_name'), array('id' => 's_name', 'class' => 'form-control', 'placeholder' => 'Basic Package')); !!}
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="s_name">
                                                    {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('s_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('s_name') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div>                          
                            
                                <div class="form-group has-feedback row {{ $errors->has('s_description') ? ' has-error ' : '' }}">
                                    {!! Form::label('s_description', 'Service Description:', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                        {!! Form::text('s_description', old('s_description'), array('id' => 's_description', 'class' => 'form-control', 'placeholder' => 'Gives you access to the Boses Film for 3 days')); !!}
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="s_description">
                                                    {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('s_description'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('s_description') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div> 
                            
                                <div class="form-group has-feedback row {{ $errors->has('s_duration') ? ' has-error ' : '' }}"
                                    data-toggle="tooltip" data-html="true" title="Each increment is equal to a day (ie: 3 is 3 days)">
                                    {!! Form::label('s_duration', 'Service Duration:', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::input('number', 's_duration', old('s_duration'), array('id' => 's_duration', 'class' => 'form-control', 'placeholder' => '3', 'min' => '1', 'max' => '999')) !!}
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="s_duration">
                                                    {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('s_duration'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('s_duration') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div> 

                                <div class="form-group has-feedback row {{ $errors->has('amount') ? ' has-error ' : '' }}">
                                    {!! Form::label('amount', 'Amount:', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::input('number', 'amount', old('amount'), array('id' => 'amount', 'class' => 'form-control', 'placeholder' => '₱500', 'min' => '1', 'max' => '999999')) !!}
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="amount">
                                                    {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('amount'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div>  

                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="row justify-content-end">                                
                            {!! Form::button('Submit', array('class' => 'btn btn-success btn-submit margin-bottom-1 mt-1 mb-1 mr-3', 'type' => 'submit')) !!}  
                        </div>
                    </div>
                    
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    @include('scripts.tooltips')
    <script>            
        $(document).ready(function() {
            var vodCategoryID = $('#category_id').val();
            adjustOptions(vodCategoryID);
            
            $('.paid-div').css("display", "none");  

            $('#category_id').change(function(e) {
                adjustOptions(e.target.value);
            });

            $('#paid').change(function(e) {
                // console.log (e.target.value);
                var paid = e.target.value;
                if (paid == 1) {
                    $('.paid-div').css("display", "flex");
                    document.getElementById("amount").required = true;
                    document.getElementById("s_duration").required = true;
                    document.getElementById("s_name").required = true;
                } else {
                    $('.paid-div').css("display", "none");  
                    // document.getElementById("amount").value = "0";
                    document.getElementById("amount").required = false;
                    document.getElementById("s_duration").required = false;
                    document.getElementById("s_name").required = false;
                }

            });
        });

        function adjustOptions(vodCategoryID) {   
            var allVods = {!! $vods !!}   

            var vodOrderElement = document.getElementById('vorder');
            var vodOrderElementList = document.getElementById('vorder').getElementsByTagName("option");
            var vodOrderElementListLength = parseInt(vodOrderElementList.length)

            var categoryVods = allVods.filter(vod => vod.category_id == vodCategoryID);
            
            var index;
            for (index = 0; index < vodOrderElementListLength; index++) {    
                vodOrderElement.removeChild(vodOrderElement.childNodes[0]);
            }

            if (categoryVods.length == 0) {             
                var option = document.createElement("option");              
                option.value = 1;             
                var optionValue = document.createTextNode(1);        
                option.appendChild(optionValue); 
                vodOrderElement.appendChild(option);
            } else {
                for (index = 0; index < categoryVods.length; index++) {                
                    var option = document.createElement("option");                
                    option.value = categoryVods[index].vorder;
                    var optionValue = document.createTextNode(categoryVods[index].vorder);        
                    option.appendChild(optionValue); 
                    vodOrderElement.appendChild(option);
                }   

                var option = document.createElement("option");                
                option.value = categoryVods[categoryVods.length-1].vorder+1;
                var optionValue = document.createTextNode(categoryVods[categoryVods.length-1].vorder+1);        
                option.appendChild(optionValue); 
                vodOrderElement.appendChild(option);
            }
        }
    </script>
@endsection