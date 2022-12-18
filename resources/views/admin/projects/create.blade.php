@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.projects'))}}
@endsection
@section('css')

@endsection

@section('content')
<!--begin::Container-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
      <!--begin::Subheader-->
      <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::project-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <h3>{{__('cp.edit_project')}}</h3>
                </div>
            </div>
            <!--end::project-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <a href="{{url(getLocal().'/admin/projects')}}" class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
                <button id="submitButton" class="btn btn-success ">{{__('cp.save')}}</button>
            </div>
            <!--end::Toolbar-->
        </div>
    </div>
    {{-- </div> --}}
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <form method="post" action="{{url(app()->getLocale().'/admin/projects')}}"
                      enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                    {{ csrf_field() }}

                    <div class="card-header">
                        <h3 class="card-title">{{__('cp.main_project')}}</h3>
                    </div>


                    <div class="row col-sm-12">
                        <div class="card-body">
                     
                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.name_'.$locale->lang)}}</label>
                                            <input required 
                                            {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} type="text" class="form-control" id="name" name="name_{{$locale->lang}}"
                                         
                                                placeholder="Enter full name" />
                                            <span class="form-text text-muted">{{__('cms.please_enter')}} {{__('cms.name')}}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                    

                          
                           
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">Duration (MONTHES):</label>
                                <div class="col-9">
                                    <input type="number" class="form-control" id="duration" name="duration" placeholder="Enter Duration" />
                                    <span class="form-text text-muted">Please enter Duration</span>
                                </div>
                            </div>
                        
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">Technologies :</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" name="technologies" id="technologies" placeholder="Enter used technologies" />
                                    <span class="form-text text-muted">Please enter used technologies LIKE: ( HTML, JAVASCRIPT)</span>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">Website Url :</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" name="url_website" id="url_website" placeholder="Enter Github Url" />
                                    <span class="form-text text-muted">Please enter Github Url</span>
                                </div>
                            </div>
                       

                            <div id="image_div" class="form-group row">
                                <label class="col-3 col-form-label">Image:</label>
                                <div class="col-3">
                                    <div class="image-input image-input-empty image-input-outline" id="image" name="image"
                                        style="background-image: url({{asset('assets/media/users/blank.png')}})">
                                        <div class="image-input-wrapper"></div>
        
                                        <label
                                            class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                            data-action="change" data-toggle="tooltip" title=""
                                            data-original-title="Change avatar">
                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                            <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="image" />
                                        </label>
        
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                            data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
        
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                            data-action="remove" data-toggle="tooltip" title="Remove avatar">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="card-header">
                                <h3 class="card-title">{{__('cp.image')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="fileinput-new thumbnail"
                                             onclick="document.getElementById('edit_image').click()"
                                             style="cursor:pointer">
                                            <img src="{{choose()}}" id="editImage" alt="">
                                        </div>
                                        <div class="btn red"
                                             onclick="document.getElementById('edit_image').click()">
                                            <i class="fa fa-pencil"></i>
                                        </div>
                                        <input type="file" class="form-control" name="image"
                                               id="edit_image"
                                               style="display:none">
                                    </div> --}}
                                {{-- </div> --}}
                            {{-- </div> --}}


                


             

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
<script src="{{asset('assets/js/pages/crud/forms/widgets/bootstrap-select.js')}}"></script> 
 <script src="{{asset('assets/js/pages/crud/file-upload/image-input.js')}}"></script>
<script>

var image = new KTImageInput('image');
    


    
</script>

@endsection