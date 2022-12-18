@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.educations'))}}
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
                    <h3>{{ucwords(__('cp.educations'))}}</h3>
                </div>
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->


            <div>
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
              
                    <button type="button" class="btn btn-secondary" href="#deleteAll" role="button" data-toggle="modal">
                        <i class="flaticon-delete"></i>
                        <span>{{__('cp.delete')}}</span>
                    </button>

                </div>
                <a href="{{url(getLocal().'/admin/educations/create')}}" class="btn btn-secondary  mr-2 btn-success">
                    <i class="icon-xl la la-plus"></i>
                    <span>{{__('cp.add')}}</span>
                </a>
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
                                <th class="wd-10p"> {{ucwords(__('cp.education_name'))}}</th>
                                <th class="wd-10p"> {{ucwords(__('cp.company_name'))}}</th>
                                <th class="wd-25p"> {{ucwords(__('cp.description_name'))}}</th>
                                <th class="wd-10p"> {{ucwords(__('cp.created'))}}</th>
                                <th class="wd-15p"> {{ucwords(__('cp.action'))}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($educations as $one)
                                <tr class="odd gradeX" id="tr-{{$one->id}}">
                                    <td class="v-align-middle wd-5p">
                                        <div class="checkbox-inline">
                                            <label class="checkbox">
                                                <input type="checkbox" value="{{$one->id}}" class="checkboxes" name="chkBox" />
                                                <span></span></label>
                                        </div>
                                    </td>

                                    {{-- <td class="v-align-middle wd-5p"><img src="{{$one->image}}" width="50px" height="50px"></td> --}}

                                    <td class="v-align-middle wd-10p" > {{$one->education_name}}</td>
                                    <td class="v-align-middle wd-10p" > {{$one->company_name}}</td>
                                    <td class="v-align-middle wd-25p">{{$one->description}}</td>
                                    <td class="v-align-middle wd-25p">{{$one->created_at}}</td>



                                    <td class="v-align-middle wd-15p optionAddHours">
                                        <a href="{{url(getLocal().'/admin/educations/'.$one->id.'/edit')}}"
                                           class="btn btn-sm btn-clean btn-icon" title="{{__('cp.edit')}}">
                                            <i class="la la-edit"></i>
                                        </a>
                                        <a href="#"  onclick="confirmDelete('{{$one->id}}', this)" role="button" title="{{__('cp.delete')}}" data-toggle="modal" class="btn btn-sm btn-clean btn-icon"><i class="la la-trash"></i></a>



                                    </td>

                                  
                                    
                                </tr>
                            @empty

                            @endforelse
                            <div class="modal-footer">
                                <button class="btn default" data-dismiss="modal" aria-hidden="true">{{__('cp.cancel')}}</button>
                                <a onclick=""><button class="btn btn-danger">{{__('cp.delete')}}</button></a>
                            </div>


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
<script src="{{asset('assets/js/pages/features/miscellaneous/toastr.js')}}"></script>
<script src="{{asset('assets/js/pages/features/miscellaneous/sweetalert2.js')}}"></script>
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
        axios.delete('/admin/educations/'+id)
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