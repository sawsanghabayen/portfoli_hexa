@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.messages'))}}
@endsection
@section('css')


@endsection

@section('content')
<!--begin::Advance Table Widget 5-->
<div class="card card-custom gutter-b">
    <!--begin::Header-->
    <div class="card-header border-0 py-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">{{__('cp.messages')}} </span>
            <span class="text-muted mt-3 font-weight-bold font-size-sm">{{__('cp.manage')}} {{__('cp.messages')}}</span>
        </h3>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-0">
        <!--begin::Table-->
        <div class="table-responsive">
            <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_2">
                <thead>
                    <tr class="text-uppercase">
                        <th style="min-width: 100px">{{__('cp.name')}} </th>
                        <th style="min-width: 100px">{{__('cp.email')}}</th>
                        <th style="min-width: 300px">{{__('cp.message')}}</th>
                        <th style="min-width: 100px">{{__('cp.send_date')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $message)
                    <tr>
                        <td class="pl-0">
                            <div>
                                <span
                                    class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$message->name}}</span>
                              
                        </td>
                        <td class="pl-0">
                            <div>
                                <span
                                    class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$message->email}}</span>
                                
                                
                            </div>
                        </td>


                 
                       <td class="pl-0">
                            <div>
                               
                                <span class="text-muted font-weight-bold d-block font-size-sm">
                                    {{$message->message}}</span>
                            </div>
                        </td>
                       <td class="pl-0">
                            <div>
                                <span
                                    class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$message->created_at->diffForHumans()}}</span>
                             
                        </td>
                    </tr>
                    @endforeach
            </table>
        </div>
        <!--end::Table-->
    </div>
    <!--end::Body-->
</div>
<!--end::Advance Table Widget 5-->
@endsection

@section('js')
<script src="{{asset('assets/js/pages/widgets.js')}}"></script>
{{-- <script>
    function performDestroy(id,reference) {
        confirmDestroy('/cms/admin/contacts', id, reference);
    }
</script> --}}
@endsection