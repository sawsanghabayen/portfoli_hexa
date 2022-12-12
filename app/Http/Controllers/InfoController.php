<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Models\Language;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfoController extends Controller
{

    use imageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $infos=Info::all();
        // $languages=Language::all();

        $array =json_decode($infos[0]->languages);
        // $langs_checked=Language::whereIn('lang',$array)->get();
        // $lang_checked=Language::where('lang_code' ,'=','en')->get();
        // dd($array);
        return response()->view('admin.infos.index',['infos'=>$infos ,'array'=>$array]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function show(Info $info)
    {
        //
    }

    public function downloadCV()
    {
        // dd($info->cv);

    $info=Info::first();
    if($info->cv !=null)

    return Storage::download($info->cv);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function edit(Info $info)
    {
        $infos=Info::all();

        $array =json_decode($infos[0]->languages);
        // dd($info->image);

        return response()->view('admin.infos.edit',['info'=>$info ,'array'=>$array]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Info $info)
    {
        $roles = [
      
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10,',
            'email' => 'required|email|unique:admins',
            'nationality' => 'required|string|min:3',
            'experience' => 'required|numeric',
            'freelance_active' => 'nullable',
        
            'facebook_url' => 'required|url',
            'twitter_url' => 'required|url',
            'skybe' => 'required|string|min:3',
            'dribbble' => 'required|string|min:3',
            'youtube_url' => 'required|url',
            'birthdate' => 'required|date',
            // 'image' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            // 'cv' => "required|mimes:pdf|max:10000",

        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['f_name_' . $locale] = 'required|string|min:3';
        }
        foreach ($locales as $locale) {
            $roles['l_name_' . $locale] = 'required|string|min:3';
        }
        foreach ($locales as $locale) {
            $roles['location_' . $locale] = 'required|string|min:3';
        }
        foreach ($locales as $locale) {
            $roles['job_' . $locale] = 'required|string|min:3';
        }

        $this->validate($request, $roles);

        $info->mobile=$request->get('mobile');
        $info->email=$request->get('email');
        $info->nationality = $request->get('nationality');
        $info->experience = $request->get('experience');
        // $array=explode(',', $request->get('languages'));
        $info->languages =$request->get('languages');
        $info->freelance_active = $request->has('freelance_active');
        $info->facebook_url = $request->get('facebook_url');
        $info->twitter_url = $request->get('twitter_url');
        $info->skybe = $request->get('skybe');
        $info->dribbble = $request->get('dribbble');
        $info->youtube_url = $request->get('youtube_url');
        $info->birthdate = $request->get('birthdate');

           if ($request->hasFile('image')) {
            $info->image =  $this->storeImage( $request->file('image'), 'infos',$info->image,null,512);
        }
        if ($request->hasFile('cv')) {

            Storage::delete($info->cv);
            $file = $request->file('cv');
            $cvName =  time().'_info_cv.' . $file->getClientOriginalExtension();
            $status = $request->file('cv')->storePubliclyAs('downloads/files', $cvName);
            $cvPath = 'downloads/files/' . $cvName;
            $info->cv = $cvPath;
        
    }
        foreach ($locales as $locale)
        {
            $info->translateOrNew($locale)->f_name = $request->get('f_name_' . $locale);
        }
        foreach ($locales as $locale)
        {
            $info->translateOrNew($locale)->l_name = $request->get('l_name_' . $locale);
        }
        foreach ($locales as $locale)
        {
            $info->translateOrNew($locale)->location = $request->get('location_' . $locale);
        }
        foreach ($locales as $locale)
        {
            $info->translateOrNew($locale)->job = $request->get('job_' . $locale);
        }

        $info->save();
        
        // return redirect()->back()->with('status', __('cp.create'));
        return redirect()->back()->with('status', __('cp.update'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function destroy(Info $info)
    {
        //
    }
}
