<?php


namespace App\Http\Controllers;


use App\Product;
use App\DataTables\ProductTable;
use Illuminate\Http\Request;
use DB;
use COM;
use Response;


class ProductController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
   
    public function index(Request $request)
    {

        // $variant = $request->input('select_product');
        $StartDate = $request->input('start_date');
        $EndDate = $request->input('end_date');
        $variant = $request->input('select_product');
        
            $model = Product::where('tbl_product.product_status', 'active')
                            ->where(function ($query) use ($request) {
                                if ($request->select_product != 'all') {
                                    $query->where('tbl_product.product_name', $request->select_product);
                                } else {
                                    $query;
                                }
                            })
                            ->whereBetween('tbl_sales_invoice.invoice_date', [$StartDate, $EndDate])

                            ->leftJoin('tbl_sales_invoice_item', 'tbl_product.id', '=', 'tbl_sales_invoice_item.product_id')
                            ->leftJoin('tbl_sales_invoice', 'tbl_sales_invoice_item.invoice_id', '=', 'tbl_sales_invoice.id')
                            ->leftJoin('tbl_customer', 'tbl_sales_invoice.customer_id', '=', 'tbl_customer.id')
                            ->leftJoin('tbl_packaging', 'tbl_sales_invoice_item.packaging_id', '=', 'tbl_packaging.id')
                            ->select(
                                'tbl_sales_invoice.invoice_code as nota', 
                                'tbl_product.product_name as product', 
                                'tbl_packaging.packaging_name as packaging', 
                                'tbl_customer.customer_store_name as customer', 
                                'tbl_sales_invoice_item.invoice_item_qty as qty', 
                                'tbl_sales_invoice.invoice_date as tanggalNota'
                            )
                            ->get();

        $product = Product::get();

        $data = [
            'product' => $product,
            'model' => $model,
        ];

        return view('products.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);


        Product::create($request->all());


        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);


        $product->update($request->all());


        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();


        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }

    public function print_report_product(Request $request)
    {
        $product = $request->all()['product'];
        $start = $request->all()['start'];
        $end = $request->all()['end'];
        $type = $request->all()['typeReport'];
        $date = date("Y-m");

        // Convert date
        $new_date_start = date('d-m-Y', strtotime($start));
        $new_date_end = date('d-m-Y', strtotime($end));

        

        if($type == 1){
            $my_report = "C:\\xampp\\htdocs\\report_ppi\public\\report\\product\\penjualan_product_summary_short_qty.rpt";
        }elseif($type == 2){
            // DD($my_report);
            $my_report = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\product\\penjualan_product_summary_short_variant.rpt";
        }elseif($type == 3){
            $my_report = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\product\\penjualan_product_summary.rpt";
        }elseif($type == 4){
            $my_report = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\product\\penjualan_product_detail.rpt";
        }

        $my_pdf = 'C:\\xampp\\htdocs\\report_ppi\\public\\report\\product\\export\\product-report-'.$date.'.pdf';

        $sqlStyle = "";
        $i = 1;
        foreach ($product as $key => $value) {
            if ($i == 1){
                $sqlStyle .= "";
            }else{
                $sqlStyle .= "OR";
            }
        
            if(is_array($value)) {
                $sec = array();
                foreach($value as $second_level) {
                    $sec[] .=  "{tbl_product.product_name}='$second_level'";
                }
                    $sqlStyle .= implode('AND', $sec);
                }else {
                    $sqlStyle .=  "{tbl_product.product_name}='$value'";
                }
            $i++;
            // dd($sqlStyle);
        }

        //- Variables - Server Information 
        $my_server = "LOCAL_2"; 
        $my_user = "root"; 
        $my_password = ""; 
        $my_database = "ppi";
        $COM_Object = "CrystalDesignRunTime.Application";

        //-Create new COM object-depends on your Crystal Report version
        $crapp= New COM($COM_Object) or die("Unable to Create Object");
        $creport = $crapp->OpenReport($my_report,1); // call rpt report

        //- Set database logon info - must have
        $creport->Database->Tables(1)->SetLogOnInfo($my_server, $my_database, $my_user, $my_password);
        // DD($creport);

        //- field prompt or else report will hang - to get through
        $creport->EnableParameterPrompting = FALSE;

        $creport->ParameterFields(3)->SetCurrentValue ("$new_date_start"); // <-- param 1
        $creport->ParameterFields(4)->SetCurrentValue ("$new_date_end"); // <-- param 2

        // pass parameter record selection formula
        $sqlString = $sqlStyle;
        $creport->RecordSelectionFormula = "($sqlString)AND{tbl_sales_invoice.invoice_date}>=#$start#AND{tbl_sales_invoice.invoice_date}<=#$end#";
        // DD($creport->RecordSelectionFormula);
        //export to PDF process
        $creport->ExportOptions->DiskFileName=$my_pdf; //export to pdf
        $creport->ExportOptions->PDFExportAllPages=true;
        $creport->ExportOptions->DestinationType=1; // export to file
        $creport->ExportOptions->FormatType=31; // PDF type
        $creport->Export(false);

        //------ Release the variables ------
        $creport = null;
        $crapp = null;
        $ObjectFactory = null;

        $file = 'C:\\xampp\\htdocs\\report_ppi\\public\\report\\product\\export\\product-report-'.$date.'.pdf';

        

        header("Content-Description: File Transfer"); 
        header("Content-Type: application/octet-stream");
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-Disposition: attachment; filename=$file"); 
        ob_clean();
        flush();
        readfile ($file);
        exit();
    }
}