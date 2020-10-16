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
use Illuminate\Support\Str;
use Image;

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
                    $button .= '<a href="' . route('book.images', $data->id) . '" class="dropdown-item" type="button" name="images" id="' . $data->id . '"> <i class="far fa-images m-1"></i> IMAGES </a>';
                    $button .= '<div class="dropdown-divider"></div>';
                    $button .= '<a href="' . route('book.destroy', $data->id) . '" class="dropdown-item" type="button" name="delete" id="' . $data->id . '"> <i class="far fa-trash-alt m-1"></i> DELETE </a>';
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = \Validator::make($request->all(), [
                'isbn' => ['required', 'numeric'],
                'title' => ['required'],
                'publicationDate' => ['required'],
                'weight' => ['required'],
                'wide' => ['required'],
                'long' => ['required'],
                'page' => ['required'],
                'description' => ['required'],
                'author' => ['required'],
                'publisher' => ['required'],
                'language' => ['required'],
                'category' => ['required'],
                'image' => ['required'],
                'image.*' => ['image'],
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

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

                        $image = Image::make($file);
                        $uploadImage = $image->save('public/storage/images/' . $nameFile);

                        $thumbnail = $image->resize(200, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $uploadThumbnail = $thumbnail->save('public/storage/images/thumbnail/' . $nameFile);

                        $bookImg[] =  new BookImg([
                            'name' =>  $nameFile,
                            'description' => $nameFile,
                        ]);
                    }
                }
                $book->BookImg()->saveMany($bookImg);
            }

            return response()->json(['success' => 'save successful']);
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
        // $img = Book::find($book->id)->bookImg;

        // var_dump($book->bookImg->first());
        // var_dump($book->publisher);
        // $author = [];
        // $authorDb = $book->author;
        // if (is_array($authorDb) || is_object($authorDb)) {
        //     foreach ($authorDb as $authorKey => $authorValue) {
        //         $author[$authorValue->id] = $authorValue->name;
        //     }
        // }
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        if ($request->ajax()) {
            $validator = \Validator::make($request->all(), [
                'isbn' => ['required', 'numeric'],
                'title' => ['required'],
                'publicationDate' => ['required'],
                'weight' => ['required'],
                'wide' => ['required'],
                'long' => ['required'],
                'page' => ['required'],
                'description' => ['required'],
                'author' => ['required'],
                'publisher' => ['required'],
                'language' => ['required'],
                'category' => ['required'],
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

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

            return response()->json(['success' => 'save successful']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function images(Book $book)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function imagesUpload(Request $request, Book $book)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
    }
}
