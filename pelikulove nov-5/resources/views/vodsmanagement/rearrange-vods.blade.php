@extends('layouts.app')

@section('template_title')
    Rearrange Blackbox Categories
@endsection

@section('head')

@endsection

@section('content')
<div class="container">
    <div class="row">
		<div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-header">
                    @if(!empty($success))
                        <div class="alert alert-success alert-dismissible">
                            <h1>{{Session::get('success')}}</h1>
                        </div>
                    @endif
                    <div class="div-title" style="display: flex; justify-content: space-between; align-items: center;">
                        Rearrange {{ $category->short_title }} Videos
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

                {!! Form::text('formType', 'blackbox-admin-rearrange-cat', array('id' => 'formType', 'class' => 'form-control', 'hidden')) !!}
                
                {!! Form::open(array('route' => ['vodsmanagement.storeRearrangedCategoryVods', $category->id, $vod->id], 'method' => 'POST', 'rearrange-cat' => 'form', 'class' => 'needs-validation mb-4')) !!}

                {!! csrf_field() !!}

                <div class="card shadow bg-white rounded container col-10">
                    @for ($index = 0; $index < sizeOf($categoryVods); $index++)
                        <div class="row d-flex border">     
                            <div class="col-8 border-right">
                                <div class="card-body">
                                    <h3 class="mt-1">
                                        <strong>                              
                                            {{ $categoryVods[$index]->short_title }}
                                        </strong>
                                    </h3>
                                </div>                            
                            </div>    
                            <div class="col-4">
                                <div class="card-body">                                    
                                    <div class="form-group has-feedback row {{ $errors->has('vorder_' . $index) ? ' has-error ' : '' }}">
                                        <div class="input-group">
                                            {!! Form::input('number', 'vorder_' . $index, $categoryVods[$index]->vorder, array('id' => 'vorder_' . $index, 'class' => 'form-control vorder', 'min' => '1', 'max' => sizeOf($categoryVods), 'step' => '1', 'required')) !!}
                                            <div class="input-group-append">
                                            </div>
                                        </div>
                                        @if ($errors->has('vorder_' . $index))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('vorder_' . $index) }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div>                            
                            </div>  
                        </div>
                        <hr class="bg-warning">  

                    @endfor   
                    <!-- Submit button -->
                    <div class="row justify-content-between border-top">                                
                        {!! Form::button('Submit', array('class' => 'btn btn-block btn-success btn-submit my-1 mx-2', 'type' => 'submit')) !!}  
                    </div>                          
                </div>       
            </div>
        </div>
            
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('footer_scripts')

<script>
    $(document).ready(function() {
        this.allVordersNew = $(".vorder");
        this.allVordersOld = this.allVordersNew.clone();

        var that = this;
        
        $(".vorder").change(function(e) {
            var element = e.target;
            var elementSplit = element.id.split("_");
            var id = elementSplit[1];

            var val = element.value;
            var maxVal = {!! sizeOf($categoryVods) !!};

            if (val > maxVal) {
                element.value = maxVal;
            }

            var targetName = element.id;
            var dupeElement;

            var index;
            for (index = 0; index < maxVal; index++) {
                var oldElement = that.allVordersOld[index];              
                            
                if (val == that.allVordersNew[index].value && that.allVordersNew[index].id != targetName) {              
                    dupeElement = that.allVordersNew[index];
                }
            }

            var index2;
            for (index2 = 0; index2 < maxVal; index2++) {
                if (targetName == that.allVordersOld[index2].id) {  
                    that.allVordersOld[index2].id + " with value " + that.allVordersOld[index2].value;   
                    dupeElement.value = that.allVordersOld[index2].value;
                }
            }

            that.allVordersOld = that.allVordersNew.clone();
        });
    });
</script>
   
@endsection