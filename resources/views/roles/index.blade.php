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
            @can('role-create')
            <a class="btn btn-ghost-success" href="{{ route('roles.create') }}"> Create New Role</a>
            @endcan
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
                    <th width="280px">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $key => $role)
                    <tr>
                      <td >{{ ++$i }}</td>
                      <td class="text-muted" >
                        {{ $role->name }}
                      </td>
                      <td>
                        <a class="btn btn-ghost-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                        @can('role-edit')
                        <a class="btn btn-ghost-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                        @endcan
                        @can('role-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
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