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

                            <div class="form-group row">
                                <label class="col-3 col-form-label">Category:</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <div class="dropdown bootstrap-select form-control dropup">
                                        <select class="form-control selectpicker" data-size="7"  id="category_id" name="category_id"
                                            title="Choose one of the following..." tabindex="null" data-live-search="true">
                                            {{-- <option  value="-1">Select Category</option> --}}
                                            {{-- @foreach ($categories as $category) --}}
                                            <option value="1"> 
                                                 @if (getLocal() =='en')
                                                 IMAGE FORMATE 
                                                @elseif (getLocal() =='ar')
                                                فئة الصورة 
                                                @endif
                                            </option>
                                            <option value="2">
                                                 @if (getLocal() =='en')
                                                VIDEO FORMATE 
                                               @elseif (getLocal() =='ar')
                                               فئة الفيديو 
                                               @endif
                                            </option>
                                            <option value="3">
                                                @if (getLocal() =='en')
                                                SLIDER FORMATE 
                                               @elseif (getLocal() =='ar')
                                               فئة السلايدر 
                                               @endif
                                            </option>
                                            <option value="4">
                                                @if (getLocal() =='en')
                                                YOUTUBE FORMATE 
                                               @elseif (getLocal() =='ar')
                                               فئة اليوتيوب 
                                               @endif
                                            </option>
                                            {{-- @endforeach --}}
                                        </select>
                                    </div>
                                    <span class="form-text text-muted"> {{__('cp.please')}}  {{__('cp.select_cataegory')}}</span>
                                </div>
                            </div>
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
                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.client_'.$locale->lang)}}</label>
                                            <input required 
                                            {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} type="text" class="form-control" id="client" name="client_{{$locale->lang}}"
                                      
                                                placeholder="Enter full client" />
                                            <span class="form-text text-muted">{{__('cms.please_enter')}} {{__('cms.client')}}</span>
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
                                <label class="col-3 col-form-label">Budget (USD):</label>
                                <div class="col-9">
                                    <input type="number" class="form-control" name="budget" id="budget" placeholder="Enter Budget" />
                                    <span class="form-text text-muted">Please enter Budget</span>
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
                                <label class="col-3 col-form-label">Github Url :</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" name="url_website" id="url_website" placeholder="Enter Github Url" />
                                    <span class="form-text text-muted">Please enter Github Url</span>
                                </div>
                            </div>
                            <div id="youtube_url_div" class="form-group row mt-4">
                                <label class="col-3 col-form-label">Youtube Url :</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="url_youtube" name="url_youtube" placeholder="Enter Youtube Url" />
                                    <span class="form-text text-muted">Please enter Youtube Url</span>
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


                            
                    <div id="slider_div" class="form-group row">
                        <label class="col-3 col-form-label">Images:</label>
                        <div class="col-3">
                            <div class="image-input image-input-empty image-input-outline" id="project_image_1" name="project_image_1"
                                style="background-image: url({{asset('assets/media/users/blank.png')}})">
                                <div class="image-input-wrapper"></div>

                                <label
                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                    data-action="change" data-toggle="tooltip" title=""
                                    data-original-title="Change avatar">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" name="project_image_1" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="project_image_1" />
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
                        <div class="col-3">
                            <div class="image-input image-input-empty image-input-outline" id="project_image_2" name="project_image_2"
                                style="background-image: url({{asset('assets/media/users/blank.png')}})">
                                <div class="image-input-wrapper"></div>

                                <label
                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                    data-action="change" data-toggle="tooltip" title=""
                                    data-original-title="Change avatar">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" name="project_image_2" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="project_image_2" />
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
                        <div class="col-3">
                            <div class="image-input image-input-empty image-input-outline" name="project_image_3" id="project_image_3"
                                style="background-image: url({{asset('assets/media/users/blank.png')}})">
                                <div class="image-input-wrapper"></div>

                                <label
                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                    data-action="change" data-toggle="tooltip" title=""
                                    data-original-title="Change avatar">
                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                    <input type="file" name="project_image_3" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="project_image_3" />
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

                    <div id ="video_div" class="form-group row">
                        <label class="col-3 col-form-label">Video:</label>

                        <input id= "video" name="video" type="file" class="form-control"><br/>
                        <div class="progress">
                            <div class="bar"></div >
                            <div class="percent">0%</div >
                        </div>
                        {{-- <br>
                        <input type="submit"  value="Submit" class="btn btn-primary"> --}}
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
<script src="{{asset('assets/js/pages/crud/forms/widgets/bootstrap-select.js')}}"></script> 
 <script src="{{asset('assets/js/pages/crud/file-upload/image-input.js')}}"></script>
<script>

var image = new KTImageInput('image');
    var image1 = new KTImageInput('project_image_1');
    var image2 = new KTImageInput('project_image_2');
    var image3 = new KTImageInput('project_image_3');  

$('#category_id').on('change',function(){
    
    if(this.value == 1){
        document.getElementById('image_div').hidden = false
        document.getElementById('slider_div').hidden = true
        document.getElementById('video_div').hidden = true
        document.getElementById('youtube_url_div').hidden = true

    }
    // alert(this.value);
        // console.log('sawsan')
    if(this.value == 4){

        document.getElementById('video_div').hidden = true
        document.getElementById('slider_div').hidden = true
        // document.getElementById('image_div').hidden = true
        document.getElementById('youtube_url_div').hidden = false
    }
    if(this.value == 3){
    document.getElementById('slider_div').hidden = false
        document.getElementById('video_div').hidden = true
        // document.getElementById('image_div').hidden = true
        document.getElementById('youtube_url_div').hidden = true

    }
    if(this.value == 2){
        
        document.getElementById('youtube_url_div').hidden = true
        document.getElementById('video_div').hidden = false
        // document.getElementById('image_div').hidden = true
        document.getElementById('slider_div').hidden = true

    }
    

    });
    
</script>

@endsection