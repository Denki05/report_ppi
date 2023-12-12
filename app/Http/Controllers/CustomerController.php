<?php

namespace App\Http\Controllers;

use App\Product;
use App\Customer;
use Illuminate\Http\Request;
use DB;
use COM;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customer = Customer::get();

        $data = [
            'customer' => $customer,
        ];

        return view('customer.index', $data);
    }

    public function print_customer_report(Request $request)
    {
        $customer = $request->all()['customer'];
        $start = $request->all()['start'];
        $end = $request->all()['end'];
        $type = $request->all()['type'];
        $date = date("Y-m");

            $sqlStyle = "";
            $i = 1;
            foreach ($customer as $key => $value) {
                if ($i == 1){
                    $sqlStyle .= "";
                }else{
                    $sqlStyle .= "OR";
                }
        
                if(is_array($value)) {
                     $sec = array();
                     foreach($value as $second_level) {
                         $sec[] .=  "{tbl_customer.customer_store_name}='$second_level'";
                     }
                     $sqlStyle .= implode('AND', $sec);
                }else {
                    $sqlStyle .=  "{tbl_customer.customer_store_name}='$value'";
                }
                $i++;

                // dd($sqlStyle);
            }

        if($type == 1){
            $my_report = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\customer\\customer_order_summary.rpt";
        }elseif($type == 2){
            $my_report = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\customer\\customer_order_detail_variant_month.rpt";
        }elseif($type == 3){
            $my_report = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\customer\\customer_order_detail.rpt";
        }

        $my_pdf = 'C:\\xampp\\htdocs\\report_ppi\\public\\report\\customer\\export\\customer-report-order-'.$date.'.pdf';

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
 
         // pass parameter record selection formula
         $sqlString = $sqlStyle;
         $creport->RecordSelectionFormula = "{tbl_sales_invoice.invoice_date}>=#$start#AND{tbl_sales_invoice.invoice_date}<=#$end#AND($sqlString)";
 
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
 
         $file = 'C:\\xampp\\htdocs\\report_ppi\\public\\report\\customer\\export\\customer-report-order-'.$date.'.pdf';
 
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