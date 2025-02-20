<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class Refcodecontroller extends Controller
{
    //
    public function index()
    {
        $refcode = DB::table('r_import_refcode')->get();

        //$count = DB::table('r_import_refcode')->count('refcode');

        //show Refcode
        return view('refcode.home',compact('refcode'));

    }

    public function importrefcode(Request $request)
    {
        $refcode = DB::table('r_import_refcode')->get();

        $dataToSave = [];

        //dd($dataToSave);

        if ($request->isMethod('post')) {
            $request->validate([
                'csv_file_add' => 'required|file|mimes:csv,txt|max:2048',
            ]);
            $file = $request->file('csv_file_add');
            // เปิดไฟล์ CSV
            if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
                $isFirstRow = true;

                while (($data = fgetcsv($handle, 300000, ',')) !== false) {

                    //dd($data);

                    //เพิ่มมาใหม่
                    if (empty(array_filter($data))) {
                        continue;
                    }

                    // Read only the first two columns (index 0 and 1)
                    if (!$isFirstRow) {
                        $dataToSave[] = [
                            'refcode' => $data[0], // First column
                            'sitecode' => $data[1], // Second column
                            'office' => $data[2], // First column
                            'project' => $data[3], // Second column
                        ];
                    }
                    $isFirstRow = false;
                }

                //dd($dataToSave);

                fclose($handle);
            } else {
                return back()->withErrors(['message' => 'ไม่สามารถเปิดไฟล์ CSV']);
            }
        }

        //dd($refcode, $dataToSave);


        return view('refcode.home', compact('refcode', 'dataToSave'));

        }

    //SAVE IMPORT Refcode 
    public function saveAdd(Request $request)
    {
        $dataToSave = json_decode($request->data_add, true);

        // ดึงข้อมูล refcode จากฐานข้อมูล
        $refcode = DB::table('r_import_refcode')->get();


        // เริ่มต้น transaction
        DB::beginTransaction();

        // ตรวจสอบว่า $dataToSave เป็น array และมีข้อมูล
        if (!is_array($dataToSave)) {
            return redirect('/addrefcode')->withErrors(['error' => 'ข้อมูลไม่ถูกต้องหรือไม่มีข้อมูลที่จะบันทึก']);
        }

        // Loop ผ่านแต่ละแถวใน $dataToSave
        $newData = []; // สำหรับเก็บข้อมูลที่ไม่ซ้ำกัน
        foreach ($dataToSave as $row) {
            // เช็คว่า refcode ซ้ำหรือไม่
            $matched = false;
            foreach ($refcode as $item) {
                if ($item->refcode === $row['refcode']) {
                    $matched = true;
                    break;
                }
            }

            // ถ้า refcode ไม่ซ้ำกัน ก็เพิ่มข้อมูลใหม่
            if (!$matched) {
                $newData[] = [
                    'refCode' => $row['refcode'],
                    'sitecode' => $row['sitecode'],
                    'office' => $row['office'], 
                    'project' => $row['project']        
                    // เพิ่มคอลัมน์อื่นๆ ตามที่ต้องการ
                ];
            }
        }

        //dd($newData);

        // ถ้ามีข้อมูลที่ไม่ซ้ำกันให้ทำการบันทึก
        if (count($newData) > 0) {
            // Insert ข้อมูลที่ไม่ซ้ำ
            DB::table('r_import_refcode')->insert($newData);
            // Commit การทำธุรกรรม
            DB::commit();
            return redirect('refcode/home')->with('success', 'บันทึกข้อมูลสำเร็จ');
        } else {
            // ถ้าไม่มีข้อมูลใหม่ให้บันทึก
            DB::rollBack(); // ยกเลิกการทำธุรกรรม
            return redirect('refcode/home')->withErrors(['error' => 'ข้อมูล Refcode ซ้ำกัน']);
        }
    }

}
