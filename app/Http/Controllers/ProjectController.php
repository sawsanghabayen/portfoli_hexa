<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Language;
use App\Models\Project;
use App\Traits\imageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{

    use imageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects=Project::all();
        return response()->view('admin.projects.index',['projects'=>$projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('admin.projects.create');
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
            'duration' => 'required|numeric|min:1',
            'technologies' => 'required|string|min:3',
            'url_website' => 'required|url',
            // 'image' => 'nullable|image|mimes:jpg,png|max:2048',

        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }

       
        $this->validate($request, $roles);

        $item= new Project();
        $item->duration=$request->get('duration');
        $item->technologies=$request->get('technologies');
        $item->url_website=$request->get('url_website');

        if ($request->hasFile('image')) {
            $item->image =  $this->storeImage( $request->file('image'), 'projects',null,512);
        }



        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
     

        $isSaved = $item->save();
        
        return redirect()->back()->with('status', __('cp.update'));

    }

  

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        // $categories=Category::all();
        return response()->view('admin.projects.edit',['project'=>$project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $roles = [
            'duration' => 'required|numeric|min:1',
            'technologies' => 'required|string|min:3',
            'url_website' => 'required|url',
            // 'image' => 'nullable|image|mimes:jpg,png|max:2048',

        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
     
        $this->validate($request, $roles);

        $project->duration=$request->get('duration');
        $project->technologies=$request->get('technologies');
        $project->url_website=$request->get('url_website');

        if ($request->hasFile('image')) {
            $project->image =  $this->storeImage( $request->file('image'), 'projects',null,512);
        }




        foreach ($locales as $locale)
        {
            $project->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
       

        $isSaved = $project->save();
    
        return redirect()->back()->with('status', __('cp.update'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $isDeleted = $project->delete();
        if ($isDeleted) {
            Storage::delete($project->image);

           
        }
        return response()->json(
            [
                'title' => $isDeleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $isDeleted ? 'Project deleted successfully' : 'Project deleting failed!',
                'icon' => $isDeleted ? 'success' : 'error'
            ],
            $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }



    }
