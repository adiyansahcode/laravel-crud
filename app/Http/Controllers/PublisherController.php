<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\PublisherStoreRequest;
use App\Http\Requests\PublisherUpdateRequest;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Publisher::latest();

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
                    $button .= '<a href="' . route('publisher.show', $data->id) . '" class="dropdown-item" type="button" name="view" id="' . $data->id . '"> <i class="far fa-clipboard m-1"></i> VIEW </a>';
                    $button .= '<div class="dropdown-divider"></div>';
                    $button .= '<a href="' . route('publisher.edit', $data->id) . '" class="dropdown-item" type="button" name="edit" id="' . $data->id . '"> <i class="far fa-edit m-1"></i> EDIT </a>';
                    $button .= '<div class="dropdown-divider"></div>';
                    $button .= '<button class="dropdown-item delete-btn" type="button" name="delete" data-id="' . $data->id . '" id="' . $data->id . '"> <i class="far fa-trash-alt m-1"></i> DELETE </button>';
                    $button .= '</div>';
                    $button .= '</div>';

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('publisher.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('publisher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\PublisherStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PublisherStoreRequest $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();

            $publisher = new Publisher();
            $publisher->name = $request->name;
            $publisher->description = $request->description;
            $publisher->city = $request->city;
            $publisher->save();

            return response()->json(['success' => 'save success']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        return view('publisher.show', [
            'publisher' => $publisher,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit(Publisher $publisher)
    {
        return view('publisher.edit', [
            'publisher' => $publisher,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PublisherUpdateRequest  $request
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(PublisherUpdateRequest $request, Publisher $publisher)
    {
        if ($request->ajax()) {
            $validated = $request->validated();

            $publisher->name = $request->name;
            $publisher->description = $request->description;
            $publisher->city = $request->city;
            $publisher->save();

            return response()->json(['success' => 'save success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publisher $publisher)
    {
        // delete publisher
        $publisher->delete();

        return response()->json(['success' => 'delete success']);
    }
}
