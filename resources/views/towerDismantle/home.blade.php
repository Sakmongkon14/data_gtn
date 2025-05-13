@extends('layouts.Tailwind')
@section('title', 'Implement Report')

@section('content')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <div data-aos="fade-up" data-aos-anchor-placement="bottom-center">
        <h2 id="zoomText" class="text-center my-1 text-2xl font-bold"
            style="transform: scale(0.8); opacity: 0; transition: transform 0.5s ease-out, opacity 0.5s ease-out;">
            54_NT-BTO Tower Dismantling for True
        </h2>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            AOS.init(); // เริ่มต้น AOS Animation

            // เพิ่ม Zoom-in เมื่อโหลดหน้า
            setTimeout(() => {
                let title = document.getElementById("zoomText");
                title.style.transform = "scale(1)";
                title.style.opacity = "1";
            }, 200);
        });
    </script>

    @if (session('success'))
        <!-- Modal Popup -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-success">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successModalLabel">สำเร็จ!</h5>
                        <!--   <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button> -->
                    </div>
                    <div class="modal-body text-success">
                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <!-- Modal Popup Error -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="errorModalLabel">เกิดข้อผิดพลาด!</h5>
                        <!-- <button type="button" class="btn-close" aria-label="Close" data-bs-dismiss="modal"></button> -->
                    </div>
                    <div class="modal-body text-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                    </div>
                </div>
            </div>
        </div>
    @endif



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">


    <div class="modal fade" id="addRefCodeModal" tabindex="-1" aria-labelledby="addRefCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="addRefCodeModalLabel">Add RefCode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body bg-gray-200">
                    <!-- Form ใส่ RefCode -->
                    <form id="addRefCodeForm" action="{{ route('towerDismantle.save') }}" method="POST">
                        @csrf
                        <div class="row">


                            {{-- RefCode Input --}}
                            <div class="col-md-4 mb-3 position-relative">
                                <label for="refCode" class="form-label">RefCode</label>
                                <input type="text" class="form-control" id="refCode" name="refCode" autocomplete="off">
                                <ul id="refcode-list" class="list-group position-absolute w-100"
                                    style="z-index: 9999; max-height: 200px; overflow-y: auto; display: none;"></ul>
                            </div>


                            {{-- SiteCode Input --}}
                            <div class="col-md-4 mb-3 position-relative">
                                <label for="siteCode" class="form-label">SiteCode</label>
                                <input type="text" class="form-control" id="siteCode" name="siteCode" autocomplete="off"
                                    required>
                                <ul id="sitecode-list" class="list-group position-absolute w-100"
                                    style="z-index: 9999; max-height: 200px; overflow-y: auto; display: none;"></ul>
                            </div>

                            <div class="col-md-4 mb-3 position-relative">
                                <label for="siteName" class="form-label">SiteName</label>
                                <input type="text" class="form-control" id="siteName" name="siteName" autocomplete="off"
                                    required>
                                <ul id="sitecode-list" class="list-group position-absolute w-100"
                                    style="z-index: 9999; max-height: 200px; overflow-y: auto; display: none;"></ul>
                            </div>


                            <div class="col-md-4 mb-3">
                                <label for="gtnOffice" class="form-label">GTN Office</label>
                                <select class="form-select" id="gtnOffice" name="gtnOffice" required>
                                    <option value="">-- กรุณาเลือก --</option>
                                    <option value="R1:BMA_West">01_BKK</option>
                                    <option value="R2:BMA_East">02_CMI</option>
                                    <option value="R3:East">03_KKN</option>
                                    <option value="R4:North">04_UBR</option>
                                    <option value="R5:Northeast1">05_HYI</option>
                                    <option value="R6:Northeast2">06_PLK</option>
                                </select>

                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="trueRegion" class="form-label">True Region</label>
                                <select class="form-select" id="trueRegion" name="trueRegion" required>
                                    <option value="">-- กรุณาเลือก --</option>
                                    <option value="R1:BMA_West">R1: BMA West</option>
                                    <option value="R2:BMA_East">R2: BMA East</option>
                                    <option value="R3:East">R3: East</option>
                                    <option value="R4:North">R4: North</option>
                                    <option value="R5:Northeast1">R5: Northeast1</option>
                                    <option value="R6:Northeast2">R6: Northeast2</option>
                                    <option value="R7:CentralWest">R7: Central West</option>
                                    <option value="R8:South">R8: South</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="towerType" class="form-label">Tower Type</label>
                                <select class="form-select" id="towerType" name="towerType" required>
                                    <option value="">-- กรุณาเลือก --</option>
                                    <option value="Guyed Mast Tower">Guyed Mast Tower</option>
                                    <option value="Self-Support Tower">Self-Support Tower</option>
                                    <option value="Pole on Roof">Pole on Roof</option>
                                    <option value="Electic Pole">Electic Pole</option>
                                    <option value="Wall Pole">Wall Pole</option>
                                    <option value="Wall Mount">Wall Mount</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="towerModel" class="form-label">Tower Model</label>
                                <input type="text" class="form-control" id="towerModel" name="towerModel">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="estimatedTowerWeight" class="form-label">Estimated Tower Weight (Kg.)</label>
                                <input type="number" class="form-control" id="estimatedTowerWeight"
                                    name="estimatedTowerWeight" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="actualTowerWeight" class="form-label">Actual Tower Weight (Kg.)</label>
                                <input type="number" class="form-control" id="actualTowerWeight"
                                    name="actualTowerWeight" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="remark" class="form-label">Remark</label>
                                <input type="text" class="form-control" id="remark" name="remark">
                            </div>

                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light text-gray border border-gray"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addRefCodeForm" class="btn btn-primary">Add Refcode</button>
                </div>

            </div>
        </div>
    </div>


    <div class="container-fluid  custom-container"> <!-- Add custom-container class -->
        <div class="row align-items-center h-100"> <!-- Add h-100 to make row take full height -->
            <div class="col-12 d-flex justify-content-between "> <!-- Add h-100 to the column -->


                <div class="d-flex align-items-center"> <!-- Keep the search and export buttons together -->
                    <form class="d-flex ms-2">
                        <!-- Add margin-start to create space -->
                        <div data-aos="fade-left" data-aos-anchor="#example-anchor" data-aos-offset="500"
                            data-aos-duration="500">

                            <!--
                                            class="bg-green-500 text-white border border-green-500 w-48 
                                px-2 py-2 rounded hover:bg-green-600 transition"
                                        -->

                            <button
                                class="bg-blue-500 text-white border border-blue-600 w-48 px-2 py-1 rounded hover:bg-blue-700 transition"
                                type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"
                                data-aos="fade-right" data-aos-offset="100" data-aos-duration="800"
                                data-aos-easing="ease-out">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#addRefCodeModal">
                                    <i class="bi bi-plus-lg fs-5 me-1"></i> Add New RefCode
                                </a>
                            </button>
                        </div>

                    </form>
                </div>


                <div class="d-flex align-items-center"> <!-- Keep the search and export buttons together -->
                    <form class="d-flex ms-2">
                        <!-- Add margin-start to create space -->
                        <div data-aos="fade-left" data-aos-anchor="#example-anchor" data-aos-offset="500"
                            data-aos-duration="500">

                            <button type="submit"
                                class="bg-green-500 text-white border border-green-500 w-48 px-2 py-2 rounded hover:bg-green-600 transition"
                                id="exportButton" style="margin-right: 20px;">
                                <i class="bi bi-download"></i> Export Excel
                            </button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-container {
            height: 60px;
            /* Adjust the height of the container as needed */
        }

        .fixed-width-input {
            height: 40px;
            /* Adjust the height of the input field */
            width: 170px;
        }

        .btn {
            height: 40px;

        }

        #exportButton {
            width: 125px;
        }

        label.form-label {
            font-weight: bold;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ถ้ามี session('success') ให้เปิด Modal Success
            @if (session('success'))
                var successModal = new bootstrap.Modal(document.getElementById('successModal'), {
                    keyboard: false
                });
                successModal.show(); // แสดง Modal สำหรับ success

                // ปิด Modal หลังจาก 3 วินาที (3000ms)
                setTimeout(function() {
                    successModal.hide(); // ปิด Modal
                }, 3000);
            @endif

            // ถ้ามี session('error') ให้เปิด Modal Error
            @if (session('error'))
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'), {
                    keyboard: false
                });
                errorModal.show(); // แสดง Modal สำหรับ error

                // ปิด Modal หลังจาก 3 วินาที (3000ms)
                setTimeout(function() {
                    errorModal.hide(); // ปิด Modal
                }, 3000);
            @endif
        });
    </script>

    <script>
        // ฟังก์ชันส่งออก export
        document.getElementById('exportButton').addEventListener('click', function() {
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.table_to_sheet(document.getElementById('table'));
            XLSX.utils.book_append_sheet(wb, ws, 'x');
            XLSX.writeFile(wb, 'New_Site.xlsx');
        });
    </script>

    <style>
        .input-group {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            width: 25%;
        }

        .table-container {
            width: 98%;
            max-height: 500px;
            overflow-x: auto;
            overflow-y: auto;
        }


        .table-container table {
            height: 100%;
            border-collapse: collapse;
        }

        .table-container td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            white-space: nowrap;
        }

        .table-container th {
            padding: 8px;
            text-align: center;
            white-space: nowrap;
            position: sticky;
            top: 0px;
            background-color: #172554;
            /* bg-blue-950 */
            color: #FAFAFA;
            /* text-neutral-50 */
        }

        .table-container th:nth-child(1),
        .table-container td:nth-child(1) {
            position: sticky;
            left: 0px;
            width: 50px;
            min-width: 50px;

        }

        .table-container th:nth-child(2),
        .table-container td:nth-child(2) {
            position: sticky;
            left: 50px;
            width: 100px;
            min-width: 100px;
        }

        .table-container th:nth-child(3),
        .table-container td:nth-child(3) {
            position: sticky;
            left: 150px;
            width: 100px;
            min-width: 100px;
        }

        .table-container td:nth-child(1),
        .table-container td:nth-child(2),
        .table-container td:nth-child(3) {}

        .table-container th:nth-child(1),
        .table-container th:nth-child(2),
        .table-container th:nth-child(3) {
            z-index: 3;
            background: #172554;
        }

        .status-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 60px;
            /* ระยะห่างระหว่างแต่ละ <h5> */
        }

        .indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-left: 5px;
            /* เพิ่มระยะห่างระหว่างข้อความและตัวบ่งชี้ */
        }

        .has-data {
            background-color: rgb(0, 156, 0);
        }

        .no-data {
            background-color: rgb(255, 0, 0);
        }
    </style>

    <div data-aos="fade-up" data-aos-anchor-placement="top-bottom">
        <div class="table-container">
            <table class="table" id="table">
                <thead style="font-size: 12px; text-align:center">

                    <th scope="col"></th>

                    <!-- Header -->
                    <th scope="col">Refcode</th>
                    <th scope="col">Sitecode</th>
                    <th scope="col">Sitename</th>
                    <th scope="col">GTN Office</th>
                    <th scope="col">TRUE Region</th>
                    <th scope="col">Tower Type</th>
                    <th scope="col">Tower Model</th>
                    <th scope="col">Estimated Tower Weight (Kg.)</th>
                    <th scope="col">Actual Tower Weight (Kg.)</th>
                    <th scope="col">Remark</th>

                    <!-- Estimate -->
                    <th scope="col">Estimated Revenue</th>
                    <th scope="col">Estimated Service cost</th>
                    <th scope="col">Estimated buyback cost</th>
                    <th scope="col">Estimated Transportation Cost</th>
                    <th scope="col">Estimated Other Cost</th>
                    <th scope="col">Estimated Gross Profit</th>
                    <th scope="col">Estimated Gross Profit Margin</th>

                    <!-- Working Progress -->
                    <th scope="col">Job Assigned Date by Customer</th>
                    <th scope="col">Plan Surveyed Date</th>
                    <th scope="col">Actual Surveyed Date</th>
                    <th scope="col">Customer Committed Date</th>
                    <th scope="col">Tower Dismantling SubC</th>
                    <th scope="col">Plan Started Date</th>
                    <th scope="col">Actual Started Date</th>
                    <th scope="col">Plan Finished Date</th>
                    <th scope="col">Actual Finished Date</th>
                    <th scope="col">Working Issue</th>

                    <!-- TowerBuyback -->
                    <th scope="col">Tower_TowerPrice</th>
                    <th scope="col">Tower_Towerbuyback_PlanPaidDate</th>
                    <th scope="col">Tower_Towerbuyback_ActualPaidDate</th>
                    <th scope="col">Tower_ReceiptNo</th>

                    <!-- Tower Selling data -->
                    <th scope="col">Tower Buyer Name</th>
                    <th scope="col">Tower Selling Price</th>
                    <th scope="col">Plan Get Paid Date</th>
                    <th scope="col">Actual Get Paid Date</th>

                    <!--  Revenue Detail ( 1 )-->
                    <th scope="col">Tower Dismantling Service Price</th>
                    <th scope="col">Customer - Quotation Subbmitted Date (Plan)</th>
                    <th scope="col">Customer - Quotation Subbmitted Date (Actual)</th>
                    <th scope="col">Customer - Quotation Amount</th>

                    <th scope="col">Customer - PO Amount</th>
                    <th scope="col">Customer - PO Received date</th>
                    <th scope="col">Plan Invoice Placed date</th>
                    <th scope="col">Plan Invoice Amount</th>

                    <th scope="col">Invoice No.</th>
                    <th scope="col">Actual Invoice Amount</th>
                    <th scope="col">Actual Invoice Placed date</th>
                    <th scope="col">Confirmed Due datet</th>

                    <!--  Revenue Detail ( 2 )-->
                    <th scope="col">Tower Dismantling Service Price</th>
                    <th scope="col">Customer - Quotation Subbmitted Date (Plan)</th>
                    <th scope="col">Customer - Quotation Subbmitted Date (Actual)</th>
                    <th scope="col">Customer - Quotation Amount</th>

                    <th scope="col">Customer - PO 2 Amount</th>
                    <th scope="col">Customer - PO 2 Received date</th>
                    <th scope="col">Plan Invoice 2 Placed date</th>
                    <th scope="col">Plan Invoice 2 Amount</th>

                    <th scope="col">Invoice No.2</th>
                    <th scope="col">Actual Invoice 2 Amount</th>
                    <th scope="col">Actual Invoice 2 Placed date</th>
                    <th scope="col">Confirmed Due datet</th>

                    <!--  Revenue Detail ( 3 )-->
                    <th scope="col">Tower Dismantling Service Price</th>
                    <th scope="col">Customer - Quotation Subbmitted Date (Plan)</th>
                    <th scope="col">Customer - Quotation Subbmitted Date (Actual)</th>
                    <th scope="col">Customer - Quotation Amount</th>

                    <th scope="col">Customer - PO 3 Amount</th>
                    <th scope="col">Customer - PO 3 Received date</th>
                    <th scope="col">Plan Invoice 3 Placed date</th>
                    <th scope="col">Plan Invoice 3 Amount</th>

                    <th scope="col">Invoice No.3</th>
                    <th scope="col">Actual Invoice 3 Amount</th>
                    <th scope="col">Actual Invoice 3 Placed date</th>
                    <th scope="col">Confirmed Due datet</th>

                    <!-- Pay_1 -->

                    <th scope="col">SubC Name</th>
                    <th scope="col">Activity of payment</th>
                    <th scope="col">PR Amount</th>
                    <th scope="col">PR requested date (Email)</th>
                    <th scope="col">PR Approved date (Email)</th>
                    <th scope="col">PR No. (ERP)</th>
                    <th scope="col">PR Issued date (ERP)</th>
                    <th scope="col">PR Approved date (ERP)</th>

                    <th scope="col">WO Amount (ERP)</th>
                    <th scope="col">WO No.</th>
                    <th scope="col">WO Issue date (ERP)</th>
                    <th scope="col">WO Approved date (ERP)</th>
                    <th scope="col">Date sent WO to SubC (Email)</th>

                    <th scope="col">Billing Amount</th>
                    <th scope="col">Billing Requested date (Email)</th>
                    <th scope="col">Billing Approved date (Email)</th>
                    <th scope="col">Billing No. (ERP)</th>
                    <th scope="col">Billing Issued date (ERP)</th>
                    <th scope="col">Billing Approved date (ERP)</th>
                    <th scope="col">Date sent Billing to SubC</th>
                    <th scope="col">Invoice Placed date by SubC</th>
                    <th scope="col">SubC - Invoice Amount</th>
                    <th scope="col">Payment confirmed date (ERP)</th>


                    <!-- Pay_2 -->

                    <th scope="col">SubC Name</th>
                    <th scope="col">Activity of payment</th>
                    <th scope="col">PR Amount</th>
                    <th scope="col">PR requested date (Email)</th>
                    <th scope="col">PR Approved date (Email)</th>
                    <th scope="col">PR No. (ERP)</th>
                    <th scope="col">PR Issued date (ERP)</th>
                    <th scope="col">PR Approved date (ERP)</th>

                    <th scope="col">WO Amount (ERP)</th>
                    <th scope="col">WO No.</th>
                    <th scope="col">WO Issue date (ERP)</th>
                    <th scope="col">WO Approved date (ERP)</th>
                    <th scope="col">Date sent WO to SubC (Email)</th>

                    <th scope="col">Billing Amount</th>
                    <th scope="col">Billing Requested date (Email)</th>
                    <th scope="col">Billing Approved date (Email)</th>
                    <th scope="col">Billing No. (ERP)</th>
                    <th scope="col">Billing Issued date (ERP)</th>
                    <th scope="col">Billing Approved date (ERP)</th>
                    <th scope="col">Date sent Billing to SubC</th>
                    <th scope="col">Invoice Placed date by SubC</th>
                    <th scope="col">SubC - Invoice Amount</th>
                    <th scope="col">Payment confirmed date (ERP)</th>


                    <!-- Pay_3  -->
                    <th scope="col">SubC Name</th>
                    <th scope="col">Activity of payment</th>
                    <th scope="col">PR Amount</th>
                    <th scope="col">PR requested date (Email)</th>
                    <th scope="col">PR Approved date (Email)</th>
                    <th scope="col">PR No. (ERP)</th>
                    <th scope="col">PR Issued date (ERP)</th>
                    <th scope="col">PR Approved date (ERP)</th>

                    <th scope="col">WO Amount (ERP)</th>
                    <th scope="col">WO No.</th>
                    <th scope="col">WO Issue date (ERP)</th>
                    <th scope="col">WO Approved date (ERP)</th>
                    <th scope="col">Date sent WO to SubC (Email)</th>

                    <th scope="col">Billing Amount</th>
                    <th scope="col">Billing Requested date (Email)</th>
                    <th scope="col">Billing Approved date (Email)</th>
                    <th scope="col">Billing No. (ERP)</th>
                    <th scope="col">Billing Issued date (ERP)</th>
                    <th scope="col">Billing Approved date (ERP)</th>
                    <th scope="col">Date sent Billing to SubC</th>
                    <th scope="col">Invoice Placed date by SubC</th>
                    <th scope="col">SubC - Invoice Amount</th>
                    <th scope="col">Payment confirmed date (ERP)</th>



                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr style="font-size: 10px; text-align:center ">
                            <td><a href=" {{ route('towerDismantle.update', $item->id) }}"><i
                                        class="bi bi-pencil-fill "></i></a></td>

                            <!-- Header -->
                            <td>{{ $item->refCode }}</td>
                            <td>{{ $item->siteCode }}</td>
                            <td>{{ $item->siteName }}</td>
                            <td>{{ $item->gtnOffice }}</td>
                            <td>{{ $item->trueRegion }}</td>
                            <td>{{ $item->towerType }}</td>
                            <td>{{ $item->towerModel }}</td>
                            <td>{{ $item->estimatedTowerWeight }}</td>
                            <td>{{ $item->actualTowerWeight }}</td>
                            <td>{{ $item->remark }}</td>

                            <!-- Estimate -->
                            @php
                                $revenue = $item->est_revenue;

                                $serviceCost = $item->est_serviceCost;
                                $buybackCost = $item->est_buybackCost;
                                $transportationCost = $item->est_transportationCost;
                                $otherCost = $item->est_otherCost;

                                $sum = $serviceCost + $buybackCost + $transportationCost + $otherCost;

                                $total = $revenue - $sum;

                                //คำนวณ % Gross Profit Margin
                                if ($revenue != 0) {
                                    $grossProfitMargin = ($total * 100) / $revenue;
                                    $grossProfitMargin = floor($grossProfitMargin);
                                } else {
                                    $grossProfitMargin = 0;
                                }

                                //decimal 2
                                $decimal = number_format($total, 2); // ได้เป็น string "1000.00"

                                // เพิ่ม % ลงท้าย
                                $grossProfitMarginWithPercent = $grossProfitMargin . '%';

                            @endphp

                            <td>{{ $item->est_revenue }}</td>
                            <td>{{ $item->est_serviceCost }}</td>
                            <td>{{ $item->est_buybackCost }}</td>
                            <td>{{ $item->est_transportationCost }}</td>
                            <td>{{ $item->est_otherCost }}</td>

                            {{-- เงื่อนไข: แสดงเฉพาะเมื่อ $decimal ไม่เท่ากับ "0.00" --}}
                            @if ($decimal !== '0.00')
                                <td>{{ $decimal }}</td>
                            @endif
                            

                            {{-- เงื่อนไข: แสดงเฉพาะเมื่อไม่ใช่ "0%" --}}
                            @if ($grossProfitMarginWithPercent !== '0%')
                                <td>{{ $grossProfitMarginWithPercent }}</td>
                            @endif

                            <!-- Working -->
                            <td>{{ $item->work_JobAssignedDateByCustomer }}</td>
                            <td>{{ $item->work_PlanSurveyedDate }}</td>
                            <td>{{ $item->work_ActualSurveyedDate }}</td>
                            <td>{{ $item->work_CustomerCommittedDate }}</td>
                            <td>{{ $item->work_TowerDismantlingSubC }}</td>
                            <td>{{ $item->work_PlanStartedDate }}</td>
                            <td>{{ $item->work_ActualStartedDate }}</td>
                            <td>{{ $item->work_PlanFinishedDate }}</td>
                            <td>{{ $item->work_ActualFinishedDate }}</td>
                            <td>{{ $item->work_WorkingIssue }}</td>

                            <!-- Towerbuybackdata -->
                            <td>{{ $item->tower_TowerPrice }}</td>
                            <td>{{ $item->tower_Towerbuyback_PlanPaidDate }}</td>
                            <td>{{ $item->tower_Towerbuyback_ActualPaidDate }}</td>
                            <td>{{ $item->tower_ReceiptNo }}</td>

                            <!-- TowerselingData -->
                            <td>{{ $item->towersell_TowerBuyerName }}</td>
                            <td>{{ $item->towersell_TowerSellingPrice }}</td>
                            <td>{{ $item->towersell_PlanGetPaidDate }}</td>
                            <td>{{ $item->towersell_ActualGetPaidDate }}</td>

                            <!-- Revenue1 -->
                            <td>{{ $item->re1_TowerDismantlingServicePrice }}</td>
                            <td>{{ $item->re1_Customer_QuotationSubbmittedDatePlan }}</td>
                            <td>{{ $item->re1_Customer_QuotationSubbmittedDateActual }}</td>
                            <td>{{ $item->re1_Customer_QuotationAmount }}</td>
                            <td>{{ $item->re1_Customer_POAmount }}</td>
                            <td>{{ $item->re1_Customer_POReceivedDate }}</td>
                            <td>{{ $item->re1_PlanInvoicePlacedDate }}</td>
                            <td>{{ $item->re1_PlanInvoiceAmount }}</td>
                            <td>{{ $item->re1_InvoiceNo }}</td>
                            <td>{{ $item->re1_ActualInvoiceAmount }}</td>
                            <td>{{ $item->re1_ActualInvoicePlacedDate }}</td>
                            <td>{{ $item->re1_ConfirmedDueDate }}</td>

                            <!-- Revenue2 -->
                            <td>{{ $item->re2_TowerDismantlingServicePrice }}</td>
                            <td>{{ $item->re2_Customer_QuotationSubbmittedDatePlan }}</td>
                            <td>{{ $item->re2_Customer_QuotationSubbmittedDateActual }}</td>
                            <td>{{ $item->re2_Customer_QuotationAmount }}</td>
                            <td>{{ $item->re2_Customer_POAmount }}</td>
                            <td>{{ $item->re2_Customer_POReceivedDate }}</td>
                            <td>{{ $item->re2_PlanInvoicePlacedDate }}</td>
                            <td>{{ $item->re2_PlanInvoiceAmount }}</td>
                            <td>{{ $item->re2_InvoiceNo }}</td>
                            <td>{{ $item->re2_ActualInvoiceAmount }}</td>
                            <td>{{ $item->re2_ActualInvoicePlacedDate }}</td>
                            <td>{{ $item->re2_ConfirmedDueDate }}</td>


                            <!-- Revenue3 -->
                            <td>{{ $item->re3_TowerDismantlingServicePrice }}</td>
                            <td>{{ $item->re3_Customer_QuotationSubbmittedDatePlan }}</td>
                            <td>{{ $item->re3_Customer_QuotationSubbmittedDateActual }}</td>
                            <td>{{ $item->re3_Customer_QuotationAmount }}</td>
                            <td>{{ $item->re3_Customer_POAmount }}</td>
                            <td>{{ $item->re3_Customer_POReceivedDate }}</td>
                            <td>{{ $item->re3_PlanInvoicePlacedDate }}</td>
                            <td>{{ $item->re3_PlanInvoiceAmount }}</td>
                            <td>{{ $item->re3_InvoiceNo }}</td>
                            <td>{{ $item->re3_ActualInvoiceAmount }}</td>
                            <td>{{ $item->re3_ActualInvoicePlacedDate }}</td>
                            <td>{{ $item->re3_ConfirmedDueDate }}</td>


                            <!-- Pay_1 -->
                            <td>{{ $item->pay1_SubCName }}</td>
                            <td>{{ $item->pay1_ActivityOfPayment }}</td>
                            <td>{{ $item->pay1_PRAmount }}</td>
                            <td>{{ $item->pay1_PRrequestedDateEmail }}</td>
                            <td>{{ $item->pay1_PRApprovedDateEmail }}</td>
                            <td>{{ $item->pay1_PRNoERP }}</td>
                            <td>{{ $item->pay1_PRIssuedDateERP }}</td>
                            <td>{{ $item->pay1_PRApprovedDateERP }}</td>
                            <td>{{ $item->pay1_WOAmountERP }}</td>
                            <td>{{ $item->pay1_WONo }}</td>
                            <td>{{ $item->pay1_WOIssueDateERP }}</td>
                            <td>{{ $item->pay1_WOApprovedDateERP }}</td>
                            <td>{{ $item->pay1_DatesentWOtoSubCEmail }}</td>
                            <td>{{ $item->pay1_BillingAmount }}</td>
                            <td>{{ $item->pay1_BillingRequestedDateEmail }}</td>
                            <td>{{ $item->pay1_BillingApprovedDateEmail }}</td>
                            <td>{{ $item->pay1_BillingNoERP }}</td>
                            <td>{{ $item->pay1_BillingIssuedDateERP }}</td>
                            <td>{{ $item->pay1_BillingApprovedDateERP }}</td>
                            <td>{{ $item->pay1_DatesentBillingtoSubC }}</td>
                            <td>{{ $item->pay1_InvoicePlaceddatebySubC }}</td>
                            <td>{{ $item->pay1_SubC_InvoiceAmount }}</td>
                            <td>{{ $item->pay1_PaymentconfirmedDateERP }}</td>

                            <!-- Pay_2 -->
                            <td>{{ $item->pay2_SubCName }}</td>
                            <td>{{ $item->pay2_ActivityOfPayment }}</td>
                            <td>{{ $item->pay2_PRAmount }}</td>
                            <td>{{ $item->pay2_PRrequestedDateEmail }}</td>
                            <td>{{ $item->pay2_PRApprovedDateEmail }}</td>
                            <td>{{ $item->pay2_PRNoERP }}</td>
                            <td>{{ $item->pay2_PRIssuedDateERP }}</td>
                            <td>{{ $item->pay2_PRApprovedDateERP }}</td>
                            <td>{{ $item->pay2_WOAmountERP }}</td>
                            <td>{{ $item->pay2_WONo }}</td>
                            <td>{{ $item->pay2_WOIssueDateERP }}</td>
                            <td>{{ $item->pay2_WOApprovedDateERP }}</td>
                            <td>{{ $item->pay2_DatesentWOtoSubCEmail }}</td>
                            <td>{{ $item->pay2_BillingAmount }}</td>
                            <td>{{ $item->pay2_BillingRequestedDateEmail }}</td>
                            <td>{{ $item->pay2_BillingApprovedDateEmail }}</td>
                            <td>{{ $item->pay2_BillingNoERP }}</td>
                            <td>{{ $item->pay2_BillingIssuedDateERP }}</td>
                            <td>{{ $item->pay2_BillingApprovedDateERP }}</td>
                            <td>{{ $item->pay2_DatesentBillingtoSubC }}</td>
                            <td>{{ $item->pay2_InvoicePlaceddatebySubC }}</td>
                            <td>{{ $item->pay2_SubC_InvoiceAmount }}</td>
                            <td>{{ $item->pay2_PaymentconfirmedDateERP }}</td>


                            <!-- Pay_3 -->
                            <td>{{ $item->pay3_SubCName }}</td>
                            <td>{{ $item->pay3_ActivityOfPayment }}</td>
                            <td>{{ $item->pay3_PRAmount }}</td>
                            <td>{{ $item->pay3_PRrequestedDateEmail }}</td>
                            <td>{{ $item->pay3_PRApprovedDateEmail }}</td>
                            <td>{{ $item->pay3_PRNoERP }}</td>
                            <td>{{ $item->pay3_PRIssuedDateERP }}</td>
                            <td>{{ $item->pay3_PRApprovedDateERP }}</td>
                            <td>{{ $item->pay3_WOAmountERP }}</td>
                            <td>{{ $item->pay3_WONo }}</td>
                            <td>{{ $item->pay3_WOIssueDateERP }}</td>
                            <td>{{ $item->pay3_WOApprovedDateERP }}</td>
                            <td>{{ $item->pay3_DatesentWOtoSubCEmail }}</td>
                            <td>{{ $item->pay3_BillingAmount }}</td>
                            <td>{{ $item->pay3_BillingRequestedDateEmail }}</td>
                            <td>{{ $item->pay3_BillingApprovedDateEmail }}</td>
                            <td>{{ $item->pay3_BillingNoERP }}</td>
                            <td>{{ $item->pay3_BillingIssuedDateERP }}</td>
                            <td>{{ $item->pay3_BillingApprovedDateERP }}</td>
                            <td>{{ $item->pay3_DatesentBillingtoSubC }}</td>
                            <td>{{ $item->pay3_InvoicePlaceddatebySubC }}</td>
                            <td>{{ $item->pay3_SubC_InvoiceAmount }}</td>
                            <td>{{ $item->pay3_PaymentconfirmedDateERP }}</td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

        <script>
            document.querySelectorAll('input[type="number"]').forEach(function(element) {
                // เพิ่ม step="0.01" และ min="0" ไม่ให้กรอกค่าติดลบ
                element.setAttribute('step', '0.01');
                element.setAttribute('min', '0');
        
                element.addEventListener('blur', function(e) {
                    let value = e.target.value;
                    if (value) {
                        value = parseFloat(value);
                        if (value < 0) {
                            e.target.value = '';
                            alert("ห้ามกรอกค่าติดลบ");
                        } else {
                            e.target.value = value.toFixed(2); // ปัดเศษทศนิยม 2 ตำแหน่ง
                        }
                    }
                });
            });
        </script>
        

        

    @endsection
