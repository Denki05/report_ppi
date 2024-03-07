<?php

namespace App\Http\Controllers;

use App\Product;
use App\Customer;
use App\Factory;
use Illuminate\Http\Request;
use DB;
use COM;

class PrincipalController extends Controller
{

    public function index(Request $request)
    {
        $factory = Factory::get();

        $data = [
            'factory' => $factory,
        ];

        return view('principal.index', $data);
    }

    public function print_report_principal(Request $request)
    {
        $factory = $request->all()['factory'];
        $start = $request->all()['start'];
        $end = $request->all()['end'];
        $type = $request->all()['type'];
        $date = date("Y-m");

        // Convert date
        $new_date_start = date('d-m-Y', strtotime($start));
        $new_date_end = date('d-m-Y', strtotime($end));

        if($type == 1){
            $my_report = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\principal\\principal_summary.rpt";
        }else{
            $my_report = "C:\\xampp\\htdocs\\report_ppi\\public\\report\\principal\\principal_detail.rpt";
        }
        
        $my_pdf = 'C:\\xampp\\htdocs\\report_ppi\\public\\report\\principal\\export\\principal-semester-'.$date.'.pdf';

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

        $creport->ParameterFields(3)->SetCurrentValue ("$new_date_start"); // <-- param 1
        $creport->ParameterFields(4)->SetCurrentValue ("$new_date_end"); // <-- param 2

        // pass parameter record selection formula
        $creport->RecordSelectionFormula = "{tbl_factory.factory_name}='$factory'AND{tbl_sales_invoice.invoice_date}>=#$start#AND{tbl_sales_invoice.invoice_date}<=#$end#";

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

        $file = 'C:\\xampp\\htdocs\\report_ppi\\public\\report\\principal\\export\\principal-semester-'.$date.'.pdf';

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