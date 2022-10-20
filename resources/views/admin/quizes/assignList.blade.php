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
                    <h5>Quiz Assigned List</h5>
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
                    <table id="assigned_list" class="table table-bordered table-condensed table-striped"
                        style="font-size: small;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Quiz</th>
                                <th>Result</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
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
            var modal = $('.modal');
            var form = $('.form');
            var btnAdd = $('.add'),
                btnSave = $('.btn-save'),
                btnUpdate = $('.btn-update');
                btnView = $('.btn-view');

            var table = $('#assigned_list').DataTable({
                ajax: route('quiz.assign.list'),
                serverSide: true,
                processing: true,
                aaSorting: [
                    [0, "desc"]
                ],
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'student',
                        name: 'student'
                    },
                    {
                        data: 'quiz',
                        name: 'quiz'
                    },
                    {
                        data: 'result',
                        name: 'result'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }
                ],
                'createdRow': function(row, data) {
                    $(row).attr('id', data.id)
                },
                "bDestroy": true
            });
        });
    </script>
@endpush