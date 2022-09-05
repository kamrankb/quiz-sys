@extends('admin.layouts.main')
@section('container')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">ADD NEW USERS</h4>
                @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                    @php
                    Session::forget('success');
                    @endphp
                </div>
                @endif
                <form action="{{route('user.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            @can('User-Create')
                            <a href="{{route('user.add')}}" class="btn btn-xs btn-success float-right add">Add User</a>
                            @endcan
                            @can('User-View')
                            <a href="{{route('user.list')}}" class="btn btn-xs btn-primary float-right add">All Users</a>
                            @endcan
                            @can('User-Delete')
                            <a href="{{route('user.list.trashed')}}" class="btn btn-xs btn-danger float-right add">Trash</a>
                            @endcan
                            <div class="row">
                                <div class="col-sm-12">
                                    <strong><label for="horizontal-name-input" class="col-sm-3 col-form-label">Roles</label></strong>
                                    <select class="form-control select2" name="roles" id="roles">
                                        <option value="" selected disabled>Select Roles</option>
                                        @forelse($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @if ($errors->has('roles'))
                                    <span class="text-danger">{{ $errors->first('roles') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong><label for="horizontal-first_name-input" class="col-sm-3 col-form-label">First Name</label></strong>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="first_name" id="horizontal-first_name-input" placeholder="Enter First Name here">
                                        @if ($errors->has('first_name'))
                                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                        @endif

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <strong><label for="horizontal-last_name-input" class="col-sm-3 col-form-label">Last Name</label></strong>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="last_name" id="horizontal-last_name-input" placeholder="Enter Last Name here">
                                        @if ($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong><label for="horizontal-email-input" class="col-sm-3 col-form-label">Email</label></strong>
                                    <div class="col-sm-12">
                                        <input type="email" class="form-control" placeholder="Enter Email here" name="email" id="horizontal-email-input">
                                        @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <strong><label for="horizontal-phone_number-input" class="col-sm-3 col-form-label">Number</label></strong>
                                    <div class="col-sm-12">
                                        <input class="form-control phone_number" name="phone_number" id="phone_number" placeholder="Enter  Number here">
                                        @if ($errors->has('phone_number'))
                                        <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong><label for="horizontal-state-input" class="col-sm-5 col-form-label">State</label></strong>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="state" id="horizontal-state-input" placeholder="Enter State here">

                                        @if ($errors->has('state'))
                                        <span class="text-danger">{{ $errors->first('state') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <strong><label for="horizontal-address-input" class="col-sm-5 col-form-label">Address</label></strong>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="address" id="horizontal-address-input" placeholder="Enter Address here">

                                        @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong><label for="horizontal-password-input" class="col-sm-5 col-form-label">Password</label></strong>
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control" name="password" id="horizontal-password-input" placeholder="Enter password here">

                                        @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <strong><label for="horizontal-confirm-password-input" class="col-sm-5 col-form-label">Confirm Password</label></strong>
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control" name="confirm-password" id="horizontal-confirm-password-input" placeholder="Enter Confirm Password here">

                                        @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="image" class="control-label">User Icon image</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                    <div class="invalid-feedback">
                                        Please upload icon image.
                                    </div>
                                </div>
                            </div>
                        </div>
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
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });

    $(document).ready(function() {
        $(".repeater").repeater({
            show: function() {
                $(this).slideDown();
            },
            hide: function(e) {
                $(this).slideUp(e);
            },
            ready: function(e) {},
        });
    });
</script>

@endpush
