@extends('adminlte::page')

@section('title', 'Publisher')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Publisher</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">Book Settings</li>
                <li class="breadcrumb-item">Publisher</li>
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
                            'route' => 'publisher.store',
                            'method' => 'post',
                            'id' => 'form-create',
                            'class' => 'form form-horizontal',
                            'files' => true,
                        ])
                    }}
                        <div class="form-group row">
                            {{ Form::label('name', 'Name', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                {{
                                    Form::text('name', null, [
                                        'class' => 'form-control',
                                        'placeholder' => 'Name',
                                    ])
                                }}
                                <div id="nameError"></div>
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
                            {{ Form::label('city', 'City', ['class' => 'col-3 col-sm-2 col-form-label']) }}
                            <div class="col-9 col-sm-9">
                                {{
                                    Form::text('city', null, [
                                        'class' => 'form-control',
                                        'placeholder' => 'City',
                                    ])
                                }}
                                <div id="cityError"></div>
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
                                <a href="{{ route('publisher.index') }}" name="cancel" id="cancel" class="btn btn-default">
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
<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}" {{ Sri::html('vendor/sweetalert2/sweetalert2.min.js') }} ></script>
<script>
$(function() {

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
                        window.location.href = "{{ route('publisher.index') }}";
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
