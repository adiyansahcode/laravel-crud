@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">Welcome</p>
                </div>
            </div>
        </div>
    </div>
@stop
