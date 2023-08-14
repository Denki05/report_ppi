@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        <div class="row">
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Report Customer Type</h5>
                        <a href="{{ route('report_customer_type.index') }}" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Report Sales Order by Brand</h5>
                        <a href="#" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Report Sales Order by Supplier</h5>
                        <a href="#" class="btn btn-primary">Go</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

