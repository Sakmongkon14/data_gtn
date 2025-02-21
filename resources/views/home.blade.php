@extends('layouts.app')
@section('title', 'Home')

@section('content')

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Card 1: TANKING -->
                <div class="card">
                    <div class="card-header text-center">TANKING</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (Auth::check())
                            @if (in_array(Auth::user()->status, [1, 2, 3, 4]))
                                <a href="/blog" class="btn btn-primary">New Site</a>

                                @if (Auth::user()->status == 4)
                                    <a href="{{ route('register') }}" class="btn btn-primary">Add Member</a>
                                @endif
                            @else
                                <a href="/blog" class="btn btn-primary disabled">New Site</a>
                            @endif

                        @endif
                    </div>
                </div>

                <!-- Card 2: ERP -->
                <div class="card mt-4">
                    <div class="card-header text-center">ERP</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (Auth::check())
                            <a href="refcode/home" class="btn btn-primary">ค้นหา Refcode</a>
                        @else
                            <a href="#" class="btn btn-secondary disabled">ค้นหา Refcode</a>
                        @endif
                        <a href="#" class="btn btn-danger disabled">IT Clinic</a>
                        <a href="#" class="btn btn-danger disabled">Inventory</a>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
