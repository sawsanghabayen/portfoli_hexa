@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.experiences'))}}
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
                    <h3>{{__('cp.add_experience')}}</h3>
                </div>
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <a href="{{url(getLocal().'/admin/experiences')}}" class="btn btn-secondary  mr-2">{{__('cp.cancel')}}</a>
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
                <form method="post" action="{{url(app()->getLocale().'/admin/experiences')}}"
                      enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                    {{ csrf_field() }}

                    <div class="card-header">
                        <h3 class="card-title">{{__('cp.main_info')}}</h3>
                    </div>


                    <div class="row col-sm-12">
                        <div class="card-body">

                            <div class="form-group row">
                                <label class="col-3 col-form-label">Type Of Job:</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <div class="dropdown bootstrap-select form-control dropup">
                                        <select class="form-control selectpicker" data-size="7"  name="type_id" required
                                            title="Choose one of the following..." tabindex="null" data-live-search="true">
                                            <option value="1">{{__('cp.full_time')}}</option>
                                            <option value="2">{{__('cp.part_time')}}</option>
                                           
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Please select Type Job</span>
                                </div>
                            </div>
              
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.start_date')}}:</label>
                                <div class="col-9">
                                    <input type="date" class="form-control" name="start_date" 
                                        placeholder="{{__('cp.start_date')}}"  required/>
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.start_date')}}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cp.end_date')}}:</label>
                                <div class="col-9">
                                    <input type="date" class="form-control" name="end_date" 
                                        placeholder="{{__('cp.end_date')}}" />
                                    <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.end_date')}}</span>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.company_name_'.$locale->lang)}}</label>
                                            <input  required   {{($locale->lang == 'ar') ? 'dir=rtl' :'' }} type="text" class="form-control" id="company_name"  name="company_name_{{$locale->lang}}"
                                            placeholder="{{__('cp.company_name')}}" value="{{old('company_name_'.$locale->lang)}}"/>
                                        <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.company_name_'.$locale->lang)}} </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        
                            {{-- <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cms.company_name')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="company_name" 
                                        placeholder="Enter company_name" />
                                    <span class="form-text text-muted">{{__('cms.please_enter')}} {{__('cms.company_name')}}</span>
                                </div>
                            </div> --}}
                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.experience_name_'.$locale->lang)}}</label>
                                            <input  {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}  required type="text" class="form-control" id="experience_name"  name="experience_name_{{$locale->lang}}"
                                            placeholder="Enter experience_name" value="{{old('experience_name_'.$locale->lang)}}"/>
                                        <span class="form-text text-muted">{{__('cp.please_enter')}} {{__('cp.experience_name_'.$locale->lang)}} </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{-- <div class="form-group row mt-4">
                                <label class="col-3 col-form-label">{{__('cms.experience_name')}}:</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="experience_name" 
                                        placeholder="Enter experience_name" />
                                    <span class="form-text text-muted">{{__('cms.please_enter')}} {{__('cms.experience_name')}}</span>
                                </div>
                            </div> --}}

                            <div class="row">
                                @foreach($locales as $locale)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('cp.description_'.$locale->lang)}}</label>
                                            <textarea type="text" class="form-control form-control-solid"
                                                      rows="3" maxlength="150"
                                                      {{($locale->lang == 'ar') ? 'dir=rtl' :'' }}  name="description_{{$locale->lang}}"
                                                      required>{{old('description_'.$locale->lang)}}</textarea>
                                        </div>
                                    </div>
                                @endforeach
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

     function performStore() {
        let formData = new FormData();
        formData.append('language_id',document.getElementById('language_id').value);
        formData.append('company_name',document.getElementById('company_name').value);
        formData.append('experience_name',document.getElementById('experience_name').value);
        formData.append('description',document.getElementById('description').value);
        formData.append('start_date',document.getElementById('start_date').value);
        formData.append('end_date',document.getElementById('end_date').value);
        
        if(document.getElementById('experience_id').value !=null)
        formData.append('experience_id',document.getElementById('experience_id').value);
        // endif
     
        axios.post('/cms/admin/experiences',formData)
        .then(function (response) {
            console.log(response);
            toastr.success(response.data.message);
            document.getElementById('create-form').reset();

            
        })
        .catch(function (error) {
            console.log(error.response);
            toastr.error(error.response.data.message);
        });
    }
</script>

@endsection