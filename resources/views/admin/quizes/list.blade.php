@extends('admin.layouts.main')
@section('container')
    <style>
        #hvt:hover { transform: scale(3.5); }
    </style>

    <div class="row">
        @if (Session::has('success') && Session::has('message'))
            <div class="alert alert-{{ Session::get('success') == 'true' ? 'success' : 'danger' }} alert-dismissible fade show"
                role="alert">
                <i class="mdi mdi-check-all me-2"></i>
                {{ Session::get('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="col-md-12 message"></div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Quiz List</h5>
                    <h3>
                        @can('Subscriber-Create')
                            <h3>
                                <a href="{{ route('quiz.add') }}" class="btn btn-xs btn-success float-right add">Add Subject</a>
                                <a href="{{ route('quiz.list') }}" class="btn btn-xs btn-primary">All Subject</a>
                                <a href="{{ route('quiz.list.trashed') }}"class="btn btn-xs btn-danger">Trash</a>

                            </h3>
                        @endcan
                    </h3>
                    <hr>
                    <table id="subject" class="table table-bordered table-condensed table-striped"
                        style="font-size: small;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Name</th>
                                <th>Questions</th>
                                <th>Difficulty</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="modal fade orderdetailsModal" id="modal" tabindex="-1" role="dialog"
                        aria-labelledby="orderdetailsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="orderdetailsModalLabel"> View Subject</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap">
                                            <thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">
                                                        <div>
                                                            <h5 class="text-truncate font-size-14">ID</h5>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div>
                                                            <h5 class="text-truncate font-size-14 " id="id"></h5>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div>
                                                            <h5 class="text-truncate font-size-14">Name</h5>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div>
                                                            <h5 class="text-truncate font-size-14 badge badge-pill badge-soft-success font-size-12"
                                                                id="name"></h5>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div>
                                                            <h5 class="text-truncate font-size-14">Subject</h5>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div>
                                                            <h5 class="text-truncate font-size-14 badge badge-pill badge-soft-success font-size-12"
                                                                id="subjectName"></h5>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div>
                                                            <h5 class="text-truncate font-size-14">Questions</h5>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div>
                                                            <h5 class="text-truncate font-size-14" id="questions"></h5>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div>
                                                            <h5 class="text-truncate font-size-14">Difficulty</h5>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div>
                                                            <h5 class="text-truncate font-size-14" id="difficulty"></h5>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customScripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            // $.noConflict();

            var modal = $('.modal')
            var form = $('.form')
            var btnAdd = $('.add'),
                btnSave = $('.btn-save'),
                btnUpdate = $('.btn-update');
                btnView = $('.btn-view');

            var table = $('#subject').DataTable({
                ajax: route('quiz.list'),
                serverSide: true,
                processing: true,
                aaSorting: [
                    [0, "desc"]
                ],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },{
                        data: 'subject.name',
                        name: 'subject'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'questions',
                        name: 'questions'
                    },
                    {
                        data: 'difficulty',
                        name: 'difficulty'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                'createdRow': function(row, data) {
                    $(row).attr('id', data.id)
                },
                "bDestroy": true
            });

            // update ajax
            $(document).on('click', '.btn-view', function() {
                $.ajax({
                    url: route('quiz.view'),
                    type: "get",
                    data: {
                        id: $(this).data('id')
                    },
                    success: function(data) {
                        let quizData = data.data;
                        $('#id').html(quizData.id);
                        $('#subjectName').html(quizData.subject.name);
                        $('#name').html(quizData.name);
                        $('#questions').html(quizData.questions);
                        $('#difficulty').html(quizData.difficulty);
                    }
                });
            });

            // delete ajax
            $(document).on('click', '.remove', function() {
                var id = $(this).data('id')
                var el = $(this)
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    confirmButtonClass: "btn btn-success mt-2",
                    cancelButtonClass: "btn btn-danger ms-2 mt-2",
                    buttonsStyling: !1
                }).then(function(t) {
                    if (t.value) {
                        if (!id) return;
                        $.ajax({
                            url: route('quiz.remove'),
                            type: "POST",
                            data: {
                                id: id
                            },
                            dataType: 'JSON',

                            success: function(data) {
                                console.log(data);
                                if ($.isEmptyObject(data.error)) {
                                    let table = $('#subject').DataTable();
                                    table.row('#' + id).remove().draw(false)
                                    showMsg("success", data.message);
                                } else {
                                    printErrorMsg(data.error);
                                }
                            }
                        });

                    }

                })
            })
        })
        $(document).on('change', '.banner_status', function(e) {
        let id = $(this).attr("data-id");
        let status = $(this).is(':checked');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, Update it!",
            cancelButtonText: "No, cancel!",
            confirmButtonClass: "btn btn-success mt-2",
            cancelButtonClass: "btn btn-danger ms-2 mt-2",
            buttonsStyling: !1
        }).then(function(t) {
            if (t.value) {
                if (!id) return;
                $.ajax({
                    url: route('quiz.status',[id]),
                    type: "POST",
                    data: {
                        id: id,
                        status: status
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        showMsg("success", data.message);
                        table.ajax().reload();
                    }
                });

            } else {
            }
        })
    });
    </script>
@endpush
