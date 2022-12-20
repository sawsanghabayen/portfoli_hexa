<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Language;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $experiences=experience::all();
        return response()->view('admin.experiences.index',['experiences'=>$experiences]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $experiences = experience::all();

        return response()->view('admin.experiences.create',['experiences'=>$experiences]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $roles = [
            'type_id'=>'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['company_name_' . $locale] = 'required|string|min:3';
        }
        foreach ($locales as $locale) {
            $roles['description_' . $locale] = 'required|string|min:3';
        }
        foreach ($locales as $locale) {
            $roles['experience_name_' . $locale] = 'required|string|min:3';
        }

        $this->validate($request, $roles);

        $item= new experience();
        $item->type_id=$request->get('type_id');
        $item->start_date=$request->get('start_date');
        $item->end_date=$request->get('end_date');

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->company_name = $request->get('company_name_' . $locale);
        }
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->description = $request->get('description_' . $locale);
        }
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->experience_name = $request->get('experience_name_' . $locale);
        }

        $item->save();
        
        return redirect()->back()->with('status', __('cp.create'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function show(Experience $experience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function edit(Experience $experience)
    {
        return response()->view('admin.experiences.edit',['experience'=>$experience]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Experience $experience)
    {
        $roles = [
            'type_id'=>'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['company_name_' . $locale] = 'required';
        }
        foreach ($locales as $locale) {
            $roles['description_' . $locale] = 'required';
        }
        foreach ($locales as $locale) {
            $roles['experience_name_' . $locale] = 'required';
        }

        $this->validate($request, $roles);

        $experience->type_id=$request->get('type_id');

        $experience->start_date=$request->get('start_date');
        $experience->end_date=$request->get('end_date');

        foreach ($locales as $locale)
        {
            $experience->translateOrNew($locale)->company_name = $request->get('company_name_' . $locale);
        }
        foreach ($locales as $locale)
        {
            $experience->translateOrNew($locale)->description = $request->get('description_' . $locale);
        }
        foreach ($locales as $locale)
        {
            $experience->translateOrNew($locale)->experience_name = $request->get('experience_name_' . $locale);
        }

        $experience->save();
        
        // return redirect()->back()->with('status', __('cp.create'));
        return redirect()->back()->with('status', __('cp.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experience $experience)
    {
        $deleted = $experience->delete();
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'experience deleted successfully' : 'experience deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
    
}
