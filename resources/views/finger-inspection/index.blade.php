<!DOCTYPE html>
<html lang="en">
@include('layout.header')
<body id="page-top">
<!-- Page Wrapper -->
@include('sweetalert::alert')
<div id="wrapper">
@include('layout.sidebar')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            @include('layout.navbar')
            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Finger Inspection List</h1>
                    <div>
                    <!-- <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#importModal"><i
                        class="fas fa-plus fa-sm text-white-50"></i> Import Approval</a> -->
                    <a href="{{ route('finger-inspection.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-plus fa-sm text-white-50"></i> Create Finger Inspection</a>
                    </div>
                </div>
                
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                        <h6 class="m-0 font-weight-bold text-primary">Finger Inspection Data</h6>
                        <form method="GET" id="form-void">
                                <select name="void" id="void" class="form-control" onchange="document.getElementById('form-void').submit()" style="width: 300px;">
                                    <option disabled selected hidden>Select Status</option>
                                    <option value="false" {{ app('request')->input('void') == 'false'  ? 'selected' : ''}}>Active</option>
                                    <option value="true" {{ app('request')->input('void') == 'true'  ? 'selected' : ''}}>Void</option>
                                </select>
                        </form>
                    </div>
                    <div class="row px-4">
                        <div class="col-xl-3 col-md-6">
                            <div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <label>From Date :</label>
                                <input class="date form-control" type="month" id="fromdate" name="fromdate" value="">
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div>
                                <label>To Date :</label>
                                <input class="date form-control" type="month" id="todate" name="todate" value="">
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div style="margin-top: 32px;">
                                <button type="button" name="generate" id="generate" class="btn btn-primary btn-sm">Generate</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Finger Inspection Number</th>
                                        <th>Date of Inspection</th>
                                        <th class="justify-content-center text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fingerInspections as $fingerInspection)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $fingerInspection->finger_inspection_id }}</td>
                                        <td>{{ $fingerInspection->date_of_inspection }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm btn-icon-split" id="show-detail" data-toggle="modal" data-target="#detailModal" data-detail-url="{{ route('finger-inspection.details', $fingerInspection->finger_inspection_id) }}">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="text">Detail</span>
                                            </a>
                                            @if($fingerInspection->void == 'false')
                                            <a class="btn btn-danger btn-sm btn-icon-split btn-void-record" id="show-void" data-toggle="modal" data-target="#voidModal" href="#" 
                                                data-void-url="{{ route('finger-inspection.details', $fingerInspection->finger_inspection_id) }}"
                                                data-void-name="{{ $fingerInspection->finger_inspection_id }}">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash"></i>
                                                </span> 
                                                <span class="text">Void</span>
                                            </a>
                                            @else
                                            <a class="btn btn-success btn-sm btn-icon-split btn-restore-record" id="show-restore" data-toggle="modal" data-target="#restoreModal" href="#" 
                                                data-restore-url="{{ route('finger-inspection.details', $fingerInspection->finger_inspection_id) }}"
                                                data-restore-name="{{ $fingerInspection->finger_inspection_id }}">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash-restore"></i>
                                                </span>
                                                <span class="text">Restore</span>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Content Row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="delete-title" class="modal-title" id="exampleModalLabel">Detail Finger Inspection</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-sm" id="table-inspection-detail" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Finger Inspection Number</th>
                                    <th>Date of Inspection</th>
                                    <th>Machine Number</th>
                                    <th class="justify-content-center text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="details-title" class="modal-title" id="exampleModalLabel">details Record</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <form action="{{ route('') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <p id="modal-text-record-details"></p>
                        <input class="form-control" type="hidden" id="modal_purchase_requestion_number_details" name="purchase_requestion_number" readonly>
                        <input class="form-control" type="hidden" id="modal_employee_id_details" name="employee_id" readonly>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                        <a id="btn-confirm-details"><button class="btn btn-success" type="submit">Confirm</button></a>
                    </div>
                    </form>
                </div>
            </div>
        </div> --}}

        <div class="modal fade" id="voidModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="void-title" class="modal-title" id="exampleModalLabel">Void Record</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <form action="{{ route('finger-inspection.void') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <p id="modal-text-record-void"></p>
                        <input class="form-control" type="hidden" id="modal_finger_inspection_id_void" name="finger_inspection_id" readonly>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                        <a id="btn-confirm-void"><button class="btn btn-danger" type="submit">Confirm</button></a>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="restore-title" class="modal-title" id="exampleModalLabel">Restore Record</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <form action="{{ route('finger-inspection.restore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <p id="modal-text-record-restore"></p>
                        <input class="form-control" type="hidden" id="modal_finger_inspection_id_restore" name="finger_inspection_id" readonly>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                        <a id="btn-confirm-restore"><button class="btn btn-success" type="submit">Confirm</button></a>
                    </div>
                    </form>
                </div>
            </div>
        </div>

@include('layout.footer')
</body>
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
<script type="text/javascript">
    $('.btn-delete-record').on('click', function () {
            $('#btn-confirm').attr('href', $(this).data('delete-link'));
            $("#modal-text-record").text('Apakah anda yakin ingin menghapus Approval ' + $(this).data('delete-name') + '?');
    });
    $('.btn-void-record').on('click', function () {
            $("#modal-text-record-void").text('Apakah anda yakin ingin menghapus Finger Inspections ' + $(this).data('void-name') + '?');
    });
    $('.btn-process-record').on('click', function () {
            $("#modal-text-record-process").text('Apakah anda yakin ingin memproses Purchase Request ' + $(this).data('process-name') + '?');
    });
    $('.btn-canceled-record').on('click', function () {
            $("#modal-text-record-canceled").text('Apakah anda yakin ingin membatalkan Purchase Request ' + $(this).data('canceled-name') + '?');
    });
    $('.btn-restore-record').on('click', function () {
            $("#modal-text-record-restore").text('Apakah anda yakin ingin mengembalikan Finger Inspections ' + $(this).data('restore-name') + '?');
    });
    $('.btn-revision-record').on('click', function () {
            $("#modal-text-record-revision").text('Apakah anda yakin ingin mengubah status Approval menjadi Revision ' + $(this).data('revision-name') + '?');
    });

    // function openModal(evt, tabName) {
    //     var i, tabcontent, tablinks;
    //     tabcontent = document.getElementsByClassName("tabcontent");
    //     for (i = 0; i < tabcontent.length; i++) {
    //         tabcontent[i].style.display = "none";
    //     }

    //     tablinks = document.getElementsByClassName("tablinks");
    //     for (i = 0; i < tablinks.length; i++) {
    //         tablinks[i].className = tablinks[i].className.replace(" active", "");
    //     }

    //     document.getElementById(tabName).style.display = "block";
    //     evt.currentTarget.className += " active";
    // }
    
    $(function () {
        $('body').on('click', '#show-detail', function() {
        var jsonDetails = $(this).data('detail-url');

            $.get(jsonDetails, function (data) { 
                $('#detailModal').modal('show');

                var tableInspectionDetail = $('#table-inspection-detail').DataTable({
                    destroy: true,
                    processing: true,
                    responsive: true,
                    ajax: jsonDetails, 
                    columns: [
                        { data: null, 
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }, 
                            name: 'id', 
                            orderable: false, 
                            searchable: false
                        },
                        { data: 'finger_inspection_id', name: 'finger_inspection_id', orderable: false },
                        { data: 'date_of_inspection', name: 'date_of_inspection', orderable: true },
                        { data: 'machine_number', name: 'machine_number', orderable: false },
                        { data: 'machine_number', name: 'machine_number', render: function(data, type, row) {
                            return `
                                <a class="btn btn-warning btn-sm btn-icon-split" href="/finger-inspection/edit/${row.id}">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    <span class="text">Edit</span>
                                </a>
                            `;
                        }, orderable: false }
                        
                    ],
                });
            });
        });

        $('#generate').on('click', function () {
            var fromDate = $('#fromdate').val();
            var toDate = $('#todate').val();
            var _token = $('input[name="_token"]').val();

            window.open('{{ url('finger-inspection/export') }}/' + fromDate + '/' + toDate, '_blank');
        });
    });
    

    $(function () {
        $('body').on('click', '#show-void', function() {
        var jsonVoid = $(this).data('void-url'); 
        $.get(jsonVoid, function (data) {
            if (data.data.length > 0) {
                $('#modal_finger_inspection_id_void').val(data.data[0].finger_inspection_id);
                } else {

                }
            });
        });
    });
    $(function () {
        $('body').on('click', '#show-restore', function() {
        var jsonRestore = $(this).data('restore-url'); 
        $.get(jsonRestore, function (data) {
            if (data.data.length > 0) {
                $('#modal_finger_inspection_id_restore').val(data.data[0].finger_inspection_id);
                } else {

                }
            });
        });
    });
    // $(function () {
    //     $('body').on('click', '#show-process', function() {
    //     var jsonProcess = $(this).data('process-url'); 
    //     $.get(jsonProcess, function (data) {
    //         if (data.data.length > 0) {
    //             $('#modal_purchase_requestion_number_process').val(data.data[0].purchase_requestion_number);
    //             $('#modal_employee_id_process').val(data.data[0].employee_id);
    //             } else {

    //             }
    //         });
    //     });
    // });
    // $(function () {
    //     $('body').on('click', '#show-canceled', function() {
    //     var jsonCanceled = $(this).data('canceled-url'); 
    //     $.get(jsonCanceled, function (data) {
    //         if (data.data.length > 0) {
    //             $('#modal_purchase_requestion_number_canceled').val(data.data[0].purchase_requestion_number);
    //             $('#modal_employee_id_canceled').val(data.data[0].employee_id);
    //             } else {

    //             }
    //         });
    //     });
    // });

</script>
</html>