@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.infos'))}}
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
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <h3>{{__('cp.edit_info')}}</h3>
                </div>
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <a href="{{url(getLocal().'/admin/infos')}}" class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
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
                <form method="post" action="{{url(app()->getLocale().'/admin/infos/'.$info->id)}}"
                      enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                    {{ csrf_field() }}
                    {{ method_field('PATCH')}}

                    <div class="card-header">
                        <h3 class="card-title">{{__('cp.main_info')}}</h3>
                    </div>


                    <div class="row col-sm-12">
                        <div class="card-body">

                          
                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.f_name_'.$locale->lang)}}</label>
                                            <input required 
                                            {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} type="text" class="form-control" id="f_name" name="f_name_{{$locale->lang}}"
                                            value="{{old('f_name_'.$locale->lang,@$info->translate($locale->lang)->f_name)}}"
                                                placeholder="Enter full f_name" />
                                            <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.f_name')}}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.l_name_'.$locale->lang)}}</label>
                                            <input required 
                                            {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} type="text" class="form-control" id="l_name" name="l_name_{{$locale->lang}}"
                                            value="{{old('l_name_'.$locale->lang,@$info->translate($locale->lang)->l_name)}}"
                                                placeholder="Enter full l_name" />
                                            <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.l_name')}}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.job_'.$locale->lang)}}</label>
                                            <input required 
                                            {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} type="text" class="form-control" id="job" name="job_{{$locale->lang}}"
                                            value="{{old('job_'.$locale->lang,@$info->translate($locale->lang)->job)}}"
                                                placeholder="Enter full job" />
                                            <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.job')}}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.location_'.$locale->lang)}}</label>
                                            <input required 
                                            {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} type="text" class="form-control" id="location" name="location_{{$locale->lang}}"
                                            value="{{old('location_'.$locale->lang,@$info->translate($locale->lang)->location)}}"
                                                placeholder="Enter full location" />
                                            <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.location')}}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
              
                           
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.birthdate')}}:</label>
                                <div class="col-9">
                                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{$info->birthdate}}"
                                        placeholder="Enter birthdate" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.birthdate')}}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.mobile')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{$info->mobile}}"
                                        placeholder="Enter user name" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.mobile')}}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.nationality')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="nationality" name="nationality" value="{{$info->nationality}}"
                                        placeholder="Enter nationality " />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.nationality')}}</span>
                                </div>
                            </div>
        
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.experience')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="experience" name="experience" value="{{$info->experience}}"
                                        placeholder="Enter experience " />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.experience')}}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">{{__('cp.email')}}:</label>
                                <div class="col-9">
                                    <input type="email" class="form-control" id="email"  name="email" value="{{$info->email}}"
                                        placeholder="Enter email" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.email')}}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.facebook_url')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="facebook_url" name="facebook_url" value="{{$info->facebook_url}}"
                                        placeholder="Enter facebook_url" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.facebook_url')}}</span>
                                </div>
                            </div>    <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.youtube_url')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="youtube_url" name="youtube_url" value="{{$info->youtube_url}}"
                                        placeholder="Enter youtube_url" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.youtube_url')}}</span>
                                </div>
                            </div>    <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.twitter_url')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="twitter_url" name="twitter_url" value="{{$info->twitter_url}}"
                                        placeholder="Enter twitter_url" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.twitter_url')}}</span>
                                </div>
                            </div>    
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.skybe_url')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="skybe" name="skybe" value="{{$info->skybe}}"
                                        placeholder="Enter skybe" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.skybe')}}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.dribbble')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="dribbble" name="dribbble" value="{{$info->dribbble}}"
                                        placeholder="Enter dribbble" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.dribbble')}}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">{{__('cp.freelance_status')}}</label>
                                <div class="col-3">
                                    <span class="switch switch-outline switch-icon switch-success">
                                        <label>
                                            {{-- <input type="checkbox"  checked="checked"  id="freelance_active"> --}}
                                            <input type="checkbox" @if($info->active_status == 'Available') checked="checked" @endif  id="freelance_active" name="freelance_active">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label" > {{__('cp.select_languages')}} :</label><br/>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <div class="dropdown bootstrap-select form-control dropup">
                                <select class="form-control selectpicker" name="languages[]" data-size="7" multiple data-live-search="true" id ='languages'>
                                    {{-- @foreach ($languages as $language) --}}
                                    <option value="English" @if(in_array('English', $array)) selected @endif>English</option>
                                    <option value="Arabic"  @if(in_array('Arabic',$array)) selected @endif >Arabic</option>
                                    <option value="Turky" @if(in_array('Turky', $array)) selected @endif >Turky</option>
                                    
                                    {{-- <option value="{{$language->lang_code}}" @if(in_array($language->lang_code, $array)) selected @endif>{{$language->lang_name}}</option> --}}
                                    {{-- @endforeach --}}
                               
                            
                                  
                                </select>
                            </div>
                                </div>
                            </div>
                            <span class="form-text text-muted">{{__('cp.please')}} {{__('cp.select_languages')}}</span>
                       

                      
        
                    
                             
                                {{-- </div> --}}
                            {{-- </div> --}}
        
                 
                        {{-- </div> --}}
                        <div class="card-header">
                            <h3 class="card-title">{{__('cp.image')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="fileinput-new thumbnail"
                                         onclick="document.getElementById('edit_image').click()"
                                         style="cursor:pointer">
                                        <img src="{{$info->image}}" id="editImage" alt="">
                                    </div>
                                    <div class="btn red"
                                         onclick="document.getElementById('edit_image').click()">
                                        <i class="fa fa-pencil"></i>
                                    </div>
                                    <input type="file" class="form-control" name="image"
                                           id="edit_image"
                                           style="display:none">
                                </div>
                            </div>
                        </div>

                        {{-- <div id ="cv_div" class="form-group row">
                            <label class="col-3 col-form-label">{{__('cp.cv')}}</label>
    
                            <input id= "cv" name="cv" type="file" class="form-control"><br/>
                            <div class="progress">
                                <div class="bar"></div >
                                <div class="percent">0%</div >
                            </div> 
                             <br>
                        </div> --}}

          
                     
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
{{-- <script src="{{asset('assets/js/pages/crud/forms/widgets/bootstrap-select.js')}}"></script> 
 <script src="{{asset('assets/js/pages/crud/file-upload/image-input.js')}}"></script> --}}
<script>

// var image = new KTImageInput('image');
    
</script>

@endsection