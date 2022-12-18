<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Skill;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills=Skill::all();
        // dd($skills);
        return response()->view('admin.skills.index',['skills'=>$skills]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('admin.skills.create');

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
            'title' => 'required|String|min:3',
            'degree' => 'required|numeric|min:1|max:100',
        ];
       
       

        $this->validate($request, $roles);

        $item= new Skill();
        $item->degree=$request->get('degree');
        $item->title=$request->get('title');
    
     
        $item->save();
        
        return redirect()->back()->with('status', __('cp.create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        return response()->view('admin.skills.edit',['skill'=>$skill]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        $roles = [
            'degree' => 'required|numeric|min:1|max:100',
            'title' => 'required|String|min:3',

        ];
       

        $this->validate($request, $roles);

        $skill->degree=$request->get('degree');
        $skill->title=$request->get('title');



        $skill->save();
        
        return redirect()->back()->with('status', __('cp.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        $deleted = $skill->delete();
        return response()->json(
            [
                'title' => $deleted ? 'Deleted!' : 'Delete Failed!',
                'text' => $deleted ? 'skill deleted successfully' : 'skill deleting failed!',
                'icon' => $deleted ? 'success' : 'error'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
