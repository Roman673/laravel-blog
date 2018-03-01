<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index',]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tags.index', [
            'tags' => Tag::all(),
            'title' => 'Tags',
            'breadcrumbs' => [
                ['Home', '/'],
                ['Tags', ''],
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = [
            'primary',
            'secondary',
            'success',
            'warning',
            'danger',
            'info',
            'light',
            'dark',
        ];

        return view('tags.create', [
            'statuses' => $statuses,
            'title' => 'Creating tag',
            'breadcrumbs' => [
                ['Home', '/'],
                ['Tags', '/tags'],
                ['Creating tag', ''],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $statuses = [
            'primary',
            'secondary',
            'success',
            'warning',
            'danger',
            'info',
            'light',
            'dark',
        ];

        $this->validate($request, [
            'name' => [
                'required',
                'unique:tags',
                'max:10',
            ],
            'status' => [
                'required',
                Rule::in($statuses),
            ],
        ]);

        $tag = new Tag;
        $tag->name = $request->input('name');
        $tag->status = $request->input('status');
        $tag->save();

        return redirect()->route('tags.index')->with('success', 'Tag created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
