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
                    <h1 class="h3 mb-0 text-gray-800">Arrival Items Request</h1>
                </div>
                

                <!-- Approach -->
                <form method="post" action="{{ route('purchase-requestion.storeArrival') }}" enctype="multipart/form-data">
                @csrf
                {{-- Other Request --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Employment Identity</h6>
                            </div>
                            <input class="form-control" type="hidden" id="purchase_request_number" name="purchase_request_number" value="{{ $purchaseRequests[0]->purchase_requestion_number }}">
                            <div class="card-body">
                                <div id="employmentIdentity">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <label><b>Purchase Request Number :</b></label>
                                            <input class="form-control" type="text" id="purchase_request_number" name="purchase_request_number" value="{{ $purchaseRequests[0]->purchase_requestion_number }}" readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label><b>Date of Request :</b></label>
                                            <input class="form-control" type="date" id="date_of_request" name="date_of_request" value="{{ $purchaseRequests[0]->date_of_request }}" readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label><b>Name :</b></label>
                                            <input class="form-control" type="hidden" id="employee_id" name="employee_id" value="{{ $purchaseRequests[0]->employee_id }}" readonly>
                                            <input class="form-control" type="text" id="name" name="name" value="{{ $created_by }}" readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label><b>Date of Arrival :</b></label>
                                            <input class="form-control" type="date" id="date_of_arrival" name="date_of_arrival" value="{{ now()->format('Y-m-d') }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Hardware Device --}}
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Form Create Item Request</h6>
                            </div>
                            <div class="card-body">
                                <div id="itemRequest">
                                    @foreach ($purchaseRequests as $index => $itemRequest)
                                        <div class="row mb-2">
                                            <div class="col-xl-4">
                                                <label><b>Item Name :</b></label>
                                                <input class="form-control" type="hidden" id="id_barang" name="itemRequest[{{ $index }}][id_barang]" value="{{ $itemRequest->id }}">
                                                <input class="form-control" type="text" id="item_name" name="itemRequest[{{ $index }}][item_name]" value="{{ $itemRequest->nm_barang }}" readonly>
                                                @error('item_request.0.item_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-2">
                                                <label><b>Total Quantity :</b></label>
                                                <input class="form-control" type="number" id="total_quantity" name="itemRequest[{{ $index }}][total_quantity]" value="{{ $itemRequest->qty }}" readonly>
                                                @error('item_request.0.total_quantity')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-2">
                                                <label><b>Incoming Quantity :</b></label>
                                                <input class="form-control" type="number" id="incoming_quantity" name="itemRequest[{{ $index }}][incoming_quantity]" value="{{ $itemRequest->incoming_qty }}" readonly>
                                                @error('item_request.0.incoming_quantity')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-2">
                                                <label><b>Quantity Receiver :</b></label>
                                                <input class="form-control" type="number" id="qty_receiver" name="itemRequest[{{ $index }}][qty_receiver]" min="0" max="{{ $itemRequest->qty - $itemRequest->incoming_qty }}">
                                                @error('item_request.0.qty_receiver')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-2">
                                                <label><b>Remark :</b></label>
                                                <input class="form-control" type="text" id="remark" name="itemRequest[{{ $index }}][remark]">
                                                @error('item_request.0.remark')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button id="submit" type="submit" class="btn btn-primary btn-block"><b>Create</b></button>
                    </div>
                </div>
            </form>

                <!-- Content Row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

@include('layout.footer')
</body>
<script src="{{asset('vendor/jquery/jquery-ui.min.js')}}"></script>

<script type="module" src="{{asset('vendor/module/pdf.min.mjs')}}"></script>
<script type="module" src="{{asset('vendor/module/pdf.worker.min.mjs')}}"></script>
<script src="{{asset('vendor/jquery/interact.min.js')}}"></script>

<script type="text/javascript">

    $(document).ready(function() {
        // Inisialisasi Select2
        $('.hardware_id').select2({
            allowClear: true,
            placeholder: 'Choose Hardware Device',
        });

        $('.approval_hod_id').select2({
            allowClear: true,
            placeholder: 'Choose Your HOD',
        });

        $('.add-item_request').on('click', function() {
            let itemRequest = document.getElementById('itemRequest');
            let itemRequestIndex = itemRequest.children.length;
            $("#itemRequest").append(`<div class="row"><div class="col-xl-6"><label>Item Name :</label><input class="form-control" type="text" id="item_name" name="item_request[${itemRequestIndex}][item_name]" >
            </div><div class="col-xl-4"><label>Quantity :</label><input class="form-control" type="number" id="qty" name="item_request[${itemRequestIndex}][quantity]" >
            </div><div class="col-xl-2"><label></label><button type="button" class="btn btn-danger btn-block removeThis"><i class="fas fa-trash"></i></button>
            </div></div>`);
        });

        $(document).on('click', '.removeThis', function() {
            $(this).parent().parent().remove();
        });

    });
</script>
</html>