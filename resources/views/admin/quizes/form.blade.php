@extends('admin.layouts.main')
@section('container')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">

                    @if (Session::has('success') && Session::has('message'))
                        <div class="alert alert-{{ Session::get('success') == 'true' ? 'success' : 'danger' }} alert-dismissible fade show"
                            role="alert">
                            <i class="mdi mdi-check-all me-2"></i>
                            {{ Session::get('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    <h5>Create Quiz</h5>
                    <form action="{{route('quiz.save')}}" class="repeater" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <strong><label for="horizontal-name-input" class="col-sm-3 col-form-label">Subject</label></strong>
                                <div class="col-sm-12">
                                    <select name="subject" class="select2 form-control" required>
                                        <option selected disabled>Select Subject</option>
                                        @forelse($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    
                                    @if ($errors->has('subject'))
                                        <span class="text-danger">{{ $errors->first('subject') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <strong><label for="horizontal-name-input" class="col-sm-3 col-form-label">Name</label></strong>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="name" id="horizontal-name-input" placeholder="Enter Name here">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <strong><label for="horizontal-title-input" class="col-sm-3 col-form-label">Questions</label></strong>
                                <div class="col-sm-12">
                                    <input type="number" min="1" class="form-control" name="question_number" id="horizontal-title-input" placeholder="Enter Questions number here">
                                    @if ($errors->has('question'))
                                        <span class="text-danger">{{ $errors->first('question') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <strong><label for="horizontal-title-input" class="col-sm-12 col-form-label">Time (In minute per Question)</label></strong>
                                <div class="col-sm-12">
                                    <input type="number" min="1" class="form-control" name="time_limit" id="horizontal-title-input" placeholder="Enter Time per question in minutes here">
                                    @if ($errors->has('time'))
                                        <span class="text-danger">{{ $errors->first('time') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br/>

                        <div class="row">
                            <h5>Quiz Questions</h5>
                            <div data-repeater-list="questions" class="mb-3">
                                <div data-repeater-item class="row mb-3">
                                    <div class="col-lg-10 align-self-center">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="text" class="form-control" name="question" placeholder="Add Question here" required>
                                                
                                                <div class="row mt-3">
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" name="answer1" placeholder="Option 1" required>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" name="answer2" placeholder="Option 2" required>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" name="answer3" placeholder="Option 3" required>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" name="answer4" placeholder="Option 4" required>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-lg-4 offset-4">
                                                        <select name="correct_answer" class="select2 form-control" required>
                                                            <option selected disabled>Select Correct Option</option>
                                                            <option value="1">A</option>
                                                            <option value="2">B</option>
                                                            <option value="3">C</option>
                                                            <option value="4">D</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 align-self-center">
                                        <div class="d-grid">
                                            <input data-repeater-delete type="button" class="btn btn-danger" value="Delete"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0 mb-3" value="Add"/>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-12" style="text-align: center;">
                                <button type="submit" class="btn btn-primary w-md">SAVE</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('customScripts')
    <script src="{{ asset('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $(".repeater").repeater({
                show: function () {
                    $(this).slideDown();
                },
                hide: function (e) {
                    if(confirm("Are you sure you want to delete this question?")){
                        $(this).slideUp(e);
                    }
                },
                ready: function (e) {},
            });
        });
    </script>

    <script>
       $(document).ready(function () {
          $(document).find('.select2').select2();          
       });
    </script>

@endpush
