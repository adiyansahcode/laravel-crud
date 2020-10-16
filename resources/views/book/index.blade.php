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
                <li class="breadcrumb-item active">Book</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('book.create') }}" name="create" id="create" class="btn btn-primary fs-it-btn">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        <span class="fs-it-btn-vertical-line"></span>
                        CREATE
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="input-group">
                                <input class="form-control border-right-0 border" type="text" placeholder="search" id="search">
                                <span class="input-group-append">
                                    <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                                </span>
                            </div>
                        </div>
                    </div>
                    <table id="data-table" class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>ISBN</th>
                                <th>Title</th>
                                <th>Publication Date</th>
                                <th>Publisher</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th></th>
                            </tr>
                        </thead>
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

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" {{ Sri::html('vendor/datatables/css/dataTables.bootstrap4.min.css') }} >
<link rel="stylesheet" href="{{ asset('vendor/datatables-plugins/responsive/css/responsive.bootstrap4.min.css') }}" {{ Sri::html('vendor/datatables-plugins/responsive/css/responsive.bootstrap4.min.css') }} >
<link rel="stylesheet" href="{{ asset('vendor/datatables-plugins/fixedheader/css/fixedHeader.bootstrap4.min.css') }}" {{ Sri::html('vendor/datatables-plugins/fixedheader/css/fixedHeader.bootstrap4.min.css') }} >
<link rel="stylesheet" href="{{ asset('vendor/datatables-plugins/select/css/select.bootstrap4.min.css') }}" {{ Sri::html('vendor/datatables-plugins/select/css/select.bootstrap4.min.css') }} >
<link rel="stylesheet" href="{{ asset('vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}" {{ Sri::html('vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }} >
<style>
    .dropdown-toggle::after {
        display: none;
    }
    .fs-it-btn {
        margin-top: 10px;
        border-radius: 0;
        color: #fff;
        font-weight: bold;
    }
    .fs-it-btn-vertical-line {
        text-align:center;
        padding: 4px 0 5px 10px;
        margin-left: 10px;
        border-left: 1px solid #fff;
    }
    .dataTables_processing {
        top: 64px !important;
        z-index: 11000 !important;
    }
</style>
@stop

@section('js')
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}" {{ Sri::html('vendor/datatables/js/jquery.dataTables.min.js') }} ></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}" {{ Sri::html('vendor/datatables/js/dataTables.bootstrap4.min.js') }} ></script>
<script src="{{ asset('vendor/datatables-plugins/responsive/js/dataTables.responsive.min.js') }}" {{ Sri::html('vendor/datatables-plugins/responsive/js/dataTables.responsive.min.js') }} ></script>
<script src="{{ asset('vendor/datatables-plugins/responsive/js/responsive.bootstrap4.min.js') }}" {{ Sri::html('vendor/datatables-plugins/fixedheader/js/responsive.bootstrap4.min.js') }} ></script>
<script src="{{ asset('vendor/datatables-plugins/fixedheader/js/dataTables.fixedHeader.min.js') }}" {{ Sri::html('vendor/datatables-plugins/fixedheader/js/dataTables.fixedHeader.min.js') }} ></script>
<script src="{{ asset('vendor/datatables-plugins/fixedheader/js/fixedHeader.bootstrap4.min.js') }}" {{ Sri::html('vendor/datatables-plugins/fixedheader/js/fixedHeader.bootstrap4.min.js') }} ></script>
<script src="{{ asset('vendor/datatables-plugins/select/js/dataTables.select.min.js') }}" {{ Sri::html('vendor/datatables-plugins/select/js/dataTables.select.min.js') }} ></script>
<script src="{{ asset('vendor/datatables-plugins/select/js/select.bootstrap4.min.js') }}" {{ Sri::html('vendor/datatables-plugins/select/js/select.bootstrap4.min.js') }} ></script>
<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}" {{ Sri::html('vendor/sweetalert2/sweetalert2.min.js') }} ></script>
<script>
$(function() {
    $.fn.DataTable.ext.pager.numbers_length = 5;

    var table = $('#data-table').DataTable({
        ajax: {
            url: "{{ route('book.index') }}",
        },
        autoWidth: false,
        columns: [
            {
                name: 'DT_RowIndex',
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                name: 'created_at',
                data: {
                    _: 'created_at.display',
                    'sort': 'created_at.timestamp'
                }
            },
            {
                name: 'updated_at',
                data: {
                    _: 'updated_at.display',
                    sort: 'updated_at.timestamp'
                }
            },
            { name: 'isbn', data: 'isbn' },
            { name: 'title', data: 'title' },
            {
                name: 'publication_date',
                data: {
                    _: 'publication_date.display',
                    'sort': 'publication_date.timestamp'
                }
            },
            { name: 'publisher.name', data: 'publisher.name'},
            { name: 'author.name', data: 'author[, ].name'},
            { name: 'category.name', data: 'category.name'},
            { name: 'action', data: 'action', orderable: false, searchable: false },
        ],
        columnDefs: [
            { className: "align-middle", targets: "_all" },
        ],
        deferRender: true,
        dom:    "<'row'<'col-6'l><'col-6'p>>" +
                "<'row'<'col-12'tr>>" +
                "<'row'<'col-6'i><'col-6'p>>",
        fixedHeader: {
            header: true,
        },
        language: {
            lengthMenu: "Show _MENU_",
            searchPlaceholder: "Search",
            search: "",
            processing: '<i class="fas fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
        },
        lengthChange: true,
        order: [1,'desc'],
        pageLength: 50,
        pagingType: 'simple_numbers',
        processing: true,
        responsive: true,
        searching: true,
        serverSide: true,
        select: false
    });

    $('#search').keyup(function(e){
        if (e.keyCode == 13) {
            table.search($(this).val()).draw() ;
        }
    });

    table.on('page.dt', function() {
        $('html, body').animate({
            scrollTop: $('#data-table').offset().top
        }, 'fast');
        $('thead tr th:first-child').focus();
        $( "#search" ).focus();
    });

    table.on('click', '.delete-btn[data-id]', function (e) {
        e.preventDefault();
        var id = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure ?',
            icon: 'warning',
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.dismiss !== Swal.DismissReason.cancel) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "book/" + id,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                }).always(function (data) {
                    table.draw(false);
                });

                Swal.fire(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success'
                )
            }
        })
    });

});
</script>
@stop
