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
                    <h1 class="h3 mb-0 text-gray-800">Purchase Requestions List</h1>
                    <div>
                    <!-- <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#importModal"><i
                        class="fas fa-plus fa-sm text-white-50"></i> Import Approval</a> -->
                    <a href="{{ route('purchase-requestion.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-plus fa-sm text-white-50"></i> Create Purchase Request</a>
                    </div>
                </div>
                
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                        <h6 class="m-0 font-weight-bold text-primary">Purchase Request Data</h6>
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
                                        <th>ID</th>
                                        <th>Purchase Request ID</th>
                                        <th>Date of Request</th>
                                        <th>Total Items</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchaseRequests as $purchaseRequest)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $purchaseRequest->purchase_requestion_number . '_' . $purchaseRequest->requestion }}</td>
                                        <td>{{ $purchaseRequest->date_of_request }}</td>
                                        <td>{{ $purchaseRequest->total_items }}</td>
                                        <td class="justify-content-center">
                                            @if($purchaseRequest->status == 'process')
                                                <span class="badge badge-primary">{{ $purchaseRequest->status }}</span>
                                            @elseif($purchaseRequest->status == 'finished')
                                                <span class="badge badge-success">{{ $purchaseRequest->status }}</span>
                                            @elseif($purchaseRequest->status == 'partially')
                                                <span class="badge badge-info">{{ $purchaseRequest->status }}</span>
                                            @elseif($purchaseRequest->status == 'canceled')
                                                <span class="badge badge-danger">{{ $purchaseRequest->status }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $purchaseRequest->status }}</span>
                                            @endif
                                        </td>
                                        <td class="row justify-content-center">
                                            {{-- <a href="" class="btn btn-sm btn-circle btn-warning"><i class="fas fa-edit"></i></a> --}}
                                            <a href="" class="btn btn-sm btn-circle btn-primary btn-show-detail show-detail mx-1" id="show-detail" data-detail-url="{{ route('purchase-requestion.fetchPurchaseRequest', $purchaseRequest->purchase_requestion_number) }}" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></a>
                                            @if($purchaseRequest->status == 'waiting')
                                                <form action="{{ route('purchase-requestion.processPurchaseRequest') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="purchase_requestion_number" value="{{ $purchaseRequest->purchase_requestion_number }}">
                                                    <button type="submit" class="btn btn-sm btn-circle btn-info mx-1"><i class="fas fa-sync"></i></button>
                                                </form>
                                            @endif
                                            @if($purchaseRequest->status == 'waiting' || $purchaseRequest->status == 'process')
                                                <form action="{{ route('purchase-requestion.canceledPurchaseRequest') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="purchase_requestion_number" value="{{ $purchaseRequest->purchase_requestion_number }}">
                                                    <button type="submit" class="btn btn-sm btn-circle btn-warning mx-1"><i class="fas fa-times"></i></button>
                                                </form>
                                            @endif
                                            <a href="" class="btn btn-sm btn-circle btn-danger mx-1"><i class="fas fa-trash"></i></a>
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
                        <h5 id="delete-title" class="modal-title" id="exampleModalLabel">Detail Purchase Request</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <form action="{{ route('purchase-requestion.processPurchaseRequest') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label for="detail-request-number"><strong>Request Number:</strong></label>
                                <input type="text" id="detail-request-number" name="purchase_requestion_number" class="form-control form-control-sm" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="detail-request-date"><strong>Date of Request:</strong></label>
                                <input type="text" id="detail-request-date" name="date_of_request" class="form-control form-control-sm" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="detail-request-status"><strong>Status:</strong></label>
                                <input type="text" id="detail-request-status" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <table class="table table-bordered table-sm" id="table-purchase-detail" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Barang</th>
                                    <th>Quantity</th>
                                    <th>Incomming Quantity</th>
                                    <th>Date of Arrival</th>
                                    <th>Supplier</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
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
                    <form action="{{ route('handover.void') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <p id="modal-text-record-void"></p>
                        <input class="form-control" type="hidden" id="modal_handover_id_void" name="handover_id" readonly>
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
                    <form action="{{ route('handover.restore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <p id="modal-text-record-restore"></p>
                        <input class="form-control" type="hidden" id="modal_handover_id_restore" name="handover_id" readonly>
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
            $("#modal-text-record-void").text('Apakah anda yakin ingin menghapus IT Request ' + $(this).data('void-name') + '?');
    });
    $('.btn-restore-record').on('click', function () {
            $("#modal-text-record-restore").text('Apakah anda yakin ingin mengembalikan IT Request ' + $(this).data('restore-name') + '?');
    });
    $('.btn-revision-record').on('click', function () {
            $("#modal-text-record-revision").text('Apakah anda yakin ingin mengubah status Approval menjadi Revision ' + $(this).data('revision-name') + '?');
    });
    
    $(function () {
        $('body').on('click', '#show-detail', function() {
        var jsonDetails = $(this).data('detail-url'); 
        $.get(jsonDetails, function (data) {
            var requestionStatus = data.data[0].status;
            $('#detailModal').modal('show');
            if (data.data.length > 0) {
                $('#detail-request-number').val(data.data[0].purchase_requestion_number);
                $('#detail-request-date').val(data.data[0].date_of_request);
                $('#detail-request-status').val(data.data[0].status);
            }
            var arrivalBaseUrl = "{{ url('purchase-requestion/arrival') }}";
            var tablePurchaseDetail = $('#table-purchase-detail').DataTable({
                destroy: true,
                processing: true,
                responsive: true,
                ajax: jsonDetails, 
                columns: [
                    { data: 'id', name: 'id', orderable: false, searchable: false},
                    { data: 'nm_barang', name: 'nm_barang', orderable: false },
                    { data: 'qty', name: 'qty', orderable: false },
                    { data: 'incoming_qty', name: 'incoming_qty', orderable: false },
                    { data: 'date_of_request', name: 'date_of_request', orderable: false },
                    { data: 'supplier', name: 'supplier', orderable: false },
                    { data: 'status', name: 'status', 
                        render: function(data, type, row) {
                            if (data === 'waiting') {
                                return '<span class="badge badge-secondary">' + data + '</span>';
                            } else if (data === 'process') {
                                return '<span class="badge badge-primary">' + data + '</span>';
                            } else if (data === 'canceled') {
                                return '<span class="badge badge-danger">' + data + '</span>';
                            } else {
                                return '<span class="badge badge-success">' + data + '</span>';
                            }
                        },
                    orderable: false },
                    { data: 'id', name: 'id', render: function (data, type, row) {
                            if(requestionStatus != 'waiting' && requestionStatus != 'canceled') {
                                return `<a href="${arrivalBaseUrl}/${data}" class="btn btn-sm btn-circle btn-success"><i class="fas fa-share"></i></a>`;
                            } else {
                                return ''
                            }
                        },
                        orderable: false, searchable: false 
                    },
                ],
                });
            });
        });
    });


    $(function () {
        $('body').on('click', '#show-revision', function() {
        var jsonRevision = $(this).data('revision-url'); 
        $.get(jsonRevision, function (data) {
            if (data.length > 0) {
                $('#modal_employee_id').val(data[0].employee_id);
                $('#modal_name').val(data[0].name);
                $('#modal_document_name').val(data[0].document_name);
                $('#modal_token').val(data[0].token);
                } else {

                }
            });
        });
    });
    $(function () {
        $('body').on('click', '#show-void', function() {
        var jsonVoid = $(this).data('void-url'); 
        $.get(jsonVoid, function (data) {
            if (data.length > 0) {
                $('#modal_handover_id_void').val(data[0].id);
                } else {

                }
            });
        });
    });
    $(function () {
        $('body').on('click', '#show-restore', function() {
        var jsonRestore = $(this).data('restore-url'); 
        $.get(jsonRestore, function (data) {
            if (data.length > 0) {
                $('#modal_handover_id_restore').val(data[0].id);
                } else {

                }
            });
        });
    });
</script>
</html>