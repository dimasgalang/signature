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
                    <h1 class="h3 mb-0 text-gray-800">Computer Inspection List</h1>
                    <div>
                    <!-- <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#importModal"><i
                        class="fas fa-plus fa-sm text-white-50"></i> Import Approval</a> -->
                    <a href="{{ route('computer-inspection.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-plus fa-sm text-white-50"></i> Create Computer Inspection</a>
                    </div>
                </div>
                
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                        <h6 class="m-0 font-weight-bold text-primary">Computer Inspection Data</h6>
                        <form method="GET" id="form-void">
                                <select name="void" id="void" class="form-control" onchange="document.getElementById('form-void').submit()" style="width: 300px;">
                                    <option disabled selected hidden>Select Status</option>
                                    <option value="false" {{ app('request')->input('void') == 'false'  ? 'selected' : ''}}>Active</option>
                                    <option value="true" {{ app('request')->input('void') == 'true'  ? 'selected' : ''}}>Void</option>
                                </select>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Purchase Request Number</th>
                                        <th>Date of Inspection</th>
                                        <th>Asset Number</th>
                                        <th>User</th>
                                        <th>Device</th>
                                        <th>Location</th>
                                        {{-- <th class="justify-content-center text-center">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($computerInspections as $computerInspection)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $computerInspection->computer_inspection_id }}</td>
                                        <td>{{ $computerInspection->date_of_inspection }}</td>
                                        <td>{{ $computerInspection->assets_number }}</td>
                                        <td>{{ $computerInspection->user }}</td>
                                        <td>{{ $computerInspection->device_name }}</td>
                                        <td>{{ $computerInspection->location }}</td>
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
                        <h5 id="delete-title" class="modal-title" id="exampleModalLabel">Detail Purchase Request</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="tab">
                            <button class="tablinks" onclick="openModal(event, 'Recap')">Recap Request Item</button>
                            <button class="tablinks" onclick="openModal(event, 'History')">History Arrival Item</button>
                        </div>
                        <div id="Recap" class="tabcontent">
                                <div class="row mb-2 mt-2">
                                    <div class="col-md-3">
                                        <label for="detail-request-number"><strong>Request Number:</strong></label>
                                        <input type="text" id="detail-request-number" name="purchase_requestion_number" class="form-control form-control-sm" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="detail-request-date"><strong>Date of Request:</strong></label>
                                        <input type="text" id="detail-request-date" name="date_of_request" class="form-control form-control-sm" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="detail-request-req-by"><strong>Requestion By:</strong></label>
                                        <input type="text" id="detail-request-req-by" class="form-control form-control-sm" style="text-transform:capitalize;" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="detail-request-status"><strong>Status:</strong></label>
                                        <input type="text" id="detail-request-status" class="form-control form-control-sm" style="text-transform:capitalize;" readonly>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    {{-- @if($purchaseRequest->status === 'process' || $purchaseRequest->status === 'partially') --}}
                                    <div class="col-md-3">
                                        <label for="detail-processed-by"><strong>Processed By:</strong></label>
                                        <input type="text" id="detail-processed-by" class="form-control form-control-sm" style="text-transform:capitalize;" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="detail-processed-date"><strong>Date of Process:</strong></label>
                                        <input type="text" id="detail-processed-date" name="date_of_processed" class="form-control form-control-sm" readonly>
                                    </div>
                                    {{-- @elseif($purchaseRequest->status === 'canceled')  --}}
                                    <div class="col-md-3">
                                        <label for="detail-canceled-by"><strong>Canceled By:</strong></label>
                                        <input type="text" id="detail-canceled-by" class="form-control form-control-sm" style="text-transform:capitalize;" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="detail-canceled-date"><strong>Date of Canceled:</strong></label>
                                        <input type="text" id="detail-canceled-date" name="date_of_canceled" class="form-control form-control-sm" readonly>
                                    </div>
                                    {{-- @endif --}}
                                </div>
                                <table class="table table-bordered table-sm" id="table-purchase-detail" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Barang</th>
                                            <th>Quantity</th>
                                            <th>Incomming Quantity</th>
                                            <th>Balance</th>
                                            <th>Date of Arrival</th>
                                            <th>Supplier</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                        </div>

                        <div id="History" class="tabcontent">
                            <br>
                            <table class="table table-bordered table-sm" id="table-arrival-history" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Barang</th>
                                        <th>Arrival Quantity</th>
                                        <th>Date of Arrival</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="processModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="process-title" class="modal-title" id="exampleModalLabel">Process Record</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <form action="{{ route('purchase-requestion.processPurchaseRequest') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <p id="modal-text-record-process"></p>
                        <input class="form-control" type="hidden" id="modal_purchase_requestion_number_process" name="purchase_requestion_number" readonly>
                        <input class="form-control" type="hidden" id="modal_employee_id_process" name="employee_id" readonly>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                        <a id="btn-confirm-process"><button class="btn btn-success" type="submit">Confirm</button></a>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="canceledModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="canceled-title" class="modal-title" id="exampleModalLabel">Canceled Record</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <form action="{{ route('purchase-requestion.canceledPurchaseRequest') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <p id="modal-text-record-canceled"></p>
                        <input class="form-control" type="hidden" id="modal_purchase_requestion_number_canceled" name="purchase_requestion_number" readonly>
                        <input class="form-control" type="hidden" id="modal_employee_id_canceled" name="employee_id" readonly>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                        <a id="btn-confirm-canceled"><button class="btn btn-warning" type="submit">Confirm</button></a>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="voidModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="void-title" class="modal-title" id="exampleModalLabel">Void Record</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <form action="{{ route('purchase-requestion.void') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <p id="modal-text-record-void"></p>
                        <input class="form-control" type="hidden" id="modal_purchase_requestion_number_void" name="purchase_requestion_number" readonly>
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
                    <form action="{{ route('purchase-requestion.restore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <p id="modal-text-record-restore"></p>
                        <input class="form-control" type="hidden" id="modal_purchase_requestion_number_restore" name="purchase_requestion_number" readonly>
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
            $("#modal-text-record-void").text('Apakah anda yakin ingin menghapus Purchase Request ' + $(this).data('void-name') + '?');
    });
    $('.btn-process-record').on('click', function () {
            $("#modal-text-record-process").text('Apakah anda yakin ingin memproses Purchase Request ' + $(this).data('process-name') + '?');
    });
    $('.btn-canceled-record').on('click', function () {
            $("#modal-text-record-canceled").text('Apakah anda yakin ingin membatalkan Purchase Request ' + $(this).data('canceled-name') + '?');
    });
    $('.btn-restore-record').on('click', function () {
            $("#modal-text-record-restore").text('Apakah anda yakin ingin mengembalikan Purchase Request ' + $(this).data('restore-name') + '?');
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
    
    // $(function () {
    //     $('body').on('click', '#show-detail', function() {
    //     var jsonDetails = $(this).data('detail-url');
    //     var jsonHistory = $(this).data('history-url');

    //     $.get(jsonDetails, function (data) {
    //         var requestionStatus = data.data[0].status;
    //         $('#detailModal').modal('show');
    //         if (data.data.length > 0) {
    //             $('#detail-request-number').val(data.data[0].purchase_requestion_number + '_' + data.data[0].requestion);
    //             $('#detail-request-date').val(data.data[0].date_of_request);
    //             $('#detail-request-req-by').val(data.requestBy);
    //             $('#detail-processed-by').val(data.processedBy ?? '-');
    //             $('#detail-processed-date').val(data.data[0].process_date ?? '-');
    //             $('#detail-canceled-by').val(data.canceledBy ?? '-');
    //             $('#detail-canceled-date').val(data.data[0].canceled_date ?? '-');
    //             $('#detail-request-status').val(data.data[0].status);
    //         }

    //         var tablePurchaseDetail = $('#table-purchase-detail').DataTable({
    //             destroy: true,
    //             processing: true,
    //             responsive: true,
    //             ajax: jsonDetails, 
    //             columns: [
    //                 { data: null, 
    //                     render: function (data, type, row, meta) {
    //                         return meta.row + meta.settings._iDisplayStart + 1;
    //                     }, 
    //                     name: 'id', 
    //                     orderable: false, 
    //                     searchable: false
    //                 },
    //                 { data: 'nm_barang', name: 'nm_barang', orderable: false },
    //                 { data: 'qty', name: 'qty', orderable: false },
    //                 { data: 'incoming_qty', name: 'incoming_qty', orderable: false },
    //                 { data: null, 
    //                     render: function(data, type, row) {
    //                         const qty = Number(row.qty) || 0;
    //                         const incomingQty = Number(row.incoming_qty) || 0;
    //                         const balance = qty - incomingQty;
    //                         return balance;
    //                     }, 
    //                     name: 'balance', 
    //                     orderable: false 
    //                 },
    //                 { data: 'date_of_request', name: 'date_of_request', orderable: false },
    //                 { data: 'supplier', name: 'supplier', orderable: false },
    //                 { data: 'status', name: 'status', 
    //                     render: function(data, type, row) {
    //                         const qty = Number(row.qty) || 0;
    //                         const incomingQty = Number(row.incoming_qty) || 0;

    //                         if (data === 'waiting') {
    //                             return '<span class="badge badge-secondary" style="text-transform:capitalize;">' + data + '</span>';
    //                         } else if (qty > incomingQty && data === 'process') {
    //                             return '<span class="badge badge-primary" style="text-transform:capitalize;">partially</span>';
    //                         } else if (data === 'canceled') {
    //                             return '<span class="badge badge-danger" style="text-transform:capitalize;">' + data + '</span>';
    //                         } else {
    //                             return '<span class="badge badge-success" style="text-transform:capitalize;">' + data + '</span>';
    //                         }
    //                     },
    //                 orderable: false },
    //             ],
    //         });
    //     });
    //     // });

    //     $.get(jsonHistory, function (data) {
                
    //             var tableArrivalHistory = $('#table-arrival-history').DataTable({
    //                 destroy: true,
    //                 processing: true,
    //                 responsive: true,
    //                 ajax: jsonHistory, 
    //                 columns: [
    //                     { data: 'id', name: 'id', orderable: false, searchable: false},
    //                     { data: 'nm_barang', name: 'nm_barang', orderable: false },
    //                     { data: 'qty', name: 'qty', orderable: false },
    //                     { data: 'date_of_arrival', name: 'date_of_arrival', orderable: true },
    //                 ],
    //             });
    //         });
    //     });
    // });

    // $(function () {
    //     $('body').on('click', '#show-void', function() {
    //     var jsonVoid = $(this).data('void-url'); 
    //     $.get(jsonVoid, function (data) {
    //         console.log(data);
    //         if (data.data.length > 0) {
    //             $('#modal_purchase_requestion_number_void').val(data.data[0].purchase_requestion_number);
    //             } else {

    //             }
    //         });
    //     });
    // });
    // $(function () {
    //     $('body').on('click', '#show-restore', function() {
    //     var jsonRestore = $(this).data('restore-url'); 
    //     $.get(jsonRestore, function (data) {
    //         if (data.data.length > 0) {
    //             $('#modal_purchase_requestion_number_restore').val(data.data[0].purchase_requestion_number);
    //             } else {

    //             }
    //         });
    //     });
    // });
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