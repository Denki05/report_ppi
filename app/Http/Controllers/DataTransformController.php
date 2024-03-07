<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTransform;
use DB;
use COM;

class DataTransformController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:transform-list|transform-create|transform-edit|transform-delete', ['only' => ['index','show']]);
         $this->middleware('permission:transform-create', ['only' => ['create','store']]);
         $this->middleware('permission:transform-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:transform-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return view('data_transform.index');
    }

    public function postData(Request $request)
    {
        // $year = ['2023', '2024'];

        $res = DB::table('tbl_sales_invoice')
            ->select( DB::Raw('SUM(tbl_sales_invoice_item.invoice_item_qty) AS invoice_qty'), 
                'tbl_sales_invoice.invoice_code', 
                'tbl_sales_invoice.invoice_date', 
                'tbl_sales_invoice.invoice_product_type', 
                'tbl_sales_invoice.invoice_type', 
                'tbl_sales_invoice.invoice_shipping_cost', 
                'tbl_sales_invoice.invoice_cost_resi', 
                'tbl_sales_invoice.invoice_subtotal',
                'tbl_sales_invoice.invoice_disc_amount',
                'tbl_sales_invoice.invoice_disc_amount2',
                'tbl_customer.customer_store_name', 
                'tbl_customer.customer_type', 
                'tbl_customer.customer_zone', 
                'tbl_customer.customer_city',
                'tbl_customer.customer_province'
            )
            ->leftJoin('tbl_sales_invoice_item', 'tbl_sales_invoice.id', 'tbl_sales_invoice_item.invoice_id')
            ->leftJoin('tbl_customer', 'tbl_sales_invoice.customer_id', 'tbl_customer.id')
            ->whereNotIn('tbl_sales_invoice.invoice_product_type', [435, 436, 437])
            ->where('tbl_sales_invoice.is_deleted', 0)
            ->whereYear('tbl_sales_invoice.invoice_date', 2024)
            ->groupBy('tbl_sales_invoice.invoice_code')
            ->get();

            foreach($res as $key){
                $transform = DataTransform::firstOrNew([
                    'invoice_code' => $key->invoice_code
                ]);
    
                $transform->customer_name = $key->customer_store_name;
                $transform->customer_type = $key->customer_type;
                $transform->customer_city = $key->customer_city;
                $transform->customer_provinsi = $key->customer_province;
                $transform->customer_zone = $key->customer_zone;
                $transform->invoice_code = $key->invoice_code;
                $transform->invoice_date = $key->invoice_date;
                $transform->invoice_brand = $key->invoice_product_type;
                $transform->invoice_type = $key->invoice_type;
                $transform->invoice_purchase = $key->invoice_subtotal;
                $transform->invoice_disc_amount = $key->invoice_disc_amount ?? 0;
                $transform->invoice_disc_amount2 = $key->invoice_disc_amount2 ?? 0;
                $transform->invoice_shipp_cost = $key->invoice_shipping_cost ?? 0;
                $transform->invoice_resi = $key->invoice_cost_resi;
                $transform->invoice_qty = $key->invoice_qty;
                $transform->save();
                
    
                // dd($transform->customer_name);
            }

            return redirect()->route('data_transform.index')
                        ->with('success','Sync Data successfully.');
    }

    public function print_report(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;
        $date = date("Y-m");

        // Convert date
        $new_date_start = date('d-m-Y', strtotime($start));
        $new_date_end = date('d-m-Y', strtotime($end));

        $my_report = "C:\\xampp\\htdocs\\report_ppi\public\\report\\data_transform\\register_brand\\report_omset_customer_by_brand.rpt";
        $my_pdf = 'C:\\xampp\\htdocs\\report_ppi\\public\\report\\data_transform\\register_brand\\export\\register-brand-'.$date.'.pdf';

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

        //- field prompt or else report will hang - to get through
        $creport->EnableParameterPrompting = FALSE;

        $creport->ParameterFields(2)->SetCurrentValue ("$new_date_start"); // <-- param 2
        $creport->ParameterFields(3)->SetCurrentValue ("$new_date_end"); // <-- param 2

        // pass parameter record selection formula
        $creport->RecordSelectionFormula = "{tbl_data_sync.invoice_date}>=#$start#AND{tbl_data_sync.invoice_date}<=#$end#";

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

        $file = 'C:\\xampp\\htdocs\\report_ppi\\public\\report\\data_transform\\register_brand\\export\\register-brand-'.$date.'.pdf';

        header("Content-Description: File Transfer"); 
        header("Content-Type: application/octet-stream"); 
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-Disposition: attachment; filename=\"". basename($file) ."\""); 
        ob_clean();
        flush();
        readfile ($file);
        exit();
    }

    public function resetData(Request $request)
    {
        DB::table('tbl_data_sync2')->truncate();

        return redirect()->route('data_transform.index')
                        ->with('success','Reset Data successfully.');
    }
}
