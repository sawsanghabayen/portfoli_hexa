@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.skills'))}}
@endsection
@section('css')

@endsection

@section('content')
<!--begin::Container-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <h3>{{__('cp.add_skill')}}</h3>
                </div>
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <a href="{{url(getLocal().'/admin/skills')}}" class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
                <button id="submitButton" class="btn btn-success ">{{__('cp.save')}}</button>
            </div>
            <!--end::Toolbar-->
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <form method="post" action="{{url(app()->getLocale().'/admin/skills')}}"
                      enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                    {{ csrf_field() }}

                    <div class="card-header">
                        <h3 class="card-title">{{__('cp.main_info')}}</h3>
                    </div>


                    <div class="row col-sm-12">
                        <div class="card-body">
                            
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.title')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" placeholder="{{__('cp.enter_title')}}" name="title" 
                                        placeholder="Enter title" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.title')}}</span>
                                </div>
                            </div>

                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.degree')}} %:</label>
                                <div class="col-9">
                                    <input type="number" class="form-control" name="degree" 
                                        placeholder="{{__('cp.enter_degree')}}" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.degree')}} %</span>
                                </div>
                            </div>
                          
                        
                        
                        
                    </div>

                    <button type="submit" id="submitForm" style="display:none"></button>
                </form>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>

<!--end::Container-->
@endsection

@section('js')
{{-- <script src="{{asset('controlPanel/assets/js/pages/crud/forms/widgets/bootstrap-select.js')}}"></script> --}}
{{-- <script src="{{asset('controlPanel/assets/js/pages/crud/file-upload/image-input.js')}}"></script> --}}
<script>

    
</script>

@endsection