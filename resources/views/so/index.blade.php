@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Sales Order</h2>
        <div class="lead">
            List Order
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table class="table table-striped table-bordered" id="datatables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Created At</th>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Purchase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($so as $key)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$key->invoice_date}}</td>
                    <td>{{$key->invoice_code}}</td>
                    <td>{{$key->customer_id}}</td>
                    <td>{{number_format($key->invoice_subtotal - $key->invoice_disc_amount - $key->invoice_disc_amount2)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $so->links() !!}
        </div>

    </div>
@endsection

@push('plugin-styles')
<link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css') }}">
@endpush

@push('scripts')
<script src="{{ url('https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#datatables').DataTable({
            processing: true,
            serverSide: true,
        });
    })
</script>
@endpush
