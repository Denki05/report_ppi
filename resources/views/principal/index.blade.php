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
        <div class="page-body">
          <div class="container-xl">
            <form class="card">
            @csrf
              <div class="card-header">
                <h3 class="card-title">Report Forcast Principal :</h3>
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
                    <label class="col-3 col-form-label required">Factory</label>
                    <div class="col">
                      <select type="text" class="form-select" placeholder="Select Factory" id="select_factory" value="" name="select_factory[]">
                        <option value="">Select Factory</option>
                        @foreach($factory as $key)
                          <option value="{{ $key->factory_name }}">{{ $key->factory_name }}</option>
                        @endforeach
                        <input type="hidden" class="form-control" name="product_name" id="product_name">
                      </select>
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <div class="col-3 col-form-label required">Type Report</div>
                    <div class="col">
                      <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radios-inline" id="principal_summary" value="1">
                        <span class="form-check-label">Summary</span>
                      </label>
                      <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radios-inline" id="principal_detail" value="2">
                        <span class="form-check-label">Detail</span>
                      </label>
                    </div>
                  </div>
                </div>
              <div class="card-footer text-end">
                  <button type="submit" id="printReport" class="btn btn-success">Print</button>
                  {{--<button type="submit" id="filter" class="btn btn-primary">Search</button>--}}
              </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('public/dist/libs/litepicker/dist/litepicker.js?1684106062') }}" defer></script>
    <script src="{{ asset('public/dist/libs/tom-select/dist/js/tom-select.base.min.js?1684106062') }}" defer></script>
    <script src="{{ asset('public/dist/libs/list.js/dist/list.min.js?1684106062') }}" defer></script>

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
        window.TomSelect && (new TomSelect(el = document.getElementById('select_factory'), {
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

      $(document).ajaxSend(function() {
        $("#overlay").fadeIn(300);　
      });

      $('#printReport').on('click', function(e) {
        e.preventDefault(); // prevent the form submit
        let factory = $('#select_factory').val();
        let start = $('#start_date').val();
        let end = $('#end_date').val();
        let typeReport = $("input:radio[name=radios-inline]:checked").val();
        
        $.ajax({
           type:'POST',
           url:"{{ route('principal.print_report_principal') }}",
           data:{"_token": "{{ csrf_token() }}","factory":factory, "start":start, "end":end, "type":typeReport},
           success:function(response){
            // console.log(response);
           }
        });
      })
    </script>
@endsection