@extends('adminlte::page')

@section('title', 'Book')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Book</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">Book Settings</li>
                <li class="breadcrumb-item">Book</li>
                <li class="breadcrumb-item active">View</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <h3 class="d-inline-block d-sm-none">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
                            <div class="col-12">
                                @if($book->bookImg->first() !== null)
                                    <img src="{{ asset('public/storage/images/' . $book->bookImg->first()->name) }}" class="product-image" alt="{{ $book->bookImg->first()->description }}">
                                @else
                                    <img src="https://via.placeholder.com/500" class="product-image" alt="image">
                                @endif
                            </div>
                            <div class="col-12 product-image-thumbs">
                                @forelse($book->bookImg as $img)
                                    <div class="product-image-thumb" >
                                        <img src="{{ asset('public/storage/images/' . $img->name) }}" alt="{{ $img->description }}">
                                    </div>
                                @empty
                                    <div class="product-image-thumb" >
                                        <img src="https://via.placeholder.com/500" alt="image">
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 offset-sm-1">
                            <h3 class="my-3">{{ $book->title }}</h3>
                            <p>{{ $book->description }}</p>
                            <hr>
                            <h4>Detail</h4>
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td>isbn</td>
                                        <td>{{ $book->isbn }}</td>
                                    </tr>
                                    <tr>
                                        <td>Date Publication</td>
                                        <td>{{ $book->publication_date }}</td>
                                    </tr>
                                    <tr>
                                        <td>Category</td>
                                        <td>{{ $book->category->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Book Weight</td>
                                        <td>{{ $book->weight }}</td>
                                    </tr>
                                    <tr>
                                        <td>Book Wide</td>
                                        <td>{{ $book->wide }}</td>
                                    </tr>
                                    <tr>
                                        <td>Book Long</td>
                                        <td>{{ $book->long }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Book Page</td>
                                        <td>{{ $book->page }}</td>
                                    </tr>
                                    <tr>
                                        <td>Language</td>
                                        <td>{{ $book->language->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Publisher</td>
                                        <td>{{ $book->publisher->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Author</td>
                                        <td>
                                            @forelse($book->author as $author)
                                                @if (!$loop->first)
                                                    , {{ $author->name }}
                                                @else
                                                    {{ $author->name }}
                                                @endif
                                            @empty
                                                -
                                            @endforelse
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@stop


@section('footer')
    <strong>{{ config('app.name') }}
    <div class="float-right d-none d-sm-block">
        <a href="http://adiyansahcode.id/">adiyansahcode</a>
    </div>
@stop

@section('js')
<script>
$(function() {
    $('.product-image-thumb').on('click', function() {
        const image_element = $(this).find('img');
        $('.product-image').prop('src', $(image_element).attr('src'))
        $('.product-image-thumb.active').removeClass('active');
        $(this).addClass('active');
    });
});
</script>
@stop
