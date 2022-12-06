<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Language;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use imageTrait;

    public function index()
    {
        $educations=Education::all();
        return response()->view('admin.educations.index',['educations'=>$educations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $languages = Language::all();
        $educations = Education::all();

        return response()->view('admin.educations.create',['educations'=>$educations]);
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
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['company_name_' . $locale] = 'required';
        }
        foreach ($locales as $locale) {
            $roles['description_' . $locale] = 'required';
        }
        foreach ($locales as $locale) {
            $roles['education_name_' . $locale] = 'required';
        }

        $this->validate($request, $roles);

        $item= new Education();
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
            $item->translateOrNew($locale)->education_name = $request->get('education_name_' . $locale);
        }

        $item->save();
        
        return redirect()->back()->with('status', __('cp.create'));



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function show(Education $education)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function edit(Education $education)
    {
             return response()->view('admin.educations.edit',['education'=>$education]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Education $education)
    {
        $roles = [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['company_name_' . $locale] = 'required';
        }
        foreach ($locales as $locale) {
            $roles['description_' . $locale] = 'required';
        }
        foreach ($locales as $locale) {
            $roles['education_name_' . $locale] = 'required';
        }

        $this->validate($request, $roles);

        // $item= new Education();
        $education->start_date=$request->get('start_date');
        $education->end_date=$request->get('end_date');

        foreach ($locales as $locale)
        {
            $education->translateOrNew($locale)->company_name = $request->get('company_name_' . $locale);
        }
        foreach ($locales as $locale)
        {
            $education->translateOrNew($locale)->description = $request->get('description_' . $locale);
        }
        foreach ($locales as $locale)
        {
            $education->translateOrNew($locale)->education_name = $request->get('education_name_' . $locale);
        }

        $education->save();
        
        // return redirect()->back()->with('status', __('cp.create'));
        return redirect()->back()->with('status', __('cp.update'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function destroy(Education $education)
    {
        $deleted = $education->delete();
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'Education deleted successfully' : 'Education deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
    
}
