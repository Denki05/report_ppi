@extends('layouts.app')


@section('content')

    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                    Show Account
                </h2>
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    <div class="col d-flex flex-column">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md">
                                    <div class="form-label">Name</div>
                                    <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                                </div>
                                <div class="col-md">
                                    <div class="form-label">Email</div>
                                    <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                                </div>
                                <div class="col-md">
                                    <div class="form-label">Roles</div>
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                            <span class="badge bg-azure">{{ $v }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>  
                        </div>
                        <div class="card-footer text-end">
                            <a class="btn btn-ghost-info" href="{{ route('users.index') }}" role="button">Link</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection