@extends('adminlte::page')

@section('title', 'Category')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Category</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">Book Settings</li>
                <li class="breadcrumb-item">Category</li>
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
                    <h4>Detail</h4>
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{ $category->name }}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>{{ $category->description }}</td>
                            </tr>
                        </tbody>
                    </table>
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
</script>
@stop
