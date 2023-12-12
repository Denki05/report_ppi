@extends('layouts.app')


@section('content')

@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif

<div class="page-wrapper">
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title">
                Account Management
            </h2>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="container-xl">
      <div class="row row-cards">
        <div class="col-12">
            <!-- <form method="POST" action="{{ route('users.store') }}" class="card"> -->
            {!! Form::open(array('route' => 'users.store','method'=>'POST', 'class' => 'card')) !!}
                <div class="card-header">
                    <h4 class="card-title">Create new account</h4>
                </div>
                <div class="card-body">
                    <div class="row row-cards">
                        <div class="col-12">
                            <div class="card-body">
                                <div class="row row-cards">
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <!-- <input type="text" class="form-control" placeholder="Name"> -->
                                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            {!! Form::text('username', null, array('placeholder' => 'Username','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                
                                
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Roles</label>
                                        
                                        {!! Form::select('roles[]', $roles,[], array('class' => 'form-select', 'id' => 'select_roles')) !!}
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                  <div class="d-flex">
                    <a href="{{ route('users.index') }}" class="btn btn-link">Cancel</a>
                    <button type="submit" class="btn btn-primary ms-auto">Send data</button>
                  </div>
                </div>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('public/dist/libs/tom-select/dist/js/tom-select.base.min.js?1684106062') }}" defer></script>

<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
    	var el;
    	window.TomSelect && (new TomSelect(el = document.getElementById('select_roles'), {
    		copyClassesToDropdown: false,
    		dropdownParent: 'body',
    		controlInput: '<input>',
    		render:{
    			item: function(data,escape) {
    				if( data.customProperties ){
    					return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
    				}
    				return '<div>' + escape(data.text) + '</div>';
    			},
    			option: function(data,escape){
    				if( data.customProperties ){
    					return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
    				}
    				return '<div>' + escape(data.text) + '</div>';
    			},
    		},
    	}));
    });
    // @formatter:on
  </script>

@endsection