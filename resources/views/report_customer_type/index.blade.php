@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Report Sales Order</h2>

        <input class="form-control" type="hidden" value="{{ count($report) }}" id="count_data">

        <div class="alert alert-info d-flex align-items-center" role="alert">
            <div>
                <b><h4>LAST UPDATE:</h4></b>
                <form action="{{ route('report_customer_type.destroy') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <?php 
                        $min_datasets = DB::table('report_type')
                            ->orderBy('invoice_date','asc')
                            ->get('invoice_date')
                            ->first();

                        $max_datasets = DB::table('report_type')
                            ->orderBy('invoice_date','desc')
                            ->get('invoice_date')
                            ->first();
                    ?>
                    @if(empty($min_datasets) && empty($max_datasets))
                        <b>Empty Data!</b>
                    @else
                        <i><b>{{ date('d/m/Y', strtotime($min_datasets->invoice_date)) }}</b> to <b>{{ date('d/m/Y', strtotime($max_datasets->invoice_date)) }}</b></i> <button class="btn btn-danger" onclick="return confirm('Are you sure to do this reset?')" type="submit" name="Delete">Reset</button>
                    @endif
                    
                </form>
            </div>
        </div>

        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <form action="{{ route('report_customer_type.store') }}" method="post">
        {{ csrf_field() }}
            <?php
                $data = DB::table('report_type')
                    ->leftJoin('report_type_detail', 'report_type.id', '=', 'report_type_detail.report_type_detail_id')
                    ->first();
            ?>
            @if(empty($data))
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
            @else

            @endif
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
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label>Start date</label>
                                                        <input type="date" class="form-control" name="start_date">
                                                    </div>
                                                    <div class="col-6">
                                                        <label>End date</label>
                                                        <input type="date" class="form-control" name="end_date">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <button type="submit" class="btn btn-success" id="btnPost">GO</button>
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
                            <form action="{{ route('report_customer_type.reportByBrand') }}" method="get">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="media d-flex">
                                            <div class="media-body text-right">
                                                <h5>#Brand</h5>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label>Start date</label>
                                                        <input type="date" class="form-control" name="start_date">
                                                    </div>
                                                    <div class="col-6">
                                                        <label>End date</label>
                                                        <input type="date" class="form-control" name="end_date">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <button type="submit" class="btn btn-success" id="btnPost">GO</button>
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
                            <form action="{{ route('report_customer_type.reportByPackaging') }}" method="GET">
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
