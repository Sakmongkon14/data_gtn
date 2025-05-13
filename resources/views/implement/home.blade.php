@extends('layouts.Tailwind')
@section('title', 'Implement Report')

@section('content')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <div data-aos="fade-up" data-aos-anchor-placement="bottom-center">
        <h2 id="zoomText" class="text-center my-3 text-2xl font-bold"
            style="transform: scale(0.8); opacity: 0; transition: transform 0.5s ease-out, opacity 0.5s ease-out;">
            Implement Report
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

    <script>
        // ให้แน่ใจว่า script ทำงานหลังจาก HTML โหลดเสร็จ
        document.addEventListener("DOMContentLoaded", function() {
            // ฟังก์ชันส่งออก Excel
            document.getElementById('exportButtonImport').addEventListener('click', function() {
                var wb = XLSX.utils.book_new();

                // สร้างตารางที่ต้องการ export (แค่หัวตาราง)
                var table = document.createElement('table');
                var thead = table.createTHead();
                var row = thead.insertRow();

                // สร้างหัวตาราง (columns)
                var th1 = row.insertCell();
                th1.innerText = "Refcode";
                var th2 = row.insertCell();
                th2.innerText = "Owner Old Ste";
                var th3 = row.insertCell();
                th3.innerText = "Site Code";
                var th4 = row.insertCell();
                th4.innerText = "Site NAME_T";
                var th5 = row.insertCell();
                th5.innerText = "Region";
                var th6 = row.insertCell();
                th6.innerText = "Province";
                var th7 = row.insertCell();
                th7.innerText = "Tower height";


                // แปลงตารางเป็น sheet และส่งออก
                var ws = XLSX.utils.table_to_sheet(table);
                XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                XLSX.writeFile(wb, 'Template Import Refcode.csv');
            });
        });
    </script>

    <style>
        .dropdown-menu li {
            width: 200px;
            /* กำหนดความกว้างของแต่ละ li */
            margin: 5px auto;
            /* จัดให้ตรงกลาง */
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">


    <div class="modal fade" id="addRefCodeModal" tabindex="-1" aria-labelledby="addRefCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- เพิ่ม modal-lg เพื่อขยายความกว้าง -->
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="addRefCodeModalLabel">Add RefCode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Form ใส่ RefCode -->
                    <form id="addRefCodeForm" action="{{ route('implement.save') }}" method="POST">
                        @csrf
                        <div class="row">

                            <div class="row">
                                {{-- SiteCode Input --}}
                                <div class="col-md-6 mb-3 position-relative">
                                    <label for="sitecode" class="form-label">SiteCode</label>
                                    <input type="text" class="form-control" id="sitecode" name="sitecode"
                                        autocomplete="off" required>
                                    <ul id="sitecode-list" class="list-group position-absolute w-100"
                                        style="z-index: 9999; max-height: 200px; overflow-y: auto; display: none;"></ul>
                                </div>

                                {{-- RefCode Input --}}
                                <div class="col-md-6 mb-3 position-relative">
                                    <label for="refcode" class="form-label">RefCode</label>
                                    <input type="text" class="form-control" id="refcode" name="refcode"
                                        autocomplete="off" required>
                                    <ul id="refcode-list" class="list-group position-absolute w-100"
                                        style="z-index: 9999; max-height: 200px; overflow-y: auto; display: none;"></ul>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="project" class="form-label">Project</label>
                                <input type="text" class="form-control" id="project" name="project" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="officeCode" class="form-label">Office Code</label>
                                <input type="text" class="form-control" id="officeCode" name="officeCode" required>
                            </div>
                            <div class="col-md-6 mb-3">
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

                            <div class="col-md-6 mb-3">
                                <label for="go_NoGo" class="form-label">Go/Nogo</label>
                                <select class="form-select" id="go_NoGo" name="go_NoGo" required>
                                    <option value="">-- กรุณาเลือก --</option>
                                    <option value="Go">Go</option>
                                    <option value="Nogo">Nogo</option>
                                </select>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addRefCodeForm" class="btn btn-primary">Save</button>
                </div>

            </div>
        </div>
    </div>


    <div class="container-fluid  custom-container"> <!-- Add custom-container class -->
        <div class="row align-items-center h-100"> <!-- Add h-100 to make row take full height -->
            <div class="col-12 d-flex justify-content-between "> <!-- Add h-100 to the column -->

                <div class="dropdown">
                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false" data-aos="fade-right" data-aos-offset="100"
                        data-aos-duration="800" data-aos-easing="ease-out">
                        Menu
                    </button>
                    <ul class="dropdown-menu p-2 text-center" aria-labelledby="dropdownMenuButton">

                        <li class="w-200 mx-auto">
                            <a class="dropdown-item py-2" href="#" data-bs-toggle="modal"
                                data-bs-target="#addRefCodeModal">Add RefCode</a>
                        </li>


                        <li class="w-200 mx-auto"><a class="dropdown-item py-2" href="#" id="importFile">Import
                                RefCode</a></li>
                        <li class="w-200 mx-auto">
                        <li class="w-200 mx-auto">
                            <button type="submit" class="btn btn-outline-success w-100" id="exportButtonImport">
                                Template Import Refcode
                            </button>
                        </li>
                    </ul>
                </div>


                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        AOS.init(); // เริ่มต้น AOS Animation
                    });
                </script>


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
                    <form class="d-flex ms-2">
                        <!-- Add margin-start to create space -->


                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                AOS.init(); // เริ่มต้น AOS Animation
                            });
                        </script>

                        <div data-aos="fade-left" data-aos-anchor="#example-anchor" data-aos-offset="500"
                            data-aos-duration="500">
                            <button type="submit" class="btn btn-outline-success ms-2" id="exportButton"
                                style="margin-right: 30px;">
                                Export to Excel
                            </button>
                        </div>


                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                AOS.init(); // เริ่มต้น AOS Animation
                            });
                        </script>

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

                    <!-- MAIN ( 6 )-->

                    <th scope="col">Site Code</th>
                    <th scope="col">Project</th>
                    <th scope="col">Office Code</th>
                    <th scope="col">TRUE Region</th>
                    <th scope="col">Go / NoGo</th>


                    <!-- Group 1 ( 6 ) -->
                    <th scope="col">Estimated Revenue</th>
                    <th scope="col">Estimated service cost</th>
                    <th scope="col">Estimated material cost</th>
                    <th scope="col">Estimated Transportation Cost</th>
                    <th scope="col">Estimated gross profit</th>
                    <th scope="col">Estimated gross profit margin</th>


                    <!-- Group 2 ( 5 ) -->
                    <th scope="col">Assigned date (จากลูกค้า)</th>
                    <th scope="col">Started date (Actual)</th>
                    <th scope="col">Estimated gross profit margin</th>
                    <th scope="col">PAT Accrpted By GTN</th>
                    <th scope="col">FAT Accrpted By Customer</th>

                    <!-- Group 3 ( PO1 ( 15 ) ) -->
                    <th scope="col" style="background-color: red; color: white;">PO1 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO1 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO1 - Invoice1 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO1 - Invoice1 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO1 - Invoice1 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO1 - Invoice2 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO1 - Invoice2 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO1 - Invoice2 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO1 - Invoice3 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO1 - Invoice3 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO1 - Invoice3 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO1 - Invoice4 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO1 - Invoice4 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO1 - Invoice4 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO1 - Balanced</th>

                    <!-- PO2 -->
                    <th scope="col" style="background-color: red; color: white;">PO2 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO2 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO2 - Invoice1 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO2 - Invoice1 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO2 - Invoice1 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO2 - Invoice2 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO2 - Invoice2 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO2 - Invoice2 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO2 - Invoice3 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO2 - Invoice3 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO2 - Invoice3 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO2 - Invoice4 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO2 - Invoice4 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO2 - Invoice4 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO2 - Balanced</th>

                    <!-- PO3 -->
                    <th scope="col" style="background-color: red; color: white;">PO3 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO3 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO3 - Invoice1 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO3 - Invoice1 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO3 - Invoice1 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO3 - Invoice2 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO3 - Invoice2 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO3 - Invoice2 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO3 - Invoice3 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO3 - Invoice3 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO3 - Invoice3 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO3 - Invoice4 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO3 - Invoice4 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO3 - Invoice4 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO3 - Balanced</th>

                    <!-- PO4 -->
                    <th scope="col" style="background-color: red; color: white;">PO4 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO4 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO4 - Invoice1 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO4 - Invoice1 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO4 - Invoice1 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO4 - Invoice2 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO4 - Invoice2 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO4 - Invoice2 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO4 - Invoice3 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO4 - Invoice3 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO4 - Invoice3 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO4 - Invoice4 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO4 - Invoice4 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO4 - Invoice4 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO4 - Balanced</th>

                    <!-- PO5 -->
                    <th scope="col" style="background-color: red; color: white;">PO5 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO5 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO5 - Invoice1 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO5 - Invoice1 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO5 - Invoice1 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO5 - Invoice2 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO5 - Invoice2 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO5 - Invoice2 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO5 - Invoice3 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO5 - Invoice3 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO5 - Invoice3 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO5 - Invoice4 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO5 - Invoice4 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO5 - Invoice4 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO5 - Balanced</th>

                    <!-- PO6 -->
                    <th scope="col" style="background-color: red; color: white;">PO6 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO6 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO6 - Invoice1 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO6 - Invoice1 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO6 - Invoice1 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO6 - Invoice2 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO6 - Invoice2 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO6 - Invoice2 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO6 - Invoice3 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO6 - Invoice3 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO6 - Invoice3 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO6 - Invoice4 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO6 - Invoice4 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO6 - Invoice4 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO6 - Balanced</th>

                    <!-- PO7 -->
                    <th scope="col" style="background-color: red; color: white;">PO7 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO7 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO7 - Invoice1 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO7 - Invoice1 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO7 - Invoice1 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO7 - Invoice2 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO7 - Invoice2 No.</th>
                    <th scope="col" style="background-color: red; color: white;">PO7 - Invoice2 Amount</th>
                    <th scope="col" style="background-color: red; color: white;">PO7 - Invoice3 Placed date</th>
                    <th scope="col" style="background-color: red; color: white;">PO7 - Invoice3 No


                        <!-- Group 4 ( 25 ) -->
                    <th scope="col">SubC Assigned date</th>
                    <th scope="col">Activity</th>
                    <th scope="col">SubC Name</th>
                    <th scope="col">SubC - Quotation No.</th>
                    <th scope="col">SubC Quotation Amount</th>

                    <th scope="col">SubC - Quotation Submitted date (Email)</th>
                    <th scope="col">PR No.(ERP)</th>
                    <th scope="col">PR Amount.(ERP)</th>
                    <th scope="col">PR Issued date (ERP)</th>
                    <th scope="col">PR Approved date (ERP)</th>

                    <th scope="col">WO No.(ERP)</th>
                    <th scope="col">WO Amount (ERP)</th>
                    <th scope="col">WO Issued date (ERP)</th>
                    <th scope="col">WO Approved date (ERP)</th>
                    <th scope="col">SubC - Billing1 Requested date (E-Mail)</th>

                    <th scope="col">Billing1 No. (ERP)</th>
                    <th scope="col">Billing1 Date (ERP)</th>
                    <th scope="col">Billing1 Amount (ERP)</th>
                    <th scope="col">SubC Invoice1 Placed date</th>
                    <th scope="col">SubC - Billing2 Requested date (E-Mail)</th>

                    <th scope="col">Billing2 No. (ERP)</th>
                    <th scope="col">Billing2 Date (ERP)</th>
                    <th scope="col">Billing2 Amount (ERP)</th>
                    <th scope="col">SubC Invoice2 Placed date</th>
                    <th scope="col">SubC WO - Balanced</th>

                    <!--    </tr>  -->

                </thead>
                <tbody>

                    {{-- <td><a href=" {{ route('edit', $item->id) }}"><i class="bi bi-pencil-fill "></i></a></td> --}}

                    @foreach ($data as $item)
                        <tr style="font-size: 10px; text-align:center ">
                            <td><a href="{{ url('/implement/edit/' . $item->id) }}"><i class="bi bi-pencil-fill"></i></a>
                            </td>
                            <td>{{ $item->refcode }}</td>
                            <td>{{ $item->sitecode }}</td>
                            <td>{{ $item->project }}</td>
                            <td>{{ $item->officeCode }}</td>
                            <td>{{ $item->trueRegion }}</td>
                            <td>{{ $item->go_NoGo }}</td>

                            <!-- เพิ่มข้อมูลอื่น ๆ -->
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                AOS.init(); // เริ่มต้น AOS Animation
            });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                function handleAutocomplete(inputId, listId, apiUrl, fillTargetId, getTargetValue) {
                    const input = document.getElementById(inputId);
                    const list = document.getElementById(listId);
                    const fillTarget = document.getElementById(fillTargetId);

                    input.addEventListener("input", function() {
                        const search = this.value;
                        if (search.length === 0) {
                            list.style.display = "none";
                            return;
                        }

                        fetch(`${apiUrl}?search=${encodeURIComponent(search)}`)
                            .then(response => response.json())
                            .then(data => {
                                list.innerHTML = "";
                                data.forEach(item => {
                                    const li = document.createElement("li");
                                    li.classList.add("list-group-item", "list-group-item-action");
                                    li.textContent = item[getTargetValue]; // แสดงค่าที่เราต้องการ
                                    li.addEventListener("click", function() {
                                        input.value = item[
                                            getTargetValue]; // กรอกใน input นี้
                                        fillTarget.value = item[
                                            fillTargetId]; // กรอกใน input อีกช่อง
                                        list.style.display = "none";
                                    });
                                    list.appendChild(li);
                                });
                                list.style.display = data.length > 0 ? "block" : "none";
                            });
                    });

                    // ปิด list เมื่อคลิกข้างนอก
                    document.addEventListener("click", function(e) {
                        if (!input.contains(e.target) && !list.contains(e.target)) {
                            list.style.display = "none";
                        }
                    });
                }

                // SiteCode -> fill RefCode
                handleAutocomplete('sitecode', 'sitecode-list', '/search-sitecode', 'refcode', 'sitecode');

                // RefCode -> fill SiteCode
                handleAutocomplete('refcode', 'refcode-list', '/search-refcodeimplement', 'sitecode', 'refcode');
            });
        </script>



    @endsection
