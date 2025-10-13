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
                    <h1 class="h3 mb-0 text-gray-800">Create Purchase Requestion</h1>
                </div>
                

                <!-- Approach -->
                <form method="post" action="{{ route('purchase-requestion.processPurchaseRequest') }}" enctype="multipart/form-data">
                @csrf
                {{-- Other Request --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Purchase Requestion Information</h6>
                            </div>
                            <input class="form-control" type="hidden" id="purchase_request_number" name="purchase_request_number" value="{{ $purchaseRequests[0]->purchase_requestion_number }}">
                            <div class="card-body">
                                <div id="employmentIdentity">
                                    <div class="row mb-4">
                                        <div class="col-xl-3">
                                            <label><b>Purchase Request Number :</b></label>
                                            <input class="form-control" type="text" id="purchase_request_number" name="purchase_request_number" value="{{ $purchaseRequests[0]->purchase_requestion_number }}" readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label><b>Purpose Requestion :</b></label>
                                            <input class="form-control" type="text" id="requestion" name="requestion" value="{{ $purchaseRequests[0]->requestion }}" readonly>
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
                                    @foreach($purchaseRequests as $index => $purchaseRequest)
                                    <div class="row mb-2">
                                        <div class="col-xl-4">
                                            <label><b>Item Name :</b></label>
                                            <input class="form-control" type="text" id="item_name" name="item_request[{{ $index }}][item_name]" value="{{ $purchaseRequest->nm_barang }}" readonly>
                                            <input type="hidden" name="item_request[{{ $index }}][id]" value="{{ $purchaseRequest->id }}">
                                            @error('item_request.0.item_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-xl-4">
                                            <label><b>Quantity :</b></label>
                                            <input class="form-control" type="number" id="qty" name="item_request[{{ $index }}][quantity]" value="{{ $purchaseRequest->qty }}" readonly>
                                            @error('item_request.0.quantity')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-xl-4">
                                            <label for="supplier_select"><strong>Supplier:</strong></label>
                                            <select name="item_request[{{ $index }}][supplier_id]" id="supplier_select{{ $index }}" class="form-control mb-1 supplier-select">
                                                <option value=""></option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier->supplier_code }}">{{ $supplier->supplier_name }}</option>
                                                @endforeach
                                            </select>

                                            @error('item_request.0.supplier_select')
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
                        <button id="submit" type="submit" class="btn btn-primary btn-block"><b>Proses</b></button>
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
        let itemRequest = document.getElementById('itemRequest');
        let itemRequestIndex = itemRequest.children.length;

        for (let i = 0; i < itemRequestIndex; i++) {
            $('#supplier_select' + i).select2({
                allowClear: true,
                placeholder: 'Choose Supplier',
                tags: true,

            });
        }

        // // Toggle date period based on checkbox state
        // $('input[name="deactivate"]').change(function() {
        //     var selectedValue = $(this).val();
        //     if (selectedValue === 'temporarily') {
        //         // Show with slide down animation
        //         $('#deactivate-period').slideDown(400);
        //     } else {
        //         // Hide with slide up animation
        //         $('#deactivate-period').slideUp(400);
                
        //         // Optional: Clear the date values when hiding
        //         $('#start_date, #end_date').val('');
        //     }
        // });

        // $(document).on('change', '.is-exist-checkbox', function() {
        //     var isChecked = $(this).is(':checked');
        //     var index = $('.is-exist-checkbox').index(this);

        //      if (isChecked) {
        //         $('#supplier_select' + index).removeClass('d-none').val('');
        //         $('#supplier_input' + index).addClass('d-none').focus();
        //     } else {
        //         $('#supplier_input' + index).removeClass('d-none');
        //         $('#supplier_select' + index).addClass('d-none').val('');
        //     }
        //     //updateDynamicInput(isChecked);
        // });

    });
</script>
</html>