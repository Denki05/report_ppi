@extends('layouts.app')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if ($errors->any())
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
        {{--<div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  #Product Pack
                </h2>
              </div>
            </div>
          </div>
        </div>--}}

        <div class="page-body">
          <div class="container-xl">
            <form class="card">
            @csrf
              <div class="card-header">
                <h3 class="card-title">Report Penjualan Varian :</h3>
              </div>
              <div class="card-body">
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Range Date</label>
                    <div class="col">
                      <div class="input-icon">
                        <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                        </span>
                        <input class="form-control" placeholder="Select a Start date" id="start_date" name="start_date"/>
                        <input type="hidden" class="form-control" id="startDate">
                      </div>
                    </div>
                    <div class="col">
                      <div class="input-icon">
                        <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                        </span>
                        <input class="form-control" placeholder="Select a End date" id="end_date" name="end_date"/>
                        <input type="hidden" class="form-control" id="endDate">
                      </div>
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Product</label>
                    <div class="col">
                      <select type="text" class="form-select" placeholder="Select Product" id="select_product" value="" name="select_product[]" multiple>
                        <option value="">Select Product</option>
                        @foreach($product as $key)
                          <option value="{{ $key->product_name }}">{{ $key->product_code }} - {{ $key->product_name }}</option>
                        @endforeach
                        <input type="hidden" class="form-control" name="product_name" id="product_name">
                      </select>
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <div class="col-3 col-form-label required">Type Report</div>
                    <div class="col">
                      <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radios-inline" id="best_seller" value="1">
                        <span class="form-check-label">Best Seller</span>
                      </label>
                      <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radios-inline" id="varian" value="2">
                        <span class="form-check-label">Varian</span>
                      </label>
                      <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radios-inline" id="varian_bulan" value="3">
                        <span class="form-check-label">Varian - Bulan</span>
                      </label>
                      <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radios-inline" id="varian_bulan_customer" value="4">
                        <span class="form-check-label">Varian - Bulan - Customer</span>
                      </label>
                    </div>
                  </div>
                </div>
              <div class="card-footer text-end">
                  <button type="submit" id="printReport" class="btn btn-success">Print</button>
                  {{--<button type="submit" id="filter" class="btn btn-primary">Search</button>--}}
              </div>
            </form>

              {{--<div class="card">
                <div class="card-body">
                  
                    <table id="datatable" class="table table-striped">
                      <thead>
                        <tr>
                          <td>#</td>
                          <td>Tgl Nota</td>
                          <td>No. Nota</td>
                          <td>Product</td>
                          <td>Packaging</td>
                          <td>Customer</td>
                          <td>Qty</td>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($model as $row)
                          <tr>
                            <th>{{ $loop->iteration }}</th>
                            <th>{{ date('d-m-Y', strtotime($row->tanggalNota)) }}</th>
                            <th>{{ $row->nota }}</th>
                            <th>{{ $row->product }}</th>
                            <th>{{ $row->packaging }}</th>
                            <th>{{ $row->customer }}</th>
                            <th>{{ $row->qty }}</th>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
              </div>--}}
        </div>
    </div>

    <script src="{{ asset('/dist/libs/litepicker/dist/litepicker.js?1684106062') }}" defer></script>
    <script src="{{ asset('/dist/libs/tom-select/dist/js/tom-select.base.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('/dist/libs/list.js/dist/list.min.js?1684106062') }}" defer></script>

    <!-- datatable -->
    
      <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
      <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
      // START_DATE
      document.addEventListener("DOMContentLoaded", function () {
        window.Litepicker && (new Litepicker({
          element: document.getElementById('start_date'),
          buttonText: {
            previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
            nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
          },
        }));
      });
      
      
      // END_DATE
      document.addEventListener("DOMContentLoaded", function () {
        window.Litepicker && (new Litepicker({
          element: document.getElementById('end_date'),
          buttonText: {
            previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
            nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
          },
        }));
      });

      // SELECT_PRODUCT
      document.addEventListener("DOMContentLoaded", function () {
        var el;
        window.TomSelect && (new TomSelect(el = document.getElementById('select_product'), {
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

      let table = $('#datatable').DataTable({
        language: {
          processing: "<span class='fa-stack fa-lg'>\n\
                                <i class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
                           </span>",
        },
        processing: true,
        serverSide: false,
        order: [
          [1, 'asc']
        ],
        pageLength: 10,
        lengthMenu: [
          [10, 25, 50, 100],
          [10, 25, 50, 100]
        ],
      });

      $('#printReport').on('click', function(e) {
        e.preventDefault(); // prevent the form submit
        let product = $('#select_product').val();
        let start = $('#start_date').val();
        let end = $('#end_date').val();
        let typeReport = $("input:radio[name=radios-inline]:checked").val();
        
        $.ajax({
           type:'POST',
           url:"{{ route('products.product_summary') }}",
           data:{"_token": "{{ csrf_token() }}","product":product, "start":start, "end":end, "typeReport":typeReport},
           success:function(response){

           }
        });
      })
    </script>
@endsection