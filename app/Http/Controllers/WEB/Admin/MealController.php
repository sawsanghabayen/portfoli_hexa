<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Exports\MealsExportForAdmin;
use App\Exports\MealsReportForAdmin;
use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use App\Models\Category;
use App\Models\Extra;
use App\Models\Language;
use App\Models\Meal;
use App\Models\MealImage;
use App\Models\Option;
use App\Models\OptionOptionValue;
use App\Models\OptionValue;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Subadmin;
use App\Models\User;
use App\Models\UserImage;
use App\Traits\imageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class MealController extends Controller
{
    use imageTrait;

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
                if(can(['meals-show' , 'meals-create' , 'meals-edit' , 'meals-delete'])){
                    return $next($request);
                }
            }elseif($route_name== 'create' || $route_name== 'store'){
                if(can('meals-create')){
                    return $next($request);
                }
            }elseif($route_name== 'edit' || $route_name== 'update'){
                if(can('meals-edit')){
                    return $next($request);
                }
            }elseif($route_name== 'destroy' || $route_name== 'delete'){
                if(can('meals-delete')){
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
        $items = Meal::filter()->orderBy('id', 'desc')->paginate($this->settings->paginateTotal);
        $categories = Category::all();
        return view('admin.meals.home', [
            'items' =>$items,
            'users' =>$users,
            'categories' =>$categories,
        ]);
    }

    public function report()
    {
        $users = Subadmin::get();
        $items = Meal::filter()->orderBy('count_selling', 'desc')->limit(50)->get();
        return view('admin.meals.report', [
            'items' =>$items,
            'users' =>$users,
        ]);
    }

    public function create()
    {
        $users = Subadmin::get();
        $option_values = OptionValue::all();
        return view('admin.meals.create')->with(compact('users','option_values'));
    }


    public function store(Request $request)
    {
//        return $request;
        $roles = [
            'image' => 'required|image|mimes:jpeg,jpg,png,gif',
            'user_id' => 'required',
            'category_id' => 'nullable',
            'price' => 'required',
            'price_offer' => 'nullable',
            'sort_order' => 'required',
            'status' => 'required',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['title_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item = new Meal();
        $item->user_id = $request->user_id;
        $item->category_id = $request->category_id;
        $item->price = $request->price;
        $item->price_offer = $request->price_offer;
        $item->sort_order = $request->sort_order;
        $item->status = $request->status;
        if($request->get('best_selling') == 'on'){
            $item->best_selling = '1' ;
        }else{
            $item->best_selling = '0' ;
        }

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->title = $request->get('title_' . $locale);
            $item->translateOrNew($locale)->description = $request->get('description_' . $locale);
        }

        if ($request->hasFile('image') && $request->image != '') {
            $item->image = $this->storeImage($request->image, 'meals');
        }
        $item->save();

        if ($request->has('extras')){
            foreach ($request->extras as $e){
                $extra=new Extra();
                $extra->meal_id = $item->id;
                if ($e['price'] && $e['price'] > 0){
                    $extra->price = $e['price'];
                }else{
                    $extra->price = 0;
                }
                $extra->translateOrNew('en')->name = $e['name_en'];
                $extra->translateOrNew('ar')->name = $e['name_ar'];
                $extra->save();
                
            }
        }


        if($request->has('filename')  && !empty($request->filename))
        {
            foreach($request->filename as $one)
            {
                if (isset(explode('/', explode(';', explode(',', $one)[0])[0])[1])) {
                    $fileType = strtolower(explode('/', explode(';', explode(',', $one)[0])[0])[1]);
                    $name = "" .str_random(8) . "" .  "" . time() . "" . rand(1000000, 9999999);
                    $attachType = 0;
                    if (in_array($fileType, ['jpg','jpeg','png','pmb'])){
                        $newName = $name. ".jpg";
                        $attachType = 1;
                        Image::make($one)->resize(800, null, function ($constraint) {$constraint->aspectRatio();})->save("uploads/images/meals/$newName");
                    }
                    $image=new MealImage();
                    $image->meal_id = $item->id;
                    $image->image = $newName;
                    $image->save();
                }
            }
        }
        activity($item->title)->causedBy(auth('admin')->user())->log(' إضافة وجبة جديدة ');

        return redirect()->back()->with('status', __('cp.create'));
    }


    public function edit($id)
    {
        $users = Subadmin::get();
        $item = Meal::where('id',$id)->first();
        $categories = Category::where('user_id',@$item->user->id)->get();
        return view('admin.meals.edit', [
            'item' => $item,
            'users' => $users,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id)
    {
//        return $request;
        $roles = [
            'image' => 'image|mimes:jpeg,jpg,png,gif',
            'user_id' => 'required',
            'category_id' => 'nullable',
            'price' => 'required',
            'price_offer' => 'nullable',
            'sort_order' => 'required',
            'status' => 'required',
//            'extras.name_en' => 'required',
//            'extras.name_ar' => 'required',
//            'extras.price' => 'required',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['title_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item = Meal::query()->findOrFail($id);

        $item->user_id = $request->user_id;

        if (isset($request->category_id) && $request->category_id >0 &&$request->category_id!=null) {
            $item->category_id = $request->category_id;
        }else{
            $item->category_id = 0;
        }
        $item->price = $request->price;

        if (isset($request->price_offer)&& $request->price_offer >0 &&$request->price_offer!= null) {
            $item->price_offer = $request->price_offer;
        }else{
            $item->price_offer = 0;
        }

        $item->sort_order = $request->sort_order;
        $item->status = $request->status;
        if($request->get('best_selling') == 'on'){
            $item->best_selling = '1' ;
        }else{
            $item->best_selling = '0' ;
        }
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->title = $request->get('title_' . $locale);
            $item->translateOrNew($locale)->description = $request->get('description_' . $locale);
        }
        if ($request->hasFile('image') && $request->image != '') {
            $item->image = $this->storeImage($request->image, 'meals' , $item->getRawOriginal('image') );
        }
        $item->save();

        if ($request->has('extras')){
            Extra::where('meal_id',$item->id)->delete();
            foreach ($request->extras as $e){
                $extra=new Extra();
                $extra->meal_id = $item->id;
                $extra->price=$e['price'];
                $extra->translateOrNew('en')->name = $e['name_en'];
                $extra->translateOrNew('ar')->name = $e['name_ar'];
                $extra->save();
            }
        }else{
            Extra::where('meal_id',$item->id)->delete();
        }


        $imgsIds = $item->images->pluck('id')->toArray();
        $newImgsIds = ($request->has('oldImages'))? $request->oldImages:[];
        $diff = array_diff($imgsIds,$newImgsIds);
        MealImage::whereIn('id',$diff)->delete();

        if($request->has('filename')  && !empty($request->filename))
        {
            foreach($request->filename as $one)
            {
                if (isset(explode('/', explode(';', explode(',', $one)[0])[0])[1])) {
                    $fileType = strtolower(explode('/', explode(';', explode(',', $one)[0])[0])[1]);
                    $name = "" .str_random(8) . "" .  "" . time() . "" . rand(1000000, 9999999);
                    $attachType = 0;
                    if (in_array($fileType, ['jpg','jpeg','png','pmb'])){
                        $newName = $name. ".jpg";
                        $attachType = 1;
                        Image::make($one)->resize(800, null, function ($constraint) {$constraint->aspectRatio();})->save("uploads/images/meals/$newName");
                    }
                    $image=new MealImage();
                    $image->meal_id = $item->id;
                    $image->image = $newName;
                    $image->save();
                }
            }
        }
        activity($item->title)->causedBy(auth('admin')->user())->log(' تعديل الوجبة ');

        return redirect()->back()->with('status', __('cp.update'));
    }

    public function destroy($id)
    {
        //
        $ad = Meal::query()->findOrFail($id);
        if ($ad) {
            Meal::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }


    public function options($id){
        $meal = Meal::where('id',$id)->first();
        $items = Option::where('meal_id',$id)->orderByDesc('id')->get();
        return view('admin.meals.options')->with(compact('items','meal'));
    }


    public function createOption($id){
        $meal = Meal::where('id',$id)->first();
        $option_values = OptionValue::where('user_id',$meal->user_id)->get();
        return view('admin.meals.create_option')->with(compact('meal','option_values'));
    }

    public function storeOption(Request $request , $id){
        $roles = [
            'options_type' => 'required',
            'selection_type' => 'required',
            'minimum_value' => 'required_if:selection_type,==,1',
            'maximum_value' => 'required_if:selection_type,==,1',
            'sort_order' => 'required',
            'option_values' =>  'required',
        ];
        if ($request->has('minimum_value') && $request->selection_type == 1 && $request->has('maximum_value') ) {
            $roles = [
                'maximum_value' => 'gt:minimum_value',
            ];
        }

        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);

        $item= new Option();
        $item->meal_id = $id;
        $item->options_type = $request->options_type;
        $item->selection_type = $request->selection_type;

        if ($request->has('minimum_value') && $request->selection_type =='1' && $request->has('maximum_value') ){
            $item->minimum_value = $request->minimum_value;
            $item->maximum_value = $request->maximum_value;
        }else{
            $item->minimum_value = 0;
            $item->maximum_value = 0;
        }
        $item->sort_order = $request->sort_order;

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }

        $item->save();

         if($request->option_values != null){
             foreach($request->option_values as $option_value_id){
                 $values[] = [
                     'option_id' => $item->id,
                     'option_value_id' => $option_value_id,

                 ];
             }
             OptionOptionValue::insert($values);

         }
        activity(@$item->meal->title)->causedBy(auth('admin')->user())->log(' إضافة خيارات للوجبة ');

        return redirect()->back()->with('status', __('cp.create'));

    }



    public function editOption($id){
        $item = Option::where('id',$id)->first();
        $meal = Meal::where('id',$item->meal_id)->first();
        $option_values = OptionValue::where('user_id',$meal->user_id)->get();
        return view('admin.meals.edit_option')->with(compact('meal','item','option_values'));
    }


    public function updateOption(Request $request , $id){
        $roles = [
            'options_type' => 'required',
            'selection_type' => 'required',
            'minimum_value' => 'required_if:selection_type,==,1',
            'maximum_value' => 'required_if:selection_type,==,1',
            'sort_order' => 'required',
            'option_values' =>  'required',
        ];
        if ($request->has('minimum_value') && $request->selection_type == '1' && $request->has('maximum_value') ) {
            $roles = [
                'maximum_value' => 'gt:minimum_value',
            ];
        }
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        $this->validate($request, $roles);
        $item = Option::where('id',$id)->first();
        $meal = Meal::where('id',$item->meal_id)->first();

        $item->meal_id = $meal->id;
        $item->options_type = $request->options_type;
        $item->selection_type = $request->selection_type;

        $item->minimum_value = $request->minimum_value;
        $item->maximum_value = $request->maximum_value;
        if ($request->has('minimum_value') && $request->selection_type =='1' && $request->has('maximum_value') ){
            $item->minimum_value = $request->minimum_value;
            $item->maximum_value = $request->maximum_value;
        }else{
            $item->minimum_value = 0;
            $item->maximum_value = 0;
        }
        $item->sort_order = $request->sort_order;

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }

        $item->save();

        if($request->option_values != null){
            OptionOptionValue::where('option_id',$item->id)->delete();
            foreach($request->option_values as $option_value_id){
                $values[] = [
                    'option_id' => $item->id,
                    'option_value_id' => $option_value_id,
                ];
            }
            OptionOptionValue::insert($values);
        }else{
            OptionOptionValue::where('option_id',$item->id)->delete();
        }
        activity(@$item->meal->title)->causedBy(auth('admin')->user())->log(' تعديل خيارات الوجبة ');

        return redirect()->back()->with('status', __('cp.update'));

    }


    public function deleteOption($id)
    {
        $ad = Option::query()->findOrFail($id);
        if ($ad) {
            Option::query()->where('id', $id)->delete();
            activity($ad->name)->causedBy(auth('admin')->user())->log(' حذف خيار للوجبة ');

            return "success";
        }
        return "fail";
    }
    public function deleteOffer($id)
    {
        $ad = Meal::query()->findOrFail($id);
        if ($ad) {
            $ad->price_offer = '0';
            activity($ad->name)->causedBy(auth('admin')->user())->log(' حذف عرض من الوجبة ');
            $ad->save();
            return "success";
        }
        return "fail";
    }
    public function exportExcel(Request $request)
    {
        activity()->causedBy(auth('admin')->user())->log(' تصدير ملف إكسل لبيانات الوجبات ');
        return Excel::download(new MealsExportForAdmin($request), 'meals.xlsx');
    }

    public function MealsReportForAdmin(Request $request)
    {
        activity()->causedBy(auth('admin')->user())->log(' تصدير تقرير لبيانات الوجبات ');
        return Excel::download(new MealsReportForAdmin($request), 'meals.xlsx');
    }


}