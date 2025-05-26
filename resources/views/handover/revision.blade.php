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
                    <h1 class="h3 mb-0 text-gray-800">Revision Handover</h1>
                </div>
                

                <!-- Approach -->
                <form method="post" action="{{ route('handover.updateHandover') }}" enctype="multipart/form-data">
                 <div class="row">
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Form Revision Handover</h6>
                            </div>
                            <div class="card-body">
                                    @csrf
                                    <input class="form-control" type="hidden" id="handover_id" name="handover_id" value="{{$handover->id}}">
                                    <div id="handoverInput">
                                        <label>Handover Name :</label>
                                        <div class="row">
                                            <div class="col-xl-9">
                                                    <select class="form-control handover_name_id" id="handover_name_id" name="handover_name_id" >
                                                        <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div>
                                        <label for="text">Handover Department</label>
                                        <input class="form-control" type="text" id="handoverDepartment" name="handoverDepartment" value="{{ Auth::user()->dept }}" readonly>
                                    </div>
                                    <br>
                                    <div id="handoverInput">
                                        <label>Receiver Name :</label>
                                        <div class="row">
                                            <div class="col-xl-9">
                                                    <select class="form-control receiver_name_id" id="receiver_name_id" name="receiver_name_id" >
                                                        @foreach ($users as $user )
                                                            <option value="{{ $user->id }}" {{$user->id == $handover->receiver_name_id ? 'selected' : ''}}>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div>
                                        <label for="text">Receiver Department</label>
                                        <input class="form-control" type="text" id="receiverDepartment" value="{{$handover->department}}" name="receiverDepartment" readonly>
                                    </div>
                                    <br>
                                    <div>
                                        <label for="handoverDate">Tanggal</label>
                                        <input class="form-control" type="date" id="handoverDate" name="handoverDate" value="{{ \Carbon\Carbon::parse($handover->date)->format('Y-m-d') }}" disabled>
                                    </div>
                                    <br>
                                    <div>
                                        <label for="documentName">Document Name</label>
                                        <input class="form-control" type="text" id="documentName" name="documentName" value="{{ $handover->document_name }}" readonly>
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
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Form Revision Item</h6>
                            </div>
                            <div class="card-body">
                                <div id="itemInput">
                                    @foreach($itemHandover as $key => $itemsHdv )
                                        <div class="row">
                                            <div class="col-xl-5">
                                                <input class="form-control" type="hidden" id="id" name="product_id[{{$key}}][id]" value="{{$itemsHdv->id}}">
                                                <label>Product Name :</label>
                                                <select class="form-control product_id" id="product_id" name="product_id[{{$key}}][item_id]" >
                                                    @foreach ($items as $item )
                                                        <option value="{{ $item->id }}" {{$itemsHdv->item_id == $item->id ? 'selected' : ''}}>{{ $item->itemNumber }} - {{ $item->productName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xl-5">
                                                <label>Quantity :</label>
                                                <input class="form-control" type="number" id="number" name="product_id[{{$key}}][quantity]" value="{{$itemsHdv->quantity}}">
                                            </div>
                                            @if($loop->first)
                                                <div class="col-xl-2">
                                                    <label></label>
                                                    <button type="button" class="btn btn-sm btn-primary btn-block mt-3 add-handover" onclick="">Add</button>
                                                </div>
                                            @else 
                                                <div class="col-xl-2">
                                                    <label></label>
                                                    <button type="button" class="btn btn-danger btn-block removeThis" onclick="addItemIdToRemove({{$itemsHdv->id}})">Remove</button>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" id="itemsToDelete" name="items_to_delete" value="">
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

{{-- <script>
    $("#submit").click(function() {
        $(this).hide();
    });
    document.getElementById('file').onchange = function () {
        var name = document.getElementById('file')
        document.getElementById('document_name').value = name.files.item(0).name.split('.')[0];
    };
</script> --}}

{{-- <script>
    document.querySelector("#file").addEventListener("change", async function(e){
        var file = e.target.files[0]
        const toBase64 = file => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = reject;
        });
        console.log(await toBase64(file));

        document.getElementById('base64').value = await toBase64(file);
        if (file.type === "application/pdf") {
            const fileURL = URL.createObjectURL(file);
            document.getElementById('pdfPreview').src = fileURL;
        } else {
            alert("Please upload a valid PDF file.");
        }
    })
</script> --}}
{{-- <script type="text/javascript">
    function addRecords() {
        let itemInput = document.getElementById('itemInput');
        let itemIndex = itemInput.children.length;
        $("#itemInput").append(`<div class="row"><div class="col-xl-5"><label>Product Name :</label><select class="form-control product_id" id="product_id" name="product_id[${itemIndex}][item_id]" >@foreach ($items as $item )<option value="{{ $item->id }}">{{ $item->productName }}</option>@endforeach</select></div><div class="col-xl-5"><label>Quantity :</label><input class="form-control" type="number" id="number" name="product_id[${itemIndex}][quantity]" ></div><div class="col-xl-2"><label></label><button type="button" class="btn btn-danger btn-block removeThis">Remove</button></div></div>`);
        $('.product_id').select2({
            allowClear: true,
            placeholder: 'Choose Approval',
        });
    }

    $(document).on('click', '.removeThis', function() {
        $(this).parent().parent().remove();
    })
</script> --}}

<script type="text/javascript">

    $(document).ready(function() {
        // Inisialisasi Select2
        $('.product_id').select2({
            allowClear: true,
            placeholder: 'Choose Product Item',
        });

        // Fungsi untuk memperbarui opsi di semua dropdown
        function updateDropdownOptions() {
            // Ambil semua nilai yang dipilih
            let selectedValues = [];
            $('.product_id').each(function() {
                let value = $(this).val();
                if (value) {
                    selectedValues.push(value);
                }
            });

            // Perbarui opsi di setiap dropdown
            $('.product_id').each(function() {
                let currentDropdown = $(this);
                let currentValue = currentDropdown.val();

                currentDropdown.find('option').each(function() {
                    let optionValue = $(this).val();

                    // Disabled opsi jika sudah dipilih di dropdown lain
                    if (selectedValues.includes(optionValue) && optionValue !== currentValue) {
                        $(this).attr('disabled', true);
                    } else {
                        $(this).attr('disabled', false);
                    }
                });

                // Refresh Select2 untuk memperbarui tampilan
                currentDropdown.trigger('change.select2');
            });
        }

        // Panggil fungsi saat dropdown berubah
        $(document).on('change', '.product_id', function() {
            updateDropdownOptions();
        });

        $('.add-handover').on('click', function() {
            let itemInput = document.getElementById('itemInput');
            let itemIndex = itemInput.children.length;
            $("#itemInput").append(`<div class="row"><div class="col-xl-5"><label>Product Name :</label><select class="form-control product_id" id="product_id" name="product_id[${itemIndex}][item_id]" ><option></option>@foreach ($items as $item )<option value="{{ $item->id }}">{{ $item->itemNumber }} - {{ $item->productName }}</option>@endforeach</select></div><div class="col-xl-5"><label>Quantity :</label><input class="form-control" type="number" id="number" name="product_id[${itemIndex}][quantity]" ></div><div class="col-xl-2"><label></label><button type="button" class="btn btn-danger btn-block removeThis">Remove</button></div></div>`);
            // console.log(itemIndex);
            $('.product_id').select2({
                placeholder: 'Choose Product Item',
                allowClear: true,
            });

            // Perbarui opsi setelah menambahkan dropdown baru
            updateDropdownOptions();
        });

        $(document).on('click', '.removeThis', function() {
            $(this).parent().parent().remove();
            // Perbarui opsi setelah menambahkan dropdown baru
            updateDropdownOptions();
        });

        $(document).on("change", "#receiver_name_id", function(e){
            e.preventDefault();
            var receiverName_id = $(this).val();
            if (receiverName_id) {
                $.ajax({
                    url: '/handover/fetchDept/'+receiverName_id,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#receiverDepartment').val(data.dept);
                    }
                });
            } else{
                $('#receiverDepartment').empty();
                $('#receiverDepartment').attr('disabled','disabled');
            }
        });
    });
</script>

<script type="text/javascript">
    $('.product_id').select2({
          allowClear: true,
          placeholder: 'Choose Approval',
    });
    $('.handover_name_id').select2({
          allowClear: true,
          placeholder: 'Choose Approval',
    });
    $('.receiver_name_id').select2({
          allowClear: true,
          placeholder: 'Choose Approval',
    });
</script>

<script type="text/javascript">
    let arrayId = [];

    function addItemIdToRemove($id) {
        arrayId.push($id);
        document.getElementById('itemsToDelete').value = JSON.stringify(arrayId);
    }
</script>
</html>