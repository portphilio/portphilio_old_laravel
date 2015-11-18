<?php

namespace Portphilio\Http\Controllers;

use Portphilio\Artifact;
use Illuminate\Http\Request;

class ArtifactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('artifacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => ['required', 'url', 'unique:artifacts,url'],
            'title' => ['required'],
        ], [
            'url.required' => 'The "Link" field is required.',
            'url.url' => 'Please check the URL in your Link and make sure it is correct.',
            'url.unique' => 'It looks like you have already added an artifact with this URL.',
            'title.required' => 'Please supply a meaningful Title for your artifact.',
        ]);

        $artifact = Artifact::create($request->input());

        return redirect()->action('ArtifactController@edit', [$artifact->id])->with('success', 'New artifact added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($artifact = Artifact::find($id)) {
            return view('artifacts.edit', ['artifact' => $artifact]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'url' => ['required', 'url'],
            'title' => ['required'],
        ], [
            'url.required' => 'The "Link" field is required.',
            'url.url' => 'Please check the URL in your Link and make sure it is correct.',
            'title.required' => 'Please supply a meaningful Title for your artifact.',
        ]);

        $artifact = Artifact::find($id);
        $artifact->fill($request->input());
        $artifact->save();

        return redirect()->action('ArtifactController@edit', [$artifact->id])->with('success', 'Artifact updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
