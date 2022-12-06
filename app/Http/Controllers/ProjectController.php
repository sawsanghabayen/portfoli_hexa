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
            'category_id' => 'required',
            'duration' => 'required|numeric|min:1',
            'budget' => 'required|numeric|min:1',
            'technologies' => 'required|string|min:3',
            'url_youtube' => 'nullable|url',
            'url_website' => 'required|url',
            // 'image' => 'nullable|image|mimes:jpg,png|max:2048',
            // 'image_1' => 'nullable|image|mimes:jpg,png|max:2048',
            // 'image_2' => 'nullable|image|mimes:jpg,png|max:2048',
            // 'image_3' => 'nullable|image|mimes:jpg,png|max:2048',
            // 'video' => 'nullable|file|mimetypes:video/mp4|max:20000',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        foreach ($locales as $locale) {
            $roles['client_' . $locale] = 'required';
        }

        $this->validate($request, $roles);

        $item= new Project();
        $item->category_id=$request->get('category_id');
        $item->duration=$request->get('duration');
        $item->budget=$request->get('budget');
        $item->technologies=$request->get('technologies');
        $item->url_youtube=$request->get('url_youtube') ?? '';
        $item->url_website=$request->get('url_website');

        if ($request->hasFile('image')) {
            $item->image =  $this->storeImage( $request->file('image'), 'projects',null,512);
        }
        if ($request->hasFile('video')) {
            // dd(1111);

            $file = $request->file('video');
            
            $videoName =  time().'_project_video.' . $file->getClientOriginalExtension();
            $status = $request->file('video')->storePubliclyAs('videos/projects', $videoName ,['disk' => 'public']);
            $videoPath = 'videos/projects/' . $videoName;
            $item->video = $videoPath;
        
    }



        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->client = $request->get('client_' . $locale);
        }

        $isSaved = $item->save();
        if ($isSaved) {
            // dd(111);
            // $this->saveImage($request, $project, 'image');
            $this->saveImages($request, $item, 'project_image_1');
            $this->saveImages($request, $item, 'project_image_2');
            $this->saveImages($request, $item, 'project_image_3');
        }
        return redirect()->back()->with('status', __('cp.update'));

    }

    private function saveImages(Request $request, Project $project, String $key, bool $update = false)
    {

        if ($request->hasFile($key)) {
            // dd(1111);
            if ($update) {
                foreach ($project->images as $image) {
                    if (str_contains($image->name, $key)) {
                        Storage::delete('images/projects/' . $image->name);
                        $image->delete();
                    }
                }
            }
            $imageName = time() . '_' . str_replace(' ', '', $project->name) . "_project_$key." . $request->file($key)->extension();
            $request->file($key)->storePubliclyAs('images/projects', $imageName, ['disk' => 'public']);

            $image = new Image();
            $image->name = $imageName;
            $image->url = 'projects/' . $imageName;
            $project->images()->save($image);
        }
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
            'category_id' => 'required',
            'duration' => 'required|numeric|min:1',
            'budget' => 'required|numeric|min:1',
            'technologies' => 'required|string|min:3',
            'url_youtube' => 'nullable|url',
            'url_website' => 'required|url',
            // 'image' => 'nullable|image|mimes:jpg,png|max:2048',
            // 'image_1' => 'nullable|image|mimes:jpg,png|max:2048',
            // 'image_2' => 'nullable|image|mimes:jpg,png|max:2048',
            // 'image_3' => 'nullable|image|mimes:jpg,png|max:2048',
            // 'video' => 'nullable|file|mimetypes:video/mp4|max:20000',
        ];
        $locales = Language::all()->pluck('lang');
        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
        }
        foreach ($locales as $locale) {
            $roles['client_' . $locale] = 'required';
        }

        $this->validate($request, $roles);

        $project->category_id=$request->get('category_id');
        $project->duration=$request->get('duration');
        $project->budget=$request->get('budget');
        $project->technologies=$request->get('technologies');
        $project->url_youtube=$request->get('url_youtube') ?? '';
        $project->url_website=$request->get('url_website');

        if ($request->hasFile('image')) {
            $project->image =  $this->storeImage( $request->file('image'), 'projects',null,512);
        }
        if ($request->hasFile('video')) {
            // dd(111);
            Storage::delete($project->video);


            $file = $request->file('video');
            $videoName =  time().'_project_video.' . $file->getClientOriginalExtension();
            $status = $request->file('video')->storePubliclyAs('videos/projects', $videoName);
            $videoPath = 'videos/projects/' . $videoName;
            $project->video = $videoPath;
        
    }



        foreach ($locales as $locale)
        {
            $project->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
        foreach ($locales as $locale)
        {
            $project->translateOrNew($locale)->client = $request->get('client_' . $locale);
        }

        $isSaved = $project->save();
        if ($isSaved) {
            // dd(111);
            // $this->saveImage($request, $project, 'image');
            $this->saveImages($request, $project, 'project_image_1' ,true);
            $this->saveImages($request, $project, 'project_image_2',true);
            $this->saveImages($request, $project, 'project_image_3',true);
        }
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

            if($project->video !=null)
            Storage::delete($project->video);
            
            // $this->deleteImage($Project);
            if($project->images !=null)

            $this->deleteImages($project);
        }
        return response()->json(
            [
                'title' => $isDeleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $isDeleted ? 'Project deleted successfully' : 'Project deleting failed!',
                'icon' => $isDeleted ? 'success' : 'error'
            ],
            $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }

    private function deleteImages(Project $Project)
    {
        foreach ($Project->images as $image) {
            Storage::delete('images/projects/' .$image->name);
            $image->delete();
        }
    }

    }
