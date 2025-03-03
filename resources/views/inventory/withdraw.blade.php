<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>เบิกของ</title>
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

    .hidden-input {
        display: none;
    }

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
        z-index: 1000;
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

    .navbar.shifted {
        margin-left: 0px;
        /* Navbar ขยับตามความกว้างของ Sidebar */
    }

    .content.shifted {
        margin-left: 0px;
        /* Content ขยับตามความกว้างของ Sidebar */
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


    /* ปุ่มเบิกของ */
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

    /* Button ShowData */
    button.Data {
        font-size: 14px;
        display: inline-block;
        outline: 0;
        border: 0;
        cursor: pointer;
        will-change: box-shadow, transform;
        background: radial-gradient(100% 100% at 100% 0%, #89e5ff 0%, #5468ff 100%);
        box-shadow: 0px 0.01em 0.01em rgb(45 35 66 / 40%), 0px 0.3em 0.7em -0.01em rgb(45 35 66 / 30%), inset 0px -0.01em 0px rgb(58 65 111 / 50%);
        padding: 0 2em;
        border-radius: 0.3em;
        color: #fff;
        height: 2.6em;
        text-shadow: 0 1px 0 rgb(0 0 0 / 40%);
        transition: box-shadow 0.15s ease, transform 0.15s ease;
    }

    button.Data:hover {
        box-shadow: 0px 0.1em 0.2em rgb(45 35 66 / 40%), 0px 0.4em 0.7em -0.1em rgb(45 35 66 / 30%), inset 0px -0.1em 0px #3c4fe0;
        transform: translateY(-0.1em);
    }

    button.Data:active {
        box-shadow: inset 0px 0.1em 0.6em #3c4fe0;
        transform: translateY(0em);
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
        max-height: 590px;
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




    .AD {
        display: flex;
        gap: 1rem;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        align-items: baseline;
        padding: 20px;

    }

    /* input */
    .input-style {
        padding: 10px;
        border: 2px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        color: #555;
        outline: none;
    }

    .input-style:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

            <div class="container ">

                <!-- Modal Add เบิกของ -->
                <div class="modal" id="myModal1">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">เบิกของ</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="table-container" style="height: 489px;">
                                    <table class="table" id="table">
                                        <thead style="font-size: 12px; text-align:center; text-decoration: none; ">
                                            <tr>
                                                <th scope="background-color: skyblue;"
                                                    style="text-align: center; vertical-align: middle;">
                                                    Material_Name
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text"
                                                            id="searchMaterialName" name="searchMaterialName"
                                                            style="width: 100px; height: 20px; padding: 5px; font-size: 10px;">
                                                    </div>
                                                </th>

                                                <th scope="background-color: skyblue;"
                                                    style="text-align: center; vertical-align: middle;">
                                                    Material_Code
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text"
                                                            id="searchMaterialCode" name="searchMaterialCode"
                                                            style="width: 100px; height: 20px; padding: 5px; font-size: 10px;">
                                                    </div>
                                                </th>

                                                <th scope="background-color: skyblue;"
                                                    style="text-align: center; vertical-align: middle;">
                                                    Spec
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text" id="searchSpec"
                                                            name="searchSpec"
                                                            style="width: 100px; height: 20px; padding: 5px; font-size: 10px;">
                                                    </div>
                                                </th>



                                                <th scope="col">Unit</th>
                                                <th scope="col">Droppoint</th>
                                                <th scope="col">Refcode</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Available</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($summary as $item)
                                                <tr style="font-size: 10px; text-align:center">

                                                    <td>
                                                        <a href="#"
                                                            data-material-name="{{ $item->material_name }}"
                                                            style="text-decoration: none; color: #3cb704;"
                                                            data-material-code="{{ $item->material_code }}"
                                                            data-spec-size="{{ $item->spec }}"
                                                            data-unit="{{ $item->unit }}"
                                                            data-available="{{ $item->available }}"
                                                            data-refcode="{{ $item->refcode }}"
                                                            data-description="{{ $item->description }}"
                                                            data-droppoint="{{ $item->droppoint }}"
                                                            onclick="populateHiddenFieldsFromData(this); $('#myModal1').modal('hide');">
                                                            {{ $item->material_name }}
                                                        </a>
                                                    </td>

                                                    <td>{{ $item->material_code }}</td>
                                                    <td>{{ $item->spec }}</td>
                                                    <td>{{ $item->unit }}</td>

                                                    @foreach ($droppoint as $no)
                                                        @if ($item->droppoint == $no->id)
                                                            <td>{{ $no->droppoint }}</td>
                                                        @endif
                                                    @endforeach

                                                    <td>{{ $item->droppoint }}</td>
                                                    <td>{{ $item->refcode }}</td>
                                                    <td>{{ $item->description }}</td>
                                                    <td>{{ $item->available }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                            <!-- Modal footer -->
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
                                    ประวัติการเบิกของ</h4>
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
                                                    From
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text" id="searchRefcode1"
                                                            name="searchRefcode1"
                                                            style="width: 115px; height: 20px; padding: 5px; font-size: 10px;">
                                                    </div>
                                                </th>

                                                <!-- ค้นหา Refcode_withdraw -->
                                                <th scope="background-color: skyblue;"
                                                    style="text-align: center; vertical-align: middle;">
                                                    To
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text" id="searchRefcode2"
                                                            name="searchRefcode2"
                                                            style="width: 115px; height: 20px; padding: 5px; font-size: 10px;">
                                                    </div>
                                                </th>

                                                <!-- ค้นหา Material Code -->
                                                <th scope="background-color: skyblue;"
                                                    style="text-align: center; vertical-align: middle;">
                                                    Material Code
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text"
                                                            id="searchmaterialcode" name="searchmaterialcode"
                                                            style="width: 115px; height: 20px; padding: 5px; font-size: 10px;">
                                                    </div>
                                                </th>

                                                <!-- ค้นหา Material Name -->
                                                <th scope="background-color: skyblue;"
                                                    style="text-align: center; vertical-align: middle;">
                                                    Material Name
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text"
                                                            id="searchmaterialname" name="searchmaterialname"
                                                            style="width: 115px; height: 20px; padding: 5px; font-size: 10px;">
                                                    </div>
                                                </th>

                                                <!-- ค้นหา Spec -->
                                                <th scope="background-color: skyblue;"
                                                    style="text-align: center; vertical-align: middle;">
                                                    Spec
                                                    <div
                                                        style="display: flex; justify-content: center; align-items: center; margin-top: 5px;">
                                                        <input class="input-style" type="text" id="searchspec"
                                                            name="searchspec"
                                                            style="width: 115px; height: 20px; padding: 5px; font-size: 10px;">
                                                    </div>
                                                </th>

                                                <th scope="col" style="align-content: space-around;">Unit</th>
                                                <th scope="col" style="align-content: space-around;">Droppoint</th>
                                                <th scope="col" style="align-content: space-around;">Date</th>
                                                <th scope="col" style="align-content: space-around;">Transaction_ID
                                                </th>
                                                <th scope="col" style="align-content: space-around;">Withdraw</th>
                                                <th scope="col" style="align-content: space-around;">Remark</th>
                                                <th scope="col" style="align-content: space-around;">Transaction
                                                    Maker</th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($withdraw as $item)
                                                <tr style="font-size: 10px; text-align:center">

                                                    


                                                    <td>{{ $item->refcode_with }}</td>
                                                    <td>{{ $item->refcode_before }}</td>

                                                    <td>{{ $item->material_code }}</td>
                                                    <td>{{ $item->material_name }}</td>
                                                    <td>{{ $item->spec }}</td>
                                                    <td>{{ $item->unit }}</td>

                                                    <td>{{ $item->droppoint }}</td>

                                                    <td>{{ $item->date }}</td>
                                                    <td>{{ $item->transaction_id }}</td>
                                                    <td>{{ $item->quantity_with }}</td>
                                                    <td>{{ $item->remark }}</td>
                                                    <td>{{ $item->name }}</td>

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


                <form class="WA" autocomplete="off" method="POST" action="/withdrawAdd">
                    @csrf


                    <div class="container">
                        <div class="Refdate"
                            style=" width: 101%; display: flex; align-items: flex-end; justify-content: space-between;">
                            <div class="d-flex flex-wrap gap-3 align-items-center"
                                style="margin-left: -10px; margin-block-start: 8px;">
                                <!-- Refcode -->

                                <div class="col-md-3" style="width: 170px;">
                                    <label for="refcode" class="form-label"
                                        style="justify-content: flex-start;  display: flex;">Refcode</label>
                                    <input type="text" name="refcodename[]" class="form-control" id="refcode"
                                        placeholder=" " required>
                                </div>

                                <!-- Date -->
                                <div>
                                    <label for="date" class="form-label"
                                        style="text-align: left; justify-content: flex-start;  display: flex;">Date</label>
                                    <input type="date" name="date[]" class="form-control" id="date"
                                        required>
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="bt">
                                <button type="button" class="cssbuttons-io" data-bs-toggle="modal"
                                    data-bs-target="#showDataModal" id="showDataButton">
                                    <span style="display:flex; justify-content: center; align-items: center; gap:5px;">
                                        <i class="fa-solid fa-timeline"></i>ประวัติการเบิกของ</span>
                                </button>
                            </div>
                        </div>
                    </div>


                    <hr>

                    <div class="ba" style="display:flex">
                        <button type="button" id="addButton" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#myModal1"
                            style="display: none; width: 70px; text-align: center; float: left;">
                            ADD
                        </button>
                    </div>

                    <!-- คอนเทนเนอร์แสดงข้อมูลที่เลือก -->
                    <div id="refcode-message" style="display: none;" class="text-center"></div>

                    <div class="nametable"><span style="display:flex; justify-content: center; gap:5px; ">เบิกของ<i
                                class="fa-solid fa-hand-holding-heart"></i></span></div>

                    <div style="margin-top: 0px; max-height: 375px; overflow-y: auto;">
                        <table class="table table-bordered">
                            <thead style="position: sticky; top: 0; background-color: white; z-index: 1;">
                                <tr>
                                    <th style="width: 200px">Refcode_Withdraw</th>
                                    <th style="width: 200px">Material Code</th>
                                    <th style="width: 220px">Material Name</th>
                                    <th style="width: 120px">Unit</th>
                                    <th style="width: 200px">Spec</th>
                                    <th style="width: 200px">Droppoint</th>
                                    <th style="width: 200px">Available</th>
                                    <th style="width: 100px">Withdraw</th>
                                    <th style="width: 100px"></th>
                                </tr>
                            </thead>
                            <tbody id="refcode-table-body">
                                <!-- Rows will be dynamically added here -->
                            </tbody>
                        </table>

                    </div>

                    <div class="d-flex justify-content-center">
                        <input class="btn btn-success" type="submit" value="Submit" id="submit-button-container"
                            onclick="confirmSubmission(event)" style="display: none;">
                    </div>

                    <script>
                        function confirmSubmission(event) {
                            // แสดงกล่องยืนยัน
                            var userConfirmed = confirm("คุณต้องการส่งข้อมูลนี้หรือไม่?");
                            // ถ้าผู้ใช้กดยืนยัน ให้ส่งฟอร์ม และคืนค่า true
                            if (userConfirmed) {
                                return true;
                            } else {
                                // ถ้าผู้ใช้กดยกเลิก ยกเลิกการส่งข้อมูล และคืนค่า false
                                event.preventDefault();
                                return false;
                            }
                        }
                    </script>

            </div>

            </form>

            <script>
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

            <script>
                const droppoints = @json($droppoint); // ส่ง `$droppoint` ไปในรูป JSON
            </script>


            <!-- click link -->
            <script>
                function populateHiddenFieldsFromData(link) {
                    const materialName = link.getAttribute('data-material-name');
                    const materialCode = link.getAttribute('data-material-code');
                    const specSize = link.getAttribute('data-spec-size');
                    const unit = link.getAttribute('data-unit');
                    const quantity = link.getAttribute('data-available');
                    const refcode = link.getAttribute('data-refcode');
                    const description = link.getAttribute('data-description');
                    const droppointId = link.getAttribute('data-droppoint'); // รับค่า ID ของ droppoint

                    // หา droppoint ที่ตรงกับ ID
                    const droppoint = droppoints.find(dp => dp.id == droppointId);

                    // สร้างแถวใหม่ในตาราง
                    const container = document.getElementById('refcode-table-body'); // ตารางที่จะแสดงแถวใหม่

                    const newRow = document.createElement('tr'); // ใช้ <tr> แทน <div>

                    newRow.innerHTML = `
        <td><input type="text" name="refcode_import[]" class="form-control" style="text-align: center; font-size: 9px; border: none; background-color: transparent;" value="${refcode}" ></td>
        <td><input type="text" name="material_code_import[]" class="form-control" style="text-align: center; font-size: 9px; border: none; background-color: transparent;" value="${materialCode}" ></td>
        <td><input type="text" name="material_name_import[]" class="form-control" style="text-align: center; font-size: 9px; border: none; background-color: transparent;" value="${materialName}" ></td>
        <td><input type="text" name="unit[]" class="form-control" style="text-align: center; border: none; font-size: 9px; background-color: transparent;" value="${unit}" ></td>
        <td><input type="text" name="specSize[]" class="form-control" style="text-align: center; border: none; font-size: 9px; background-color: transparent;" value="${specSize}" ></td>
        <input type="text" name="droppoint[]" class="form-control" style="text-align: center; border: none; font-size: 9px; background-color: transparent;" value="${droppointId}" >      
        <td><input type="text" name="available[]" class="form-control" style="text-align: center; border: none; font-size: 9px; background-color: transparent;" value="${quantity}" ></td>
        <td><input type="number" name="Amout[]" class="form-control" style="text-align: center; font-size: 9px; " step="1" ></td>
        <td><button type="button" class="btn btn-danger" onclick="removeRow(this)" style="text-align: center; font-size: 9px; " >ลบ</button></td>

                 
<!-- comment

        <td><input type="text" name="material_code_import[]" class="form-control" style="text-align: center; font-size: 9px;  border: none; background-color: transparent;" value="${materialCode}" readonly></td>
        <td><input type="text" name="spec_size_import[]" class="form-control" style="text-align: center; border: none; background-color: transparent;" value="${specSize}" readonly></td>
        <td><input type="text" name="quantity[]" class="form-control" style="text-align: center; border: none; background-color: transparent;" value="${quantity}" readonly></td>
        <td><input type="text" name="description[]" class="form-control" style="text-align: center; border: none; background-color: transparent;" value="${description}" readonly></td>
        <td><button type="button" class="btn btn-danger" onclick="removeRow(this)" >ลบ</button></td>
-->

    `;

                    // เพิ่มแถวใหม่ในตาราง
                    container.appendChild(newRow);
                }

                function removeRow(button) {
                    // ลบแถวที่คลิกจากตาราง
                    const row = button.closest('tr');
                    if (row) {
                        row.remove();
                    }
                }
            </script>


            <script></script>


            <!-- jQuery (if not already included) -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
                let timeout;
                $(document).ready(function() {
                    $('#refcode').on('input', function() {
                        clearTimeout(timeout); // Clear the previous timeout

                        let refcode = $(this).val().trim();
                        console.log('Input value:', refcode); // Debugging line

                        timeout = setTimeout(function() {
                            if (refcode) {
                                $.ajax({
                                    url: "{{ route('check.import') }}",
                                    method: "GET",
                                    data: {
                                        refcode: refcode
                                    },
                                    success: function(response) {
                                        console.log('Response:', response); // Debugging log

                                        if (response.exists) {
                                            // แสดงข้อความและตั้งค่าข้อมูลที่ถูกต้อง
                                            $('#refcode-message')
                                                .text("ของที่สามารถเบิกได้: " + response
                                                    .description)
                                                .css("color", "green")
                                                .show();

                                            // ล้างตารางและเติมข้อมูลใหม่
                                            $('#refcode-table-body').empty().show();

                                            response.imports.forEach(function(importData) {
                                                // ค้นหา droppoint ที่ตรงกับ importData.droppoint
                                                matchedDroppoint = droppoints.find(dp =>
                                                    dp.id == importData.droppoint);
                                                let row = `
                                                <tr>
                                                    <td><input type="text" name="refcode_import[]" class="form-control" style="text-align: center; font-size:9px; border: none; background-color: transparent;" value="${importData.refcode}" readonly></td>
                                                    <td><input type="text" name="material_code_import[]" class="form-control" style="text-align: center; font-size:9px; border: none; background-color: transparent;" value="${importData.material_code}" readonly></td>
                                                    <td><input type="text" name="material_name_import[]" class="form-control" style="text-align: center; font-size:9px; border: none; background-color: transparent;" value="${importData.material_name}" readonly></td>
                                                    <td><input type="text" name="unit[]" class="form-control" style="text-align: center; border: none; font-size:9px; background-color: transparent;" value="${importData.unit}" readonly></td>
                                                    <td><input type="text" name="specSize[]" class="form-control" style="text-align: center; border: none; font-size:9px; background-color: transparent;" value="${importData.spec}" readonly></td>
                                                    <td>
                                                        <input type="text" name="droppoint[]" class="form-control" style="text-align: center; border: none; font-size:9px; background-color: transparent;" 
                                                        value="${importData.droppoint}" readonly>
                                                    </td>   
                                                    
                                                    <td><input type="text" name="available[]" class="form-control" style="text-align: center; border: none; font-size:9px; background-color: transparent;" value="${importData.available}" readonly></td>
                                                    <td><input type="number" name="Amout[]" class="form-control" required style="font-size: 9px; text-align: center;" step="1"></td>
                                                    <td><button type="button" class="btn btn-danger" style="font-size:9px;" onclick="removeRow(this)">ลบ</button></td>
                                                </tr>
                                            `;
                                                $('#refcode-table-body').append(row);
                                            });

                                            // แสดงปุ่มและส่วนที่เกี่ยวข้อง
                                            $('#addButton').show();
                                            $('#submit-button-container').show();
                                        } else {
                                            // ซ่อนข้อความและส่วนต่างๆ เมื่อไม่พบ Refcode
                                            $('#refcode-message')
                                                .text("ไม่พบ Refcode.")
                                                .css("color", "red")
                                                .show();

                                            $('#refcode-table-body').empty()
                                                .hide(); // ซ่อนแถวในตาราง
                                            $('#addButton').hide();
                                            $('#submit-button-container').hide();
                                        }
                                    },
                                    error: function(error) {
                                        console.error('Error:',
                                            error); // Debugging log สำหรับกรณี error
                                    }
                                });
                            } else {
                                // เมื่อ Refcode ว่างเปล่า
                                $('#refcode-message').text('').hide(); // ล้างข้อความ
                                $('#refcode-table-body').empty().hide(); // ซ่อนตาราง
                                $('#addButton').hide(); // ซ่อนปุ่ม ADD
                                $('#submit-button-container').hide(); // ซ่อนปุ่ม Submit
                            }
                        }, 300); // Delay time
                    });
                });

                function removeRow(button) {
                    // ลบแถวที่คลิกจากตาราง
                    const row = button.closest('tr');
                    if (row) {
                        row.remove();
                    }
                }
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const sidebar = document.querySelector('.sidebar'); // เลือก sidebar
                    const modal = document.getElementById('myModal'); // เลือก modal

                    // ซ่อน sidebar เมื่อ modal เปิด
                    modal.addEventListener('show.bs.modal', function() {
                        if (sidebar) {
                            sidebar.classList.add('d-none'); // เพิ่มคลาสซ่อน
                        }
                    });

                    // แสดง sidebar เมื่อ modal ปิด
                    modal.addEventListener('hidden.bs.modal', function() {
                        if (sidebar) {
                            sidebar.classList.remove('d-none'); // เอาคลาสซ่อนออก
                        }
                    });
                });
            </script>

            <!-- ตรวจสอบค่าที่กรอกใน Amout[] ห้ามเกิน Available[] ที่มีอยู่ และดักการติดลบค่าที่กรอก -->
            <script>
                // ตรวจสอบค่าที่กรอกใน Amout[]
                document.addEventListener("input", function(event) {
                  if (event.target.matches('input[name="Amout[]"]')) {
                    const inputElement = event.target; // ช่องกรอก Amout[]
                    const row = inputElement.closest("tr"); // แถวที่ช่องกรอกอยู่
                    const available = parseFloat(row.querySelector('input[name="available[]"]').value); // ค่า available[]
                    const amount = parseFloat(inputElement.value); // ค่าที่ผู้ใช้กรอก
              
                    if (amount > available) {
                      alert("ค่าที่กรอกห้ามเกิน available!");
                      inputElement.value = available; // รีเซ็ตค่ากลับเป็น available
                      inputElement.focus(); // ตั้งโฟกัสกลับไปที่ช่องกรอก
                      inputElement.select(); // เลือกข้อความทั้งหมดในช่อง
                    } else if (amount < 0) {
                      alert("ค่าที่กรอกห้ามติดลบ!");
                      inputElement.value = 0; // รีเซ็ตค่ากลับเป็น 0
                      inputElement.focus(); // ตั้งโฟกัสกลับไปที่ช่องกรอก
                      inputElement.select(); // เลือกข้อความทั้งหมดในช่อง
                    }
                  }
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

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const showDataButton = document.getElementById('showDataButton');
                    const modalElement = new bootstrap.Modal(document.getElementById(
                        'myModal')); // Bootstrap Modal instance

                    showDataButton.addEventListener('click', function() {
                        modalElement.show(); // แสดง Modal เมื่อคลิกปุ่ม
                    });
                });
            </script>

            <!-- ซ่อน ประวัติการเบิกของ -->
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
                    XLSX.writeFile(wb, 'withdraw_data.xlsx');
                });
            </script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>


            <!-- ฟังชั่นกรองข้อมูลหน้าประวัติการเบิกของ -->
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const searchInputs = {
                        refcode: document.getElementById('searchRefcode1'),
                        refcodeWithdraw: document.getElementById('searchRefcode2'),
                        materialCode: document.getElementById('searchmaterialcode'),
                        materialName: document.getElementById('searchmaterialname'),
                        spec: document.getElementById('searchspec'),
                    };

                    const table = document.getElementById('showDataTable');
                    const rows = table.querySelectorAll('tbody tr');

                    function filterTable() {
                        const filters = {
                            refcode: searchInputs.refcode.value.toLowerCase(),
                            refcodeWithdraw: searchInputs.refcodeWithdraw.value.toLowerCase(),
                            materialCode: searchInputs.materialCode.value.toLowerCase(),
                            materialName: searchInputs.materialName.value.toLowerCase(),
                            spec: searchInputs.spec.value.toLowerCase(),
                        };

                        rows.forEach(row => {
                            const refcode = row.cells[0].textContent.toLowerCase();
                            const refcodeWithdraw = row.cells[1].textContent.toLowerCase();
                            const materialCode = row.cells[2].textContent.toLowerCase();
                            const materialName = row.cells[3].textContent.toLowerCase();
                            const spec = row.cells[4].textContent.toLowerCase();

                            const matches =
                                refcode.includes(filters.refcode) &&
                                refcodeWithdraw.includes(filters.refcodeWithdraw) &&
                                materialCode.includes(filters.materialCode) &&
                                materialName.includes(filters.materialName) &&
                                spec.includes(filters.spec);

                            row.style.display = matches ? '' : 'none';
                        });
                    }

                    Object.values(searchInputs).forEach(input => {
                        input.addEventListener('input', filterTable);
                    });
                });
            </script>







            <!-- ฟังชั่นกรองข้อมูล Add เบิกของ -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const table = document.querySelector('#table'); // อ้างถึงตารางที่มี ID เป็น "table"
                    const filterInputs = [
                        '#searchMaterialName', // ช่องค้นหา Material Name
                        '#searchMaterialCode', // ช่องค้นหา Material Code
                        '#searchSpec', // ช่องค้นหา Spec/Size
                    ].map(selector => document.querySelector(selector)); // อ้างถึง input ทั้งหมด

                    function filterTable() {
                        const rows = table.querySelectorAll('tbody tr');
                        rows.forEach(row => {
                            let isMatch = true; // ใช้ตรวจสอบว่าข้อมูลตรงหรือไม่
                            filterInputs.forEach((input, index) => {
                                const filterValue = input.value.trim().toUpperCase(); // ค่าที่ผู้ใช้กรอก
                                const cellValue = row.cells[index]?.textContent.trim().toUpperCase() ||
                                    ''; // ค่าจากเซลล์
                                if (filterValue && !cellValue.includes(filterValue)) {
                                    isMatch = false;
                                }
                            });
                            row.style.display = isMatch ? '' : 'none'; // ซ่อนหรือแสดงแถว
                        });
                    }

                    filterInputs.forEach(input => input?.addEventListener('keyup', filterTable)); // ดักจับ keyup
                });
            </script>


</body>

</html>
