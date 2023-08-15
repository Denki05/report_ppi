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
                <b>Last update data :</b>
                <form action="{{ route('report_customer_type.destroy') }}" method="post">
                    @csrf
                    @method('DELETE')
                    @php
                        $reportType = DB::table('report_type')
                            ->select('id')
                            ->count();
                    @endphp
                    {{$reportType}} <i>Record's</i>&nbsp;&nbsp;<button class="btn btn-danger" onclick="return confirm('Are you sure to do this reset?')" type="submit" name="Delete">Reset</button>
                </form>
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

        <h2>Print Report</h2>
        <div class="block">
            <div class="block-content block-content-full">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 col-12"> 
                        <div class="card">
                            <form action="{{ route('report_customer_type.reportCustomerType') }}" method="get">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-right">
                                                <h5>#Customer Type</h5>
                                                <button type="submit" class="btn btn-success" id="btnPost">GO</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12"> 
                        <div class="card">
                            <form action="{{ route('report_customer_type.reportByBrand') }}" method="get">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-right">
                                                <h5>#Brand</h5>
                                                <button type="submit" class="btn btn-success" id="btnPost">GO</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card">
                            <form action="{{ route('report_customer_type.reportBySupplier') }}" method="get">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-right">
                                                <h5>#Supplier</h5>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <select class="form-select" aria-label="Pilih supplier" name="factory_name">
                                                            <option selected>Pilih Supplier</option>
                                                            @foreach($factory as $key)
                                                            <option value="{{$key->factory_name}}">{{$key->factory_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <button type="submit" class="btn btn-success" id="btnPost">GO</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card">
                            <form action="{{ route('report_customer_type.reportByPackaging') }}" method="get">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-right">
                                                <h5>#Packaging</h5>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <select class="form-select" name="product_name">
                                                            <option value="">Pilih Product</option>
                                                            @foreach($product as $row)
                                                            <option value="{{$row->product_name}}">{{$row->product_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <button type="submit" class="btn btn-success" id="btnPost">GO</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('asset.plugin.select2')

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('.js-select2').select2();
    });
</script>
@endpush
