<?php

namespace App\Http\Controllers;

use App\Models\ReportCustomerType;
use App\Models\ReportCustomerTypeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use DB;
use COM;

class ReportCustomerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $report = ReportCustomerType::get();
        $factory = DB::table('tbl_factory')->get();

        return view('report_customer_type.index', compact('report', 'factory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('report_customer_type.create');
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $start = $request->start_date;
        $end = $request->end_date;

        $data = DB::table('tbl_sales_invoice')
            ->select( 'tbl_sales_invoice_item.invoice_item_qty', 
                'tbl_sales_invoice.invoice_code', 
                'tbl_sales_invoice.invoice_date', 
                'tbl_sales_invoice.invoice_product_type', 
                'tbl_sales_invoice.invoice_type', 
                'tbl_sales_invoice.invoice_shipping_cost', 
                'tbl_sales_invoice.invoice_cost_resi', 
                'tbl_sales_invoice.invoice_subtotal', 
                'tbl_customer.customer_store_name', 
                'tbl_customer.customer_type', 
                'tbl_customer.customer_zone', 
                'tbl_customer.customer_city',
                'tbl_customer.customer_province',
                'tbl_sales_invoice.invoice_disc_amount',
                'tbl_sales_invoice.invoice_disc_amount2',
                'tbl_sales_invoice.invoice_product_type', 
                'tbl_packaging.packaging_name',
                'tbl_product.product_name', 
                'tbl_product.product_code', 
            )
            ->leftJoin('tbl_sales_invoice_item', 'tbl_sales_invoice_item.invoice_id', '=', 'tbl_sales_invoice.id')
            ->leftJoin('tbl_customer', 'tbl_customer.id', '=', 'tbl_sales_invoice.customer_id')
            ->leftJoin('tbl_packaging', 'tbl_packaging.id', '=', 'tbl_sales_invoice_item.packaging_id')
            ->leftJoin('tbl_product', 'tbl_product.id', '=', 'tbl_sales_invoice_item.product_id')
            ->whereBetween('tbl_sales_invoice.invoice_date', [$start, $end])
            ->whereNotIn('tbl_sales_invoice.invoice_product_type', [435, 436, 437])
            ->where('tbl_sales_invoice.is_deleted', 0)
            ->get();

            if($validation->fails()) {
                return $validation->errors()->first();
            }

            $create_header = ReportCustomerType::create(array(
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ));
            
            foreach($data as $key){
                $create_detail = ReportCustomerTypeDetail::create(array(
                    'customer_report_type_id' => $create_header->id,
                    'customer_name' => $key->customer_store_name,
                    'customer_type' => $key->customer_type,
                    'customer_text_kota' => $key->customer_city,
                    'invoice_code' => $key->invoice_code,
                    'invoice_brand' => $key->invoice_product_type,
                    'invoice_date' => $key->invoice_date,
                    'invoice_subtotal' => $key->invoice_subtotal,
                    'invoice_disc_amount' => $key->invoice_disc_amount,
                    'invoice_disc_amount2' => $key->invoice_disc_amount2,
                    'invoice_product' => implode("/", [$key->product_code, $key->product_name]),
                    'packaging_name' => $key->packaging_name,
                    'invoice_qty' => $key->invoice_item_qty,
                ));
            }

            return redirect()->route('report_customer_type.index')
            ->withSuccess(__('Transform data created successfully.'));
    }

    public function destroy($id)
    {
        $customer_report = ReportCustomerType::find($id);

        $customer_report->delete();

        $customer_report_detail = ReportCustomerTypeDetail::where('customer_report_type_id', $customer_report->id)->delete();

        return redirect()->route('report_customer_type.index')
            ->withSuccess(__('Data report, reset successfully.'));
    }

    public function reportCustomerType(Request $request)
    {
        $reportData = ReportCustomerType::get();

        if(!empty($reportData)){
            return redirect()->route('report_customer_type.index')
            ->withSuccess(__('No data posted.'));
        }else{
            $my_report = "C:\\xampp\\htdocs\\report_ppi\public\\report\\customer_type\\customer_type.rpt"; 
            $my_pdf = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\customer_type\\export\\customer_type.pdf";

            //- Variables - Server Information 
            $my_server = "PPI-REPORT"; 
            $my_user = "ppi_report"; 
            $my_password = "Denki@05121996"; 
            $my_database = "ppi";
            $COM_Object = "CrystalDesignRunTime.Application";

            //-Create new COM object-depends on your Crystal Report version
            $crapp= New COM($COM_Object) or die("Unable to Create Object");
            $creport = $crapp->OpenReport($my_report,1); // call rpt report

            //- Set database logon info - must have
            $creport->Database->Tables(1)->SetLogOnInfo($my_server, $my_database, $my_user, $my_password);

            //- field prompt or else report will hang - to get through
            $creport->EnableParameterPrompting = FALSE;

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
    
            $file = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\customer_type\\export\\customer_type.pdf";

            header("Content-Description: File Transfer"); 
            header("Content-Type: application/octet-stream"); 
            header("Content-Transfer-Encoding: Binary"); 
            header("Content-Disposition: attachment; filename=\"". basename($file) ."\""); 
            ob_clean();
            flush();
            readfile ($file);
            exit();
        }
    }

    public function reportByBrand(Request $request)
    {

    }
}
