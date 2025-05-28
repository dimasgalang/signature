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
                    <h1 class="h3 mb-0 text-gray-800">Items List</h1>
                    <div>
                    <!-- <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#importModal"><i
                        class="fas fa-plus fa-sm text-white-50"></i> Import Approval</a> -->
                    <a href="{{ route('item.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-plus fa-sm text-white-50"></i> Create Item</a>
                    </div>
                </div>
                
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                        <h6 class="m-0 font-weight-bold text-primary">Items Data</h6>
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
                                        <th>Item Number</th>
                                        <th>Product Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->itemNumber }}</td>
                                        <td>{{ $item->productName }}</td>
                                         <td>
                                            <center>
                                                <a href="{{ route('item.revisionItem', $item->id) }}" class="btn btn-warning btn-circle btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if (request()->get('void') == 'false' || request()->get('void') == '')
                                                <a id="show-void" class="btn btn-danger btn-circle btn-sm btn-void-record show-void" data-void-url="{{ route('item.fetchItem', $item->id) }}" data-void-link="{{ route('item.void') }}" data-void-name="data-item" data-toggle="modal" data-target="#voidModal">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                                @elseif (request()->get('void') == 'true')
                                                <a id="show-restore" class="btn btn-success btn-circle btn-sm btn-restore-record show-restore" data-restore-url="{{ route('item.fetchItem', $item->id) }}" data-restore-link="{{ route('item.restore') }}" data-restore-name="data-item" data-toggle="modal" data-target="#restoreModal">
                                                    <i class="fas fa-history"></i>
                                                </a> 
                                                @endif
                                            </center>
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

        <div class="modal fade" id="voidModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="void-title" class="modal-title" id="exampleModalLabel">Void Record</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <form action="{{ route('item.void') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <p id="modal-text-record-void"></p>
                        <input class="form-control" type="hidden" id="modal_item_id_void" name="item_id" readonly>
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
                    <form action="{{ route('item.restore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <p id="modal-text-record-restore"></p>
                        <input class="form-control" type="hidden" id="modal_item_id_restore" name="item_id" readonly>
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
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
<script type="text/javascript">
    $('.btn-delete-record').on('click', function () {
            $('#btn-confirm').attr('href', $(this).data('delete-link'));
            $("#modal-text-record").text('Apakah anda yakin ingin menghapus Approval ' + $(this).data('delete-name') + '?');
    });
    $('.btn-void-record').on('click', function () {
            $("#modal-text-record-void").text('Apakah anda yakin ingin menghapus item ' + $(this).data('void-name') + '?');
    });
    $('.btn-restore-record').on('click', function () {
            $("#modal-text-record-restore").text('Apakah anda yakin ingin mengembalikan item ' + $(this).data('restore-name') + '?');
    });

    $(function () {
        $('body').on('click', '#show-void', function() {
        var jsonVoid = $(this).data('void-url'); 
        $.get(jsonVoid, function (data) {
            if (data.length > 0) {
                $('#modal_item_id_void').val(data[0].id);
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
                $('#modal_item_id_restore').val(data[0].id);
                } else {

                }
            });
        });
    });
</script>
</html>