@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Report Sales Order</h2>

        <input class="form-control" type="hidden" value="{{ count($report) }}" id="count_data">

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
                        <small class="text">periode : {{$key->start_date}} to {{$key->end_date}}</small>
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
            <button type="submit" class="btn btn-success" id="btnPost">Post</button>
        </form>
        <hr>

        <!-- <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Customer Type</h5>
                        <p class="card-text"></p>
                        <a href="{{ route('report_customer_type.reportCustomerType') }}" class="btn btn-primary">Generate</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="card-title">Supplier</h5>
                        <div class="container">
                            <div class="row">
                                <select class="form-control">
                                    <option>Pilih Factory</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="card-title">Packaging</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="block">
            <div class="block-content block-content-full">
                <form>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <select class="form-control" name="typeReport" id="typeReport">
                                    <option value="">Pilih report type</option>
                                    <option value="1">Customer type</option>
                                    <option value="2">Packaging</option>
                                    <option value="3">Supplier</option>
                                </select>
                            </div>   
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-success" id="btnPost">Generate</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3" id="customerType">
                            <select class="form-control js-select2" name="customerType" style="display: none;">
                                <option value="">Pilih type customer</option>
                                @foreach($customer_type as $key)
                                <option value="{{$key->customer_type}}">{{$key->customer_type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3" id="packaging">
                            
                        </div>
                        <div class="col-lg-3" id="supplier">
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
