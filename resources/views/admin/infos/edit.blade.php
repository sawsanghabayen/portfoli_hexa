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
                                            <label>{{__('cp.full_name_'.$locale->lang)}}</label>
                                            <input required 
                                            {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} type="text" class="form-control" id="full_name" name="full_name_{{$locale->lang}}"
                                            value="{{old('full_name_'.$locale->lang,@$info->translate($locale->lang)->full_name)}}"
                                                placeholder="Enter full_name" />
                                            <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.f_name')}}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.nationality_'.$locale->lang)}}</label>
                                            <input required 
                                            {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} type="text" class="form-control" id="nationality" name="nationality_{{$locale->lang}}"
                                            value="{{old('nationality_'.$locale->lang,@$info->translate($locale->lang)->nationality)}}"
                                                placeholder="Enter nationality" />
                                            <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.nationality')}}</span>
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
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{old('mobile',$info->mobile)}}"
                                        placeholder="Enter user name" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.mobile')}}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.nationality')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="nationality" name="nationality" value="{{old('nationality',$info->nationality)}}"
                                        placeholder="Enter nationality " />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.nationality')}}</span>
                                </div>
                            </div>
        
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.experience')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="experience" name="experience" value="{{old('experience',$info->experience)}}"
                                        placeholder="Enter experience " />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.experience')}}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">{{__('cp.email')}}:</label>
                                <div class="col-9">
                                    <input type="email" class="form-control" id="email"  name="email" value="{{old('email',$info->email)}}"
                                        placeholder="Enter email" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.email')}}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.facebook_url')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="facebook_url" name="facebook_url" value="{{old('facebook_url',$info->facebook_url) }}"
                                        placeholder="Enter facebook_url" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.facebook_url')}}</span>
                                </div>
                            </div> 
                             
                              <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.twitter_url')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="twitter_url" name="twitter_url" value="{{old('twitter_url',$info->twitter_url) }}"
                                        placeholder="Enter twitter_url" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.twitter_url')}}</span>
                                </div>
                            </div>    
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.link')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="link" name="link" value="{{old('link',$info->link) }}"
                                        placeholder="Enter link" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.link')}}</span>
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <label class="col-3 col-form-label">{{__('cp.freelance_status')}}</label>
                                <div class="col-3">
                                    <span class="switch switch-outline switch-icon switch-success">
                                        <label>
                                           {{-- {{ dd(old( 'freelance_active',$info->freelance_active ) == 'Available');}} --}}
                                            {{-- <input type="checkbox"  checked="checked"  id="freelance_active"> --}}
                                            <input type="checkbox" @if(old( 'freelance_active',$info->freelance_active ) == 'Available') checked="checked" @endif   id="freelance_active" name="freelance_active">
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
                       

                            <div id="image_div" class="form-group row">
                                <label class="col-3 col-form-label">Image:</label>
                                <div class="col-3">
                                    <div class="image-input image-input-empty image-input-outline" id="image" name="image"
                                        style="background-image: url({{$info->image}})">
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
    
</script>

@endsection