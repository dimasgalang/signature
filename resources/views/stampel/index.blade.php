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
                    <h1 class="h3 mb-0 text-gray-800">Stampel List</h1>
                    <div>
                    <!-- <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#importModal"><i
                        class="fas fa-plus fa-sm text-white-50"></i> Import Stampel</a> -->
                    <a href="{{ route('stampel.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-plus fa-sm text-white-50"></i> Create Stampel</a>
                    </div>
                </div>
                
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                        <h6 class="m-0 font-weight-bold text-primary">Stampel Data</h6>
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stampels as $stampel)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $stampel->name }}</td>
                                        <td>{{ $stampel->document_name }}</td>
                                        <td class="text-center">
                                            <a id="show-view" class="btn btn-primary btn-circle btn-sm show-view" data-show-document="{{ asset('/storage/document/' . $stampel->original_name) }}" data-show-stamped="{{ asset('/storage/document/' . $stampel->document_stamp) }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('stampel.stamp', ['id' => $stampel->id]) }}" class="btn btn-success btn-circle btn-sm">
                                                <i class="fas fa-stop-circle"></i>
                                            </a>
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


@include('layout.footer')
</body>
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function () {
        $('body').on('click', '#show-view', function() {
            Swal.fire({
                title: "View document?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "View Document",
                denyButtonText: `View Document + Stamp`
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.open($(this).data('show-document'));
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
</script>
</html>