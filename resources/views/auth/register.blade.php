<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('asset/css/style.css')}}" rel="stylesheet" type="text/css">
  </head>
  <body>

    <section class="main-section">
      <div class="container center-container">
        <div class="row">
          <div class="col-12">
            <div class="login-signup-area">
              <div class="row align-items-center">
                <div class="col-md-5">
                  <div class="login-img">
                    <img src="{{ asset('asset/images/login.svg') }}" alt="Login">
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="login-signup-box">
                    <h1>Register</h1>
                    <form action="{{ route('register') }}" class="row" method="POST">
                      @csrf
                      <div class="form-input-container col-12">
                        <div class="register-as-area">
                          <div class="register-as-select">
                            <input type="radio" name="role" id="student" value="student" checked>
                            <label for="student" class="registerAsLabel">Student</label>
                          </div>
                          <div class="register-as-select">
                            <input type="radio" name="role" id="teacher" value="teacher">
                            <label for="teacher" class="registerAsLabel">Teacher</label>
                          </div>
                        </div>
                      </div> 
                      <div class="register-form-fields row m-0">
                        <div class="form-input-container col-md-6">
                          <label>First Name*</label>
                          <input type="text" placeholder="example" name="first_name" class="form-input" required>
                        </div>
                        <div class="form-input-container col-md-6">
                            <label>Last Name*</label>
                            <input type="text" placeholder="example" name="last_name" class="form-input" required>
                          </div>
                        <div class="form-input-container col-md-6">
                          <label>Email*</label>
                          <input type="email" placeholder="student@quiz.com" name="email" class="form-input" required>
                        </div>
                        <div class="form-input-container col-md-6">
                            <label>Subject*</label>
                            <select class="form-input" name="subject" required>
                              <option selected disabled>Select Subject</option>
                              @forelse($subjects as $subject) 
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                              @empty
                              @endforelse
                            </select>
                          </div>
                        <div class="form-input-container col-12">
                          <label>Password*</label>
                          <input type="password" name="password" placeholder="Min. 8 characters" class="form-input" required>
                        </div>
                        <div class="form-input-container col-12">
                          <input type="submit" value="Register" class="form-btn">
                        </div>
                      </div>

                      @if ($errors->any())
                          @foreach ($errors->all() as $error)
                              <div>{{$error}}</div>
                          @endforeach
                      @endif
                    </form>
                    <p class="not-user-text">Already A User? <a href="{{ route('login') }}">Login Now!</a></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <script src="{{ asset('asset/js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>
