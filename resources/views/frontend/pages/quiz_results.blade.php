@extends('frontend.layouts.master')

@section('container')
    <section class="panel-right-area">
        <div class="panel-detail-area">
          <div class="pannel-detail-heading">
            <h1>Result</h1>
          </div>
          <div class="panel-inner-detail">
            <table id="student_assign">
                <thead>
                    <tr>
                        <th width="30">#</th>
                        <th>Subject</th>
                        <th>Quiz</th>
                        <th>Difficulty</th>
                        <th>Questions</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                  
                  @forelse($quizes as $quiz)
                    <tr>
                        <td>{{ $quiz->id }}</td>
                        <td>{{ $quiz->quiz?->subject?->name }}</td>
                        <td>{{ $quiz->quiz?->name }}</td>
                        <td>{{ $quiz->quiz?->difficulty }}</td>
                        <td>{{ $quiz->quiz?->questions }}</td>
                        <td><a class="table-action-button">{{ $quiz->marks }}</a></td>
                    </tr>
                  @empty
                    <tr>
                        <td colspan="6" align="center">No Data Found</td>
                    </tr>
                  @endforelse
                </tbody>
            </table>
          </div>
        </div>
      </section>
@endsection