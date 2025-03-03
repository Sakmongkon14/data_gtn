@extends('layouts.app')
@section('title', 'ImportRefcode')
@section('content')

    @if (!empty($dataToSave) && (is_array($dataToSave) || is_object($dataToSave)))
        <!-- Modal -->
        <div class="modal fade show d-block" id="refcodeModal" tabindex="-1" role="dialog" aria-labelledby="refcodeModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="refcodeModalLabel">ตรวจสอบข้อมูล Refcode ที่ import</h5>
                        <a href="blog" class="btn-close" aria-label="Close"></a>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                            <table class="table table-bordered table-sm">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>Refcode</th>
                                      <!--  
                                        <th>OwnerOldSte</th>
                                      -->
                                        <th>SiteCode</th>
                                    <!--
                                        <th>SiteNAME_T</th>
                                        <th>PlanType</th>
                                        <th>Region_id</th>
                                        <th>Province</th>
                                        <th>SiteType</th>
                                        <th>TowerNewSite</th>
                                        <th>Towerheight</th>
                                        <th>Tower</th>
                                        <th>Zone</th>
                                      -->
                                        <th>Check Refcode</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($dataToSave as $row)
                                        <tr class="text-nowrap">
                                            <td>{{ $row['RefCode'] }}</td>
                                        <!--    
                                            <td>{{ $row['OwnerOldSte'] }}</td>
                                        -->
                                        
                                            <td>{{ $row['SiteCode'] }}</td>
                                        <!--   
                                            <td>{{ $row['SiteNAME_T'] }}</td>
                                            <td>{{ $row['PlanType'] }}</td>
                                            <td>{{ $row['Region_id'] }}</td>
                                            <td>{{ $row['Province'] }}</td>
                                            <td>{{ $row['SiteType'] }}</td>
                                            <td>{{ $row['TowerNewSite'] }}</td>
                                            <td>{{ $row['Towerheight'] }}</td>
                                            <td>{{ $row['Tower'] }}</td>
                                            <td>{{ $row['Zone'] }}</td>
                                        -->
                                            <td>
                                                @if ($row['exists_in_db'])
                                                    <span class="badge bg-danger">ไม่สามารถอัพโหลดได้</span>
                                                @else
                                                    <span class="badge bg-success">สามารถอัพโหลดได้</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="/saveImport" method="POST" class="d-flex align-items-center gap-4">
                            @csrf
                            <input type="hidden" name="data_add" value="{{ json_encode($dataToSave) }}">
                            <button type="submit" class="btn btn-success">เพิ่มข้อมูล</button>
                        </form>
                        <a href="blog" class="btn btn-danger">ย้อนกลับ</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
