@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.infos'))}}
@endsection
@section('css')


@endsection

@section('content')
<!--begin::Advance Table Widget 5-->


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <h3>{{ucwords(__('cp.infos'))}}</h3>
                </div>
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->


        
            <!--end::Toolbar-->
        </div>
    </div>
    <!--end::Subheader-->


    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="gutter-b example example-compact">

                <div class="contentTabel">
                    {{-- <button  type="button" class="btn btn-secondar btn--filter mr-2"><i class="icon-xl la la-sliders-h"></i>{{__('cp.filter')}}</button> --}}
                  
                    {{-- <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                  

                    </div> --}}
                    <div class="table-responsive">
                        <table class="table table-hover tableWithSearch" id="tableWithSearch">
                            <thead>
                            <tr>
                                <th class="wd-1p no-sort">
                                    <div class="checkbox-inline">
                                        <label class="checkbox">
                                            <input type="checkbox" name="checkAll" />
                                            <span></span></label>
                                    </div>
                                </th>
                                <th style="min-width: 120px">{{__('cp.imge')}}</th>
                                {{-- <th style="min-width: 120px">{{__('cp.cv')}}</th> --}}
                                {{-- <th style="min-width: 120px">{{__('cp.language')}}</th> --}}
                                <th style="min-width: 150px">{{__('cp.f_name')}}</th>
                                <th style="min-width: 150px">{{__('cp.l_name')}}</th>
                                <th style="min-width: 150px">{{__('cp.birthdate')}}</th>
                                <th style="min-width: 150px">{{__('cp.email')}}</th>
                                <th style="min-width: 150px">{{__('cp.mobile')}}</th>
                                <th style="min-width: 150px">{{__('cp.location')}}</th>
                                <th style="min-width: 150px">{{__('cp.experience')}}</th>
                                <th style="min-width: 150px">{{__('cp.languages')}}</th>
                                <th style="min-width: 150px">{{__('cp.nationality')}}</th>
                                <th style="min-width: 150px">{{__('cp.freelance_active')}}</th>
                                <th style="min-width: 150px">{{__('cp.job')}}</th>
                                <th style="min-width: 150px">{{__('cp.facebooke_url')}}</th>
                                <th style="min-width: 150px">{{__('cp.youtube_url')}}</th>
                                <th style="min-width: 150px">{{__('cp.twitter_url')}}</th>
                                <th style="min-width: 150px">{{__('cp.dribbble')}}</th>
                                <th style="min-width: 150px">{{__('cp.skybe')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($infos as $info)
                                <tr class="odd gradeX" id="tr-{{$info->id}}">
                                    <td class="v-align-middle wd-5p">
                                        <div class="checkbox-inline">
                                            <label class="checkbox">
                                                <input type="checkbox" value="{{$info->id}}" class="checkboxes" name="chkBox" />
                                                <span></span></label>
                                        </div>
                                    </td>
                                    <td class="pl-0 py-8">
                                        <div class="d-flex align-items-center">
                                        <div class="symbol symbol-50 symbol-light mr-4">
                                            <span class="symbol-label">
                                                @if($setting->image !=null)
                                                    
                                                <img src="{{$info->image}}"
                                                    class="h-75 align-self-end" alt="" />
                                                    @else
                                                    <img src="{{asset('assets/media/users/blank.png')}}"
                                                    class="h-75 align-self-end" alt=""/>
            
                                                @endif
            
                                            </span>
                                        </div>
                                        </div>
                                    </td>
                               
                               
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$info->f_name}}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$info->l_name}}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$info->birthdate}}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$info->email}}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$info->mobile}}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$info->location}}</span>
                                       
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$info->experience}}</span>
                                       
                                    </td>
                                    <td>
                                        @foreach ($array as $one)
                                            
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{($one)}}
                                        </span>
                                        
                                        @endforeach
                                         
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$info->nationality}}</span>
                                       
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg" >{{$info->active_status}}</span>
                                       
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg" >{{$info->job}}</span>
                                       
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$info->facebook_url}}</span>
                                       
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$info->youtube_url}}</span>
                                       
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$info->twitter_url}}</span>
                                       
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$info->dribbble}}</span>
                                       
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$info->skybe}}</span>
                                       
                                    </td>
                                  
                                    {{-- @can([ 'Update-Basic_info']) --}}
                       

                                    <td class="v-align-middle wd-15p optionAddHours">
                                        <a href="{{url(getLocal().'/admin/infos/'.$info->id.'/edit')}}"
                                           class="btn btn-sm btn-clean btn-icon" title="{{__('cp.edit')}}">
                                            <i class="la la-edit"></i>
                                        </a>



                                    </td>

                                    <div class="modal-footer">
                                        <button class="btn default" data-dismiss="modal" aria-hidden="true">{{__('cp.cancel')}}</button>
                                        <a onclick=""><button class="btn btn-danger">{{__('cp.delete')}}</button></a>
                                    </div>
                                    
                                </tr>
                            @empty

                            @endforelse


                            </tbody>
                        </table>
{{--                            {{$items->appends($_GET)->links("pagination::bootstrap-4") }}--}}
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
























<!--end::Advance Table Widget 5-->
@endsection

@section('js')
<script src="{{asset('js/axios.js')}}"></script>
<script src="{{asset('controlPanel/assets/js/pages/features/miscellaneous/toastr.js')}}"></script>
<script src="{{asset('controlPanel/assets/js/pages/features/miscellaneous/sweetalert2.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- <script src="{{asset('controlPanel/assets/js/pages/widgets.js')}}"></script> --}}
{{-- <script src="{{asset('controlPanel/assets/js/pages/widgets.js')}}"></script> --}}
<script>

function confirmDelete(id, reference) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            performDelete(id, reference);
        }
        });
    }
     function performDelete(id, reference) {
        axios.delete('/admin/infos/'+id)
        .then(function (response) {
            // toastr.success(response.data.message);
            console.log(response);
            reference.closest('tr').remove();
            showMessage(response.data);
        })
        .catch(function (error) {
            console.log(error.response);
            // toastr.error(error.response.data.message);
            showMessage(error.response.data);
        });
    }
       function showMessage(data) {
        Swal.fire(
            data.title,
            data.text,
            data.icon
        );
    }
</script>

@endsection