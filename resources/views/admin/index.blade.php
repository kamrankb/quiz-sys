@extends('admin.layouts.main')
@push('customStyles')
@endpush

@section('container')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
    </div>
    
    <div class="row">
      <div class="col-md-4">
          <div class="card mini-stats-wid">
              <div class="card-body">
                  <div class="d-flex">
                      <div class="flex-grow-1">
                          <p class="text-muted fw-medium">Teachers</p>
                          <h4 class="mb-0">{{ count($teachers) }}</h4>
                      </div>

                      <div class="flex-shrink-0 align-self-center">
                          <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                              <span class="avatar-title">
                                  <i class="bx bx-copy-alt font-size-24"></i>
                              </span>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="card mini-stats-wid">
              <div class="card-body">
                  <div class="d-flex">
                      <div class="flex-grow-1">
                          <p class="text-muted fw-medium">Students</p>
                          <h4 class="mb-0">{{ count($students) }}</h4>
                      </div>

                      <div class="flex-shrink-0 align-self-center ">
                          <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                              <span class="avatar-title rounded-circle bg-primary">
                                  <i class="bx bx-archive-in font-size-24"></i>
                              </span>
                          </div>
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
@endpush