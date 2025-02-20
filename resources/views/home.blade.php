@extends('layouts.app')
@section('title', 'Home')

@section('content')

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" class="text text-center">TANKING</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a href="/blog" class="btn btn-primary">New Site</a>


                        @if (Auth::check())

                            @if (Auth::user()->status == 4)
                                <a href="{{ route('register') }}" class="btn btn-primary">Add Member</a>
                            @else
                            @endif
                        @else
                        @endif
                 
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header" class="text text-center">ERP</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a href="refcode/home" class="btn btn-primary">ค้นหา Refcode</a>
                        <a href="#" class="btn btn-danger">IT Clinic</a>
                        <a href="#" class="btn btn-danger">Inventory</a>
                                 
                 
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
