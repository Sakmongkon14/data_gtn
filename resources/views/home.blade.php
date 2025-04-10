@extends('layouts.Tailwind')
@section('title', 'Home')

@section('content')

    @if (session('success'))
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-success">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successModalLabel">สำเร็จ!</h5>
                    </div>
                    <div class="modal-body text-success">
                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    </div>
                </div>
            </div>
        </div>

        <script>
            // เรียกเปิด modal เมื่อมีการส่งข้อความสำเร็จ
            $(document).ready(function() {
                $('#successModal').modal('show');

                // ปิด modal หลังจาก 3 วินาที
                setTimeout(function() {
                    $('#successModal').modal('hide');
                }, 2000); // 2000 มิลลิวินาที (2 วินาที)
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            // เมื่อเลือกสถานะใน select
            $('.status-dropdown').on('change', function() {
                var newStatus = $(this).val(); // ค่าที่เลือกจาก dropdown
                var userId = $(this).data('user-id'); // ID ของผู้ใช้
                var currentStatus = $(this).data('status'); // สถานะเดิมที่ถูกเลือก

                // แสดง confirmation dialog
                if (confirm('คุณต้องการเปลี่ยนสถานะของผู้ใช้นี้?')) {
                    // ส่งข้อมูลไปยัง server เพื่ออัปเดตสถานะ
                    $.ajax({
                        url: '/update-status/' + userId, // เส้นทางที่ใช้ในการอัปเดตสถานะ
                        method: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: newStatus // ส่งค่าที่เลือกไป
                        },
                        success: function(response) {
                            alert('สถานะของผู้ใช้ถูกอัปเดต!');
                            // อัปเดตสถานะที่ dropdown
                            $(this).data('status', newStatus); // เปลี่ยนสถานะใน data attribute
                        },
                        error: function() {
                            alert('เกิดข้อผิดพลาดในการอัปเดตสถานะ');
                            // รีเซ็ตสถานะเป็นค่าเดิม
                            $(this).val(currentStatus);
                        }
                    });
                } else {
                    // ถ้าผู้ใช้ไม่ยืนยันให้รีเซ็ตค่ากลับเป็นสถานะเดิม
                    $(this).val(currentStatus);
                }
            });
        });
    </script>



    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



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
                        grid justify-items-center items-center">
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

                @if (Auth::user()->status == 4)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('register') }}"
                            class="btn-primary bg-green-500 text-white hover:bg-green-600 focus:outline-none rounded-lg p-2 transition duration-300 ease-in-out transform hover:scale-105
                    grid justify-items-center items-center">
                            <img src="{{ asset('/add.png') }}" alt="GTN Logo" class="h-10">
                            Add Member
                        </a>

                        <a href="#!"
                            class="btn-primary bg-gray-500 text-white hover:bg-gray-600 focus:outline-none rounded-lg p-2 transition duration-300 ease-in-out transform hover:scale-105 grid justify-items-center items-center"
                            data-toggle="modal" data-target="#myModal">
                            <img src="{{ asset('/add.png') }}" alt="GTN Logo" class="h-10">
                            Member Total
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid gap-4">
                        <a href="{{ route('register') }}"
                            class="btn-primary bg-green-500 text-white hover:bg-green-600 focus:outline-none rounded-lg p-2 transition duration-300 ease-in-out transform hover:scale-105
                    grid justify-items-center items-center">
                            <img src="{{ asset('/add.png') }}" alt="GTN Logo" class="h-10">
                            Add Member
                        </a>
                    </div>
                @endif

            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg"> <!-- ใช้ modal-lg เพื่อปรับขนาดใหญ่ -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="myModalLabel">Member Total</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="user-list">
                                <table class="table table-bordered">
                                    <thead class="bg-blue-500 text-white">
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <!-- <th>Password</th> -->
                                            <th style="width: 50px">Status</th>
                                            <th style="width: 50px">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($users as $index => $user)
                                            <tr>
                                                <td>{{ $index + 1 }}</td> <!-- แสดงลำดับที่ -->
                                                <td>{{ $user->name }}</td> <!-- แสดงชื่อผู้ใช้ -->
                                                <td>{{ $user->email }}</td> <!-- แสดงอีเมล์ผู้ใช้ -->
                                                <td>
                                                    <select class="status-dropdown" data-user-id="{{ $user->id }}"
                                                        data-status="{{ $user->status }}">

                                                        <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>
                                                            1
                                                        </option>
                                                        <option value="2" {{ $user->status == 2 ? 'selected' : '' }}>
                                                            2
                                                        </option>
                                                        <option value="3" {{ $user->status == 3 ? 'selected' : '' }}>
                                                            3
                                                        </option>
                                                        <option value="4" {{ $user->status == 4 ? 'selected' : '' }}>
                                                            4
                                                        </option>
                                                        <!-- <option value="5" {{ $user->status == 5 ? 'selected' : '' }}>
                                                                5
                                                            </option>
                                                            <option value="6" {{ $user->status == 6 ? 'selected' : '' }}>
                                                                6</option>
                                                        -->
                                                        <option value=""
                                                            {{ $user->status == '' ? 'selected' : '' }}>
                                                            7</option>

                                                    </select>
                                                </td>
                                                <td class="flex justify-center">
                                                    <!-- ฟอร์มสำหรับลบผู้ใช้ -->
                                                    <form action="{{ route('user.delete', $user->id) }}" method="POST"
                                                        onsubmit="return confirm('คุณแน่ใจที่จะลบผู้ใช้นี้?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="bg-red-500 text-white text-xs h-6 w-7 rounded"
                                                            type="submit">ลบ</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div>

                        <!--
                                        
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                                        </div>
                                        -->

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
