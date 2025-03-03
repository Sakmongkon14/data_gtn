@extends('layouts.app')
@section('title', 'GTN')
@section('content')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <h2 class="text text-center my-3">New Site</h2>

    @if (session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>
    @endif


    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('error') }}
        </div>
    @endif



    <script>
        // ให้ alert หายไปหลังจาก 1.5 วินาที
        setTimeout(function() {
            let successAlert = document.getElementById('success-alert');
            let errorAlert = document.getElementById('error-alert');

            if (successAlert) {
                successAlert.style.display = 'none';
            }

            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 1500); // 5000 มิลลิวินาที = 5 วินาที
    </script>


    <div class="container-fluid  custom-container"> <!-- Add custom-container class -->
        <div class="row align-items-center h-100"> <!-- Add h-100 to make row take full height -->
            <div class="col-12 d-flex justify-content-between "> <!-- Add h-100 to the column -->

                <div class="dropdown">
                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Menu
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="add">Add Site Code</a></li>
                        <li><a class="dropdown-item" href="#" id="importFile">Import Site Code</a></li>
                    </ul>
                </div>

                <!-- ฟอร์มจะถูกซ่อนตอนแรก -->
                <div id="formContainer" class="container" style="display: none;">
                    <form action="/import" method="POST" enctype="multipart/form-data" id="csvForm"
                        class="d-flex flex-column flex-sm-row align-items-center gap-3 justify-content-start">
                        @csrf
                        <input type="file" class="form-control" name="csv_file_add" accept=".csv" required
                            style="width: 400px;">
                        <input type="submit" class="btn btn-success" name="preview_add"
                            value="แสดงข้อมูล SiteCode ที่ต้องการเพิ่ม" style="width: 250px; height: 37px;">
                    </form>
                </div>


                <div class="d-flex align-items-center"> <!-- Keep the search and export buttons together -->
                    <form class="d-flex ms-2"> <!-- Add margin-start to create space -->
                        <input type="text" class="form-control fixed-width-input" name="search" id="search"
                            placeholder="Search" aria-label="Search">
                        <button type="submit" class="btn btn-outline-success ms-2" id="exportButton"
                            style="margin-right: 30px;">
                            Export to Excel
                        </button>
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
    </style>

    <script>
        document.getElementById('importFile').addEventListener('click', function(event) {
            event.preventDefault(); // ป้องกันลิงก์โหลดหน้าใหม่
            let formContainer = document.getElementById('formContainer');

            // แสดงฟอร์มถ้ายังไม่แสดง หรือซ่อนถ้ากดอีกครั้ง
            if (formContainer.style.display === 'none' || formContainer.style.display === '') {
                formContainer.style.display = 'block';
            } else {
                formContainer.style.display = 'none';
            }
        });
    </script>

    <script>
        //ฟังก์ชั่น search
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var query = $(this).val().toLowerCase(); // ทำให้ query เป็นตัวพิมพ์เล็กทั้งหมด
                $('#table tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
                });
            });
        });
    </script>

    <script>
        // ฟังก์ชันส่งออก export
        document.getElementById('exportButton').addEventListener('click', function() {
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.table_to_sheet(document.getElementById('table'));
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
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
            max-height: 530px;
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
            //-เส้นขอบ colum
            padding: 8px;
            text-align: center;
            white-space: nowrap;
            position: sticky;
            top: 0px;
            text-align: center;
            background-color: #99FFCC;

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

        .table-container th:nth-child(4),
        .table-container td:nth-child(4) {
            position: sticky;
            left: 250px;
            width: 115px;
            min-width: 115px;
        }

        .table-container th:nth-child(5),
        .table-container td:nth-child(5) {
            position: sticky;
            left: 365px;
            width: 120px;
            min-width: 120px;
        }

        .table-container td:nth-child(1),
        .table-container td:nth-child(2),
        .table-container td:nth-child(3),
        .table-container td:nth-child(4),
        .table-container td:nth-child(5) {}

        .table-container th:nth-child(1),
        .table-container th:nth-child(2),
        .table-container th:nth-child(3),
        .table-container th:nth-child(4),
        .table-container th:nth-child(5) {
            z-index: 5;
            background: #d2cbc8;
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

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-container">
        <table class="table" id="table">
            <thead style="font-size: 12px; text-align:center ">

                <th scope="col"></th>

                <th scope="col">RefCode</th>
                <th scope="col">Owner Old Ste</th>
                <th scope="col">Site Code</th>
                <th scope="col">Site NAME_T</th>
                <th scope="col">Plan Type</th>
                <th scope="col">Region</th>
                <th scope="col">Province</th>
                <th scope="col">Site Type</th>
                <th scope="col">Tower New Site</th>
                <th scope="col">Tower height</th>
                <th scope="col">Tower</th>
                <th scope="col">Zone</th>


                <!-- INVOICE -->
                <th scope="col" style="background-color: #eaff01">Quotation_IN</th>
                <th scope="col" style="background-color: #eaff01">PO_No_IN</th>

                <th scope="col" style="background-color: #eaff01">PO_Amount_IN</th>
                <th scope="col" style="background-color: #ff0000">Banlace_IN</th>

                <th scope="col" style="background-color: #eaff01">Invoice1_IN</th>
                <th scope="col" style="background-color: #eaff01">Amount1_IN</th>
                <th scope="col" style="background-color: #eaff01">Invoice2_IN</th>
                <th scope="col" style="background-color: #eaff01">Amount2_IN</th>


                <!-- SAQ -->
                <th scope="col" style="background-color: #D1E9F6">Assigned SubC Survey SAQ</th>
                <th scope="col" style="background-color: #D1E9F6">SubName SAQ</th>

                <th scope="col" style="background-color: #D1E9F6">Plan Survey SAQ</th>
                <th scope="col" style="background-color: #D1E9F6">Actual Survey SAQ</th>

                <th scope="col" style="background-color: #D1E9F6">Quo No SAQ</th>
                <th scope="col" style="background-color: #D1E9F6">PR Price SAQ</th>
                <th scope="col" style="background-color: #D1E9F6">Accept PR Date SAQ</th>

                <th scope="col" style="background-color: #D1E9F6">WO No SAQ</th>
                <th scope="col" style="background-color: #D1E9F6">WO Price SAQ</th>
                <th scope="col" style="background-color: #ff0000">Banlace SAQ</th>

                <th scope="col" style="background-color: #D1E9F6">Accept 1st SAQ</th>
                <th scope="col" style="background-color: #D1E9F6">Mail</th>
                <th scope="col" style="background-color: #D1E9F6">ERP</th>

                <th scope="col" style="background-color: #D1E9F6">Accept 2st SAQ</th>
                <th scope="col" style="background-color: #D1E9F6">Mail</th>
                <th scope="col" style="background-color: #D1E9F6">ERP</th>

                <th scope="col" style="background-color: #D1E9F6">Accept 3st SAQ</th>
                <th scope="col" style="background-color: #D1E9F6">Mail</th>
                <th scope="col" style="background-color: #D1E9F6">ERP</th>
                <th scope="col" style="background-color: #D1E9F6">Accept 4st SAQ</th>
                <th scope="col" style="background-color: #D1E9F6">Mail</th>
                <th scope="col" style="background-color: #D1E9F6">ERP</th>

                <!-- CR -->
                <th scope="col" style="background-color: #29b6f6">Assigned SubC CR</th>
                <th scope="col" style="background-color: #29b6f6">SubName CR</th>

                <th scope="col" style="background-color: #29b6f6">Plan CR</th>
                <th scope="col" style="background-color: #29b6f6">Actual CR</th>

                <th scope="col" style="background-color: #29b6f6">Quo No CR</th>
                <th scope="col" style="background-color: #29b6f6">PR Price CR</th>
                <th scope="col" style="background-color: #29b6f6">Accept PR Date CR</th>

                <th scope="col" style="background-color: #29b6f6">WO No CR</th>
                <th scope="col" style="background-color: #29b6f6">WO Price CR</th>
                <th scope="col" style="background-color: #ff0000">Banlace CR</th>


                <th scope="col" style="background-color:  #29b6f6">Accept 1st CR</th>
                <th scope="col" style="background-color:  #29b6f6">Mail</th>
                <th scope="col" style="background-color:  #29b6f6">ERP</th>

                <th scope="col" style="background-color:  #29b6f6">Accept 2st CR</th>
                <th scope="col" style="background-color:  #29b6f6">Mail</th>
                <th scope="col" style="background-color:  #29b6f6">ERP</th>

                <th scope="col" style="background-color:  #29b6f6">Accept 3st CR</th>
                <th scope="col" style="background-color:  #29b6f6">Mail</th>
                <th scope="col" style="background-color:  #29b6f6">ERP</th>

                <th scope="col" style="background-color:  #29b6f6">Accept 4st CR</th>
                <th scope="col" style="background-color:  #29b6f6">Mail</th>
                <th scope="col" style="background-color:  #29b6f6">ERP</th>

                <!-- TSSR -->
                <th scope="col" style="background-color: #fff176">Assigned SubC TSSR</th>
                <th scope="col" style="background-color: #fff176">SubName TSSR</th>

                <th scope="col" style="background-color: #fff176">Plan TSSR</th>
                <th scope="col" style="background-color: #fff176">Actual TSSR</th>

                <th scope="col" style="background-color: #fff176">Quo No TSSR</th>
                <th scope="col" style="background-color: #fff176">PR Price TSSR</th>
                <th scope="col" style="background-color: #fff176">Accept PR Date TSSR</th>

                <th scope="col" style="background-color: #fff176">WO No TSSR</th>
                <th scope="col" style="background-color: #fff176">WO Price TSSR</th>
                <th scope="col" style="background-color: #fc0000">Banlace TSSR</th>


                <th scope="col" style="background-color: #fff176">Accept 1st TSSR</th>
                <th scope="col" style="background-color: #fff176">Mail</th>
                <th scope="col" style="background-color: #fff176">ERP</th>

                <th scope="col" style="background-color: #fff176">Accept 2st TSSR</th>
                <th scope="col" style="background-color: #fff176">Mail</th>
                <th scope="col" style="background-color: #fff176">ERP</th>

                <th scope="col" style="background-color: #fff176">Accept 3st TSSR</th>
                <th scope="col" style="background-color: #fff176">Mail</th>
                <th scope="col" style="background-color: #fff176">ERP</th>

                <th scope="col" style="background-color: #fff176">Accept 4st TSSR</th>
                <th scope="col" style="background-color: #fff176">Mail</th>
                <th scope="col" style="background-color: #fff176">ERP</th>



                <!-- CivilWork -->
                <th scope="col" style="background-color: #00DFA2">Plan Civil FoundationAssign</th>
                <th scope="col" style="background-color: #00DFA2">Actual Civil WorkFoundation</th>

                <th scope="col" style="background-color: #00DFA2">Plan Civil WorkTower</th>
                <th scope="col" style="background-color: #00DFA2">Actual Civil WorkTower</th>

                <th scope="col" style="background-color: #00DFA2">Plan Installation Rectifier</th>
                <th scope="col" style="background-color: #00DFA2">Actual Installation Rectifier</th>

                <th scope="col" style="background-color: #00DFA2">Plan AC Power</th>
                <th scope="col" style="background-color: #00DFA2">Actual AC Power</th>

                <th scope="col" style="background-color: #00DFA2">Plan AC Meter</th>
                <th scope="col" style="background-color: #00DFA2">Actual AC Meter</th>

                <th scope="col" style="background-color: #00DFA2">PAT</th>
                <th scope="col" style="background-color: #00DFA2">Def.PAT</th>
                <th scope="col" style="background-color: #00DFA2">FAT</th>

                <th scope="col" style="background-color: #00DFA2">Assigned CivilWork</th>
                <th scope="col" style="background-color: #00DFA2">SubName CivilWork</th>

                <th scope="col" style="background-color: #00DFA2">Plan CivilWork</th>
                <th scope="col" style="background-color: #00DFA2">Actual CivilWork</th>

                <th scope="col" style="background-color: #00DFA2">Quo No CivilWork</th>
                <th scope="col" style="background-color: #00DFA2">PR Price CivilWork</th>
                <th scope="col" style="background-color: #00DFA2">Accept PR Date CivilWork</th>

                <th scope="col" style="background-color: #00DFA2">WO No CivilWork</th>
                <th scope="col" style="background-color: #00DFA2">WO Price CivilWork</th>
                <th scope="col" style="background-color: #ff0000">Banlace CivilWork</th>


                <th scope="col" style="background-color: #00DFA2">Accept 1st CivilWork</th>
                <th scope="col" style="background-color: #00DFA2">Mail</th>
                <th scope="col" style="background-color: #00DFA2">ERP</th>

                <th scope="col" style="background-color: #00DFA2">Accept 2st CivilWork</th>
                <th scope="col" style="background-color: #00DFA2">Mail</th>
                <th scope="col" style="background-color: #00DFA2">ERP</th>

                <th scope="col" style="background-color: #00DFA2">Accept 3st CivilWork</th>
                <th scope="col" style="background-color: #00DFA2">Mail</th>
                <th scope="col" style="background-color: #00DFA2">ERP</th>

                <th scope="col" style="background-color: #00DFA2">Accept 4st CivilWork</th>
                <th scope="col" style="background-color: #00DFA2">Mail</th>
                <th scope="col" style="background-color: #00DFA2">ERP</th>

                <!-- ADDITIONAL -->
                <th scope="col" style="background-color: #ddd">Additional</th>


                <!--    </tr>  -->

            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr style="font-size: 10px; text-align:center ">

                        <td><a href=" {{ route('edit', $item->id) }}"><i class="bi bi-pencil-fill "></i></a></td>


                        <td>{{ $item->RefCode }}</td>

                        <td>{{ $item->OwnerOldSte }}</td>
                        <td>{{ $item->SiteCode }}</td>
                        <td>{{ $item->SiteNAME_T }}</td>
                        <td>{{ $item->PlanType }}</td>

                        <td>
                            @foreach ($areas as $region)
                                @if ($region->Region_id == $item->Region_id)
                                    {{ $region->Region_name }}
                                @endif
                            @endforeach
                        </td>

                        <td>{{ $item->Province }}</td>
                        <td>{{ $item->SiteType }}</td>
                        <td>{{ $item->TowerNewSite }}</td>
                        <td>{{ $item->Towerheight }}</td>
                        <td>{{ $item->Tower }}</td>
                        <td>{{ $item->Zone }}</td>


                        <!-- INVOICE -->
                        <td>{{ $item->Quotation_IN }}</td>
                        <td>{{ $item->PO_No_IN }}</td>

                        <td>{{ $item->PO_Amount_IN }}</td>

                        <td>
                            @php
                                $wo = $item->PO_Amount_IN;
                                $banlace_IN = $item->Banlace_IN;
                            @endphp
                            @if (empty($wo))
                            @elseif ($banlace_IN == 0)
                                <span style="color: green;">{{ number_format($banlace_IN, 2, '.', ',') }}</span>
                                <!-- แสดง Banlace_SAQ เป็นสีเขียวเมื่อเป็น 0 -->
                            @else
                                {{ $item->Banlace_IN }}
                            @endif
                        </td>


                        <td>{{ $item->Invoice1_IN }}</td>

                        <td>
                            {{ $item->Amount1_IN }}
                            @if (empty($item->Amount1_IN))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>

                        <td>{{ $item->Invoice2_IN }}</td>

                        <td>
                            {{ $item->Amount2_IN }}
                            @if (empty($item->Amount2_IN))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>



                        <!-- SAQ  -->
                        <td>{{ $item->AssignedSubCSurveySAQ }}</td>
                        <td>{{ $item->SubName_SAQ }}</td>

                        <td>{{ $item->PlanSurveySAQ }}</td>
                        <td>{{ $item->ActualSurveySAQ }}</td>

                        <td>{{ $item->Quo_No_SAQ }}</td>
                        <td>{{ $item->PR_Price_SAQ }}</td>
                        <td>{{ $item->Accept_PR_Date_SAQ }}</td>
                        <td>{{ $item->WO_No_SAQ }}</td>
                        <td>{{ $item->WO_Price_SAQ }}</td>

                        <td>
                            @php
                                $wo = $item->WO_Price_SAQ;
                                $banlace_SAQ = $item->Banlace_SAQ;
                            @endphp
                            @if (empty($wo))
                            @elseif ($banlace_SAQ == 0)
                                <span style="color: green;">{{ number_format($banlace_SAQ, 2, '.', ',') }}</span>
                                <!-- แสดง Banlace_SAQ เป็นสีเขียวเมื่อเป็น 0 -->
                            @else
                                {{ $item->Banlace_SAQ }}
                            @endif
                        </td>

                        <td>
                            {{ $item->Accept_1st_SAQ }}
                            @if (empty($item->Accept_1st_SAQ))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_1st_SAQ }}</td>
                        <td>{{ $item->ERP_1st_SAQ }}</td>

                        <td>
                            {{ $item->Accept_2nd_SAQ }}
                            @if (empty($item->Accept_2nd_SAQ))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_2nd_SAQ }}</td>
                        <td>{{ $item->ERP_2nd_SAQ }}</td>

                        <td>
                            {{ $item->Accept_3rd_SAQ }}
                            @if (empty($item->Accept_3rd_SAQ))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_3rd_SAQ }}</td>
                        <td>{{ $item->ERP_3rd_SAQ }}</td>

                        <td>
                            {{ $item->Accept_4th_SAQ }}
                            @if (empty($item->Accept_4th_SAQ))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_4th_SAQ }}</td>
                        <td>{{ $item->ERP_4th_SAQ }}</td>




                        <!-- CR  -->
                        <td>{{ $item->AssignedSubCCR }}</td>
                        <td>{{ $item->SubName_CR }}</td>

                        <td>{{ $item->PlanCR }}</td>
                        <td>{{ $item->ActualCR }}</td>

                        <td>{{ $item->Quo_No_CR }}</td>
                        <td>{{ $item->PR_Price_CR }}</td>
                        <td>{{ $item->Accept_PR_Date_CR }}</td>

                        <td>{{ $item->WO_No_CR }}</td>
                        <td>{{ $item->WO_Price_CR }}</td>

                        <td>
                            @php
                                $wo = $item->WO_Price_CR;
                                $banlace_CR = $item->Banlace_CR; // ดึงค่า Banlace_SAQ
                            @endphp
                            @if (empty($wo))
                            @elseif ($banlace_CR == 0)
                                <span style="color: green;">{{ number_format($banlace_CR, 2, '.', ',') }}</span>
                                <!-- แสดง Banlace_SAQ เป็นสีเขียวเมื่อเป็น 0 -->
                            @else
                                {{ $item->Banlace_CR }}
                            @endif
                        </td>


                        <td>
                            {{ $item->Accept_1st_CR }}
                            @if (empty($item->Accept_1st_CR))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_1st_CR }}</td>
                        <td>{{ $item->ERP_1st_CR }}</td>

                        <td>
                            {{ $item->Accept_2nd_CR }}
                            @if (empty($item->Accept_2nd_CR))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_2nd_CR }}</td>
                        <td>{{ $item->ERP_2nd_CR }}</td>

                        <td>
                            {{ $item->Accept_3rd_CR }}
                            @if (empty($item->Accept_3rd_CR))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_3rd_CR }}</td>
                        <td>{{ $item->ERP_3rd_CR }}</td>

                        <td>
                            {{ $item->Accept_4th_CR }}
                            @if (empty($item->Accept_4th_CR))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_4th_CR }}</td>
                        <td>{{ $item->ERP_4th_CR }}</td>


                        <!-- TSSR  -->
                        <td>{{ $item->AssignedSubCTSSR }}</td>
                        <td>{{ $item->SubName_TSSR }}</td>

                        <td>{{ $item->PlanTSSR }}</td>
                        <td>{{ $item->ActualTSSR }}</td>

                        <td>{{ $item->Quo_No_TSSR }}</td>
                        <td>{{ $item->PR_Price_TSSR }}</td>
                        <td>{{ $item->Accept_PR_Date_TSSR }}</td>

                        <td>{{ $item->WO_No_TSSR }}</td>
                        <td>{{ $item->WO_Price_TSSR }}</td>

                        <td>
                            @php
                                $wo = $item->WO_Price_TSSR;
                                $banlace_TSSR = $item->Banlace_TSSR;
                            @endphp
                            @if (empty($wo))
                            @elseif ($banlace_TSSR == 0)
                                <span style="color: green;">{{ number_format($banlace_TSSR, 2, '.', ',') }}</span>
                                <!-- แสดง Banlace_SAQ เป็นสีเขียวเมื่อเป็น 0 -->
                            @else
                                {{ $item->Banlace_TSSR }}
                            @endif
                        </td>

                        <td>
                            {{ $item->Accept_1st_TSSR }}
                            @if (empty($item->Accept_1st_TSSR))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_1st_TSSR }}</td>
                        <td>{{ $item->ERP_1st_TSSR }}</td>


                        <td>
                            {{ $item->Accept_2nd_TSSR }}
                            @if (empty($item->Accept_2nd_TSSR))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_2nd_TSSR }}</td>
                        <td>{{ $item->ERP_2nd_TSSR }}</td>


                        <td>
                            {{ $item->Accept_3rd_TSSR }}
                            @if (empty($item->Accept_3rd_TSSR))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_3rd_TSSR }}</td>
                        <td>{{ $item->ERP_3rd_TSSR }}</td>


                        <td>
                            {{ $item->Accept_4th_TSSR }}
                            @if (empty($item->Accept_4th_TSSR))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_4th_TSSR }}</td>
                        <td>{{ $item->ERP_4th_TSSR }}</td>



                        <!-- CivilWork  -->
                        <td>{{ $item->AssignSubCivilfoundation }}</td>
                        <td>{{ $item->PlanCivilWorkFoundation }}</td>

                        <td>{{ $item->ActualCivilWorkTower }}</td>
                        <td>{{ $item->AssignCivilWorkTower }}</td>

                        <td>{{ $item->PlanInstallationRectifier }}</td>
                        <td>{{ $item->ActualInstallationRectifier }}</td>

                        <td>{{ $item->PlanACPower }}</td>
                        <td>{{ $item->ActualACPower }}</td>

                        <td>{{ $item->PlanACMeter }}</td>
                        <td>{{ $item->ActualACMeter }}</td>

                        <td>{{ $item->PAT }}</td>
                        <td>{{ $item->DefPAT }}</td>
                        <td>{{ $item->FAT }}</td>

                        <td>{{ $item->Assigned_CivilWork }}</td>
                        <td>{{ $item->SubName_CivilWork }}</td>

                        <td>{{ $item->Plan_CivilWork }}</td>
                        <td>{{ $item->Actual_CivilWork }}</td>

                        <td>{{ $item->Quo_No_CivilWork }}</td>
                        <td>{{ $item->PR_Price_CivilWork }}</td>
                        <td>{{ $item->Accept_PR_Date_CivilWork }}</td>

                        <td>{{ $item->WO_No_CivilWork }}</td>
                        <td>{{ $item->WO_Price_CivilWork }}</td>

                        <td>
                            @php
                                $wo = $item->WO_Price_CivilWork;
                                $banlace_CivilWork = $item->Banlace_CivilWork;
                            @endphp
                            @if (empty($wo))
                            @elseif ($banlace_CivilWork == 0)
                                <span style="color: green;">{{ number_format($banlace_CivilWork, 2, '.', ',') }}</span>
                                <!-- แสดง Banlace_SAQ เป็นสีเขียวเมื่อเป็น 0 -->
                            @else
                                {{ $banlace_CivilWork }}
                            @endif
                        </td>

                        <td>
                            {{ $item->Accept_1st_CivilWork }}
                            @if (empty($item->Accept_1st_CivilWork))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_1st_CivilWork }}</td>
                        <td>{{ $item->ERP_1st_CivilWork }}</td>

                        <td>
                            {{ $item->Accept_2nd_CivilWork }}
                            @if (empty($item->Accept_2nd_CivilWork))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_2nd_CivilWork }}</td>
                        <td>{{ $item->ERP_2nd_CivilWork }}</td>

                        <td>
                            {{ $item->Accept_3rd_CivilWork }}
                            @if (empty($item->Accept_3rd_CivilWork))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_3rd_CivilWork }}</td>
                        <td>{{ $item->ERP_3rd_CivilWork }}</td>

                        <td>
                            {{ $item->Accept_4th_CivilWork }}
                            @if (empty($item->Accept_4th_CivilWork))
                                <span class="indicator no-data" title="No Data"></span>
                            @endif
                        </td>
                        <td>{{ $item->Mail_4th_CivilWork }}</td>
                        <td>{{ $item->ERP_4th_CivilWork }}</td>

                        <!-- ADDITIONAL -->
                        <td>{{ $item->id_add }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
