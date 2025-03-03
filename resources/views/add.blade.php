@extends('layouts.app')
@section('title', 'Add')
@section('content')

    <style>
        .form-control {
            border-color: #3399FF;
        }


        .form-control {
            font-size: 12px;
        }

        .col-md-12 {
            width: 100%;
            max-width: 320px;
            max-height: 300px;
        }

        .col-md-7 {
            width: 100%;
            max-width: 900px;
            max-height: 40px;

        }

        .custom-divider {
            margin-top: 30px;
        }

        h4 {
            margin-top: 2px;
            font-size: 16px;
            color: red
        }

        label {
            font-size: 13px;
        }
    </style>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h2 class="text text-center py-3 ">ADD</h2>

    <div class="container input-group mb-3 input-group-sm py-3">

        <form class="row g-3" autocomplete="off" method="POST" action="/insert">
            @csrf


            <div class="col-md-12 d-flex align-items-center ">
                <label for="RefCode" class="me-4" style="width: 100px;">RefCode</label>
                <div class="d-flex flex-column ">
                    <input type="text" name="RefCode" class="form-control">
                </div>
            </div>

            <div class="col-md-12 d-flex align-items-center ">
                <label for="PlanType" class="me-4" style="width: 100px;">PlanType</label>
                <div class="d-flex flex-column ">
                    <input type="text" name="PlanType" class="form-control">
                </div>
            </div>


            <div class="col-md-12 d-flex align-items-center ">
                <label for="Region_id" class="me-4" style="width: 40px;">Region</label>
                <div class="d-flex flex-column ">
                    <select name="Region_id" id="Region_id" class="form-control">
                        @foreach ($areas as $item)
                            <option value=" {{ $item->Region_id }}"> {{ $item->Region_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>




            <div class="col-md-12 d-flex align-items-center ">
                <label for="Province" class="me-4" style="width: 100px;">Province</label>
                <div class="d-flex flex-column ">
                    <input type="text" name="Province" class="form-control">
                </div>
            </div>

            <div class="col-md-12 d-flex align-items-center ">
                <label for="Province" class="me-4" style="width: 100px;">OwnerOldSte</label>
                <div class="d-flex flex-column ">
                    <input type="text" name="OwnerOldSte" class="form-control">
                </div>
            </div>

            <div class="col-md-12 d-flex align-items-center ">
                <label for="SiteCode" class="me-4" style="width: 100px;">SiteCode</label>
                <div class="d-flex flex-column ">
                    <input type="text" name="SiteCode" class="form-control">
                    @error('SiteCode')
                        <span class="text text-danger ">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-12 d-flex align-items-center ">
                <label for="SiteNAME_T" class="me-4" style="width: 100px;">SiteNAME_T</label>
                <div class="d-flex flex-column ">
                    <input type="text" name="SiteNAME_T" class="form-control">
                </div>
            </div>

            <div class="col-md-12 d-flex align-items-center ">
                <label for="SiteType" class="me-4" style="width: 100px;">SiteType</label>
                <div class="d-flex flex-column ">
                    <input type="text" name="SiteType" class="form-control">
                </div>
            </div>


            <div class="col-md-12 d-flex align-items-center ">
                <label for="TowerNewSite" class="me-4" style="width: 100px;">TowerNewSite</label>
                <div class="d-flex flex-column ">
                    <input type="text" name="TowerNewSite" class="form-control">
                </div>
            </div>

            <div class="col-md-12 d-flex align-items-center ">
                <label for="Towerheight" class="me-4" style="width: 100px;">Towerheight</label>
                <div class="d-flex flex-column ">
                    <input type="text" name="Towerheight" class="form-control">
                </div>
            </div>


            <div class="col-md-12 d-flex align-items-center ">
                <label for="Tower" class="me-4" style="width: 100px;">Tower</label>
                <div class="d-flex flex-column ">
                    <input type="text" name="Tower" class="form-control">
                </div>
            </div>

            <div class="col-md-12 d-flex align-items-center ">
                <label for="Zone" class="me-4" style="width: 100px;">Zone</label>
                <div class="d-flex flex-column ">
                    <input type="text" name="Zone" class="form-control">
                </div>
            </div>

            

            

            <div class="container text-center mb-3 my-3">
                <input type="submit" value="เพิ่ม" class="btn btn-success my-3" onclick="return confirmUpdate()">
                <a href="/blog" class="btn btn-danger">หน้าแรก</a>
            </div>

            <script>
                function confirmUpdate() {
                    // แสดงกล่องยืนยัน
                    if (confirm('คุณต้องการเพิ่มข้อมูลหรือไม่?')) {
                        return true; // ถ้าผู้ใช้ยืนยัน ให้ส่งฟอร์ม
                    } else {
                        return false; // ถ้าผู้ใช้ยกเลิก ไม่ส่งฟอร์ม
                    }
                }
            </script>

            <!-- Date -->
            <script>
                $(document).ready(function() {
                    // เปิดใช้งานฟังก์ชันเมื่อเอกสาร HTML ถูกโหลดและพร้อมใช้งาน
                    $('.datepicker').datepicker({
                        format: 'dd-mm-yyyy', // รูปแบบวันที่ที่จะแสดงใน Datepicker
                        autoclose: true, // ปิดปฏิทินอัตโนมัติเมื่อผู้ใช้เลือกวันที่
                        todayHighlight: true, // ไฮไลท์วันที่ปัจจุบันในปฏิทิน
                        clearBtn: true // แสดงปุ่ม Clear ในปฏิทิน
                    });
                });
            </script>

            <script>
                document.querySelectorAll('input[placeholder="กรุณากรอกตัวเลข"]').forEach(function(element) {
                    element.addEventListener('blur', function(e) {
                        let value = e.target.value;
                        if (value) {
                            // Convert to number and format to 2 decimal places
                            value = parseFloat(value).toFixed(2);
                            e.target.value = value;
                        }
                    });
                });
            </script>

        </form>

        
    </div>
@endsection
