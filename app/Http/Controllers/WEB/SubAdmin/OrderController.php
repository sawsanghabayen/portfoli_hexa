<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Exports\OrdersExport;
use App\Exports\OrdersExportForProvider;
use App\Exports\OrdersReportForProvider;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Subadmin;
use App\Models\Token;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->locales = Language::all();
        $this->settings = Setting::query()->first();
        view()->share([
            'locales' => $this->locales,
            'settings' => $this->settings,

        ]);


    }
    public function index()
    {
        $items = Order::filter()->where('provider_id',auth('subadmin')->id())->orderBy('id', 'desc')->paginate($this->settings->paginateTotal);
        return view('subadmin.orders.home', [
            'items' =>$items,
        ]);
    }

    public function report()
    {
        $items = Order::filter()->where('provider_id',auth('subadmin')->id())->where('status','4')->orderBy('id', 'desc')->paginate($this->settings->paginateTotal);
        return view('subadmin.orders.report', [
            'items' =>$items,
        ]);
    }

    public function create(){
        $users = User::get();
        $providers = Subadmin::get();

        return view('provider.orders.create')->with(compact('users','providers'));
    }
    public function edit($id)
    {
        $item = Order::where('id',$id)->first();
        return view('subadmin.orders.show', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $roles = [
            'status'=>'required',
        ];
        $this->validate($request, $roles);
        $item = Order::query()->where('id',$id)->first();

        if ($item->status == '4' ||$item->status == '5'){
            return redirect()->back()->with('status', __('cp.update'));
        }


        if ($request->status =='4'){
            $item->status=$request->status;
            $item->save();
            foreach ($item->meals as $one){
                $one->meal->increment('count_selling');
                if (@$one->meal->price_offer > 0){
                    $one->meal->increment('total_selling_amount',$one->meal->price_offer);
                }else{
                    $one->meal->increment('total_selling_amount',$one->meal->price);
                }
            }


        }else{
            $item->status=$request->status;
            $item->save();
        }

        if ($item->status == 1){
            return redirect()->back()->with('status', __('cp.update'));
        }else {
            $message_en = '';
            $message_ar = '';
            if ($item->status == 2) {
                $message_en = 'You order is Being Prepared';
                $message_ar = 'طلبك قيد التحضير';
            } elseif ($item->status == 3) {
                $message_en = 'Your order is Ready for Pick Up';
                $message_ar = 'طلبك جاهز للاستلام';
            } elseif ($item->status == 4) {
                $message_en = 'Your order has been picked up';
                $message_ar = 'تم تسليم طلبك';
            } elseif ($item->status == 5) {
                $message_en = 'Sorry! Your order has been cancelled, please contact our customer service.';
                $message_ar = 'نأسف ! تم الغاء طلبك , يرجى التواصل مع خدمة العملاء';
            }
            $locales = Language::all()->pluck('lang');
            $usersIDs = User::query()->where('notifications', '1')->where('id', $item->user_id)->pluck('id')->toArray();
            $notify = new Notification();

            $notify->translateOrNew('en')->title = 'Order #' . $item->id;
            $notify->translateOrNew('ar')->title = $item->id . 'طلب #';
            $notify->translateOrNew('en')->message = $message_en;
            $notify->translateOrNew('ar')->message = $message_ar;
            $notify->target_id = $item->id;
            $notify->user_id = $item->user_id;
            $notify->fcm_token = $item->fcm_token;
            $notify->type = '2';
            $notify->save();

            $tokens_en = Token::where('lang', 'en')->whereIn('user_id', $usersIDs)->orWhere('fcm_token', $item->fcm_token)->pluck('fcm_token')->toArray();
            $tokens_ar = Token::where('lang', 'ar')->whereIn('user_id', $usersIDs)->orWhere('fcm_token', $item->fcm_token)->pluck('fcm_token')->toArray();
            sendNotificationToUsers($tokens_en, '2', $item->id, 'Order #' . $item->id, $message_en);
            sendNotificationToUsers($tokens_ar, '2', $item->id, $item->id . 'طلب #', $message_ar);
        }
        return redirect()->back()->with('status', __('cp.update'));
    }

    public function changeStatus($id , $status){
        $item = Order::where('id',$id)->first();
        if ($item->status!=4 && $item->status!=5 ){
            $item->status = $status;
            $item->save();
        }

        if ($item->status == 1){
            return redirect()->back();
        }else {
            $message_en = '';
            $message_ar = '';
            if ($item->status == 2) {
                $message_en = 'You order is Being Prepared';
                $message_ar = 'طلبك قيد التحضير';
            } elseif ($item->status == 3) {
                $message_en = 'Your order is Ready for Pick Up';
                $message_ar = 'طلبك جاهز للاستلام';
            } elseif ($item->status == 4) {
                $message_en = 'Your order has been picked up';
                $message_ar = 'تم تسليم طلبك';
            } elseif ($item->status == 5) {
                $message_en = 'Sorry! Your order has been cancelled, please contact our customer service.';
                $message_ar = 'نأسف ! تم الغاء طلبك , يرجى التواصل مع خدمة العملاء';
            }
            $locales = Language::all()->pluck('lang');
            $usersIDs = User::query()->where('notifications', '1')->where('id', $item->user_id)->pluck('id')->toArray();
            $notify = new Notification();

            $notify->translateOrNew('en')->title = 'Order #' . $item->id;
            $notify->translateOrNew('ar')->title = $item->id . 'طلب #';
            $notify->translateOrNew('en')->message = $message_en;
            $notify->translateOrNew('ar')->message = $message_ar;
            $notify->target_id = $item->id;
            $notify->user_id = $item->user_id;
            $notify->fcm_token = $item->fcm_token;
            $notify->type = '2';
            $notify->save();

            $tokens_en = Token::where('lang', 'en')->whereIn('user_id', $usersIDs)->orWhere('fcm_token', $item->fcm_token)->pluck('fcm_token')->toArray();
            $tokens_ar = Token::where('lang', 'ar')->whereIn('user_id', $usersIDs)->orWhere('fcm_token', $item->fcm_token)->pluck('fcm_token')->toArray();
            sendNotificationToUsers($tokens_en, '2', $item->id, 'Order #' . $item->id, $message_en);
            sendNotificationToUsers($tokens_ar, '2', $item->id, $item->id . 'طلب #', $message_ar);

        }
        return redirect()->back();
    }
    public function destroy($id)
    {
        //
        $ad = Order::query()->findOrFail($id);
        if ($ad) {
            Order::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }
    public function exportExcel(Request $request)
    {
        return Excel::download(new OrdersExportForProvider($request), 'orders.xlsx');
    }

    public function OrdersReportForProvider(Request $request)
    {
        return Excel::download(new OrdersReportForProvider($request), 'orders.xlsx');
    }

    public function pdfOrders(Request $request)
    {
        activity()->causedBy(auth('subadmin')->user())->log(' تصدير ملف PDF لبيانات الطلبات ');
        $items = Order::where('provider_id',auth('subadmin')->id())->orderByDesc('id')->get();
        $pdf = PDF::loadView('subadmin.orders.export_pdf', ['items'=>$items]);
        return $pdf->download('orders.pdf');
    }

    public function getNewOrdersCount()
    {
        if (Session::get('provider_total_notifications')){
            return response()->json(Session::get('provider_total_notifications'));
        }
        return response()->json(0);
    }
    public function changeOrdersCount(Request $request)
    {
        $value = $request->value;
        Session::put('provider_total_notifications',$value);
        response()->json('success');
    }


    public function refund($id)
    {
        $order = Order::where('id',$id)->first();
        if ($order){
            if ($order->status == '5'){
                $refund = refund($order->total , $order->payment_id);
                if ($refund->status && $refund->response && $refund->response->Data) {
                    if ($refund->response->IsSuccess && $refund->response->Data->Key == $order->paymentInvoiceId) {
                        $order->payment_status = 2;
                        $order->save();
                    }
                }
            }
        }
        return redirect()->back();
    }


    public function invoice($id){
        $item = Order::where('id',$id)->first();
        return view('subadmin.orders.invoice')->with(compact('item'));
    }


}
