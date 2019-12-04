<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalSemestersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('localSemesters.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas = \App\LocalSemester::with('user')->orderBy('id', 'desc')->get();
        return response()->json($datas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = $request->title;
        $content = $request->content;
        $id = auth()->user()->id;
        $localSemester = \App\User::find($id)->local_semesters()->create([
           'title'=>$title,
           'content'=>$content,
        ]);
        $data = \App\LocalSemester::where('id',$localSemester->id)->with('user')->get();
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = \App\LocalSemester::where('id', $id)->with('user')->get();
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    public function update(Request $request, \App\LocalSemester $localSemester)
    {           
        $localSemester->update($request->all());
        // flash()->success('수정하신 내용을 저장했습니다.');

        return response()->json([], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\LocalSemester $localSemester)
    {
        $localSemester->delete();
        return response()->json([], 204);
    }
}
