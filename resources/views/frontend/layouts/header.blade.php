<section class="panel-left-area">
    <div class="panel-user-area">
      <img src="{{asset('asset/images/user.jpg')}}" alt="User">
      <p>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
      </form>
      <a href="{{ route('logout') }}" onclick="event.preventDefault();
      document.getElementById('logout-form').submit();">Logout</a>
    </div>
    {{-- <div class="panel-tabs-area">
      <h3>Teacher's Panel</h3>
      <ul>
        <li>
          <a href="dashboard.html"><i class="fa-solid fa-list"></i>Students List</a>
        </li>
        <li>
          <a href="viewTestQuestions.html"><i class="fa-solid fa-eye"></i>View Test Questions</a>
        </li>
        <li>
          <a href="addTest.html"><i class="fa-solid fa-plus"></i>Add Test Question</a>
        </li>
      </ul>
    </div> --}}
    <div class="panel-tabs-area">
      <h3>Student's Panel</h3>
      <ul>
        <li>
          <a href="studentDashboard.html" class="active"><i class="fa-solid fa-graduation-cap"></i>Test Results</a>
        </li>
        <li>
          <a href="takeTest.html"><i class="fa-solid fa-book"></i>Take A Test</a>
        </li>
      </ul>
    </div>
  </section>