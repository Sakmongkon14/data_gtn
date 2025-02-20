@extends('layouts.app')
@section('title', 'ค้นหา Refcode')
@section('content')


    <h2 class="text text-center mt-2">Search Refcode</h2>
    

    <div class="container mt-4">
        <form action="importrefcode" method="POST" enctype="multipart/form-data" id="csvForm"
            class="d-flex align-items-center gap-2" style="flex-wrap: nowrap; justify-content: center;">
            @csrf
            <input type="file" class="form-control" name="csv_file_add" accept=".csv" required
                style="width: 300px; height: 29px; font-size: 10px;">
            <input type="submit" class="btn btn-primary" name="preview_add" value="แสดงข้อมูล Refcode ที่ต้องการเพิ่ม"
                data-bs-toggle="modal" data-bs-target="#exampleModal"style="font-size: 10px;">
        </form>
    </div>

    <!-- แสดงข้อความสำเร็จ -->
    @if (session('success'))
        <div class="alert alert-success style=margin: 20px; mt-2">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->has('error'))
        <div class="alert alert-danger style=margin: 20px; mt-2">
            {{ $errors->first('error') }}
        </div>
    @endif



    <!-- import -->

    @if (!empty($dataToSave) && (is_array($dataToSave) || is_object($dataToSave)))
        <div class="modal fade show d-block" id="refcodeModal" tabindex="-1" role="dialog"
            aria-labelledby="refcodeModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content" style="max-height: 650px; overflow-y: auto;">
                    <div class="modal-header">
                        <h2 class="modal-title" id="refcodeModalLabel" style="font-size: 25px;">ตรวจสอบข้อมูล Refcode</h2>
                        <a href="home" class="btn-close" aria-label="Close"></a>
                    </div>
                    <div class="modal-body">
                        <div class="table-container" style="max-height: 450px; overflow-y: auto;">
                            <table class="table table-bordered" id="modalTable" style="width: 100%; table-layout: fixed;">
                                <thead style="position: sticky; top: 0; background-color: #fff; z-index: 1;">
                                    <tr>
                                        <th scope="col" style="width: 150px">Refcode</th>
                                        <th scope="col" style="width: 300px">Description</th>
                                        <th scope="col" style="width: 100px">Office</th>
                                        <th scope="col" style="width: 300px">Project</th>
                                        <th scope="col" style="width: 200px">Check Refcode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataToSave as $row)
                                        <tr>
                                            @foreach ($row as $key => $cell)
                                                <td>{{ $cell }}</td>
                                            @endforeach
                                            <td>
                                                @php
                                                    $check = false;
                                                    foreach ($refcode as $item) {
                                                        if ($item->refcode === $row['refcode']) {
                                                            $check = true;
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                @if ($check)
                                                    <span style="color: red;">refcode ซ้ำกัน</span>
                                                @else
                                                    <span style="color: green;">สามารถ Upload refcode ได้</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="saverefcode" method="POST">
                            @csrf
                            <input type="hidden" name="data_add" value="{{ json_encode($dataToSave) }}">
                            <button type="submit" class="btn btn-success">เพิ่มข้อมูล</button>
                        </form>
                        <a href="home" class="btn btn-danger">ย้อนกลับ</a>
                    </div>
                </div>
            </div>
        </div>

    @endif

    <div class="table-container mt-2" style="height: 510px; overflow-y: auto;">
        <table class="table mt-2" style="width: 100%;">
            <thead style="position: sticky; top: 0; background-color: white;">
                <tr style="font-size: 14px; text-align:center;">
                    <th scope="col" style="background-color: #e6f7ff;">Refcode</th>
                    <th scope="col" style="background-color: #e6f7ff;">SiteCode
                        <input class="input-style" type="text" id="searchMaterial_name" name="searchmaterial_name"
                            style="width: 250px; height: 25px; padding: 5px; font-size: 11px;">
                    </th>
                    <th scope="col" style="background-color: #e6f7ff;">Office</th>
                    <th scope="col" style="background-color: #e6f7ff;">Project</th>
                </tr>

            </thead>

            <tbody style="font-size: 10px; text-align:center; background-color: white;">
                @foreach ($refcode as $item)
                    <tr>
                        <td>{{ $item->refcode }}</td>
                        <td class="sitecode">{{ $item->sitecode }}</td>
                        <td>{{ $item->office }}</td>
                        <td>{{ $item->project }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchMaterial_name').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                $('tbody tr').each(function() {
                    var sitecode = $(this).find('.sitecode').text().toLowerCase();
                    if (sitecode.indexOf(searchTerm) > -1) {
                        $(this).show(); // แสดงแถวที่ตรงกับคำค้นหา
                    } else {
                        $(this).hide(); // ซ่อนแถวที่ไม่ตรงกับคำค้นหา
                    }
                });
            });
        });
    </script>




@endsection
