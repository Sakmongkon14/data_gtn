<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Implementcontroller extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = DB::table('implement_main')->get();

        return view('implement.home', compact('data'));
    }

    public function addrefcode(Request $request)
    {
        $request->validate([
            'refcode' => 'required',
            'sitecode' => 'required',
            'project' => 'required',
            'officeCode' => 'required',
            'trueRegion' => 'required',
            'go_NoGo' => 'required',
        ]);

        $data = [
            'refcode' => $request->refcode,
            'sitecode' => $request->sitecode,
            'project' => $request->project,
            'officeCode' => $request->officeCode,
            'trueRegion' => $request->trueRegion,
            'go_NoGo' => $request->go_NoGo,
        ];

        DB::beginTransaction(); // เริ่ม Transaction

        try {
            // ✅ insert แล้วเอา id กลับมา
            $mainId = DB::table('implement_main')->insertGetId($data);


            $est = [

                'id_est' => $mainId,
            ];

            $work = [
                'id_work' => $mainId,  // ใช้ ID ที่ดึงมาจาก main_csv
            ];

            $po1 = [
                'id_PO1' => $mainId,
            ];

            $po2 = [
                'id_PO2' => $mainId,
            ];

            $po3 = [
                'id_PO3' => $mainId,
            ];

            $po4 = [
                'id_PO4' => $mainId,
            ];

            $po5 = [
                'id_PO5' => $mainId,
            ];

            $po6 = [
                'id_PO6' => $mainId,
            ];

            $po7 = [
                'id_PO7' => $mainId,
            ];

            //dd($mainId, $est, $work, $po1, $po2, $po3, $po4, $po5, $po6, $po7);

            // ✅ เตรียมข้อมูลที่ใช้ id นี้ ไปแทรกในตารางอื่น
            DB::table('implement_workingprogress')->insert($work);
            DB::table('implement_estimated')->insert($est);

            DB::table('implement_revenue_po1')->insert($po1);
            DB::table('implement_revenue_po2')->insert($po2);
            DB::table('implement_revenue_po3')->insert($po3);
            DB::table('implement_revenue_po4')->insert($po4);
            DB::table('implement_revenue_po5')->insert($po5);
            DB::table('implement_revenue_po6')->insert($po6);
            DB::table('implement_revenue_po7')->insert($po7);

            DB::commit(); // ทุกอย่างผ่าน ก็ commit
        } catch (\Exception $e) {
            DB::rollBack(); // ถ้ามีอะไรพัง ก็ rollback กลับ
            throw $e;
        }


        return redirect()->back()->with('success', 'RefCode added successfully!');
    }

    // ฟังก์ชันค้นหา sitecode โดยใช้ refcode

    public function searchSitecode(Request $request)
    {
        $search = $request->input('search');
        $results = DB::table('r_import_refcode')
            ->where('sitecode', 'like', '%' . $search . '%')
            ->select('sitecode', 'refcode')
            ->get();

        return response()->json($results);
    }

    // เส้นทาง search-refcodeimplement
    public function searchRefcode(Request $request)
    {
        $search = $request->input('search');
        $results = DB::table('r_import_refcode')
            ->where('refcode', 'like', '%' . $search . '%')
            ->select('refcode', 'sitecode')
            ->get();

        return response()->json($results);
    }

    public function edit($id)
    {
       
        $blog = DB::table("implement_main as m")
            ->leftJoin('implement_estimated as e', 'm.id', '=', 'e.id_est')
            ->leftJoin('implement_workingprogress as w', 'm.id', '=', 'w.id_Work')
            ->leftJoin('implement_revenue_po1 as p1', 'm.id', '=', 'p1.id_PO1')
            ->leftJoin('implement_revenue_po2 as p2', 'm.id', '=', 'p2.id_PO2')
            ->leftJoin('implement_revenue_po3 as p3', 'm.id', '=', 'p3.id_PO3')
            ->leftJoin('implement_revenue_po4 as p4', 'm.id', '=', 'p4.id_PO4')
            ->leftJoin('implement_revenue_po5 as p5', 'm.id', '=', 'p5.id_PO5')
            ->leftJoin('implement_revenue_po6 as p6', 'm.id', '=', 'p6.id_PO6')
            ->leftJoin('implement_revenue_po7 as p7', 'm.id', '=', 'p7.id_PO7')

            ->where('m.id', $id)
            ->first();

            

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (!$blog) {
            return redirect()->back()->withErrors('Data not found for the given ID.');
        }

        dd($blog);

        return view("implement.update",compact("blog"));

    }


  
}
