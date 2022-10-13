@extends('frontend.layouts.master')

@section('container')
    <section class="panel-right-area">
        <div class="panel-detail-area">
          <div class="pannel-detail-heading">
            <h1>Take A Quiz</h1>
          </div>
          <div class="panel-inner-detail">
            <table id="student_assign">
                <thead>
                    <tr>
                        <th width="30">#</th>
                        <th>Subject</th>
                        <th>Questions</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                  @forelse($quizes as $quiz)
                    <tr>
                      <td>{{ $quiz->id }}</td>
                      <td>{{ $quiz->quiz->subject->name }}</td>
                      <td>{{ $quiz->quiz->name }}</td>
                      @if($quiz->result?->marks)
                        <td><a class="table-action-button">({{ $quiz->result->marks }})</a></td>
                      @else
                        <td><a href="{{ route('front.quiz.attempt', $quiz->id) }}" class="table-action-button"><i class="fa-solid fa-play"></i> Start Test</a></td>
                      @endif
                    </tr>
                  @empty
                  @endforelse
                </tbody>
            </table>
          </div>
        </div>
      </section>
@endsection