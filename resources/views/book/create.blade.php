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
                <li class="breadcrumb-item active">Form Create</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <span id="form_result"></span>
            <div class="card card-info">
                <div class="card-body">
                    <!-- form start -->
                    {{
                        Form::open([
                            'route' => 'book.store',
                            'method' => 'post',
                            'id' => 'form-create',
                            'class' => 'form form-horizontal',
                            'files' => true,
                        ])
                    }}
                        <div class="form-group row">
                            {{ Form::label('isbn', 'ISBN', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                {{
                                    Form::text('isbn', null, [
                                        'class' => 'form-control',
                                        'placeholder' => 'ISBN',
                                    ])
                                }}
                                <div id="isbnError"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('title', 'Title', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                {{
                                    Form::text('title', null, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Title',
                                    ])
                                }}
                                <div id="titleError"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('publicationDate', 'Publication Date', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                <div class="input-group">
                                    {{
                                        Form::text('publicationDate', null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'Publication Date',
                                        ])
                                    }}
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                <div id="publicationDateError"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('weight', 'Weight', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                {{
                                    Form::number('weight', 0, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Weight',
                                        'step' => 1
                                    ])
                                }}
                                <div id="weightError"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('wide', 'Wide', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                {{
                                    Form::number('wide', 0, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Wide',
                                        'step' => 1
                                    ])
                                }}
                                <div id="wideError"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('long', 'Long', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                {{
                                    Form::number('long', 0, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Long',
                                        'step' => 1
                                    ])
                                }}
                                <div id="longError"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('page', 'Page', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                {{
                                    Form::number('page', 0, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Page',
                                        'step' => 1
                                    ])
                                }}
                                <div id="pageError"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('description', 'Description', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                {{
                                    Form::textarea('description', null, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Description',
                                        'rows' => 3
                                    ])
                                }}
                                <div id="descriptionError"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('author[]', 'Author', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                {{
                                    Form::select('author[]', [], null, [
                                        'id' => 'author',
                                        'class' => 'form-control select-author',
                                        'data-placeholder' => "Select Author",
                                        'style' => "width: 100%;",
                                        'multiple'=>'multiple'
                                    ])
                                }}
                                <div id="authorError"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('publisher', 'Publisher', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                {{
                                    Form::select('publisher', [], null, [
                                        'class' => 'form-control select-publisher',
                                        'data-placeholder' => "Select Publisher",
                                        'style' => "width: 100%;"
                                    ])
                                }}
                                <div id="publisherError"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('language', 'Language', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                {{
                                    Form::select('language', [], null, [
                                        'class' => 'form-control select-language',
                                        'data-placeholder' => "Select Language",
                                        'style' => "width: 100%;"
                                    ])
                                }}
                                <div id="languageError"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('category', 'Category', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                {{
                                    Form::select('category', [], null, [
                                        'class' => 'form-control select-category',
                                        'data-placeholder' => "Select Category",
                                        'style' => "width: 100%;"
                                    ])
                                }}
                                <div id="categoryError"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('image[]', 'Images', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                <div class="custom-file">
                                    {{
                                        Form::file('image[]', [
                                            'id' => 'image',
                                            'class' => 'custom-file-input',
                                            'data-placeholder' => "Upload Image",
                                            'multiple' => 'multiple'
                                        ])
                                    }}
                                    {{ Form::label('image[]', 'Choose image', ['class' => 'custom-file-label']) }}
                                </div>
                                <div id="imageError"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-3 offset-sm-2 col-9 col-sm-9">
                                {{
                                    Form::button('<i class="fas fa-check m-1"></i> <span>Save</span>', [
                                        'type' => 'submit',
                                        'class' => 'btn btn-primary'
                                    ])
                                }}
                                <a href="{{ route('book.index') }}" name="cancel" id="cancel" class="btn btn-default">
                                    <i class="fas fa-times m-1"></i>
                                    <span>Cancel</span>
                                </a>
                            </div>
                        </div>
                    {{ Form::close() }}
                    <!-- form end -->
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

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}" {{ Sri::html('vendor/daterangepicker/daterangepicker.css') }} >
<link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}" {{ Sri::html('vendor/select2/css/select2.min.css') }} >
<link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" {{ Sri::html('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }} >
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}" {{ Sri::html('vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }} >
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
@stop

@section('js')
<script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}" {{ Sri::html('vendor/daterangepicker/daterangepicker.js') }} ></script>
<script src="{{ asset('vendor/select2/js/select2.min.js') }}" {{ Sri::html('vendor/select2/js/select2.min.js') }} ></script>
<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}" {{ Sri::html('vendor/sweetalert2/sweetalert2.min.js') }} ></script>
<script src="{{ asset('vendor/bs-custom-file-input/bs-custom-file-input.min.js') }}" {{ Sri::html('vendor/bs-custom-file-input/bs-custom-file-input.min.js') }} ></script>
<script>
$(function() {
    bsCustomFileInput.init();

    $('input[name="publicationDate"]').daterangepicker({
        autoApply: true,
        drops: 'down',
        locale: {
            format: 'YYYY-MM-DD',
        },
        opens: 'right',
        singleDatePicker: true,
        showDropdowns: true,
    });

    $('.select-author').select2({
        theme: 'bootstrap4',
        maximumInputLength: 10,
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
            cache: true,
            dataType: 'json',
            delay: 250,
            url: "{{ route('author.select') }}",
            type:'get',
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            }
        }
    });

    $('.select-publisher').select2({
        theme: 'bootstrap4',
        maximumInputLength: 10,
        minimumInputLength: 2,
        ajax: {
            cache: true,
            dataType: 'json',
            delay: 250,
            url: "{{ route('publisher.select') }}",
            type:'get',
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            }
        }
    });

    $('.select-language').select2({
        theme: 'bootstrap4',
        maximumInputLength: 10,
        minimumInputLength: 2,
        ajax: {
            cache: true,
            dataType: 'json',
            delay: 250,
            url: "{{ route('language.select') }}",
            type:'get',
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            }
        }
    });

    $('.select-category').select2({
        theme: 'bootstrap4',
        maximumInputLength: 10,
        minimumInputLength: 2,
        ajax: {
            cache: true,
            dataType: 'json',
            delay: 250,
            url: "{{ route('category.select') }}",
            type:'get',
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            }
        }
    });

    $('#form-create').on('submit', function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = new FormData(this);
        var formURL = $(this).attr("action");

		$.ajax({
            url: formURL,
			method: "POST",
			data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $("button").attr("disabled",true);
            },
            complete: function() {
                $("button").attr("disabled",false);
            },
			success:function(data) {
                $("button").attr("disabled",false);
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'save successful',
                    }).then(function (result) {
                        window.location.href = "{{ route('book.index') }}";
                    })
				}
            },
            error: function(jqXhr, json, errorThrown){
                $("button").attr("disabled",false);
                var data = jqXhr.responseJSON;
                $('.alert').hide();
                $.each(data.errors, function( index, value ) {
                    var html = '';
                    html += '<div class="alert alert-danger" role="alert">';
                    html += '<span>' + value + '</span>';
                    html += '</div>';
                    $('#'+index+'Error').html(html);
                });
                Swal.fire({
                    icon: 'error',
                    title: 'Error Validation',
                    text: 'Please check your input',
                });
            }
		});
	});
});
</script>
@stop
