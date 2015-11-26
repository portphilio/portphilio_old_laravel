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
        $user = session('user');
        $artifacts = Artifact::where('user_id', $user->id)->get();

        return view('artifacts.index', ['artifacts' => $artifacts]);
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

    public function json(Request $request)
    {
        $actions = <<<AXN
        <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
            <a class="blue" href="%s"><i class="fa fa-search bigger-130"></i></a> 
            <a class="green" href="%s"><i class="fa fa-pencil bigger-130"></i></a>
        </div>
        <div class="visible-xs visible-sm hidden-md hidden-lg">
            <div class="inline position-relative">
                <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-caret-down icon-only bigger-120"></i>
                </button>
                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                    <li>
                        <span class="blue">
                            <a href="%s" class="tooltip-info" data-rel="tooltip" title="View">
                                <i class="fa fa-search bigger-130"></i>
                            </a>
                        </span>
                    </li>
                    <li>
                        <span class="green">
                            <a href="%s" class="tooltip-info" data-rel="tooltip" title="Edit">
                                <i class="fa fa-pencil bigger-130"></i>
                            </a>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
AXN;
        // get the input parameters
        $i = $request->input();
        $user = session('user');

        // parse the parameters and set default values
        $draw = isset($i[ 'draw'   ]) ? $i[ 'draw'   ] : 1;
        $start = isset($i[ 'start'  ]) ? $i[ 'start'  ] : 0;
        $length = isset($i[ 'length' ]) ? $i[ 'length' ] : 10;
        $search = isset($i[ 'search' ][ 'value' ]) && '' != $i[ 'search' ][ 'value' ] ? $i[ 'search' ][ 'value' ] : false;
        $ordrby = isset($i[ 'order'  ]) ? $i[ 'columns' ][ $i[ 'order' ][ 0 ][ 'column' ] ][ 'name' ] : '';
        $ordrdr = isset($i[ 'order'  ]) ? $i[ 'order' ][ 0 ][ 'dir' ] : 'asc';
        $total = Artifact::where('user_id', $user->id)->count();
        $filter = $total;

        // get the data
        if ('' == $search) {
            switch ($ordrby) {
                case 'title':
                    $artifacts = Artifact::skip($start)->take($length)->orderBy('title', $ordrdr)->get();
                    break;
                case 'type':
                    $artifacts = Artifact::skip($start)->take($length)->orderBy('type', $ordrdr)->get();
                    break;
                default:
                    $artifacts = Artifact::skip($start)->take($length)->get();
            }
        } else {
            $artifacts = Artifact::skip($start)->take($length)
                ->where('title', 'ILIKE', '%'.$search.'%')
                ->orWhere('type', 'ILIKE', '%'.$search.'%')->get();
            $filter = Artifact::where('title', 'ILIKE', '%'.$search.'%')
                ->orWhere('type', 'ILIKE', '%'.$search.'%')->count();
        }

        $data = [];
        foreach ($artifacts as $a) {
            $show = route('artifacts.show', $a->id);
            $edit = route('artifacts.edit', $a->id);
            $data[] = [
                'checkbox' => '<label><input type="checkbox" class="ace" value="'.$a->id.'" /><span class="lbl"></span></label>',
                'title' => [
                    'display' => '<a href="'.$edit.'"><img src="'.$a->thumbnail.'"> '.$a->title.'</a>',
                    'filter' => $a->title,
                    'sort' => $a->title,
                ],
                'type' => [
                    'display' => $a->type,
                    'filter' => $a->type,
                    'sort' => $a->type,
                ],
                'actions' => sprintf($actions, $show, $edit, $show, $edit),
            ];
        }

        $adata = [
            'draw' => $draw,
            'recordsTotal' => $total,  //consider caching or setting fixed value for this
            'recordsFiltered' => $filter,
            'data' => $data,
        ];

        return response()->json($adata);
    }
}
