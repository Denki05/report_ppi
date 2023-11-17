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
use Carbon\Carbon;

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
        $product = DB::table('tbl_product')->get();
        $pack = DB::table('tbl_packaging')->get();
        $factory = DB::table('tbl_factory')->get();

        return view('report_customer_type.index', compact('report', 'factory', 'product', 'pack'));
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

        $model_header = DB::table('tbl_sales_invoice')
            ->select(
                'tbl_sales_invoice.id', 
                'tbl_sales_invoice.invoice_code', 
                'tbl_sales_invoice.invoice_type', 
                'tbl_sales_invoice.invoice_date', 
                'tbl_sales_invoice.invoice_product_type', 
                'tbl_sales_invoice.invoice_subtotal',
                'tbl_customer.customer_store_name', 
                'tbl_customer.customer_type', 
                'tbl_customer.customer_city',
                'tbl_customer.customer_province',
                'tbl_sales_invoice.invoice_disc_amount',
                'tbl_sales_invoice.invoice_disc_amount2',
                'tbl_sales_invoice.invoice_product_type',
            )
            ->leftJoin('tbl_customer', 'tbl_customer.id', '=', 'tbl_sales_invoice.customer_id')
            ->whereBetween('tbl_sales_invoice.invoice_date', [$start, $end])
            ->whereNotIn('tbl_sales_invoice.invoice_product_type', [435, 436, 437])
            ->where('tbl_sales_invoice.is_deleted', 0)
            ->groupBy('tbl_sales_invoice.invoice_code')
            ->get();

        foreach($model_header as $key){
            $create_header = new ReportCustomerType;
            $create_header->customer_name = $key->customer_store_name;
            $create_header->customer_city = $key->customer_city;
            $create_header->customer_type = $key->customer_type;
            $create_header->invoice_code = $key->invoice_code;
            $create_header->invoice_type = $key->invoice_type;
            $create_header->invoice_brand = $key->invoice_product_type;
            $create_header->invoice_date = $key->invoice_date;
            $create_header->invoice_subtotal = $key->invoice_subtotal;
            $create_header->invoice_disc_amount = $key->invoice_disc_amount;
            $create_header->invoice_disc_amount2 = $key->invoice_disc_amount2;
            $create_header->save();

            $model_detail = DB::table('tbl_sales_invoice_item')
                ->leftJoin('tbl_sales_invoice', 'tbl_sales_invoice_item.invoice_id', '=', 'tbl_sales_invoice.id')
                ->leftJoin('tbl_product', 'tbl_sales_invoice_item.product_id', '=', 'tbl_product.id')
                ->leftJoin('tbl_packaging', 'tbl_sales_invoice_item.packaging_id', '=', 'tbl_packaging.id')
                ->leftJoin('tbl_factory', 'tbl_product.factory_id', '=', 'tbl_factory.id')
                ->where('tbl_sales_invoice_item.invoice_id', $key->id)
                ->select(
                    'tbl_sales_invoice_item.invoice_id',
                    'tbl_sales_invoice.invoice_product_type',
                    'tbl_sales_invoice_item.invoice_item_qty', 
                    'tbl_product.product_name', 
                    'tbl_product.product_code', 
                    'tbl_packaging.packaging_name',
                    'tbl_factory.factory_name',
                )
                ->get();

                foreach($model_detail as $row){
                   $create_detail = new ReportCustomerTypeDetail;
                   $create_detail->report_type_detail_id = $create_header->id;
                   $create_detail->product_name = $row->product_name;
                   $create_detail->product_brand = $row->invoice_product_type;
                   $create_detail->product_qty = $row->invoice_item_qty;
                   $create_detail->pakaging_name = $row->packaging_name;
                   $create_detail->factory_name = $row->factory_name;
                   $create_detail->save();
                }
        }

        if($validation->fails()) {
            return $validation->errors()->first();
        }

        return redirect()->route('report_customer_type.index')
        ->withSuccess(__('Transform data created successfully.'));
    }

    public function destroy(Request $request)
    {
        DB::table('report_type')->truncate();
        DB::table('report_type_detail')->truncate();

        return redirect()->route('report_customer_type.index')
            ->withSuccess(__('Data report, reset successfully.'));
    }

    public function reportCustomerType(Request $request)
    {

        $noData = false;
        $data = DB::table('report_type')
            ->leftJoin('report_type_detail', 'report_type_detail.report_type_detail_id', '=', 'report_type.id')
            ->get();

        $start = $request->start_date;
        $end = $request->end_date;
      
        try{
            if(empty($data)){
                $noData = true;
                return redirect()->route('report_customer_type.index')
                ->withSuccess(__('No data posted!'));
                
            }else{
                    $my_report = "C:\\xampp\\htdocs\\report_ppi\public\\report\\customer_type\\customer_type.rpt"; 
                    $my_pdf = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\customer_type\\export\\customer_type.pdf";

                    //- Variables - Server Information 
                    $my_server = "SERVER"; 
                    $my_user = "dev_denki"; 
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
                    $creport->RecordSelectionFormula = "{report_type.invoice_date}>=#$start#AND{report_type.invoice_date}<=#$end#";

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
        }catch (\Exception $e) {
            return $e->getMessage();
        }

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

    public function reportBySupplier(Request $request)
    {
        $factory = $request->factory_name;
        $get_factory = DB::table('tbl_factory')->where('factory_name', $factory)->first();
        $reportData = ReportCustomerTypeDetail::first();

        try {
            if(empty($reportData)){
                return redirect()->route('report_customer_type.index')
                ->withSuccess(__('No data posted.'));
            }else{
                $my_report = "C:\\xampp\\htdocs\\report_ppi\public\\report\\supplier\\supplier.rpt"; 
                $my_pdf = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\supplier\\export\\supplier.pdf";

    
                //- Variables - Server Information 
                $my_server = "SERVER"; 
                $my_user = "dev_denki"; 
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
                $creport->RecordSelectionFormula = "{report_type_detail.factory_name}= '$get_factory->factory_name'";
    
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
        
                $file = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\supplier\\export\\supplier.pdf";
    
                header("Content-Description: File Transfer"); 
                header("Content-Type: application/octet-stream"); 
                header("Content-Transfer-Encoding: Binary"); 
                header("Content-Disposition: attachment; filename=\"". basename($file) ."\""); 
                ob_clean();
                flush();
                readfile ($file);
                exit();
            }
          
        } catch (\Exception $e) {
          
            return $e->getMessage();
        }
    }

    public function reportByBrand(Request $request)
    {
        $reportData = DB::table('report_type')->leftJoin('report_type_detail', 'report_type.id', '=', 'report_type_detail.report_type_detail_id')->first();

        try{
            if(empty($reportData)){
                return redirect()->route('report_customer_type.index')
                ->withSuccess(__('No data posted.'));
            }else{
                $my_report = "C:\\xampp\\htdocs\\report_ppi\public\\report\\brand\\brand.rpt"; 
                $my_pdf = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\brand\\export\\brand.pdf";

    
                //- Variables - Server Information 
                $my_server = "SERVER"; 
                $my_user = "dev_denki"; 
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
        
                $file = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\brand\\export\\brand.pdf";
    
                header("Content-Description: File Transfer"); 
                header("Content-Type: application/octet-stream"); 
                header("Content-Transfer-Encoding: Binary"); 
                header("Content-Disposition: attachment; filename=\"". basename($file) ."\""); 
                ob_clean();
                flush();
                readfile ($file);
                exit();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function reportByPackaging(Request $request)
    {
        $reportData = DB::table('report_type')->leftJoin('report_type_detail', 'report_type.id', '=', 'report_type_detail.report_type_detail_id')->first();

        $product = $request->product_name;

        $get_product = DB::table('tbl_product')->where('product_name', $product)->first();
        // dd($get_packaging);

        if(empty($reportData)){
            return redirect()->route('report_customer_type.index')
            ->withSuccess(__('No data posted.'));
        }else{
            $my_report = "C:\\xampp\\htdocs\\report_ppi\public\\report\\packaging\\packaging.rpt"; 
            $my_pdf = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\packaging\\export\\packaging.pdf";

            //- Variables - Server Information 
            $my_server = "SERVER"; 
            $my_user = "dev_denki"; 
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
            $creport->RecordSelectionFormula = "{report_type_detail.product_name}= '$get_product->product_name'";
            // $creport->RecordSelectionFormula = str_replace($rptParam->Name, $cVal, $rpt->RecordSelectionFormula);

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
    
            $file = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\packaging\\export\\packaging.pdf";

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
}
