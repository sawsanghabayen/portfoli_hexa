<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\OptionValue;
use App\Models\Setting;
use App\Models\Subadmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class OptionValueController extends Controller
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
                if(can(['option_values-show' , 'option_values-create' , 'option_values-edit' , 'option_values-delete'])){
                    return $next($request);
                }
            }elseif($route_name== 'create' || $route_name== 'store'){
                if(can('option_values-create')){
                    return $next($request);
                }
            }elseif($route_name== 'edit' || $route_name== 'update'){
                if(can('option_values-edit')){
                    return $next($request);
                }
            }elseif($route_name== 'destroy' || $route_name== 'delete'){
                if(can('option_values-delete')){
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
        $items = OptionValue::filter()->orderBy('id', 'desc')->paginate($this->settings->paginateTotal);
        return view('admin.option_values.home', [
            'items' =>$items,
            'users' =>$users,
        ]);
    }


    public function create()
    {
        $users = Subadmin::get();
        return view('admin.option_values.create')->with(compact('users'));
    }


    public function store(Request $request)
    {
        $roles = [
            'user_id' => 'required',
            'price' => 'numeric|nullable',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item= new OptionValue();
        $item->user_id = $request->user_id;
        $item->price = $request->price;
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }

        $item->save();
        activity($item->name)->causedBy(auth('admin')->user())->log(' إضافة الخيار ');

        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $users = Subadmin::get();
        $item = OptionValue::where('id',$id)->first();
        return view('admin.option_values.edit', [
            'item' => $item,
            'users' => $users,
        ]);
    }

    public function update(Request $request, $id)
    {

        $roles = [
            'user_id' => 'required',
            'price' => 'numeric|nullable',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item = OptionValue::query()->findOrFail($id);
        $item->user_id = $request->user_id;
        $item->price = $request->price;

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }



        $item->save();
        activity($item->name)->causedBy(auth('admin')->user())->log(' تعديل الخيار ');

        return redirect()->back()->with('status', __('cp.update'));
    }

    public function destroy($id)
    {
        //
        $ad = OptionValue::query()->findOrFail($id);
        if ($ad) {
            OptionValue::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
