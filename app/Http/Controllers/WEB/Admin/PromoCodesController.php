<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\PromoCode;
use App\Models\PromoCodeUser;
use App\Models\Setting;
use App\Models\Subadmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
class PromoCodesController extends Controller
{

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
                if(can(['promo_codes-show' , 'promo_codes-create' , 'promo_codes-edit' , 'promo_codes-delete'])){
                    return $next($request);
                }
            }elseif($route_name== 'create' || $route_name== 'store'){
                if(can('promo_codes-create')){
                    return $next($request);
                }
            }elseif($route_name== 'edit' || $route_name== 'update'){
                if(can('promo_codes-edit')){
                    return $next($request);
                }
            }elseif($route_name== 'destroy' || $route_name== 'delete'){
                if(can('promo_codes-delete')){
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
        $users = Subadmin::get();
        $items = PromoCode::filter()->orderBy('id', 'desc')->get();
        return view('admin.promo_codes.home', [
            'items' =>$items,
            'users' =>$users,
        ]);
    }


    public function create()
    {
        $users = Subadmin::get();
        $categories = Category::where('parent_id','0')->get();
        return view('admin.promo_codes.create')->with(compact('categories','users'));
    }


    public function store(Request $request)
    {
        $roles = [
            'name' => 'required|unique:promo_codes',
            'amount' => 'required',
            'max_usage' => 'nullable',
            'end_date' => 'required|date_format:Y-m-d|after:today',
            'user_id'=>'nullable',
            'discount_type'=>'required',
            'status'=>'required',

        ];

        $this->validate($request, $roles);

        $item= new PromoCode();

        $item->name=$request->name;
        $item->amount=$request->amount;
        $item->max_usage=$request->max_usage;
        $item->end_date=$request->end_date;
        $item->status=$request->status;
        $item->discount_type=$request->discount_type;
//        if (isset($request->user_id)&&$request->user_id > 0){
//            $item->user_id=$request->user_id;
//        }else{
//            $item->user_id=0;
//        }

        if($request->userIds != null){
            $all = false;
            foreach($request->userIds as $userId){
                $values[] = [
                    'promo_code_id' => $item->id,
                    'user_id' => $userId,
                ];
                if ($userId=='0'){
                    $all = true;
                    break;
                }
            }
            if ($all){
                //PromoCodeUser::where('promo_code_id',$item->id)->delete();
                $item->user_id=0;
            }else{
                PromoCodeUser::insert($values);
                $item->user_id=null;
            }

        }

        $item->save();
        activity($item->name)->causedBy(auth('admin')->user())->log(' إضافة كود الخصم ');

        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $users = Subadmin::get();
        $item = PromoCode::where('id',$id)->first();
        return view('admin.promo_codes.edit', [
            'item' => $item,
            'users' => $users,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = PromoCode::query()->where('id',$id)->first();

        $roles = [
            'name' => 'required|unique:promo_codes,name,' . $item->id,
            'amount' => 'required',
            'max_usage' => 'nullable',
            'end_date' => 'required|date_format:Y-m-d|after:today',
//            'user_id'=>'nullable',
            'discount_type'=>'required',
            'status'=>'required',

        ];

        $this->validate($request, $roles);

        $item->name=$request->name;
        $item->amount=$request->amount;
        $item->max_usage=$request->max_usage;
        $item->end_date=$request->end_date;
        $item->status=$request->status;
        $item->discount_type=$request->discount_type;
//        if (isset($request->user_id)&&$request->user_id > 0){
//            $item->user_id=$request->user_id;
//        }else{
//            $item->user_id=0;
//        }
//
//

        if($request->userIds != null){
            $all = false;
            foreach($request->userIds as $userId){
                $values[] = [
                    'promo_code_id' => $item->id,
                    'user_id' => $userId,
                ];
                if ($userId=='0'){
                    $all = true;
                    break;
                }
            }
            PromoCodeUser::where('promo_code_id',$item->id)->delete();
            if ($all){
                $item->user_id=0;
            }else{
                $item->user_id=null;
                PromoCodeUser::insert($values);
            }
        }


        $item->save();
        activity($item->name)->causedBy(auth('admin')->user())->log(' تعديل كود الخصم ');

        return redirect()->back()->with('status', __('cp.update'));
    }

    public function destroy($id)
    {
        //
        $ad = PromoCode::query()->findOrFail($id);
        if ($ad) {
            PromoCode::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
