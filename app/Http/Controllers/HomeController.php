<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

     // ก่อนเข้าหน้า home 
     public function __construct()
    {
        $this->middleware('auth');
    }
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable

     */

     //ถ้าต้องการเข้า home จะต้องผ่านการเข้ารหัสก่อน
    public function index()
    {
        return view('home');
    }
}
