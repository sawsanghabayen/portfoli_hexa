@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.join_requests'))}}
@endsection
@section('css')

@endsection
@section('content')



    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h3>{{ucwords(__('cp.join_requests'))}}</h3>
                    </div>
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->


                <div>
                    <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
                        <a  class="btn btn-secondary" href="{{url(getLocal().'/admin/pdfJoinRequests')}}">
                            <i class="icon-xl la la-file-pdf"></i>
                            <span>PDF</span>
                        </a>


                        <a  class="btn btn-secondary" href="{{url(getLocal().'/admin/export/excel/join_requests')}}">
                            <i class="icon-xl la la-file-excel"></i>
                            <span>{{__('cp.excel')}}</span>
                        </a>

{{--                        <button type="button" class="btn btn-secondary" href="#activation" role="button"  data-toggle="modal">--}}
{{--                            <i class="icon-xl la la-check"></i>--}}
{{--                            <span>{{__('cp.activation')}}</span>--}}
{{--                        </button>--}}
{{--                        <button type="button" class="btn btn-secondary" href="#cancel_activation" role="button"  data-toggle="modal">--}}
{{--                            <i class="icon-xl la la-ban"></i>--}}
{{--                            <span>{{__('cp.cancel_activation')}}</span>--}}
{{--                        </button>--}}
                        <button type="button" class="btn btn-secondary" href="#deleteAll" role="button" data-toggle="modal">
                            <i class="flaticon-delete"></i>
                            <span>{{__('cp.delete')}}</span>
                        </button>
                    </div>

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

                                <!--{{--                                                        <th class="wd-5p"> {{ucwords(__('cp.image'))}}</th>--}}-->
                                    <th class="wd-25p"> {{ucwords(__('cp.name'))}}</th>
                                    <th class="wd-25p"> {{ucwords(__('cp.email'))}}</th>
                                    <th class="wd-25p"> {{ucwords(__('cp.mobile'))}}</th>
                                    <th class="wd-10p"> {{ucwords(__('cp.status'))}}</th>
                                    <th class="wd-10p"> {{ucwords(__('cp.created_date'))}}</th>
                                    <th class="wd-15p"> {{ucwords(__('cp.action'))}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($items as $one)
                                    <tr class="odd gradeX" id="tr-{{$one->id}}">
                                        <td class="v-align-middle wd-5p">
                                            <div class="checkbox-inline">
                                                <label class="checkbox">
                                                    <input type="checkbox" value="{{$one->id}}" class="checkboxes" name="chkBox" />
                                                    <span></span></label>
                                            </div>
                                        </td>

                                        {{--                                                    <td class="v-align-middle wd-5p"><img src="{{$one->logo}}" width="50px" height="50px"></td>--}}

                                        <td class="v-align-middle wd-25p">{{$one->name}}</td>
                                        <td class="v-align-middle wd-25p">{{$one->email}}</td>
                                        <td class="v-align-middle wd-25p">{{$one->mobile}}</td>
                                        <td class="v-align-middle wd-10p" > <span id="label-{{$one->id}}" class="badge badge-pill badge-{{($one->is_read == "1")
                                            ? "info" : "danger"}}" id="label-{{$one->id}}">
                                            {{$one->is_read == "1"?__('cp.seen1'):__('cp.pending')}}
                                        </span>
                                        </td>
                                        <td class="v-align-middle wd-10p">{{$one->created_at->format('Y-m-d')}}</td>
                                        <td class="v-align-middle wd-15p optionAddHours">
                                            <a href="{{url(getLocal().'/admin/join_requests/'.$one->id.'/show')}}"
                                               class="btn btn-sm btn-clean btn-icon" title="{{__('cp.description')}}">
                                                <i class="la la-eye"></i>
                                            </a>
                                            <a href="#myModal{{$one->id}}" role="button" title="{{__('cp.description')}}"
                                               data-toggle="modal" class="btn btn-sm btn-clean btn-icon"><i
                                                    class="la la-comment-dots"></i></a>
                                        </td>
                                    </tr>
                                    <div id="myModal{{$one->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">{{__('cp.description')}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        {{$one->description}}
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn default" data-dismiss="modal" aria-hidden="true">{{__('cp.cancel')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty

                                @endforelse


                                </tbody>
                            </table>
                            {{$items->appends($_GET)->links("pagination::bootstrap-4") }}
                        </div>
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

@endsection
@section('js')

@endsection

@section('script')

@endsection