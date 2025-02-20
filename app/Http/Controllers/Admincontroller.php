<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Dropdowncontroller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Admincontroller extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }  
    //Data total
    function index(){
        $areas = DB::table('area')->get();

        $data = DB::table('main_csv as m')
            ->leftJoin('saq_csv as s', 'm.id', '=', 's.id_saq')
            ->leftJoin('cr_csv as c', 'm.id', '=', 'c.id_cr')
            ->leftJoin('tssr_csv as t', 'm.id', '=', 't.id_tssr')
            ->leftJoin('civilwork_csv as cw', 'm.id', '=', 'cw.id_cw')
            ->get();
        
        return view('blog', compact('areas','data'));
// OK
        
    }

    public function edit($id) {
        $areas = DB::table('area')->get();
        $blog = DB::table("main_csv as m")
                ->leftJoin('saq_csv as s', 'm.id', '=', 's.id_saq')
                ->leftJoin('cr_csv as c', 'm.id', '=', 'c.id_cr')
                ->leftJoin('tssr_csv as t', 'm.id', '=', 't.id_tssr')
                ->leftJoin('civilwork_csv as cw', 'm.id', '=', 'cw.id_cw')
                ->join('area as b', 'm.Region_id', '=', 'b.Region_id')
                ->where('m.id', $id)
                ->first();
        
        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (!$blog) {
            return redirect()->back()->withErrors('Data not found for the given ID.');
        }
    
        return view("edit", compact("blog", "areas"));
    }
    
    // LINE NOTIFY
    private function sendLineNotify($message)
    {
        $line_token = 'Rsov88H4frcqLTscPnyPKSBuESSuccoqKFfPO1QcZey'; // ใส่ Line Notify Token ของคุณ
        $line_api = 'https://notify-api.line.me/api/notify';
        $queryData = http_build_query(['message' => $message], '', '&');
        
        $headerOptions = [
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
                             "Authorization: Bearer ".$line_token."\r\n" .
                             "Content-Length: ".strlen($queryData)."\r\n",
                'content' => $queryData,
            ],
        ];
    
        $context = stream_context_create($headerOptions);
        $result = file_get_contents($line_api, false, $context);
        
        return json_decode($result);
    }
    
    function update(Request $request, $id){

        $blog = DB::table("main_csv as m")
                ->leftJoin('saq_csv as s', 'm.id', '=', 's.id_saq')
                ->leftJoin('cr_csv as c', 'm.id', '=', 'c.id_cr')
                ->leftJoin('tssr_csv as t', 'm.id', '=', 't.id_tssr')
                ->leftJoin('civilwork_csv as cw', 'm.id', '=', 'cw.id_cw')
                ->join('area as b', 'm.Region_id', '=', 'b.Region_id')
                ->where('m.id', $id)
                ->first();

        $request->validate([
            'SiteCode'=> 'required',

        ],
        [
            'SiteCode' =>'กรุณากรอก SiteCode',   

        ]);



        // แปลงค่าเป็นตัวเลขก่อนการคำนวณ BALACE

        $amount1_IN = floatval($request->Amount1_IN);
        $amount2_IN = floatval($request->Amount2_IN);
        $po_Amount = floatval($request->PO_Amount_IN);

        // คำนวณผลรวม
        $total = $amount1_IN + $amount2_IN;
        $banlace = $request->PO_Amount_IN;
        $difference = ($banlace - $total); 

        if(empty($banlace)){
            $Banlace_IN = null;
        }elseif($total > $banlace){
            $Banlace_IN = $difference;
            
        }else{
            $Banlace_IN = $difference;
            }

    
        $data_MAIN = [ //input form
            'GTNJobNo'=> $request->GTNJobNo ,
            'RefCode'=> $request->RefCode ,
            'PlanType'=> $request->PlanType ,
            'Region_id'=> $request->Region_id ,
            'Province'=> $request->Province ,
            'OwnerOldSte'=> $request->OwnerOldSte ,
            'SiteCode'=> $request->SiteCode ,
            'SiteNAME_T'=> $request->SiteNAME_T ,
            'SiteType'=> $request->SiteType ,
            'CancelSite'=> $request->CancelSite ,
            'TowerNewSite'=> $request->TowerNewSite ,
            'Towerheight'=> $request->Towerheight ,
            'Tower'=> $request->Tower ,
            'Zone'=> $request->Zone ,
            'DeadLine'=> $request->DeadLine ,
            'DeadLine_Y'=> $request->DeadLine_Y ,
            'Status'=> $request->Status ,

            // INVOICE
            'Quotation_IN'=> $request->Quotation_IN ,
            'PO_No_IN'=> $request->PO_No_IN ,
            'PO_Amount_IN'=> $request->PO_Amount_IN ,
            'Invoice1_IN'=> $request->Invoice1_IN ,
            'Amount1_IN'=> $request->Amount1_IN ,
            'Invoice2_IN'=> $request->Invoice2_IN ,
            'Amount2_IN'=> $request->Amount2_IN  ,
            
            'Banlace_IN' => number_format($Banlace_IN, 2, '.', ''),


        ];

        // แปลงค่าเป็นตัวเลขก่อนการคำนวณ BALACE

            $accept_1st_saq = floatval($request->Accept_1st_SAQ);
            $accept_2nd_saq = floatval($request->Accept_2nd_SAQ);
            $accept_3rd_saq = floatval($request->Accept_3rd_SAQ);
            $accept_4th_saq = floatval($request->Accept_4th_SAQ);
            $wo_price_saq = floatval($request->WO_Price_SAQ);

            // คำนวณผลรวม
            $total = $accept_1st_saq + $accept_2nd_saq + $accept_3rd_saq + $accept_4th_saq;
            $banlace = $request->WO_Price_SAQ;
            $difference = ($banlace - $total);  

            if(empty($banlace)){
                $banlace_saq = null;
            }elseif($total > $banlace){
                $banlace_saq = $difference;
            }else{
                $banlace_saq = $difference;
                }
    
        $data_SAQ = [
            'AssignedSubCSurveySAQ' => $request->AssignedSubCSurveySAQ ,    
            'PlanSurveySAQ' => $request->PlanSurveySAQ ,
            'ActualSurveySAQ' => $request->ActualSurveySAQ ,
            'SubName_SAQ' => $request->SubName_SAQ ,
            'Quo_No_SAQ' => $request->Quo_No_SAQ ,
            'PR_Price_SAQ' => $request->PR_Price_SAQ ,
            'Accept_PR_Date_SAQ' => $request->Accept_PR_Date_SAQ ,
            'WO_No_SAQ' => $request->WO_No_SAQ ,
            'WO_Price_SAQ' => $request->WO_Price_SAQ ,

            'Accept_1st_SAQ' => $request->Accept_1st_SAQ ,
            'Mail_1st_SAQ' => $request->Mail_1st_SAQ ,  // วันที่ในรูปแบบ d-m-Y
            'ERP_1st_SAQ' => $request->ERP_1st_SAQ ,   // วันที่ในรูปแบบ d-m-Y

            'Accept_2nd_SAQ' => $request->Accept_2nd_SAQ ,
            'Mail_2nd_SAQ' => $request->Mail_2nd_SAQ ,  // วันที่ในรูปแบบ d-m-Y
            'ERP_2nd_SAQ' => $request->ERP_2nd_SAQ ,   // วันที่ในรูปแบบ d-m-Y

            'Accept_3rd_SAQ' => $request->Accept_3rd_SAQ,
            'Mail_3rd_SAQ' => $request->Mail_3rd_SAQ ,  // วันที่ในรูปแบบ d-m-Y
            'ERP_3rd_SAQ' => $request->ERP_3rd_SAQ ,   // วันที่ในรูปแบบ d-m-Y

            'Accept_4th_SAQ' => $request->Accept_4th_SAQ ,
            'Mail_4th_SAQ' => $request->Mail_4th_SAQ ,  // วันที่ในรูปแบบ d-m-Y
            'ERP_4th_SAQ' => $request->ERP_4th_SAQ ,   // วันที่ในรูปแบบ d-m-Y

            'Banlace_SAQ' => number_format($banlace_saq, 2, '.', ''),

        ];

        // แปลงค่าเป็นตัวเลขก่อนการคำนวณ BALACE

        $accept_1st_cr = floatval($request->Accept_1st_CR);
        $accept_2nd_cr = floatval($request->Accept_2nd_CR);
        $accept_3rd_cr = floatval($request->Accept_3rd_CR);
        $accept_4th_cr = floatval($request->Accept_4th_CR);
        $wo_price_cr = floatval($request->WO_Price_CR);

        // คำนวณผลรวม
        $total = $accept_1st_cr + $accept_2nd_cr + $accept_3rd_cr + $accept_4th_cr;
        $banlace = $request->WO_Price_CR;
        $difference = ($banlace - $total); 

        if(empty($banlace)){
            $banlace_cr = null;
        }elseif($total > $banlace){
            $banlace_cr = $difference;
        }else{
            $banlace_cr = $difference;
            }
    
            // -- CR -->
        $data_CR = [
            'AssignedSubCCR'=> $request->AssignedSubCCR  , //Date
            'PlanCR'=> $request->PlanCR  , //Date
            'ActualCR'=> $request->ActualCR , //Date
            'SubName_CR'=> $request->SubName_CR ,
            'Quo_No_CR'=> $request->Quo_No_CR ,
            'PR_Price_CR'=> $request->PR_Price_CR ,
            'Accept_PR_Date_CR'=> $request->Accept_PR_Date_CR , //Date
            'WO_No_CR'=> $request->WO_No_CR ,
            'WO_Price_CR'=> $request->WO_Price_CR ,

            'Accept_1st_CR'=> $request->Accept_1st_CR ,
            'Mail_1st_CR' => $request->Mail_1st_CR ,  // วันที่ในรูปแบบ d-m-Y
            'ERP_1st_CR' => $request->ERP_1st_CR ,

            'Accept_2nd_CR'=> $request->Accept_2nd_CR ,
            'Mail_2nd_CR' => $request->Mail_2nd_CR ,  // วันที่ในรูปแบบ d-m-Y
            'ERP_2nd_CR' => $request->ERP_2nd_CR ,  

            'Accept_3rd_CR'=> $request->Accept_3rd_CR ,
            'Mail_3rd_CR' => $request->Mail_3rd_CR ,  // วันที่ในรูปแบบ d-m-Y
            'ERP_3rd_CR' => $request->ERP_3rd_CR , 

            'Accept_4th_CR'=> $request->Accept_4th_CR ,
            'Mail_4th_CR' => $request->Mail_4th_CR ,
            'ERP_4th_CR'=> $request->ERP_4th_CR , //Date

            
            'Banlace_CR' => number_format($banlace_cr, 2, '.', ''),

        ];

        

        // แปลงค่าเป็นตัวเลขก่อนการคำนวณ BALACE

         // -- TSSR -->

        $accept_1st_TSSR = floatval($request->Accept_1st_TSSR);
        $accept_2nd_TSSR = floatval($request->Accept_2nd_TSSR);
        $accept_3rd_TSSR = floatval($request->Accept_3rd_TSSR);
        $accept_4th_TSSR = floatval($request->Accept_4th_TSSR);
        $wo_price_TSSR = floatval($request->WO_Price_TSSR);

        // คำนวณผลรวม
        $total = $accept_1st_TSSR + $accept_2nd_TSSR + $accept_3rd_TSSR + $accept_4th_TSSR;
        $banlace = $request->WO_Price_TSSR;
        $difference = ($banlace - $total);

        if(empty($banlace)){
            $banlace_TSSR = null;
        }elseif($total > $banlace){
            $banlace_TSSR = $difference;
        }else{
            $banlace_TSSR = $difference;
            }
        
        $data_TSSR = [
            'AssignedSubCTSSR'=> $request->AssignedSubCTSSR , //Date
            'PlanTSSR'=> $request->PlanTSSR   , //Date
            'ActualTSSR'=> $request->ActualTSSR , //Date
            'SubName_TSSR'=> $request->SubName_TSSR ,
            'Quo_No_TSSR'=> $request->Quo_No_TSSR ,
            'PR_Price_TSSR'=> $request->PR_Price_TSSR ,
            'Accept_PR_Date_TSSR'=> $request->Accept_PR_Date_TSSR , //Date
            'WO_No_TSSR'=> $request->WO_No_TSSR ,
            'WO_Price_TSSR'=> $request->WO_Price_TSSR ,
            
            'Accept_1st_TSSR'=> $request->Accept_1st_TSSR ,
            'Mail_1st_TSSR' => $request->Mail_1st_TSSR ,  // วันที่ในรูปแบบ d-m-Y
            'ERP_1st_TSSR' => $request->ERP_1st_TSSR ,

            'Accept_2nd_TSSR'=> $request->Accept_2nd_TSSR ,
            'Mail_2nd_TSSR' => $request->Mail_2nd_TSSR ,  // วันที่ในรูปแบบ d-m-Y
            'ERP_2nd_TSSR' => $request->ERP_2nd_TSSR ,  

            'Accept_3rd_TSSR'=> $request->Accept_3rd_TSSR ,
            'Mail_3rd_TSSR' => $request->Mail_3rd_TSSR ,  // วันที่ในรูปแบบ d-m-Y
            'ERP_3rd_TSSR' => $request->ERP_3rd_TSSR , 

            'Accept_4th_TSSR'=> $request->Accept_4th_TSSR ,
            'Mail_4th_TSSR' => $request->Mail_4th_TSSR ,
            'ERP_4th_TSSR' => $request->ERP_4th_TSSR ,         
    
            'Banlace_TSSR' => number_format($banlace_TSSR, 2, '.', ''),
        ];
            

        // แปลงค่าเป็นตัวเลขก่อนการคำนวณ BALACE

         // CivilWork

        $accept_1st_CivilWork = floatval($request->Accept_1st_CivilWork);
        $accept_2nd_CivilWork = floatval($request->Accept_2nd_CivilWork);
        $accept_3rd_CivilWork = floatval($request->Accept_3rd_CivilWork);
        $accept_4th_CivilWork = floatval($request->Accept_4th_CivilWork);
        $wo_price_CivilWork = floatval($request->WO_Price_CivilWork);

        // คำนวณผลรวม
        $total = $accept_1st_CivilWork + $accept_2nd_CivilWork + $accept_3rd_CivilWork + $accept_4th_CivilWork;
        $banlace = $request->WO_Price_CivilWork;
        $difference = ($banlace - $total);

        if(empty($banlace)){
            $banlace_CivilWork = null;
        }elseif($total > $banlace){
            $banlace_CivilWork = $difference;
        }else{
            $banlace_CivilWork = $difference;
            }
 

        $data_CW = [

            
            'AssignSubCivilfoundation'=> $request->AssignSubCivilfoundation ,
            'PlanCivilWorkFoundation'=> $request->PlanCivilWorkFoundation ,
            'ActualCivilWorkTower'=> $request->ActualCivilWorkTower ,
            'AssignCivilWorkTower'=> $request->AssignCivilWorkTower ,
            'PlanInstallationRectifier'=> $request->PlanInstallationRectifier ,
            'ActualInstallationRectifier'=> $request->ActualInstallationRectifier ,
            'PlanACPower'=> $request->PlanACPower  ,
            'ActualACPower'=> $request->ActualACPower  ,
            'PlanACMeter'=> $request->PlanACMeter ,
            'ActualACMeter'=> $request->ActualACMeter , 
            'PAT'=> $request->PAT,
            'DefPAT'=> $request->DefPAT ,
            'FAT'=> $request->FAT ,
            
            'Assigned_CivilWork' => $request->Assigned_CivilWork  ,      // วันที่ในรูปแบบ d-m-Y
            'Plan_CivilWork' => $request->Plan_CivilWork  ,   // วันที่ในรูปแบบ d-m-Y
            'Actual_CivilWork' => $request->Actual_CivilWork , // วันที่ในรูปแบบ d-m-Y
            'SubName_CivilWork'=> $request->SubName_CivilWork  ,
            'Quo_No_CivilWork'=> $request->Quo_No_CivilWork  ,
            'PR_Price_CivilWork'=> $request->PR_Price_CivilWork  , //กรอกเลข 0.00    
            'Accept_PR_Date_CivilWork'=> $request->Accept_PR_Date_CivilWork  ,     // วันที่ในรูปแบบ d-m-Y
            'WO_No_CivilWork'=> $request->WO_No_CivilWork  ,       //กรอกเลข 0.00
            'WO_Price_CivilWork'=> $request->WO_Price_CivilWork  , //กรอกเลข 0.00

            'Accept_1st_CivilWork'=> $request->Accept_1st_CivilWork ,    //กรอกเลข 0.00
            'Mail_1st_CivilWork' => $request->Mail_1st_CivilWork ,  // วันที่ในรูปแบบ d-m-Y
            'ERP_1st_CivilWork' => $request->ERP_1st_CivilWork ,   // วันที่ในรูปแบบ d-m-Y
            
            'Accept_2nd_CivilWork'=> $request->Accept_2nd_CivilWork ,   //กรอกเลข 0.00
            'Mail_2nd_CivilWork' => $request->Mail_2nd_CivilWork , // วันที่ในรูปแบบ d-m-Y
            'ERP_2nd_CivilWork' => $request->ERP_2nd_CivilWork ,   // วันที่ในรูปแบบ d-m-Y

            'Accept_3rd_CivilWork'=> $request->Accept_3rd_CivilWork ,  //กรอกเลข 0.00
            'Mail_3rd_CivilWork' => $request->Mail_3rd_CivilWork ,   // วันที่ในรูปแบบ d-m-Y
            'ERP_3rd_CivilWork' => $request->ERP_3rd_CivilWork ,    // วันที่ในรูปแบบ d-m-Y

            'Accept_4th_CivilWork'=> $request->Accept_4th_CivilWork ,   //กรอกเลข 0.00
            'Mail_4th_CivilWork' => $request->Mail_4th_CivilWork ,   // วันที่ในรูปแบบ d-m-Y
            'ERP_4th_CivilWork' => $request->ERP_4th_CivilWork ,    // วันที่ในรูปแบบ d-m-Y

            'Banlace_CivilWork' => number_format($banlace_CivilWork, 2, '.', ''),

        ];

        
        try {


            // เริ่ม transaction
            DB::beginTransaction();

            // รับข้อมูลเก่าจากฐานข้อมูลเพื่อตรวจสอบการเปลี่ยนแปลง

            $main = DB::table("main_csv")->where("id", $id)->first();
            $saq = DB::table("saq_csv")->where("id_saq", $id)->first();
            $cr = DB::table("cr_csv")->where("id_cr", $id)->first();
            $tssr = DB::table("tssr_csv")->where("id_tssr", $id)->first();
            $cw = DB::table("civilwork_csv")->where("id_cw", $id)->first();
        
           // dd($data_MAIN, $data_SAQ, $data_CR, $data_TSSR, $data_CW);
           
            // อัปเดตข้อมูลในตาราง main_csv โดยใช้ $id ที่มีอยู่แล้ว
            DB::table('main_csv')->where('id', $id)->update($data_MAIN);
            // อัปเดตข้อมูลในตาราง saq_csv โดยใช้ id_saq
            DB::table("saq_csv")->where("id_saq", $id)->update($data_SAQ);
            // อัปเดตข้อมูลในตาราง cr_csv โดยใช้ id_cr
            DB::table("cr_csv")->where("id_cr", $id)->update($data_CR);
            // อัปเดตข้อมูลในตาราง tssr_csv โดยใช้ id_tssr
            DB::table("tssr_csv")->where("id_tssr", $id)->update($data_TSSR);
            // อัปเดตข้อมูลในตาราง civilwork_csv โดยใช้ id_cw
            DB::table("civilwork_csv")->where("id_cw", $id)->update($data_CW);
            // Commit transaction หลังจากอัปเดตสำเร็จ
            DB::commit();

            

            // สร้างข้อความที่ต้องการส่งไปยัง LINE Notify
            $name = Auth::user()->name; // ดึงชื่อของผู้ใช้ที่เข้าสู่ระบบ
            
            $message = $name . " อัปเดตข้อมูล " . "\n" .
                       "SiteCode : " . $request->input('SiteCode') . "\n";
                      


            // ตรวจสอบว่ามีค่าหรือไม่ก่อนจะเพิ่มเข้าไปในข้อความ  INVOICE

            if ($request->filled('PO_No_IN') && $request->input('PO_No_IN') != $main->PO_No_IN) {
                $message .= "PO No: " . $request->input('PO_No_IN') . "\n";
            }   
            
            if ($request->filled('Invoice1_IN') && $request->input('Invoice1_IN') != $main->Invoice1_IN) {
                $message .= "Invoice 1: " . $request->input('Invoice1_IN') . "\n";
            }

            if ($request->filled('Amount1_IN') && $request->input('Amount1_IN') != $main->Amount1_IN) {
                $message .= "Amount 1: " . $request->input('Amount1_IN') . "\n";
            }

            if ($request->filled('Invoice2_IN') && $request->input('Invoice2_IN') != $main->Invoice2_IN) {
                $message .= "Invoice 2: " . $request->input('Invoice2_IN') . "\n";
            }   
            
            if ($request->filled('Amount2_IN') && $request->input('Amount2_IN') != $main->Amount2_IN) {
                $message .= "Amount 2: " . $request->input('Amount2_IN') . "\n\n";
            }

            
            // ตรวจสอบว่ามีค่าหรือไม่ก่อนจะเพิ่มเข้าไปในข้อความ  SAQ
            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 1
            if ($request->filled('Accept_1st_SAQ') && $request->input('Accept_1st_SAQ') != $saq->Accept_1st_SAQ) {
                $message .= "Accept 1st SAQ: " . $request->input('Accept_1st_SAQ') . "\n";
            }   
            
            if ($request->filled('Mail_1st_SAQ') && $request->input('Mail_1st_SAQ') != $saq->Mail_1st_SAQ) {
                $message .= "Mail 1st SAQ: " . $request->input('Mail_1st_SAQ') . "\n";
            }

            if ($request->filled('ERP_1st_SAQ') && $request->input('ERP_1st_SAQ') != $saq->ERP_1st_SAQ) {
                $message .= "ERP 1st SAQ: " . $request->input('ERP_1st_SAQ') . "\n";
            }

            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 2
            if ($request->filled('Accept_2nd_SAQ') && $request->input('Accept_2nd_SAQ') != $saq->Accept_2nd_SAQ) {
                $message .= "Accept 2nd SAQ: " . $request->input('Accept_2nd_SAQ') . "\n";
            }   
            
            if ($request->filled('Mail_2nd_SAQ') && $request->input('Mail_2nd_SAQ') != $saq->Mail_2nd_SAQ) {
                $message .= "Mail 2nd SAQ: " . $request->input('Mail_2nd_SAQ') . "\n";
            }

            if ($request->filled('ERP_2nd_SAQ') && $request->input('ERP_2nd_SAQ') != $saq->ERP_2nd_SAQ) {
                $message .= "ERP 2nd SAQ: " . $request->input('ERP_2nd_SAQ') . "\n";
            }

            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 3
            if ($request->filled('Accept_3rd_SAQ') && $request->input('Accept_3rd_SAQ') != $saq->Accept_3rd_SAQ) {
                $message .= "Accept 3rd SAQ: " . $request->input('Accept_3rd_SAQ') . "\n";
            }   
            
            if ($request->filled('Mail_3rd_SAQ') && $request->input('Mail_3rd_SAQ') != $saq->Mail_3rd_SAQ) {
                $message .= "Mail 3rd SAQ: " . $request->input('Mail_3rd_SAQ') . "\n";
            }

            if ($request->filled('ERP_3rd_SAQ') && $request->input('ERP_3rd_SAQ') != $saq->ERP_3rd_SAQ) {
                $message .= "ERP 3rd SAQ: " . $request->input('ERP_3rd_SAQ') . "\n";
            }

            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 4
            if ($request->filled('Accept_4th_SAQ') && $request->input('Accept_4th_SAQ') != $saq->Accept_4th_SAQ) {
                $message .= "Accept 4th SAQ: " . $request->input('Accept_4th_SAQ') . "\n";
            }   
            
            if ($request->filled('Mail_4th_SAQ') && $request->input('Mail_4th_SAQ') != $saq->Mail_4th_SAQ) {
                $message .= "Mail 4th SAQ: " . $request->input('Mail_4th_SAQ') . "\n";
            }

            if ($request->filled('ERP_4th_SAQ') && $request->input('ERP_4th_SAQ') != $saq->ERP_4th_SAQ) {
                $message .= "ERP 4th SAQ: " . $request->input('ERP_4th_SAQ') . "\n\n";
            }



            // ตรวจสอบว่ามีค่าหรือไม่ก่อนจะเพิ่มเข้าไปในข้อความ  CR
            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 1
            if ($request->filled('Accept_1st_CR') && $request->input('Accept_1st_CR') != $cr->Accept_1st_CR) {
                $message .= "Accept 1st CR: " . $request->input('Accept_1st_CR') . "\n";
            }

            if ($request->filled('Mail_1st_CR') && $request->input('Mail_1st_CR') != $cr->Mail_1st_CR) {
                $message .= "Mail 1st CR: " . $request->input('Mail_1st_CR') . "\n";
            }

            if ($request->filled('ERP_1st_CR') && $request->input('ERP_1st_CR') != $cr->ERP_1st_CR) {
                $message .= "ERP 1st CR: " . $request->input('ERP_1st_CR') . "\n";
            }

            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 2
            if ($request->filled('Accept_2nd_CR') && $request->input('Accept_2nd_CR') != $cr->Accept_2nd_CR) {
                $message .= "Accept 2nd CR: " . $request->input('Accept_2nd_CR') . "\n";
            }

            if ($request->filled('Mail_2nd_CR') && $request->input('Mail_2nd_CR') != $cr->Mail_2nd_CR) {
                $message .= "Mail 2nd CR: " . $request->input('Mail_2nd_CR') . "\n";
            }

            if ($request->filled('ERP_2nd_CR') && $request->input('ERP_2nd_CR') != $cr->ERP_2nd_CR) {
                $message .= "ERP 2nd CR: " . $request->input('ERP_2nd_CR') . "\n";
            }

            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 3
            if ($request->filled('Accept_3rd_CR') && $request->input('Accept_3rd_CR') != $cr->Accept_3rd_CR) {
                $message .= "Accept 3rd CR: " . $request->input('Accept_3rd_CR') . "\n";
            }

            if ($request->filled('Mail_3rd_CR') && $request->input('Mail_3rd_CR') != $cr->Mail_3rd_CR) {
                $message .= "Mail 2nd CR: " . $request->input('Mail_3rd_CR') . "\n";
            }

            if ($request->filled('ERP_3rd_CR') && $request->input('ERP_3rd_CR') != $cr->ERP_3rd_CR) {
                $message .= "ERP 3rd CR: " . $request->input('ERP_3rd_CR') . "\n";
            }

            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 4
            if ($request->filled('Accept_4th_CR') && $request->input('Accept_4th_CR') != $cr->Accept_4th_CR) {
                $message .= "Accept 4th CR: " . $request->input('Accept_4th_CR') . "\n";
            }

            if ($request->filled('Mail_4th_CR') && $request->input('Mail_4th_CR') != $cr->Mail_4th_CR) {
                $message .= "Mail 4th CR: " . $request->input('Mail_4th_CR') . "\n";
            }

            if ($request->filled('ERP_4th_CR') && $request->input('ERP_4th_CR') != $cr->ERP_4th_CR) {
                $message .= "ERP 4th CR: " . $request->input('ERP_4th_CR') . "\n\n";
            }

            


            // ตรวจสอบว่ามีค่าหรือไม่ก่อนจะเพิ่มเข้าไปในข้อความ  TSRR
            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 1
            if ($request->filled('Accept_1st_TSSR') && $request->input('Accept_1st_TSSR') != $tssr->Accept_1st_TSSR) {
                $message .= "Accept 1st TSSR: " . $request->input('Accept_1st_TSSR') . "\n";
            }

            if ($request->filled('Mail_1st_TSSR') && $request->input('Mail_1st_TSSR') != $tssr->Mail_1st_TSSR) {
                $message .= "Mail 1st TSSR: " . $request->input('Mail_1st_TSSR') . "\n";
            }

            if ($request->filled('ERP_1st_TSSR') && $request->input('ERP_1st_TSSR') != $tssr->ERP_1st_TSSR) {
                $message .= "ERP 1st TSSR: " . $request->input('ERP_1st_TSSR') . "\n";
            }

            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 2
            if ($request->filled('Accept_2nd_TSSR') && $request->input('Accept_2nd_TSSR') != $tssr->Accept_2nd_TSSR) {
                $message .= "Accept 2nd TSSR: " . $request->input('Accept_2nd_TSSR') . "\n";
            }

            if ($request->filled('Mail_2nd_TSSR') && $request->input('Mail_2nd_TSSR') != $tssr->Mail_2nd_TSSR) {
                $message .= "Mail 2nd TSSR: " . $request->input('Mail_2nd_TSSR') . "\n";
            }

            if ($request->filled('ERP_2nd_TSSR') && $request->input('ERP_2nd_TSSR') != $tssr->ERP_2nd_TSSR) {
                $message .= "ERP 2nd TSSR: " . $request->input('ERP_2nd_TSSR') . "\n";
            }

            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 3
            if ($request->filled('Accept_3rd_TSSR') && $request->input('Accept_3rd_TSSR') != $tssr->Accept_3rd_TSSR) {
                $message .= "Accept 3rd TSSR: " . $request->input('Accept_3rd_TSSR') . "\n";
            }

            if ($request->filled('Mail_3rd_TSSR') && $request->input('Mail_3rd_TSSR') != $tssr->Mail_3rd_TSSR) {
                $message .= "Mail 3rd TSSR: " . $request->input('Mail_3rd_TSSR') . "\n";
            }

            if ($request->filled('ERP_3rd_TSSR') && $request->input('ERP_3rd_TSSR') != $tssr->ERP_3rd_TSSR) {
                $message .= "ERP 3rd TSSR: " . $request->input('ERP_3rd_TSSR') . "\n";
            }

            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 4
            if ($request->filled('Accept_4th_TSSR') && $request->input('Accept_4th_TSSR') != $tssr->Accept_4th_TSSR) {
                $message .= "Accept 4th TSSR: " . $request->input('Accept_4th_TSSR') . "\n";
            }

            if ($request->filled('Mail_4th_TSSR') && $request->input('Mail_4th_TSSR') != $tssr->Mail_4th_TSSR) {
                $message .= "Mail 4th TSSR: " . $request->input('Mail_4th_TSSR') . "\n";
            }

            if ($request->filled('ERP_4th_TSSR') && $request->input('ERP_4th_TSSR') != $tssr->ERP_4th_TSSR) {
                $message .= "ERP 4th TSSR: " . $request->input('ERP_4th_TSSR') . "\n\n";
            }



            // ตรวจสอบว่ามีค่าหรือไม่ก่อนจะเพิ่มเข้าไปในข้อความ  CIVILWORK
            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 1
            if ($request->filled('Accept_1st_CivilWork') && $request->input('Accept_1st_CivilWork') != $cw->Accept_1st_CivilWork) {
                $message .= "Accept 1st Civil Work: " . $request->input('Accept_1st_CivilWork') . "\n";
            }

            if ($request->filled('Mail_1st_CivilWork') && $request->input('Mail_1st_CivilWork') != $cw->Mail_1st_CivilWork) {
                $message .= "Mail 1st Civil Work: " . $request->input('Mail_1st_CivilWork') . "\n";
            }

            if ($request->filled('ERP_1st_CivilWork') && $request->input('ERP_1st_CivilWork') != $cw->ERP_1st_CivilWork) {
                $message .= "ERP 1st Civil Work: " . $request->input('ERP_1st_CivilWork') . "\n";
            }

            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 2 
            if ($request->filled('Accept_2nd_CivilWork') && $request->input('Accept_2nd_CivilWork') != $cw->Accept_2nd_CivilWork) {
                $message .= "Accept 2nd CivilWork: " . $request->input('Accept_2nd_CivilWork') . "\n";
            }

            if ($request->filled('Mail_2nd_CivilWork') && $request->input('Mail_2nd_CivilWork') != $cw->Mail_2nd_CivilWork) {
                $message .= "Mail 2nd Civil Work: " . $request->input('Mail_2nd_CivilWork') . "\n";
            }

            if ($request->filled('ERP_2nd_CivilWork') && $request->input('ERP_2nd_CivilWork') != $cw->ERP_2nd_CivilWork) {
                $message .= "ERP 2nd Civil Work: " . $request->input('ERP_2nd_CivilWork') . "\n";
            }

        // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 3
            if ($request->filled('Accept_3rd_CivilWork') && $request->input('Accept_3rd_CivilWork') != $cw->Accept_3rd_CivilWork) {
                $message .= "Accept 3rd CivilWork: " . $request->input('Accept_3rd_CivilWork') . "\n";
            }

            if ($request->filled('Mail_3rd_CivilWork') && $request->input('Mail_3rd_CivilWork') != $cw->Mail_3rd_CivilWork) {
                $message .= "Mail 3rd Civil Work: " . $request->input('Mail_3rd_CivilWork') . "\n";
            }

            if ($request->filled('ERP_3rd_CivilWork') && $request->input('ERP_3rd_CivilWork') != $cw->ERP_3rd_CivilWork) {
                $message .= "ERP 3rd Civil Work: " . $request->input('ERP_3rd_CivilWork') . "\n";
            }
            
            // ตรวจสอบข้อมูลใหม่กับข้อมูลเก่าก่อนแจ้งเตือน  ACCEPT 4
            if ($request->filled('Accept_4th_CivilWork') && $request->input('Accept_4th_CivilWork') != $cw->Accept_4th_CivilWork) {
                $message .= "Accept 4th CivilWork: " . $request->input('Accept_4th_CivilWork') . "\n";
            }

            if ($request->filled('Mail_4th_CivilWork') && $request->input('Mail_4th_CivilWork') != $cw->Mail_4th_CivilWork) {
                $message .= "Mail 4th Civil Work: " . $request->input('Mail_4th_CivilWork') . "\n";
            }

            if ($request->filled('ERP_4th_CivilWork') && $request->input('ERP_4th_CivilWork') != $cw->ERP_4th_CivilWork) {
                $message .= "ERP 4th Civil Work: " . $request->input('ERP_4th_CivilWork') . "\n";
            }
            
            // ส่งข้อความไปยัง LINE Notify
            $this->sendLineNotify($message);
        
            // ส่งข้อความ success กลับไปยังหน้าเดิม
            return back()->with('success', 'Updated New Site successfully');
        
        } catch (\Exception $e) {
            // Rollback transaction หากเกิดข้อผิดพลาด
            DB::rollback();
            
            // จัดการกับข้อผิดพลาดที่เกิดขึ้นที่นี่ เช่นการแจ้งเตือน
            throw $e;
        }
            
    }

    // ฟังก์ชันสำหรับแปลงวันที่
        private function convertToDateFormat($date)
        {
            if ($date) {
                $dateObject = \DateTime::createFromFormat(format: 'd-m-Y', datetime: $date);
                if ($dateObject) {
                    return $dateObject->format('d-m-Y');
                }
            }
            return null; // หรือค่าเริ่มต้นอื่น ๆ
        }

    
    function add(){
        $areas = DB::table('area')->get();   
        return view('add', compact("areas"));
    }

    // เพิ่ม Sitecode
    function insert(Request $request){
        
        $request->validate([
            'SiteCode'=> 'required',

            // Money decimal (10,2) 

            'WO_Price_CivilWork' => 'nullable|numeric',
            'Accept_1st_CivilWork' => 'nullable|numeric',
            'Accept_2nd_CivilWork' => 'nullable|numeric',
            'Accept_3rd_CivilWork' => 'nullable|numeric',
            'Accept_4th_CivilWork' => 'nullable|numeric',
            'Banlace_CivilWork' => 'nullable|numeric',
     
            // Date d-m-Y
                'Assigned_CivilWork' => 'nullable|date_format:d-m-Y',
                'Plan_CivilWork' => 'nullable|date_format:d-m-Y',
                'Actual_CivilWork' => 'nullable|date_format:d-m-Y',
                'Accept_PR_Date_CivilWork' => 'nullable|date_format:d-m-Y',
                'Mail_1st_CivilWork' => 'nullable|date_format:d-m-Y',
                'ERP_1st_CivilWork' => 'nullable|date_format:d-m-Y',
                'Mail_2nd_CivilWork' => 'nullable|date_format:d-m-Y',
                'ERP_2nd_CivilWork' => 'nullable|date_format:d-m-Y',
                'Mail_3rd_CivilWork' => 'nullable|date_format:d-m-Y',
                'ERP_3rd_CivilWork' => 'nullable|date_format:d-m-Y',
                'Mail_4th_CivilWork' => 'nullable|date_format:d-m-Y',
                'ERP_4th_CivilWork' => 'nullable|date_format:d-m-Y',
            
        ],
        [
            'SiteCode' =>'กรุณากรอก SiteCode',
        ]);

             // Form MAIN

             $data_MAIN = [
                'GTNJobNo'=> $request->GTNJobNo,
                'RefCode'=> $request->RefCode,
                'PlanType'=> $request->PlanType,
                'Region_id'=> $request->Region_id,
                'Province'=> $request->Province,
                'OwnerOldSte'=> $request->OwnerOldSte,
                'SiteCode'=> $request->SiteCode,
                'SiteNAME_T'=> $request->SiteNAME_T,
                'SiteType'=> $request->SiteType,
                'CancelSite'=> $request->CancelSite,
                'TowerNewSite'=> $request->TowerNewSite,
                'Towerheight'=> $request->Towerheight,
                'Tower'=> $request->Tower,
                'Zone'=> $request->Zone,
                'DeadLine'=> $request->DeadLine,
                'DeadLine_Y'=> $request->DeadLine_Y,
                'Status'=> $request->Status,
             ];


            // Form CivilWork

            $civilwork = [
                'WO_Price_CivilWork' => $request->input('WO_Price_CivilWork'),
                'Accept_1st_CivilWork' => $request->input('Accept_1st_CivilWork'),
                'Accept_2nd_CivilWork' => $request->input('Accept_2nd_CivilWork'),
                'Accept_3rd_CivilWork' => $request->input('Accept_3rd_CivilWork'),
                'Accept_4th_CivilWork' => $request->input('Accept_4th_CivilWork'),
                'Banlace_CivilWork' => $request->input('Banlace_CivilWork'),
                'PR_Price_CivilWork' => $request->input('PR_Price_CivilWork'),
            ];
    
            // ตรวจสอบและจัดรูปแบบทศนิยม 2 ตำแหน่ง
            foreach ($civilwork as $key => $value) {
                if (!empty($value) && is_numeric($value)) {
                    $civilwork[$key] = number_format((float)$value, 2, '.', '');
                }
            }

            // แปลงวันที่ให้เป็นรูปแบบ d-m-Y  Civil
            $assignedCivilWork = $this->convertToDateFormat($request->input('Assigned_CivilWork'));
            $planCivilWork = $this->convertToDateFormat($request->input('Plan_CivilWork'));
            $actualCivilWork = $this->convertToDateFormat($request->input('Actual_CivilWork'));
            $AcceptPRDateCivilWork = $this->convertToDateFormat($request->input('Accept_PR_Date_CivilWork'));
            $Mail_1stCivilWork = $this->convertToDateFormat($request->input('Mail_1st_CivilWork'));
            $ERP_1stCivilWork = $this->convertToDateFormat($request->input('ERP_1st_CivilWork'));
            $Mail_2ndCivilWork = $this->convertToDateFormat($request->input('Mail_2nd_CivilWork'));
            $ERP_2ndCivilWork = $this->convertToDateFormat($request->input('ERP_2nd_CivilWork'));
            $Mail_3rdCivilWork = $this->convertToDateFormat($request->input('Mail_3rd_CivilWork'));
            $ERP_3rdCivilWork = $this->convertToDateFormat($request->input('ERP_3rd_CivilWork'));
            $Mail_4thCivilWork = $this->convertToDateFormat($request->input('Mail_4th_CivilWork'));
            $ERP_4thCivilWork = $this->convertToDateFormat($request->input('ERP_4th_CivilWork'));
                

            try {
                // แทรกข้อมูลลงใน main_csv และดึง ID ที่สร้างขึ้น
                $mainId = DB::table('main_csv')->insertGetId($data_MAIN);
        
                // สร้างข้อมูลสำหรับตาราง saq_csv โดยใช้ ID ที่ได้จาก main_csv
                $data_SAQ = [
                    'id_saq' => $mainId,  // ใช้ ID ที่ดึงมาจาก main_csv
                  /*
                    'AssignedSubCSurveySAQ' => $request->AssignedSubCSurveySAQ,
                    'PlanSurveySAQ' => $request->PlanSurveySAQ,
                    'ActualSurveySAQ' => $request->ActualSurveySAQ,
                    'SubName_SAQ' => $request->SubName_SAQ,
                    'Quo_No_SAQ' => $request->Quo_No_SAQ,
                    'PR_Price_SAQ' => $request->PR_Price_SAQ,
                    'Accept_PR_Date_SAQ' => $request->Accept_PR_Date_SAQ,
                    'WO_No_SAQ' => $request->WO_No_SAQ,
                    'WO_Price_SAQ' => $request->WO_Price_SAQ,
                    'Accept_1st_SAQ' => $request->Accept_1st_SAQ,
                    'Accept_2nd_SAQ' => $request->Accept_2nd_SAQ,
                    'Accept_3rd_SAQ' => $request->Accept_3rd_SAQ,
                    'Accept_4th_SAQ' => $request->Accept_4th_SAQ,
                    'Banlace_SAQ' => $request->Banlace_SAQ,
                    */
                ];

                $data_CR = [

                    'id_cr' => $mainId, 
                   /*
                    'AssignedSubCCR'=> $request->AssignedSubCCR, //Date
                    'PlanCR'=> $request->PlanCR, //Date
                    'ActualCR'=> $request->ActualCR, //Date
                    'SubName_CR'=> $request->SubName_CR,
                    'Quo_No_CR'=> $request->Quo_No_CR,
                    'PR_Price_CR'=> $request->PR_Price_CR,
                    'Accept_PR_Date_CR'=> $request->Accept_PR_Date_CR, //Date
                    'WO_No_CR'=> $request->WO_No_CR,
                    'WO_Price_CR'=> $request->WO_Price_CR,
                    'Accept_1st_CR'=> $request->Accept_1st_CR,
                    'Accept_2nd_CR'=> $request->Accept_2nd_CR,
                    'Accept_3rd_CR'=> $request->Accept_3rd_CR,
                    'Accept_4th_CR'=> $request->Accept_4th_CR,
                    'Banlace_CR'=> $request->Banlace_CR,
                    */
                
                ]; 

                $data_TSSR = [

                    'id_tssr' => $mainId, 
                    /*
                    'AssignedSubCTSSR'=> $request->AssignedSubCTSSR, //Date
                    'PlanTSSR'=> $request->PlanTSSR, //Date
                    'ActualTSSR'=> $request->ActualTSSR, //Date
                    'SubName_TSSR'=> $request->SubName_TSSR,
                    'Quo_No_TSSR'=> $request->Quo_No_TSSR,
                    'PR_Price_TSSR'=> $request->PR_Price_TSSR,
                    'Accept_PR_Date_TSSR'=> $request->Accept_PR_Date_TSSR, //Date
                    'WO_No_TSSR'=> $request->WO_No_TSSR,
                    'WO_Price_TSSR'=> $request->WO_Price_TSSR,
                
                    'Accept_1st_TSSR'=> $request->Accept_1st_TSSR,
                    'Accept_2nd_TSSR'=> $request->Accept_2nd_TSSR,
                    'Accept_3rd_TSSR'=> $request->Accept_3rd_TSSR,
                    'Accept_4th_TSSR'=> $request->Accept_4th_TSSR,
        
                    'Banlace_TSSR'=> $request->Banlace_TSSR,
                    */
                ];

                $data_CivilWork = [
                    'id_cw' => $mainId, 
                    /*
                    'AssignSubCivilfoundation'=> $request->AssignSubCivilfoundation,
                    'PlanCivilWorkFoundation'=> $request->PlanCivilWorkFoundation,
                    'ActualCivilWorkTower'=> $request->ActualCivilWorkTower,
                    'AssignCivilWorkTower'=> $request->AssignCivilWorkTower,
                    'PlanInstallationRectifier'=> $request->PlanInstallationRectifier,
                    'ActualInstallationRectifier'=> $request->ActualInstallationRectifier,
                    'PlanACPower'=> $request->PlanACPower,
                    'ActualACPower'=> $request->ActualACPower,
                    'PlanACMeter'=> $request->PlanACMeter,
                    'ActualACMeter'=> $request->ActualACMeter,
                    'PAT'=> $request->PAT,
                    'DefPAT'=> $request->DefPAT,
                    'FAT'=> $request->FAT,
                    
    
                    'Assigned_CivilWork' => $assignedCivilWork, // วันที่ในรูปแบบ d-m-Y
                    'Plan_CivilWork' => $planCivilWork, // วันที่ในรูปแบบ d-m-Y
                    'Actual_CivilWork' => $actualCivilWork, // วันที่ในรูปแบบ d-m-Y
                    'SubName_CivilWork'=> $request->SubName_CivilWork,
                    'Quo_No_CivilWork'=> $request->Quo_No_CivilWork,
                    'PR_Price_CivilWork'=> $request->PR_Price_CivilWork, //กรอกเลข 0.00    
                    'Accept_PR_Date_CivilWork'=> $AcceptPRDateCivilWork,     // วันที่ในรูปแบบ d-m-Y
                    'WO_No_CivilWork'=> $request->WO_No_CivilWork,       //กรอกเลข 0.00
                    'WO_Price_CivilWork'=> $request->WO_Price_CivilWork, //กรอกเลข 0.00
    
                    'Accept_1st_CivilWork'=> $request->Accept_1st_CivilWork,    //กรอกเลข 0.00
                    'Mail_1st_CivilWork' => $Mail_1stCivilWork, // วันที่ในรูปแบบ d-m-Y
                    'ERP_1st_CivilWork' => $ERP_1stCivilWork,   // วันที่ในรูปแบบ d-m-Y
                
                    'Accept_2nd_CivilWork'=> $request->Accept_2nd_CivilWork,   //กรอกเลข 0.00
                    'Mail_2nd_CivilWork' => $Mail_2ndCivilWork, // วันที่ในรูปแบบ d-m-Y
                    'ERP_2nd_CivilWork' => $ERP_2ndCivilWork,   // วันที่ในรูปแบบ d-m-Y
    
                    'Accept_3rd_CivilWork'=> $request->Accept_3rd_CivilWork,  //กรอกเลข 0.00
                    'Mail_3rd_CivilWork' => $Mail_3rdCivilWork,   // วันที่ในรูปแบบ d-m-Y
                    'ERP_3rd_CivilWork' => $ERP_3rdCivilWork,     // วันที่ในรูปแบบ d-m-Y
    
                    'Accept_4th_CivilWork'=> $request->Accept_4th_CivilWork,   //กรอกเลข 0.00
                    'Mail_4th_CivilWork' => $Mail_4thCivilWork,   // วันที่ในรูปแบบ d-m-Y
                    'ERP_4th_CivilWork' => $ERP_4thCivilWork,     // วันที่ในรูปแบบ d-m-Y
    
                    'Banlace_CivilWork'=> $request->Banlace_CivilWork, //กรอกเลข 0.00
                    */
                ];
        
                // แทรกข้อมูลลงใน saq_csv
                DB::table('saq_csv')->insert($data_SAQ);
                DB::table('cr_csv')->insert($data_CR);
                DB::table('tssr_csv')->insert($data_TSSR);
                DB::table('civilwork_csv')->insert($data_CivilWork);
        

                // Commit transaction
                DB::commit();

                 // สร้างข้อความที่ต้องการส่งไปยัง LINE Notify
                $message = "มีการเพิ่ม SiteCode " . $request->input('SiteCode');

                // ส่งข้อความไปยัง LINE Notify
                $this->sendLineNotify($message);

            } catch (\Exception $e) {
                // Rollback transaction if there is an error
                DB::rollback();
                // จัดการกับข้อผิดพลาดที่เกิดขึ้นที่นี่
                // เช่น การบันทึกข้อผิดพลาดหรือการแจ้งเตือน
                throw $e;
            }
            
             // เปลี่ยนเส้นทางหลังจากการบันทึกข้อมูลสำเร็จ
             return redirect('/blog')->with('success', 'Data add successfully!');

         
    }
}
