@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Report Sales Order</h2>

        <div class="alert alert-info d-flex align-items-center" role="alert">
            <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg> -->
            <div>
                <b>Last update:</b>
                @foreach($report as $key)
                    <form action="{{ route('report_customer_type.destroy', $key->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                        <small class="text">{{$key->code}} / {{$key->created_at}}</small>
                        <button class="btn btn-danger" onclick="return confirm('Are you sure to do this reset?')" type="submit" name="Delete">Reset</button>
                    </form>
                @endforeach
            </div>
        </div>

        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <form action="{{ route('report_customer_type.store') }}" method="post">
        {{ csrf_field() }}
            <div class="row">
                <div class="form-group">  
                    <label for="code">Code </label>  
                    <input type="text" class="form-control code" name="code" id="code">
                </div>     
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">  
                        <label for="inputDate">Start </label>  
                        <input type="date" class="form-control start_date" name="start_date" id="start_date">
                    </div> 
                </div>
                <div class="col">
                    <div class="form-group">  
                        <label for="inputDate">End </label>  
                        <input type="date" class="form-control end_date" name="end_date">
                    </div>  
                </div>
            </div>
            <br>
            <!-- <button type="submit" class="custom btn btn-2"> Submit </button> -->
            <button type="submit" class="btn btn-success">Post</button>
        </form>  

        <hr>

        <div class="row">
            <div class="col">
                <div class="card text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Report customer type</h5>
                        <a href="{{route('report_customer_type.reportCustomerType')}}" class="btn btn-primary">Get</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Report by brand</h5>
                        <a href="#" class="btn btn-primary">Get</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Report by packaging</h5>
                        <a href="#" class="btn btn-primary">Get</a>
                    </div>
                </div>
            </div>
        </div>
        {{--<table class="table table-striped table-bordered" id="datatables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report as $key)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$key->code}}</td>
                    <td>{{$key->start_date}}</td>
                    <td>{{$key->end_date}}</td>
                    <td>
                        <!-- {!! Form::open(['method' => 'DELETE','route' => ['posts.destroy', $key->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!} -->
                        <form action="{{ route('report_customer_type.destroy', $key->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')" type="submit" name="Delete">Reset</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>--}}

        {{--<div class="d-flex">
            {!! $report->links() !!}
        </div>--}}

    </div>
@endsection

@push('plugin-styles')
<link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endpush

@push('scripts')
<script src="{{ url('https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#start_date").on("change", function(){
            alert($(this).val());
        });
    });
</script>
@endpush
