<?php
namespace App\Http\Controllers\WEB\Admin;
use App\Models\Subadmin;
use App\Models\User;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Banner;
 use Illuminate\Support\Facades\Route;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use imageTrait;
    public function __construct()
    {
        $this->settings = Setting::query()->first();
        view()->share([
            'settings' => $this->settings,

        ]);

         $route=Route::currentRouteAction();
         $route_name = substr($route, strpos($route, "@") + 1);
         $this->middleware(function ($request, $next) use($route_name){
         if(can('banners')){
            return $next($request);
         }
          if($route_name== 'index' ){
             if(can(['banners-show' , 'banners-create' , 'banners-edit' , 'banners-delete'])){
                 return $next($request);
             }
          }elseif($route_name== 'create' || $route_name== 'store'){
              if(can('banners-create')){
                 return $next($request);
             }
          }elseif($route_name== 'edit' || $route_name== 'update'){
              if(can('banners-edit')){
                 return $next($request);
             }
          }elseif($route_name== 'destroy' || $route_name== 'delete'){
              if(can('banners-delete')){
                 return $next($request);
             }
          }else{
              return $next($request);
          }
          if($request->ajax()){
            $message = __('cp.you_dont_have_premession');
            return response()->json(['status' => false, 'code' => 503, 'message' => $message, ]);
          }else{
            return redirect()->back()->withErrors(__('cp.you_dont_have_premession'));
          }
        });
    }

    public function index(Request $request)
    {
        $users = Subadmin::get();
        $items = Banner::filter()->orderBy('id', 'desc')->get();
        return view('admin.banners.home', [
            'items' =>$items,
            'users' =>$users,
        ]);

    }


    public function create()
    {
        $users = Subadmin::where('status','active')->get();
        return view('admin.banners.create')->with(compact('users'));
    }


    public function store(Request $request)
    {
        $roles = [
            'image' => 'required|image|mimes:jpeg,jpg,png,gif',
            'user_id'=>'nullable|numeric'
        ];
        $this->validate($request, $roles);

        $item= new Banner();

        if ($request->hasFile('image')) {
            $item->image =  $this->storeImage( $request->file('image'), 'banners',null,512);
        }
        if (isset($request->user_id)){
            $item->user_id = $request->user_id;
        }
        $item->status = $request->status;
        $item->save();

        activity()->causedBy(auth('admin')->user())->log(' إضافة اعلان جديد ');
        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
        {
            $users = Subadmin::where('status','active')->get();
            $item = Banner::where('id',$id)->first();
            return view('admin.banners.edit', [
                'item' => $item,
                'users' => $users,
            ]);

        }


    public function update(Request $request, $id)
    {
        $roles = [
            'image' => 'image|mimes:jpeg,jpg,png,gif',
            'user_id'=>'nullable|numeric'
        ];

        $this->validate($request, $roles);

        $item = Banner::query()->findOrFail($id);

        if ($request->hasFile('image')) {
            $item->image =  $this->storeImage( $request->file('image'), 'banners',$item->getRawOriginal('image'),null,512);
        }
        if (isset($request->user_id)){
            $item->user_id = $request->user_id;
        }
        $item->status = $request->status;
        $item->save();
        return redirect()->back()->with('status', __('cp.update'));
    }


    public function destroy($id)
    {
        //
        $ad = Banner::query()->findOrFail($id);
        if ($ad) {
            Banner::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }
}
