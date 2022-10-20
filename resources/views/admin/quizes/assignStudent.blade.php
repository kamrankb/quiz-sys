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
                    <h5>Assign Quiz</h5>
                    <form action="{{route('quiz.assign.save')}}" class="repeater" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <strong><label for="horizontal-name-input" class="col-sm-3 col-form-label">Quiz</label></strong>
                                <div class="col-sm-12">
                                    <select name="quiz" class="select2 form-control" required>
                                        <option selected disabled>Select Subject</option>
                                        @forelse($quizes as $quiz)
                                            <option value="{{ $quiz->id }}" {{ ($quiz_id!="" && $quiz_id == $quiz->id) ? 'selected' : '' }}>{{ $quiz->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    
                                    @if ($errors->has('quiz'))
                                        <span class="text-danger">{{ $errors->first('quiz') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <strong><label for="horizontal-name-input" class="col-sm-3 col-form-label">Student</label></strong>
                                <div class="col-sm-12">
                                    <select name="student" class="select2 form-control" required>
                                        <option selected disabled>Select Student</option>
                                        @forelse($students as $student)
                                            <option value="{{ $student->id }}">{{ $student->first_name." ".$student->last_name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @if ($errors->has('student'))
                                        <span class="text-danger">{{ $errors->first('student') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br/>

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
