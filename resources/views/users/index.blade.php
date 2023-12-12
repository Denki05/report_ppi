@extends('layouts.app')


@section('content')


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif

<div class="page-wrapper">
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <a class="btn btn-ghost-success" href="{{ route('users.create') }}">Create Account</a>
        </div>
      </div>
    </div>
  </div>

  <div class="page-body">
    <div class="container-xl">
      <div class="row row-cards">
        <div class="col-12">
          <div class="card">
            <div class="table-responsive">
              <table class="table table-vcenter card-table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th width="280px">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $key => $user)
                    <tr>
                      <td >{{ ++$i }}</td>
                      <td class="text-muted" >
                        {{ $user->name }}
                      </td>
                      <td class="text-muted" ><a href="#" class="text-reset">{{ $user->email }}</a></td>
                      <td class="text-muted" >
                        @if(!empty($user->getRoleNames()))
                          @foreach($user->getRoleNames() as $v)
                            <!-- <label class="badge badge-success">{{ $v }}</label> -->
                            <span class="badge bg-azure">{{ $v }}</span>
                          @endforeach
                        @endif
                      </td>
                      <td>
                        <a class="btn btn-ghost-info" href="{{ route('users.show',$user->id) }}">Show</a>
                        <a class="btn btn-ghost-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-ghost-danger']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection