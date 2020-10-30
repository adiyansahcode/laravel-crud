<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookImg;
use App\Models\Author;
use App\Models\Category;
use App\Models\Language;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Book::latest()
                ->with([
                    'category',
                    'language',
                    'publisher',
                    'bookImg',
                    'author',
                ]);

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
                ->editColumn('publication_date', function ($row) {
                    return [
                        'display' => date("Y-m-d", strtotime($row->publication_date)),
                        'timestamp' => strtotime($row->publication_date),
                    ];
                })
                ->addColumn('action', function ($data) {
                    $button = null;
                    $button .= '<div class="btn-group">';
                    $button .= '<button type="button" class="btn btn-default btn-sm dropdown-toggle" id="action-' . $data->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-ellipsis-v"></i> </button>';
                    $button .= '<div class="dropdown-menu dropdown-menu-right" id="action-' . $data->id . '-menu" aria-labelledby="action-' . $data->id . '">';
                    $button .= '<a href="' . route('book.show', $data->id) . '" class="dropdown-item" type="button" name="view" id="' . $data->id . '"> <i class="far fa-clipboard m-1"></i> VIEW </a>';
                    $button .= '<div class="dropdown-divider"></div>';
                    $button .= '<a href="' . route('book.edit', $data->id) . '" class="dropdown-item" type="button" name="edit" id="' . $data->id . '"> <i class="far fa-edit m-1"></i> EDIT </a>';
                    $button .= '<div class="dropdown-divider"></div>';
                    $button .= '<button class="dropdown-item delete-btn" type="button" name="delete" data-id="' . $data->id . '" id="' . $data->id . '"> <i class="far fa-trash-alt m-1"></i> DELETE </button>';
                    $button .= '</div>';
                    $button .= '</div>';

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('book.index');
    }

    public function authorSelectData(Request $request)
    {
        if ($request->ajax()) {
            if ($request->filled('q')) {
                $search = Str::lower($request->query('q'));
                $data = DB::table('author')
                    ->select('id', 'name')
                    ->whereRaw('LOWER(name) LIKE "%' . $search . '%"')
                    ->get();

                return response()->json($data);
            }
        }
    }

    public function publisherSelectData(Request $request)
    {
        if ($request->ajax()) {
            if ($request->filled('q')) {
                $search = Str::lower($request->query('q'));
                $data = DB::table('publisher')
                    ->select('id', 'name')
                    ->whereRaw('LOWER(name) LIKE "%' . $search . '%"')
                    ->get();

                return response()->json($data);
            }
        }
    }

    public function languageSelectData(Request $request)
    {
        if ($request->ajax()) {
            if ($request->filled('q')) {
                $search = Str::lower($request->query('q'));
                $data = DB::table('language')
                    ->select('id', 'name')
                    ->whereRaw('LOWER(name) LIKE "%' . $search . '%"')
                    ->get();

                return response()->json($data);
            }
        }
    }

    public function categorySelectData(Request $request)
    {
        if ($request->ajax()) {
            if ($request->filled('q')) {
                $search = Str::lower($request->query('q'));
                $data = DB::table('category')
                    ->select('id', 'name')
                    ->whereRaw('LOWER(name) LIKE "%' . $search . '%"')
                    ->get();

                return response()->json($data);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\BookStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
    {
        if ($request->ajax()) {
            $validated = $request->validated();

            $book = new Book();
            $book->isbn = $request->isbn;
            $book->title = $request->title;
            $book->publication_date = $request->publicationDate;
            $book->weight = $request->weight;
            $book->wide = $request->wide;
            $book->long = $request->long;
            $book->page = $request->page;
            $book->description = $request->description;

            $publisher = Publisher::find($request->publisher);
            $book->publisher()->associate($publisher);

            $language = Language::find($request->language);
            $book->language()->associate($language);

            $category = category::find($request->category);
            $book->category()->associate($category);

            $book->save();

            if (is_array($request->author)) {
                $book->author()->attach($request->author);
            } else {
                $author = Author::find($request->author);
                $book->author()->attach([
                    $author->id,
                ]);
            }

            if ($request->hasFile('image')) {
                $bookImg = [];
                foreach ($request->file('image') as $file) {
                    if ($file->isValid()) {
                        $name = $file->getClientOriginalName();
                        $type = $file->getClientMimeType();
                        $path = $file->path();
                        $extension = $file->extension();
                        $nameFile = md5($name . time()) . '.' . $extension;
                        $file->storeAs('public/images', $nameFile);

                        $bookImg[] = new BookImg([
                            'name' => $nameFile,
                            'description' => $nameFile,
                        ]);
                    }
                }
                $book->BookImg()->saveMany($bookImg);
            }

            return response()->json(['success' => 'save success']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('book.show', [
            'book' => $book,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $authorOption = [];
        $authorSelected = [];
        $authorDb = $book->author;
        if (is_array($authorDb) || is_object($authorDb)) {
            foreach ($authorDb as $authorKey => $authorValue) {
                $authorOption[$authorValue->id] = $authorValue->name;
                $authorSelected[] = $authorValue->id;
            }
        }

        return view('book.edit', [
            'book' => $book,
            'authorOption' => $authorOption,
            'authorSelected' => $authorSelected,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BookUpdateRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        if ($request->ajax()) {
            $validated = $request->validated();

            $book->isbn = $request->isbn;
            $book->title = $request->title;
            $book->publication_date = $request->publicationDate;
            $book->weight = $request->weight;
            $book->wide = $request->wide;
            $book->long = $request->long;
            $book->page = $request->page;
            $book->description = $request->description;

            $publisher = Publisher::find($request->publisher);
            $book->publisher()->associate($publisher);

            $language = Language::find($request->language);
            $book->language()->associate($language);

            $category = category::find($request->category);
            $book->category()->associate($category);

            $book->save();

            if (is_array($request->author)) {
                $book->author()->sync($request->author);
            } else {
                $author = Author::find($request->author);
                $book->author()->sync([
                    $author->id,
                ]);
            }

            // if upload has file
            if ($request->hasFile('image')) {
                // get all images and delete
                $imagesDb = $book->bookImg;
                if (is_array($imagesDb) || is_object($imagesDb)) {
                    foreach ($imagesDb as $imagesData) {
                        $imagesDataName = $imagesData->name;
                        if (Storage::disk('public')->exists('images/' . $imagesDataName)) {
                            Storage::disk('public')->delete('images/' . $imagesDataName);
                            $imagesData->delete();
                        }
                    }
                }
                // upload new image
                $bookImg = [];
                foreach ($request->file('image') as $file) {
                    if ($file->isValid()) {
                        $name = $file->getClientOriginalName();
                        $type = $file->getClientMimeType();
                        $path = $file->path();
                        $extension = $file->extension();
                        $nameFile = md5($name . time()) . '.' . $extension;
                        $file->storeAs('public/images', $nameFile);

                        $bookImg[] = new BookImg([
                            'name' => $nameFile,
                            'description' => $nameFile,
                        ]);
                    }
                }
                $book->BookImg()->saveMany($bookImg);
            }

            return response()->json(['success' => 'update success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        // get all images and delete
        $imagesDb = $book->bookImg;
        if (is_array($imagesDb) || is_object($imagesDb)) {
            foreach ($imagesDb as $imagesData) {
                $imagesDataName = $imagesData->name;
                if (Storage::disk('public')->exists('images/' . $imagesDataName)) {
                    Storage::disk('public')->delete('images/' . $imagesDataName);
                    $imagesData->delete();
                }
            }
        }

        // delete book
        $book->delete();

        return response()->json(['success' => 'delete success']);
    }
}
