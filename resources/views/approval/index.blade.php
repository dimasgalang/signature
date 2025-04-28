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
                    <h1 class="h3 mb-0 text-gray-800">Approval List</h1>
                    <div>
                    <!-- <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#importModal"><i
                        class="fas fa-plus fa-sm text-white-50"></i> Import Approval</a> -->
                    <a href="{{ route('approval.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-plus fa-sm text-white-50"></i> Create Approval</a>
                    </div>
                </div>
                
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                        <h6 class="m-0 font-weight-bold text-primary">Approval Data</h6>
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
                                        <th>Preparer</th>
                                        <th>Document Name</th>
                                        <th>Original Name</th>
                                        <th>Need Approve</th>
                                        <th>Approval Date</th>
                                        <th>Status</th>
                                        <th>Attachment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($approvals as $approval)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $approval->name }}</td>
                                        <td>{{ $approval->document_name }}</td>
                                        <td>{{ $approval->original_name }}</td>
                                        <td>{{ $approval->need_approve }}</td>
                                        <td>{{ $approval->approval_date }}</td>
                                        @if ($approval->status == 'pending')
                                        <td><center><a class="btn btn-danger btn-icon-split btn-sm">
                                            <span class="text">Pending</span>
                                            </a></center>
                                        </td>
                                        @elseif ($approval->status == 'approved')
                                        <td><center><a class="btn btn-success btn-icon-split btn-sm">
                                            <span class="text">Approved</span>
                                            </a></center>
                                        </td>
                                        @elseif ($approval->status == 'revision')
                                        <td><center><a id="show-comment" class="btn btn-warning btn-icon-split btn-sm show-comment" data-toggle="modal" data-target="#commentModal" data-comment-url="{{ route('approval.fetchapproval', $approval->id) }}">
                                            <span class="text">Revision</span>
                                            </a></center>
                                        </td>
                                        @endif
                                        <td align="center"><a id="show-detail-attachment" class="btn btn-primary btn-icon-split btn-sm btn-show-detail-attachment" data-url-attachment="{{ route('approval.fetchattachment', $approval->token) }}" data-show-title-attachment="{{ $approval->document_name }}">
                                            <span class="text">Detail</span>
                                        </a></td>
                                        <td class="text-center">
                                            @if (($approval->value_first == null) && ($approval->value_last == null))
                                            <a id="show-view" class="btn btn-primary btn-circle btn-sm show-view" data-show-approved="{{ asset('/storage/document/' . $approval->original_name) }}" data-show-stamped="{{ asset('/storage/document/' . $approval->document_stamp) }}">
                                            <!-- <a id="show-view" href="{{ asset('/storage/document/' . $approval->original_name) }}" class="btn btn-primary btn-circle btn-sm show-view" target="_blank"> -->
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @elseif ((!is_null($approval->value_first)) && ($approval->value_last == null))
                                            <a id="show-view" class="btn btn-primary btn-circle btn-sm show-view" data-show-approved="{{ asset('/storage/document/' . $approval->value_first) }}" data-show-stamped="{{ asset('/storage/document/' . $approval->document_stamp) }}">
                                            <!-- <a id="show-view" href="{{ asset('/storage/document/' . $approval->value_first) }}" class="btn btn-primary btn-circle btn-sm show-view" target="_blank"> -->
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @elseif ((!is_null($approval->value_first)) && (!is_null($approval->value_last)))
                                            <a id="show-view" class="btn btn-primary btn-circle btn-sm show-view" data-show-approved="{{ asset('/storage/document/' . $approval->value_last) }}" data-show-stamped="{{ asset('/storage/document/' . $approval->document_stamp) }}">
                                                <!-- <a id="show-view" href="{{ asset('/storage/document/' . $approval->value_last) }}" class="btn btn-primary btn-circle btn-sm show-view" target="_blank"> -->
                                                <i class="fas fa-eye"></i>
                                            </a>
                                                @if ($approval->stamp != 'true')
                                                <a href="{{ route('approval.stamp', ['id' => $approval->id]) }}" class="btn btn-success btn-circle btn-sm">
                                                    <i class="fas fa-stop-circle"></i>
                                                </a>
                                                @endif
                                            @endif
                                            @if (request()->get('void') == 'false' || request()->get('void') == '')
                                                @if ($approval->approval_level == $approval->approval_progress)
                                                    @if ($approval->status == 'pending')
                                                    <a href="{{ route('approval.approve', ['id' => $approval->id]) }}" class="btn btn-success btn-circle btn-sm">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    <a id="show-revision" class="btn btn-warning btn-circle btn-sm show-revision" data-revision-url="{{ route('approval.fetchapproval', $approval->id) }}" data-revision-link="{{ route('approval.revision') }}" data-revision-name="{{ $approval->document_name }}" data-preparer-name="{{ $approval->preparer_id }}" data-date-name="{{ $approval->created_at }}" data-toggle="modal" data-target="#revisionModal">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                    @endif
                                                @endif
                                            @endif
                                            @if ($approval->preparer_id == $approval->approval_id)
                                                @if (request()->get('void') == 'false' || request()->get('void') == '')
                                                <a id="show-void" class="btn btn-danger btn-circle btn-sm btn-void-record show-void" data-void-url="{{ route('approval.fetchapproval', $approval->id) }}" data-void-link="{{ route('approval.void') }}" data-void-name="{{ $approval->document_name }}" data-preparer-name="{{ $approval->preparer_id }}" data-date-name="{{ $approval->created_at }}" data-toggle="modal" data-target="#voidModal">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                                @elseif (request()->get('void') == 'true')
                                                <a id="show-restore" class="btn btn-success btn-circle btn-sm btn-restore-record show-restore" data-restore-url="{{ route('approval.fetchapproval', $approval->id) }}" data-restore-link="{{ route('approval.restore') }}" data-restore-name="{{ $approval->document_name }}" data-preparer-name="{{ $approval->preparer_id }}" data-date-name="{{ $approval->created_at }}" data-toggle="modal" data-target="#restoreModal">
                                                    <i class="fas fa-history"></i>
                                                </a>
                                                @endif
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
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="delete-title" class="modal-title" id="exampleModalLabel">Delete Record</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body"><p id="modal-text-record"></p></div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                        <a id="btn-confirm" href=""><button class="btn btn-primary" type="button">Confirm</button></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="revisionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="revision-title" class="modal-title" id="exampleModalLabel">Revision Record</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <form action="{{ route('approval.revision') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                            <input class="form-control" type="hidden" id="modal_preparer_id" name="preparer_id" readonly>
                            <input class="form-control" type="hidden" id="modal_name" name="name" readonly>
                            <label>Document Name :</label>
                            <input class="form-control" type="text" id="modal_document_name" name="document_name" readonly>
                            <br>
                            <input class="form-control" type="hidden" id="modal_token" name="token" readonly>
                            <label>Revision Comment : </label>
                            <textarea class="form-control" type="hidden" id="modal_comment" name="comment"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                        <a id="btn-confirm-revision" href=""><button class="btn btn-primary" type="submit">Confirm</button></a>
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
                    <form action="{{ route('approval.void') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <p id="modal-text-record-void"></p>
                        <input class="form-control" type="hidden" id="modal_preparer_id_void" name="preparer_id" readonly>
                        <input class="form-control" type="hidden" id="modal_name_void" name="name" readonly>
                        <input class="form-control" type="hidden" id="modal_document_name_void" name="document_name" readonly>
                        <input class="form-control" type="hidden" id="modal_token_void" name="token">
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
                    <form action="{{ route('approval.restore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <p id="modal-text-record-restore"></p>
                        <input class="form-control" type="hidden" id="modal_preparer_id_restore" name="preparer_id" readonly>
                        <input class="form-control" type="hidden" id="modal_name_restore" name="name" readonly>
                        <input class="form-control" type="hidden" id="modal_document_name_restore" name="document_name" readonly>
                        <input class="form-control" type="hidden" id="modal_token_restore" name="token">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                        <a id="btn-confirm-restore"><button class="btn btn-success" type="submit">Confirm</button></a>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="comment-title" class="modal-title" id="exampleModalLabel">Comment Record</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label>Revision Comment : </label>
                        <textarea class="form-control" type="text" id="modal_comment_detail" name="comment" readonly></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="modal-title" class="modal-title" id="exampleModalLabel">Import Approval</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>PILIH FILE</label>
                                    <input type="file" name="file" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-success">Import</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="attachmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="detail-title" class="modal-title" id="exampleModalLabel">Attachment Detail</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-row align-items-center justify-content-between" style="margin-top: 10px;">
                            <h6 class="m-0 font-weight-bold text-primary"></h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-blue-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink">
                                    <!-- <div class="dropdown-header">Action:</div> -->
                                    <a class="dropdown-item" href="{{ route('attachment.create') }}" target="_blank">Create Attachment</a>
                                    <!-- <a class="dropdown-item" href="#">Export Excel</a> -->
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xl-12 col-md-6 mb-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-modal table-sm" id="table-attachment-detail" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Attachment Name</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>


@include('layout.footer')
</body>
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    $('.btn-delete-record').on('click', function () {
            $('#btn-confirm').attr('href', $(this).data('delete-link'));
            $("#modal-text-record").text('Apakah anda yakin ingin menghapus Approval ' + $(this).data('delete-name') + '?');
    });
    $('.btn-void-record').on('click', function () {
            $("#modal-text-record-void").text('Apakah anda yakin ingin menghapus Approval ' + $(this).data('void-name') + '?');
    });
    $('.btn-restore-record').on('click', function () {
            $("#modal-text-record-restore").text('Apakah anda yakin ingin mengembalikan Approval ' + $(this).data('restore-name') + '?');
    });
    $('.btn-revision-record').on('click', function () {
            $("#modal-text-record-revision").text('Apakah anda yakin ingin mengubah status Approval menjadi Revision ' + $(this).data('revision-name') + '?');
    });
    $(function () {
        $('body').on('click', '#show-revision', function() {
        var jsonRevision = $(this).data('revision-url'); 
        $.get(jsonRevision, function (data) {
            if (data.length > 0) {
                $('#modal_preparer_id').val(data[0].preparer_id);
                $('#modal_name').val(data[0].name);
                $('#modal_document_name').val(data[0].document_name);
                $('#modal_token').val(data[0].token);
                } else {

                }
            });
        });
    });
    $(document).ready(function () {
        $('body').on('click', '#show-detail-attachment', function() {
            var jsonAttachmentDetail = $(this).data('url-attachment');
            $.get(jsonAttachmentDetail, function (data) {
                $('#attachmentModal').modal('show');
                var tableAttachmentDetail = $('#table-attachment-detail').DataTable({
                        destroy: true,
                        processing: true,
                        responsive: true,
                        ajax: jsonAttachmentDetail, 
                        columns: [
                            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                            { data: 'document_name', name: 'document_name', orderable: false },
                            { data: 'created_at', name: 'created_at', orderable: false },
                            { data: 'viewbadge', name: 'viewbadge', orderable: false },
                        ],
                    });
            })
        });
    });
    $(function () {
        $('body').on('click', '#show-view', function() {
            console.log($(this).data('show-stamped'));
            Swal.fire({
                title: "View document?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "View Document",
                denyButtonText: `View Document + Stamp`
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.open($(this).data('show-approved'));
                } else if (result.isDenied) {
                    if($(this).data('show-stamped').substr($(this).data('show-stamped').length - 4) == ".pdf") {
                        window.open($(this).data('show-stamped'));
                    } else {
                        Swal.fire("This document not stamped", "", "danger");
                    }
                }
            });
        });
    });
    $(function () {
        $('body').on('click', '#show-void', function() {
        var jsonVoid = $(this).data('void-url'); 
        $.get(jsonVoid, function (data) {
            if (data.length > 0) {
                $('#modal_preparer_id_void').val(data[0].preparer_id);
                $('#modal_name_void').val(data[0].name);
                $('#modal_document_name_void').val(data[0].document_name);
                $('#modal_token_void').val(data[0].token);
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
                $('#modal_preparer_id_restore').val(data[0].preparer_id);
                $('#modal_name_restore').val(data[0].name);
                $('#modal_document_name_restore').val(data[0].document_name);
                $('#modal_token_restore').val(data[0].token);
                } else {

                }
            });
        });
    });
    $(function () {
        $('body').on('click', '#show-comment', function() {
        var jsonComment = $(this).data('comment-url'); 
        $.get(jsonComment, function (data) {
            if (data.length > 0) {
                $('#modal_comment_detail').val(data[0].comment);
                } else {

                }
            });
        });
    });
</script>
</html>