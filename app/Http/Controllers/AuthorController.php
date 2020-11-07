<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Author::latest();

            return datatables()
                ->of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return [
                        'display' => date("Y-m-d H:i:s", strtotime($row->created_at)),
                        'timestamp' => strtotime($row->created_at),
                    ];
                })
                ->editColumn('updated_at', function ($row) {
                    return [
                        'display' => date("Y-m-d H:i:s", strtotime($row->updated_at)),
                        'timestamp' => strtotime($row->updated_at),
                    ];
                })
                ->addColumn('action', function ($data) {
                    $button = null;
                    $button .= '<div class="btn-group">';
                    $button .= '<button type="button" class="btn btn-default btn-sm dropdown-toggle" id="action-' . $data->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-ellipsis-v"></i> </button>';
                    $button .= '<div class="dropdown-menu dropdown-menu-right" id="action-' . $data->id . '-menu" aria-labelledby="action-' . $data->id . '">';
                    $button .= '<a href="' . route('author.show', $data->id) . '" class="dropdown-item" type="button" name="view" id="' . $data->id . '"> <i class="far fa-clipboard m-1"></i> VIEW </a>';
                    $button .= '<div class="dropdown-divider"></div>';
                    $button .= '<a href="' . route('author.edit', $data->id) . '" class="dropdown-item" type="button" name="edit" id="' . $data->id . '"> <i class="far fa-edit m-1"></i> EDIT </a>';
                    $button .= '<div class="dropdown-divider"></div>';
                    $button .= '<button class="dropdown-item delete-btn" type="button" name="delete" data-id="' . $data->id . '" id="' . $data->id . '"> <i class="far fa-trash-alt m-1"></i> DELETE </button>';
                    $button .= '</div>';
                    $button .= '</div>';

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('author.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('author.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\AuthorStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorStoreRequest $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();

            $author = new Author();
            $author->name = $request->name;
            $author->description = $request->description;
            $author->save();

            return response()->json(['success' => 'save success']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        return view('author.show', [
            'author' => $author,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        return view('author.edit', [
            'author' => $author,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorUpdateRequest $request, Author $author)
    {
        if ($request->ajax()) {
            $validated = $request->validated();

            $author->name = $request->name;
            $author->description = $request->description;
            $author->save();

            return response()->json(['success' => 'save success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        // delete author
        $author->delete();

        return response()->json(['success' => 'delete success']);
    }
}
