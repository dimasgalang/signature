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
                    <h1 class="h3 mb-0 text-gray-800">Revision Items</h1>
                </div>
                

                <!-- Approach -->
                <form method="post" action="{{ route('item.updateItem') }}">
                 <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Form Revision Item</h6>
                            </div>
                            <div class="card-body">
                                    @csrf
                                    <input class="form-control" type="hidden" id="item_id" name="item_id" value="{{$item->id}}">
                                     <div>
                                        <label for="text">Item Number</label>
                                        <input class="form-control" type="text" id="item_number" name="item_number" value="{{$item->itemNumber}}" readonly>
                                    </div>
                                    <br>
                                    <div>
                                        <label for="text">Product Name</label>
                                        <input class="form-control" type="text" id="product_name" name="product_name" value="{{$item->productName}}">
                                    </div>
                                    <br>
                                    <div>
                                        <label for="text">Qty Type</label>
                                        <select class="form-control qty_type" id="qty_type" name="qty_type">
                                            <option value=""></option>
                                            <option value="pcs" {{$item->qtyType == 'pcs' ? 'selected' : ''}}>Pcs</option>
                                            <option value="unit" {{$item->qtyType == 'unit' ? 'selected' : ''}}>Unit</option>
                                            <option value="lot" {{$item->qtyType == 'lot' ? 'selected' : ''}}>Lot</option>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <button id="submit" type="submit" class="btn btn-primary btn-block">Update</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
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
    $('.qty_type').select2({
          allowClear: true,
          placeholder: 'Choose Qty Type',
    });
</script>
</html>