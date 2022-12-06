<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Exports\JoinRequestExport;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\JoinRequest;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class JoinRequestController extends Controller
{
    //
    public function __construct()
    {
        $this->locales = Language::all();
        $this->settings = Setting::query()->first();
        view()->share([
            'locales' => $this->locales,
            'settings' => $this->settings,

        ]);

        $route=Route::currentRouteAction();
        $route_name = substr($route, strpos($route, "@") + 1);
        $this->middleware(function ($request, $next) use($route_name){
            if($route_name== 'index' ){
                if(can(['join_requests-show' ,  'join_requests-edit' , 'join_requests-delete'])){
                    return $next($request);
                }
            }elseif($route_name== 'edit' || $route_name== 'update'){
                if(can('join_requests-edit')){
                    return $next($request);
                }
            }elseif($route_name== 'destroy' || $route_name== 'delete'){
                if(can('join_requests-delete')){
                    return $next($request);
                }
            }else{
                return $next($request);
            }
            return redirect()->back()->withErrors(__('cp.you_dont_have_permission'));
        });

    }
    public function index()
    {
        $items = JoinRequest::filter()->orderBy('id', 'desc')->paginate(30);
        return view('admin.join_requests.home', [
            'items' =>$items,
        ]);
    }


    public function show($id)
    {
        $item = JoinRequest::where('id',$id)->first();
        return view('admin.join_requests.show', [
            'item' =>$item,
        ]);
    }
    public function update(Request $request, $id)
    {
        $roles = [
            'is_read'=>'required'
        ];

        $this->validate($request, $roles);

        $item = JoinRequest::where('id',$id)->first();
        $item->is_read = $request->is_read;
        $item->save();
        return redirect()->back()->with('status', __('cp.update'));
    }



    public function destroy($id)
    {
        $ad = JoinRequest::query()->findOrFail($id);
        if ($ad) {
            JoinRequest::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

    public function exportExcel(Request $request)
    {
        activity()->causedBy(auth('admin')->user())->log(' تصدير ملف إكسل لبيانات طلبات الانضمام ');
        return Excel::download(new JoinRequestExport($request), 'JoinRequests.xlsx');
    }
    public function pdfJoinRequests(Request $request)
    {
        activity()->causedBy(auth('admin')->user())->log(' تصدير ملف PDF لبيانات طلبات الانضمام ');
        $items = JoinRequest::orderByDesc('id')->get();
        $pdf = PDF::loadView('admin.join_requests.export_pdf', ['items'=>$items]);
        return $pdf->download('join_requests.pdf');
    }
}
