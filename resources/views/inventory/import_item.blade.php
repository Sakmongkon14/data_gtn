<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ข้อมูลเข้าคลังสินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- Add Boxicons -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Add Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

    :root {
        --color-default: #004f83;
        --color-second: #0067ac;
        --color-white: #fff;
        --color-body: #e4e9f7;
        --color-light: #e0e0e0;
    }


    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        min-height: 100vh;
    }

    .sidebar {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        /* ดันเนื้อหาให้ห่างกัน */
        min-height: 100vh;
        width: 78px;
        padding-right: 10px;
        z-index: 99;
        background-color: var(--color-default);
        transition: all 0.5s ease;
        position: fixed;
        top: 0;
        left: 0;
    }

    .nav-list {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        /* ขยายเพื่อรองรับเนื้อหาด้านบน */
    }

    .logout {
        margin-top: auto;
        /* ดันปุ่ม Logout ไปด้านล่างสุด */
    }

    .sidebar.open {
        width: 250px;
    }

    .sidebar .logo_details {
        height: 60px;
        display: flex;
        align-items: center;
        position: relative;
    }

    .sidebar .logo_details .icon {
        opacity: 0;
        transition: all 0.5s ease;
    }



    .sidebar .logo_details .logo_name {
        color: var(--color-white);
        font-size: 22px;
        font-weight: 600;
        opacity: 0;
        transition: all .5s ease;
    }

    .sidebar.open .logo_details .icon,
    .sidebar.open .logo_details .logo_name {
        opacity: 1;
        margin: 10px;
    }

    .sidebar .logo_details #btn {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        font-size: 23px;
        text-align: center;
        cursor: pointer;
        transition: all .5s ease;
    }

    .sidebar.open .logo_details #btn {
        text-align: right;
    }

    .sidebar i {
        color: var(--color-white);
        height: 60px;
        line-height: 60px;
        min-width: 50px;
        font-size: 25px;
        text-align: center;
    }

    .sidebar .nav-list {
        margin-top: 20px;
        height: 100%;
    }

    .sidebar li {
        position: relative;
        margin: 8px 0;
        list-style: none;
    }

    .sidebar li .tooltip {
        position: absolute;
        top: -20px;
        left: calc(100% + 15px);
        z-index: 3;
        background-color: var(--color-white);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        padding: 6px 14px;
        font-size: 15px;
        font-weight: 400;
        border-radius: 5px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
    }

    .sidebar li:hover .tooltip {
        opacity: 1;
        pointer-events: auto;
        transition: all 0.4s ease;
        top: 50%;
        transform: translateY(-50%);
    }

    .sidebar.open li .tooltip {
        display: none;
    }

    .sidebar input {
        font-size: 15px;
        color: var(--color-white);
        font-weight: 400;
        outline: none;
        height: 35px;
        width: 35px;
        border: none;
        border-radius: 5px;
        background-color: var(--color-second);
        transition: all .5s ease;
    }

    .sidebar input::placeholder {
        color: var(--color-light)
    }

    .sidebar.open input {
        width: 100%;
        padding: 0 20px 0 50px;
    }

    .sidebar .bx-search {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        font-size: 22px;
        background-color: var(--color-second);
        color: var(--color-white);
    }

    .sidebar li a {
        display: flex;
        height: 100%;
        width: 100%;
        align-items: center;
        text-decoration: none;
        background-color: var(--color-default);
        position: relative;
        transition: all .5s ease;
        z-index: 12;
    }

    .sidebar li a::after {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        transform: scaleX(0);
        background-color: var(--color-white);
        border-radius: 5px;
        transition: transform 0.3s ease-in-out;
        transform-origin: left;
        z-index: -2;
    }

    .sidebar li a:hover::after {
        transform: scaleX(1);
        color: var(--color-default)
    }

    .sidebar li a .link_name {
        color: var(--color-white);
        font-size: 15px;
        font-weight: 400;
        white-space: nowrap;
        pointer-events: auto;
        transition: all 0.4s ease;
        pointer-events: none;
        opacity: 0;
    }

    .sidebar li a:hover .link_name,
    .sidebar li a:hover i {
        transition: all 0.5s ease;
        color: var(--color-default)
    }

    .sidebar.open li a .link_name {
        opacity: 1;
        pointer-events: auto;
    }

    .sidebar li i {
        height: 35px;
        padding-right: 30px;
        line-height: 35px;
        font-size: 18px;
        border-radius: 5px;
    }

    .sidebar li.profile {
        position: fixed;
        height: 60px;
        width: 78px;
        left: 0;
        bottom: -8px;
        padding: 10px 14px;
        overflow: hidden;
        transition: all .5s ease;
    }

    .sidebar.open li.profile {
        width: 250px;
    }

    .sidebar .profile .profile_details {
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
    }

    .sidebar li img {
        height: 45px;
        width: 45px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 10px;
    }

    .sidebar li.profile .name,
    .sidebar li.profile .designation {
        font-size: 15px;
        font-weight: 400;
        color: var(--color-white);
        white-space: nowrap;
    }

    .sidebar li.profile .designation {
        font-size: 12px;
    }

    .sidebar .profile #log_out {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        background-color: var(--color-second);
        width: 100%;
        height: 60px;
        line-height: 60px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.5s ease;
    }

    .sidebar.open .profile #log_out {
        width: 50px;
        background: none;
    }

    .home-section {
        position: relative;
        background-color: var(--color-body);
        min-height: 100vh;
        top: 0;
        left: 78px;
        width: calc(100% - 78px);
        transition: all .5s ease;
        z-index: 2;
    }

    .home-section .text {
        display: inline-block;
        color: var(--color-default);
        font-size: 15px;
        font-weight: 500;

    }

    .sidebar.open~.home-section {
        left: 250px;
        width: calc(100% - 250px);
    }




    /* From */

    .form button {
        border: none;
        background: none;
        color: #8b8ba7;
    }

    .from {
        display: flex;
        align-items: center;

    }

    .form {
        margin-left: 40px;
        --timing: 0.3s;
        --width-of-input: 200px;
        --height-of-input: 40px;
        --border-height: 2px;
        --input-bg: #fff;
        --border-color: #2f2ee9;
        --border-radius: 30px;
        --after-border-radius: 1px;
        position: relative;
        width: var(--width-of-input);
        height: var(--height-of-input);
        display: flex;
        align-items: center;
        padding-inline: 0.8em;
        border-radius: var(--border-radius);
        transition: border-radius 0.5s ease;
        background: var(--input-bg, #fff);
    }


    /* from Input */
    .input {
        font-size: 0.9rem;
        background-color: transparent;
        width: 100%;
        height: 100%;
        padding-inline: 0.5em;
        padding-block: 0.7em;
        border: none;
    }

    /* styling of animated border */
    .form:before {
        content: "";
        position: absolute;
        background: var(--border-color);
        transform: scaleX(0);
        transform-origin: center;
        width: 100%;
        height: var(--border-height);
        left: 0;
        bottom: 0;
        border-radius: 1px;
        transition: transform var(--timing) ease;
    }

    /* Hover on Input */
    .form:focus-within {
        border-radius: var(--after-border-radius);
    }



    input:focus {
        outline: none;
    }

    /* here is code of animated border */
    .form:focus-within:before {
        transform: scale(1);
    }

    /* styling of close button */
    /* == you can click the close button to remove text == */
    .reset {
        border: none;
        background: none;
        opacity: 0;
        visibility: hidden;
    }

    /* close button shown when typing */
    input:not(:placeholder-shown)~.reset {
        opacity: 1;
        visibility: visible;
    }

    /* sizing svg icons */
    .form svg {
        width: 17px;
        margin-top: 3px;
    }



    /* ปุ่มนำของเข้า */
    .cssbuttons-io {
        position: relative;
        font-family: inherit;
        font-weight: 500;
        font-size: 12px;
        letter-spacing: 0.05em;
        border-radius: 0.8em;
        cursor: pointer;
        border: none;
        background: linear-gradient(to right, #0dcaf0, #00e035);
        color: rgb(0, 0, 0);
        overflow: hidden;
    }

    .cssbuttons-io svg {
        width: 1.2em;
        height: 1.2em;
        margin-right: 0.5em;
    }

    .cssbuttons-io span {
        position: relative;
        z-index: 10;
        transition: color 0.4s;
        display: inline-flex;
        align-items: center;
        padding: 0.8em 1.2em 0.8em 1.05em;
    }

    .cssbuttons-io::before,
    .cssbuttons-io::after {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    .cssbuttons-io::before {
        content: "";
        background: skyblue;
        width: 120%;
        left: -10%;
        transform: skew(30deg);
        transition: transform 0.4s cubic-bezier(0.3, 1, 0.8, 1);
    }

    .cssbuttons-io:hover::before {
        transform: translate3d(100%, 0, 0);
    }

    .cssbuttons-io:active {
        transform: scale(0.95);
    }



    /* input */
    .input-style {
        padding: 2px;
        border: 2px solid #ccc;
        border-radius: 5px;
        font-size: 10px;
        color: #555;
        outline: none;
    }

    .input-style:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }



    .fb {
        display: flex;
        flex-wrap: wrap;
        align-content: center;
        justify-content: center;
        align-items: center;
    }

    .modal-header {
        font-size: 10px;
        font-family: sans-serif;
        display: flex;
        align-items: center;
        gap: 50px;

    }

    .modal-backdrop.show {
        display: none;
    }

    .modal-body {
        max-height: 586px;
        /* กำหนดความสูงสูงสุดของตาราง */
        background: white;
        padding: 20px;
        border-radius: 10px;
    }




    .hi {
        display: flex;
        align-items: baseline;
        gap: 10px;
    }



    /* Export*/
    .button {
        position: relative;
        width: 150px;
        height: 40px;
        cursor: pointer;
        display: flex;
        align-items: center;
        border: 1px solid #17795E;
        background-color: #209978;
        overflow: hidden;
    }

    .button,
    .button__icon,
    .button__text {
        transition: all 0.3s;
    }

    .button .button__text {
        transform: translateX(22px);
        color: #fff;
        font-size: 9px;
        font-weight: 600;
    }

    .button .button__icon {
        position: absolute;
        transform: translateX(109px);
        height: 100%;
        width: 39px;
        background-color: #17795E;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .button .svg {
        width: 20px;
        fill: #fff;
    }

    .button:hover {
        background: #17795E;
    }

    .button:hover .button__text {
        color: transparent;
    }

    .button:hover .button__icon {
        width: 148px;
        transform: translateX(0);
    }

    .button:active .button__icon {
        background-color: #146c54;
    }

    .button:active {
        border: 1px solid #146c54;
    }


    .table>:not(caption)>*>* {
        text-align: center;
    }

    .table-wrapper {
        height: auto;
        /* กำหนดความสูงสูงสุดของตาราง */
        box-shadow: 0 2px 5px #8494a4;
        background: white;
        padding: 20px;
        border-radius: 10px;
    }

    /* ปรับการจัดตำแหน่งข้อความในตาราง */
    .table th,
    .table td {
        text-align: center;
    }

    .table-wrapper {
        max-height: 500px;
        box-shadow: 0 2px 5px #8494a4;
        background: white;
        padding: 20px;
        border-radius: 10px;
    }

    .table-container {
        display: flex;
        align-content: center;
        justify-content: center;
        align-items: baseline;
        font-family: sans-serif;
        width: 100%;
        height: 545px;
        overflow-y: auto;
        border: 1px solid #ccc;
    }

    .table thead th {
        position: sticky;
        /* ทำให้คงที่ */
        top: 0;
        /* ติดด้านบน */
        background-color: skyblue;
        /* กำหนดสีพื้นหลังของหัวตาราง */
        z-index: 2;
        /* ให้หัวคอลัมน์อยู่ด้านบนของเนื้อหา */
        text-align: center;
        padding: 10px;
        font-size: 11px;
    }

    .table td {
        font-size: 10px;
        background-color: #ffffff;
        text-align: center;
    }


    .texeadd {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        gap: 1rem;
    }

    .mb-4 {
        font-size: 15px;
    }

    .mt-5 {
        margin-top: 1rem !important;
    }

    .table th {
        background-color: skyblue;
        /* กำหนดสีพื้นหลังของหัวตาราง */
        text-align: center;
        padding: 15px;
        font-size: 14px;
    }

    .table td {
        background-color: #ffffff33;
        padding: 0px;
        text-align: center;
    }



    .table thead {
        background-color: #55608f;
        /* สีพื้นหลังที่เหมาะสมสำหรับ thead */
    }

    tbody tr:hover {
        background-color: #ee0d3e4d;
        /* สีพื้นหลังเมื่อมีการ hover แถว */
    }
</style>


<body>


    <div class="sidebar">
        <div class="logo_details">
            <div class="logo_name">GTN</div>
            <i class="bx bx-menu" id="btn"></i>
        </div>

        <ul class="nav-list">
            <div class="sidebox">
                @if (Auth::check())

                    @if (in_array(Auth::user()->status, [1]))
                        <li>
                            <a href="import">
                                <i class="fa-solid fa-warehouse"></i>
                                <span class="link_name">นำของเข้า</span>
                            </a>
                            <span class="tooltip">นำของเข้า</span>
                        </li>
                    @endif

                @endif
                <li>
                    <a href="withdraw">
                        <i class="fa-solid fa-hand-holding-heart"></i>
                        <span class="link_name">เบิกของ</span>
                    </a>
                    <span class="tooltip">เบิกของ</span>
                </li>
                <li>
                    <a href="sum">
                        <i class="fa-solid fa-square-poll-vertical"></i>
                        <span class="link_name">วัสดุคงคลัง</span>
                    </a>
                    <span class="tooltip">วัสดุคงคลัง</span>
                </li>
                <li>
                    <a href="material">
                        <i class="fa-solid fa-cart-plus"></i>
                        <span class="link_name">รายการวัสดุ</span>
                    </a>
                    <span class="tooltip">รายการวัสดุ</span>
                </li>
                <li>
                    <a href="droppoint">
                        <i class="fa-solid fa-location-dot"></i>
                        <span class="link_name">สถานที่เก็บอุปกรณ์</span>
                    </a>
                    <span class="tooltip">สถานที่เก็บอุปกรณ์</span>
                </li>
                <li>
                    <a href="addrefcode">
                        <i class="fa-solid fa-file-code"></i>
                        <span class="link_name">Refcode</span>
                    </a>
                    <span class="tooltip">Refcode</span>
                </li>
                
                <li style="margin-top: 100px;">
                    <a href="region">
                        <i class='fas fa-arrow-alt-circle-down'></i>
                        <span class="link_name">Region</span>
                    </a>
                    <span class="tooltip">Region</span>
                </li>
            </div>


            <li style="margin-top: 150px;">
                <a href="home">
                    <i class="fas fa-home"></i>
                    <span class="link_name">HOME</span>
                </a>
                <span class="tooltip">HOME</span>
            </li>
    

        </ul>
    </div>

    <section class="home-section">

        <!-- Content -->

        <!-- Navbar -->
        <div class="content" style="transition: margin-left 0.3s ease-in-out; padding-top: 60px;">
            <nav
                style="background: #f8f9fa; position: absolute; top: 0; width: 100%; z-index: 900; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">
                <div id="sticky-wrapper" class="sticky-wrapper"
                    style="height: 30px; background: #87ceeb; font-size: 15px">
                    <div class="container">
                        <div class="name"
                            style=" display: flex; height: 30px; justify-content: space-between; align-items: center; color: #f8f9fa; font-size: 15px;">
                            <div class="text" style="display: flex; align-items: center; gap:5px;">Inventory control<i
                                    class="fa-solid fa-truck-ramp-box"></i></div>
                            <div class="name">
                                <i class="fa-regular fa-user"> {{ Auth::user()->name }}</i>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="container">

                <!--Add Modal-->
                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="addModalLabel" style="font-size: 15px;">Add Material</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-container" style="height: 490px;">
                                    <table class="table" id="materialTable">
                                        <thead>
                                            <tr>

                                                <th
                                                    style="background-color: skyblue; width: 20rem; text-align: center; vertical-align: middle;">
                                                    Material Code
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text"
                                                            id="searchMaterialCode" name="searchMaterialCode">
                                                    </div>
                                                </th>
                                                <th
                                                    style="background-color: skyblue; width: 20rem; text-align: center; vertical-align: middle;">
                                                    Material Name
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text"
                                                            id="searchMaterialName" name="searchMaterialName">
                                                    </div>
                                                </th>
                                                <th
                                                    style="background-color: skyblue; width: 20rem; text-align: center; vertical-align: middle;">
                                                    Spec/Size
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text" id="searchSpec"
                                                            name="searchSpec">
                                                    </div>
                                                </th>
                                                <th scope="col">Brand</th>
                                                <th scope="col">Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($material as $item)
                                                <tr data-material-code="{{ $item->material_c }}"
                                                    data-material-name="{{ $item->material_n }}"
                                                    data-spec="{{ $item->spec_size }}">

                                                    <td>
                                                        <a href="#"
                                                            onclick="populateHiddenFields('{{ $item->material_c }}', '{{ $item->material_n }}', '{{ $item->spec_size }}', '{{ $item->brand }}', '{{ $item->unit }}', event); $('#addModal').modal('hide');"
                                                            style="text-decoration: none; color: #0dcaf0;">
                                                            {{ $item->material_c }}
                                                        </a>
                                                    </td>
                                                    <td class="searchtable">{{ $item->material_n }}</td>
                                                    <td class="searchtable">{{ $item->spec_size }}</td>
                                                    <td>{{ $item->brand }}</td>
                                                    <td>{{ $item->unit }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Show Data -->
                <div class="modal fade" id="showDataModal" tabindex="-1" aria-labelledby="showDataModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="showDataModalLabel" style="font-size: 15px;">
                                    ประวัติการนำของเข้า</h4>
                                <button class="button" type="button" id="exportButton" aria-label="Export">
                                    <span class="button__text">Export visible data</span>
                                    <span class="button__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35"
                                            id="bdd05811-e15d-428c-bb53-8661459f9307" data-name="Layer 2"
                                            class="svg">
                                            <path
                                                d="M17.5,22.131a1.249,1.249,0,0,1-1.25-1.25V2.187a1.25,1.25,0,0,1,2.5,0V20.881A1.25,1.25,0,0,1,17.5,22.131Z">
                                            </path>
                                            <path
                                                d="M17.5,22.693a3.189,3.189,0,0,1-2.262-.936L8.487,15.006a1.249,1.249,0,0,1,1.767-1.767l6.751,6.751a.7.7,0,0,0,.99,0l6.751-6.751a1.25,1.25,0,0,1,1.768,1.767l-6.752,6.751A3.191,3.191,0,0,1,17.5,22.693Z">
                                            </path>
                                            <path
                                                d="M31.436,34.063H3.564A3.318,3.318,0,0,1,.25,30.749V22.011a1.25,1.25,0,0,1,2.5,0v8.738a.815.815,0,0,0,.814.814H31.436a.815.815,0,0,0,.814-.814V22.011a1.25,1.25,0,1,1,2.5,0v8.738A3.318,3.318,0,0,1,31.436,34.063Z">
                                            </path>
                                        </svg>
                                    </span>
                                </button>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-container">
                                    <table class="table" id="showDataTable">
                                        <thead>
                                            <tr>

                                                <!-- ค้นหา Refcode -->
                                                <th scope="background-color: skyblue;"
                                                    style="text-align: center; vertical-align: middle;">
                                                    Refcode
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text" id="searchRefcode1"
                                                            name="searchrefcode1"
                                                            style="width: 115px; height: 20px; padding: 5px; font-size: 10px;">
                                                    </div>
                                                </th>

                                                <!-- ค้นหา Droppoint -->
                                                <th scope="background-color: skyblue;"
                                                    style="text-align: center; vertical-align: middle;">
                                                    Droppoint
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text"
                                                            id="searchDroppoint" name="searchdroppoint"
                                                            style="width: 115px; height: 20px; padding: 5px; font-size: 10px;">
                                                    </div>
                                                </th>

                                                <!-- ค้นหา Material_code -->
                                                <th scope="background-color: skyblue;"
                                                    style="text-align: center; vertical-align: middle;">
                                                    Material_code
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text"
                                                            id="searchMaterial_code" name="searchmaterial_codet"
                                                            style="width: 115px; height: 20px; padding: 5px; font-size: 10px;">
                                                    </div>
                                                </th>

                                                <!-- ค้นหา Material_name -->
                                                <th scope="background-color: skyblue;"
                                                    style="text-align: center; vertical-align: middle;">
                                                    Material_name
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text"
                                                            id="searchMaterial_name" name="searchmaterial_name"
                                                            style="width: 115px; height: 20px; padding: 5px; font-size: 10px;">
                                                    </div>
                                                </th>

                                                <!-- ค้นหา Spec/Size -->
                                                <th scope="background-color: skyblue;"
                                                    style="text-align: center; vertical-align: middle;">
                                                    Spec/Size
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text"
                                                            id="searchSpec/Size" name="searchspec"
                                                            style="width: 115px; height: 20px; padding: 5px; font-size: 10px;">
                                                    </div>
                                                </th>

                                                <th scope="col" style="align-content: space-around;">Brand</th>
                                                <th scope="col" style="align-content: space-around;">Unit</th>
                                                <th scope="col" style="align-content: space-around;">Quantity</th>
                                                <th scope="col" style="align-content: space-around;">Remark</th>
                                                <th scope="col" style="align-content: space-around;">Date</th>
                                                <th scope="col" style="align-content: space-around;">Transaction ID</th>
                                                <th scope="col" style="align-content: space-around;">Import Quantity</th>
                                                <th scope="col" style="align-content: space-around;">Transaction Maker</th>
                                                <th scope="col" style="align-content: space-around;">Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($import_add as $item)
                                                <tr style="font-size: 10px; text-align:center">
                                                    

                                                    <td>{{ $item->refcode_import }}</td>
                                                    <td>{{ $item->droppoint_import }}</td>
                                                    <td>{{ $item->material_code_import }}</td>
                                                    <td>{{ $item->material_name_import }}</td>
                                                    <td>{{ $item->spec_size_import }}</td>
                                                    <td>{{ $item->brand }}</td>
                                                    <td>{{ $item->unit }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ $item->remark }}</td>
                                                    <td>{{ $item->date }}</td>
                                                    <td>{{ $item->transaction }}</td>
                                                    <td>{{ $item->import_quantity }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>
                                                        @if ($item->confirm == 0)
                                                            <span style="color: red;">&#9679;</span> <!-- Red dot -->
                                                        @elseif ($item->confirm == 1)
                                                            <span style="color: green;">&#9679;</span> <!-- Green dot -->
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
                            </div>
                        </div>
                    </div>
                </div>

                <form class="row g-3 justify-content-center my-2 text-center" autocomplete="off" method="POST"
                    action="/importadd">
                    @csrf

                    <div class="container">
                        <div class="Rddb"
                            style="display: flex;align-items: flex-end;justify-content: space-between;">

                            <!-- Left Section: Refcode, Date, Droppoint -->
                            <div class="col d-flex align-items-center gap-3">
                                <div class="col-md-3">
                                    <label for="refcode" class="form-label"
                                        style="justify-content: flex-start;  display: flex;">Refcode</label>
                                    <input type="text" name="refcodename[]" class="form-control" id="refcode"
                                        required>
                                </div>
                                <div class="col-md-2">
                                    <label for="date" class="form-label"
                                        style="justify-content: flex-start; display: flex;">Date</label>
                                    <input type="date" name="date[]" class="form-control" id="date"
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <label for="droppoint" class="form-label"
                                        style="justify-content: flex-start; display: flex;">Droppoint</label>
                                    <select name="droppoint[]" class="form-control" id="droppoint" required>
                                        <option value="" disabled selected>กรุณาเลือก Droppoint</option>
                                        @foreach ($droppoint as $item)
                                            <option value="{{ $item->droppoint }}">{{ $item->droppoint }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Right Section: Button -->
                            <div class="but">
                                <button type="button" class="cssbuttons-io" data-bs-toggle="modal"
                                    data-bs-target="#showDataModal">
                                    <span style="display:flex; justify-content: center; align-items: center; gap:5px;">
                                        <i class="fa-solid fa-timeline"></i>ประวัติการนำเข้า</span>
                                </button>
                            </div>

                        </div>

                        <hr>

                        <!-- ADD -->
                        <div class="row g-12">
                            <button type="button" id="addButton" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addModal"
                                style="display: none; margin: 10px; width: 60px; text-align: center; float: left;">
                                ADD
                            </button>
                        </div>

                        <!-- คอนเทนเนอร์แสดงข้อมูลที่เลือก -->
                        <div id="refcode-message"></div>
                        <!-- สร้างคอนเทนเนอร์ที่ครอบตาราง -->
                        <div style="max-height: 220px; overflow-y: auto;">
                            <table class="table table-bordered" id="selectedMaterialsTable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Material Code</th>
                                        <th scope="col">Material Name</th>
                                        <th scope="col">Spec/Size</th>
                                        <th scope="col">Brand</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Remark</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="rowsContainer">
                                    <!-- ข้อมูลที่เลือกจะถูกแสดงที่นี่ -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center my-1">
                        <input id="submitButton" class="btn btn-success" type="submit" value="Submit"
                            onclick="return Addsubmit();" style="display: block;">
                        <!-- แสดงปุ่ม -->
                    </div>

                    <script>
                        function Addsubmit() {
                            if (confirm("คุณต้องการเพิ่มของนำเข้าหรือไม่")) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    </script>

            </div>

            </form>

        </div>

        <script>
            function Addsubmit() {
                if (confirm("คุณต้องการอัพเดทหรือไม่")) {
                    return true;
                } else {
                    return false;
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const rowsContainer = document.getElementById('rowsContainer');
                const submitButton = document.querySelector('input[type="submit"]');

                if (rowsContainer.children.row === 0) {
                    submitButton.style.display = 'none'; // ซ่อนปุ่ม
                } else {
                    submitButton.style.display = 'block'; // แสดงปุ่ม
                }
            });
        </script>

        <!-- click link -->
        <script>
            function populateHiddenFields(materialCode, materialName, specSize, brand, unit, event) {
                event.preventDefault(); // ป้องกันการรีเฟรชหน้า

                // ค้นหาคอนเทนเนอร์ที่จะแสดงข้อมูลในตาราง
                const container = document.getElementById('rowsContainer');

                // นับจำนวนแถวปัจจุบันในตาราง
                const currentRowCount = container.getElementsByTagName('tr').length;

                // คำนวณลำดับแถวใหม่
                const newRowNumber = currentRowCount + 1;

                // สร้างแถวใหม่
                const newRow = document.createElement('tr');
                newRow.innerHTML =
                    `
        <td style="text-align: center; font-size: 9px; border: none;">${newRowNumber}</td>
        <td><input type="text" name="materialCode[]" class="form-control" style="text-align: center; font-size: 9px; border: none; background-color: transparent;" value="${materialCode}" readonly></td>
        <td><input type="text" name="materialName[]" class="form-control" style="text-align: center; font-size: 9px;border: none; background-color: transparent;" value="${materialName}" readonly></td>
        <td><input type="text" name="specSize[]" class="form-control" style="text-align: center; font-size: 9px; border: none; background-color: transparent;" value="${specSize}" readonly></td>
        <td><input type="text" name="brand[]" class="form-control" style="text-align: center;  font-size: 9px; border: none; background-color: transparent;" value="${brand}" readonly></td>
        <td><input type="text" name="unit[]" class="form-control" style="text-align: center;  font-size: 9px; border: none; background-color: transparent;" value="${unit}" readonly></td>
        <td><input type="number" name="Amout[]" required class="form-control" style="text-align: center; font-size: 9px;" step="1"></td>
        <td><input type="hidden" name="Remark[]" class="form-control" style="text-align: center; font-size: 9px; border: none; background-color: transparent;" ></td>
        <td><button type="button" class="btn btn-danger" onclick="removeRow(this)" style="font-size: 9px;">ลบ</button></td>`;
                // เพิ่มแถวใหม่ลงในคอนเทนเนอร์
                container.appendChild(newRow);
            }

            function removeRow(button) {
                const row = button.parentNode.parentNode; // ค้นหาแถวที่เกี่ยวข้อง
                const container = document.getElementById('rowsContainer'); // ค้นหา tbody

                // ลบแถวออกจากคอนเทนเนอร์
                container.removeChild(row);

                // ปรับลำดับหมายเลขใหม่
                const rows = container.getElementsByTagName('tr'); // ดึงทุกแถวที่เหลืออยู่
                Array.from(rows).forEach((row, index) => {
                    const firstCell = row.getElementsByTagName('td')[0]; // ค้นหาเซลล์แรก (No)
                    if (firstCell) {
                        firstCell.textContent = index + 1; // อัปเดตหมายเลขใหม่ (เริ่มต้นที่ 1)
                    }
                });
            }

            // ป้องกันการกรอกค่าติดลบในช่อง Amout[]
            document.addEventListener("input", function(event) {
                if (event.target.matches('input[name="Amout[]"]')) {
                    const inputElement = event.target;
                    if (parseFloat(inputElement.value) < 0) {
                        alert("ค่าที่กรอกห้ามติดลบ!");
                        inputElement.value = 0; // รีเซ็ตค่าเป็น 0
                        inputElement.focus(); // ตั้งโฟกัสกลับที่ช่องกรอก
                        inputElement.select(); // เลือกข้อความในช่องกรอก
                    }
                }
            });
        </script>

        <!-- jQuery (if not already included) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            let timeout;
            $(document).ready(function() {
                // ซ่อนปุ่ม Submit ตอนเริ่มต้น
                $('#submitButton').hide();
                $('#addButton').hide();

                // ตรวจสอบค่าที่พิมพ์ใน input #refcode
                $('#refcode').on('input', function() {
                    clearTimeout(timeout); // ลบ timeout เดิมก่อน
                    let refcode = $(this).val().trim(); // รับค่าที่ผู้ใช้พิมพ์และลบช่องว่าง

                    console.log('Input value:', refcode); // Debug: ดูค่าที่ผู้ใช้พิมพ์

                    timeout = setTimeout(function() {
                        if (refcode) {
                            // เรียก Ajax เพื่อตรวจสอบ refcode ในระบบ
                            $.ajax({
                                url: "{{ route('check.refcode') }}", // URL ที่ใช้ตรวจสอบ
                                method: "GET",
                                data: {
                                    refcode: refcode // ส่งค่า refcode ไปยัง server
                                },
                                success: function(response) {
                                    if (response.exists) {
                                        // หากพบ refcode
                                        $('#refcode-message').text("Description: " +
                                                response.description) // แสดงคำอธิบาย
                                            .css("color", "green") // ข้อความสีเขียว
                                            .show();
                                        $('#addButton').show(); // แสดงปุ่ม ADD
                                    } else {
                                        // หากไม่พบ refcode
                                        $('#refcode-message').text(
                                            "Refcode not found.") // แสดงข้อความว่าไม่พบ
                                            .css("color", "red") // ข้อความสีแดง
                                            .show();
                                        $('#addButton').hide(); // ซ่อนปุ่ม ADD
                                        $('#submitButton').hide(); // ซ่อนปุ่ม Submit
                                    }
                                }
                            });
                        } else {
                            // หาก input ว่างเปล่า
                            $('#refcode-message').text('').hide(); // ซ่อนข้อความแจ้งเตือน
                            $('#addButton').hide(); // ซ่อนปุ่ม ADD
                            $('#submitButton').hide(); // ซ่อนปุ่ม Submit
                        }
                    }, 300); // ตั้งเวลา delay (ms) สำหรับการตรวจสอบ
                });

                // สร้าง MutationObserver เพื่อตรวจสอบการเปลี่ยนแปลงใน #rowsContainer
                const rowsObserver = new MutationObserver(function(mutationsList, observer) {
                    // ตรวจสอบว่ามี <tr> ภายใน <tbody> หรือไม่
                    if ($('#rowsContainer tr').length > 0) {
                        $('#submitButton').show(); // แสดงปุ่ม Submit
                    } else {
                        $('#submitButton').hide(); // ซ่อนปุ่ม Submit หากไม่มี <tr>
                    }
                });

                // เริ่มการเฝ้าดูการเปลี่ยนแปลงใน #rowsContainer
                rowsObserver.observe(document.getElementById('rowsContainer'), {
                    childList: true, // เฝ้าดูการเปลี่ยนแปลงของลูก (child nodes)
                });
            });
        </script>


        <script>
            window.onload = function() {
                const sidebar = document.querySelector(".sidebar");
                const closeBtn = document.querySelector("#btn");

                closeBtn.addEventListener("click", function() {
                    sidebar.classList.toggle("open");
                });
            }
        </script>

        <!-- ซ่อน ประวัติการนำเข้า -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.querySelector('.sidebar'); // เลือก sidebar
                const showDataModal = document.getElementById('showDataModal'); // เลือก showDataModal

                // ซ่อน sidebar เมื่อ showDataModal เปิด
                showDataModal.addEventListener('show.bs.modal', function() {
                    if (sidebar) {
                        sidebar.classList.add('d-none'); // เพิ่มคลาสซ่อน
                    }
                });

                // แสดง sidebar เมื่อ showDataModal ปิด
                showDataModal.addEventListener('hidden.bs.modal', function() {
                    if (sidebar) {
                        sidebar.classList.remove('d-none'); // เอาคลาสซ่อนออก
                    }
                });
            });
        </script>


        <script>
            // ฟังก์ชันส่งออก export
            document.getElementById('exportButton').addEventListener('click', function() {
                var wb = XLSX.utils.book_new();
                var ws = XLSX.utils.table_to_sheet(document.getElementById('showDataTable'));
                XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                XLSX.writeFile(wb, 'importItem_data.xlsx');
            });
        </script>

        <!-- ไลบรารี XLSX.js สำหรับ "Export -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>



        <!-- ฟังชั่นกรองข้อมูลหน้าประวัติการนำของเข้า -->
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                // กำหนดตัวกรอง
                const searchInputs = {
                    refcode: document.getElementById('searchRefcode1'),
                    droppoint: document.getElementById('searchDroppoint'),
                    materialCode: document.getElementById('searchMaterial_code'),
                    materialName: document.getElementById('searchMaterial_name'),
                    spec: document.getElementById('searchSpec/Size'),
                };

                const table = document.getElementById('showDataTable');
                const rows = table.querySelectorAll('tbody tr');

                // ฟังก์ชันกรองข้อมูล
                function filterTable() {
                    const filters = {
                        refcode: searchInputs.refcode.value.toLowerCase().trim(),
                        droppoint: searchInputs.droppoint.value.toLowerCase().trim(),
                        materialCode: searchInputs.materialCode.value.toLowerCase().trim(),
                        materialName: searchInputs.materialName.value.toLowerCase().trim(),
                        spec: searchInputs.spec.value.toLowerCase().trim(),
                    };

                    rows.forEach(row => {
                        const refcode = row.cells[0]?.textContent.toLowerCase().trim() || '';
                        const droppoint = row.cells[1]?.textContent.toLowerCase().trim() || '';
                        const materialCode = row.cells[2]?.textContent.toLowerCase().trim() || '';
                        const materialName = row.cells[3]?.textContent.toLowerCase().trim() || '';
                        const spec = row.cells[4]?.textContent.toLowerCase().trim() || '';

                        // เช็คเงื่อนไขการกรอง
                        const matches =
                            refcode.includes(filters.refcode) &&
                            droppoint.includes(filters.droppoint) &&
                            materialCode.includes(filters.materialCode) &&
                            materialName.includes(filters.materialName) &&
                            spec.includes(filters.spec);

                        // ซ่อนหรือแสดงแถวตามผลการกรอง
                        row.style.display = matches ? '' : 'none';
                    });
                }

                // ผูกฟังก์ชันกับ event 'input'
                Object.values(searchInputs).forEach(input => {
                    input.addEventListener('input', filterTable);
                });
            });
        </script>



        <!-- ฟังชั่นกรองข้อมูล Add Material -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const table = document.querySelector('#materialTable');
                const filterInputs = [
                    '#searchMaterialCode',
                    '#searchMaterialName',
                    '#searchSpec'
                ].map(selector => document.querySelector(selector));

                function filterTable() {
                    const rows = table.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        let isMatch = true;
                        filterInputs.forEach((input, index) => {
                            const filterValue = input.value.trim().toUpperCase();
                            const attributeName = ['data-material-code', 'data-material-name',
                                'data-spec'
                            ][index];
                            const cellValue = row.getAttribute(attributeName)?.toUpperCase() || '';
                            if (filterValue && !cellValue.includes(filterValue)) {
                                isMatch = false;
                            }
                        });
                        row.style.display = isMatch ? '' : 'none';
                    });
                }

                filterInputs.forEach(input => input?.addEventListener('keyup', filterTable));
            });
        </script>

</body>

</html>
