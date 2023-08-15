@extends('layouts.app-master')

@section('content')
    @guest
        <div class="container" align="center">
            <div class="card text-center" style="width: 18rem;">
                <div class="card-body" >
                    <h5 class="card-title">Already Account?</h5>
                    <p class="card-text">if you don't have an account, contact IT.</p>
                    <a href="{{ route('login.show') }}" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>
        
    @endguest

    @auth
    <div class="bg-light p-4 rounded">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <?php
                                        $date = \Carbon\Carbon::now();

                                        $lastMonth =  $date->subMonth()->format('m');
                                        $yearNow = $date->format('Y');

                                        $this_month = DB::table('tbl_sales_invoice')
                                            ->whereYear('invoice_date', \Carbon\Carbon::now()->year)
                                            ->whereMonth('invoice_date', \Carbon\Carbon::now()->month)
                                            ->count();

                                        $last_month = DB::table('tbl_sales_invoice')
                                            ->whereYear('invoice_date', $yearNow)
                                            ->whereMonth('invoice_date', $lastMonth)
                                            ->count();
                                    ?>
                                    <h5 class="card-title text-uppercase text-muted mb-0">ORDER</h5>
                                    <span class="h4 font-weight-bold mb-0">{{$this_month}} <i>Ticket's</i></span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow" style="width: 3rem; height: 3rem; display: inline-flex; padding: 12px; text-align: center; border-radius: 50%; align-items: center; justify-content: center;">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <?php
                                    $date = \Carbon\Carbon::now();

                                    $lastMonth =  $date->subMonth()->format('m');
                                    $yearNow = $date->format('Y');

                                    $sales_order_item = DB::table('tbl_sales_invoice_item')
                                        ->leftJoin('tbl_sales_invoice', 'tbl_sales_invoice_item.invoice_id', '=', 'tbl_sales_invoice.id')
                                        ->whereYear('invoice_date', \Carbon\Carbon::now()->year)
                                        ->whereMonth('invoice_date', \Carbon\Carbon::now()->month)
                                        ->sum('invoice_item_qty');

                                    $sales_order_item_last = DB::table('tbl_sales_invoice_item')
                                        ->leftJoin('tbl_sales_invoice', 'tbl_sales_invoice_item.invoice_id', '=', 'tbl_sales_invoice.id')
                                        ->whereYear('invoice_date', $yearNow)
                                        ->whereMonth('invoice_date', $lastMonth)
                                        ->sum('invoice_item_qty');

                                    
                                ?>

                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Qty</h5>
                                    <span class="h4 font-weight-bold mb-0">{{$sales_order_item}} <i>KG's</i></span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow" style="width: 3rem; height: 3rem; display: inline-flex; padding: 12px; text-align: center; border-radius: 50%; align-items: center; justify-content: center;">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <?php 
                                    $date = \Carbon\Carbon::now();

                                    $lastMonth =  $date->subMonth()->format('m');
                                    $yearNow = $date->format('Y');

                                    $pay = DB::table('tbl_sales_payment')
                                        ->whereYear('payment_date', \Carbon\Carbon::now()->year)
                                        ->whereMonth('payment_date', \Carbon\Carbon::now()->month)
                                        ->sum('payment_total_amount');

                                    $pay_last_month = DB::table('tbl_sales_payment')
                                        ->whereYear('payment_date', $yearNow)
                                        ->whereMonth('payment_date', $lastMonth)
                                        ->sum('payment_total_amount');

                                    $percentacePay = ($pay_last_month - $pay) / 100;

                                    // dd($percentacePay);
                                ?>
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">PAID PAYMENT</h5>
                                    <span class="h4 font-weight-bold mb-0">Rp {{ number_format($pay) }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-success text-white rounded-circle shadow" style="width: 3rem; height: 3rem; display: inline-flex; padding: 12px; text-align: center; border-radius: 50%; align-items: center; justify-content: center;">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <?php 
                                    // $date = \Carbon\Carbon::now();

                                    // $lastMonth =  $date->subMonth()->format('m');
                                    // $yearNow = $date->format('Y');

                                    $unpaid = DB::table('tbl_sales_invoice')
                                        ->whereYear('invoice_date', \Carbon\Carbon::now()->year)
                                        ->whereMonth('invoice_date', \Carbon\Carbon::now()->month)
                                        ->where('invoice_payment_status', 'new')
                                        ->sum('invoice_subtotal');
                                ?>
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">OUTSTANDING</h5>
                                    <span class="h4 font-weight-bold mb-0">Rp {{number_format($unpaid)}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow" style="width: 3rem; height: 3rem; display: inline-flex; padding: 12px; text-align: center; border-radius: 50%; align-items: center; justify-content: center;">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                <span class="text-nowrap">Since last month</span>
                            </p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endauth
@endsection
