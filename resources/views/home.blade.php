@extends('layouts.Tailwind')
@section('title', 'Home')

@section('content')

    <div class="container mx-auto px-3 py-5">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-center">

            <!-- Tracking Section -->
            <div class="bg-white shadow-lg rounded-lg p-6 grid justify-items-center items-center">
                <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center flex items-center justify-center">
                    <img src="{{ asset('/task.png') }}" alt="GTN Logo" class="h-10">
                    Tracking
                </h2>
                <div class="grid grid-cols-1 md:grid gap-4">
                    <a href="/blog"
                        class="btn-primary bg-blue-500 text-white hover:bg-blue-600 focus:outline-none rounded-lg p-2 px-4 transition duration-300 ease-in-out transform hover:scale-105 
                        grid justify-items-center items-center ">
                        <img src="{{ asset('/site-map.png') }}" alt="GTN Logo" class="h-10">
                        New Site 
                    </a>
                </div>
            </div>

            <!-- ERP Section -->
            <div class="bg-white shadow-lg rounded-lg p-6 grid justify-items-center items-center">
                <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center flex items-center justify-center">
                    <img src="{{ asset('/erp.png') }}" alt="GTN Logo" class="h-10">
                    ERP
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if (Auth::check())
                        <a href="refcode/home"
                            class="btn-primary bg-blue-500 text-white hover:bg-blue-600 focus:outline-none rounded-lg p-2 transition duration-300 ease-in-out transform hover:scale-105 
                    grid justify-items-center items-center">
                            <img src="{{ asset('/binary-code.png') }}" alt="GTN Logo" class="h-10">
                            ค้นหา Refcode
                        </a>
                        <a href="/import"
                            class="btn-danger bg-yellow-400 text-white hover:bg-yellow-500 focus:outline-none rounded-lg p-2 transition duration-300 ease-in-out transform hover:scale-105
                grid justify-items-center items-center">
                            <img src="{{ asset('/stock.png') }}" alt="GTN Logo" class="h-10 ">
                            Inventory
                        </a>
                    @endif
                </div>
            </div>

            <!-- IT Support Section -->
            <div class="bg-white shadow-lg rounded-lg p-6 grid justify-items-center items-center">
                <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center flex items-center justify-center">
                    <img src="{{ asset('/customer-service.png') }}" alt="GTN Logo" class="h-10">
                    IT Support
                </h2>
                <div class="grid grid-cols-1 md:grid gap-4">
                    <a href="https://sites.google.com/team-gtn.com/it-clinic/home"
                        class="btn-danger bg-red-500 text-white hover:bg-red-600 focus:outline-none rounded-lg p-2 px-4 transition duration-300 ease-in-out transform hover:scale-105 grid justify-items-center items-center"
                        target="_blank">
                        <img src="{{ asset('/support.png') }}" alt="GTN Logo" class="h-10">
                        IT Clinic
                    </a>
                </div>
            </div>

            <!-- Admin Section -->
            <div class="bg-white shadow-lg rounded-lg p-6 grid justify-items-center items-center">
                <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center flex items-center justify-center">
                    <img src="{{ asset('/customer-service.png') }}" alt="GTN Logo" class="h-10">
                    Admin
                </h2>
                <div class="grid grid-cols-1 md:grid gap-4">
                    <a href="{{ route('register') }}"
                        class="btn-primary bg-green-500 text-white hover:bg-green-600 focus:outline-none rounded-lg p-2 transition duration-300 ease-in-out transform hover:scale-105
                                grid justify-items-center items-center">
                        <img src="{{ asset('/add.png') }}" alt="GTN Logo" class="h-10">
                        Add Member
                    </a>
                </div>
            </div>
        </div>

    </div>

@endsection
