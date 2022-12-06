<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Models\Subadmin;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function index()
    {
        $sales_this_day = Order::whereDate('created_at', Carbon::today())->where('status','4')->where('provider_id',auth('subadmin')->id())->sum('total');
        $orders_this_day = Order::whereDate('created_at', Carbon::today())->where('provider_id',auth('subadmin')->id())->count();
        $avg = round(Order::where('status','!=','5')->where('provider_id',auth('subadmin')->id())->average('total'),2);
        $total_sales = Order::where('status','!=','5')->where('provider_id',auth('subadmin')->id())->sum('total');
        $total_orders = Order::where('provider_id',auth('subadmin')->id())->count();
        $confirmed_orders = Order::where('status','1')->where('provider_id',auth('subadmin')->id())->count();
        $under_preparing_orders = Order::where('status','2')->where('provider_id',auth('subadmin')->id())->count();
        $ready_to_pick_orders = Order::where('status','3')->where('provider_id',auth('subadmin')->id())->count();
        $completed_orders = Order::where('status','4')->where('provider_id',auth('subadmin')->id())->count();
        $canceled_orders = Order::where('status','5')->where('provider_id',auth('subadmin')->id())->count();


        return view('subadmin.home')->with(compact('sales_this_day','orders_this_day'
        ,'avg','total_sales','total_orders'
        ,'confirmed_orders','under_preparing_orders','ready_to_pick_orders','completed_orders','canceled_orders'));
    }


    public function changeStatus($model, Request $request)
    {
        $role = "";
        if ($model == "admins") $role = 'App\Models\Admin';
        if ($model == "categories") $role = 'App\Models\Category';
        if ($model == "meals") $role = 'App\Models\Meal';
        if ($model == "option_values") $role = 'App\Models\OptionValue';
        if ($model == "promo_codes") $role = 'App\Models\PromoCode';
        if ($model == "orders") $role = 'App\Models\Order';
        if ($model == "cuisines") $role = 'App\Models\Cuisine';
        if ($model == "banners") $role = 'App\Models\Banner';
        if ($model == "contacts") $role = 'App\Models\Contact';
        if ($model == "roles") $role = 'App\Models\Role';

        if ($role != "") {
            if ($request->action == 'delete') {
                $role::query()->whereIn('id', $request->IDsArray)->delete();
            } else {
                if ($request->action) {
                    $role::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->action]);
                }
            }

            return $request->action;
        }
        return false;


    }


}
