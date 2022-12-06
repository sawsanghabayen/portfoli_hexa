<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuisine;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CuisineController extends Controller
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
                if(can(['cuisines-show' , 'cuisines-create' , 'cuisines-edit' , 'cuisines-delete'])){
                    return $next($request);
                }
            }elseif($route_name== 'create' || $route_name== 'store'){
                if(can('cuisines-create')){
                    return $next($request);
                }
            }elseif($route_name== 'edit' || $route_name== 'update'){
                if(can('cuisines-edit')){
                    return $next($request);
                }
            }elseif($route_name== 'destroy' || $route_name== 'delete'){
                if(can('cuisines-delete')){
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
        $items = Cuisine::orderBy('id', 'desc')->paginate($this->settings->paginateTotal);
        return view('admin.cuisines.home', [
            'items' =>$items,
        ]);
    }


    public function create()
    {
        return view('admin.cuisines.create');
    }


    public function store(Request $request)
    {
        $roles = [

        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item= new Cuisine();
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }

        $item->save();
        activity($item->name)->causedBy(auth('admin')->user())->log(' إضافة مطبخ جديد ');

        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $item = Cuisine::where('id',$id)->first();
        return view('admin.cuisines.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {

        $roles = [

        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item = Cuisine::query()->findOrFail($id);

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }

        $item->save();
        activity($item->name)->causedBy(auth('admin')->user())->log(' تعديل المطبخ ');

        return redirect()->back()->with('status', __('cp.update'));
    }

    public function destroy($id)
    {
        //
        $ad = Cuisine::query()->findOrFail($id);
        if ($ad) {
            Cuisine::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
