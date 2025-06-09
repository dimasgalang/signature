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
                    <h1 class="h3 mb-0 text-gray-800">Create Handover</h1>
                </div>
                

                <!-- Approach -->
                <form method="post" action="{{ route('handover.store') }}" enctype="multipart/form-data">
                 <div class="row">
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Form Create Handover</h6>
                            </div>
                            <div class="card-body">
                                    @csrf
                                    <input class="form-control" type="hidden" id="handover_id" name="handover_id">
                                    <div id="handoverInput">
                                        <label>Handover Name :</label>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                    <select class="form-control handover_name_id" id="handover_name_id" name="handover_name_id" >
                                                        <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                     <div>
                                        <label for="text">From Department</label>
                                        <input class="form-control" type="text" id="handoverDepartment" name="handoverDepartment" value="{{ Auth::user()->dept }}" readonly>
                                    </div>
                                    <br>
                                    <div id="handoverInput">
                                        <label>Receiver Name :</label>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                    <select class="form-control receiver_name_id" id="receiver_name_id" name="receiver_name_id" >
                                                        <option></option>
                                                        @foreach ($users as $user )
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div>
                                        <label for="text">To Department</label>
                                        <input class="form-control" type="text" id="receiverDepartment" name="receiverDepartment" readonly>
                                    </div>
                                    <br>
                                    <div>
                                        <label for="handoverDate">Tanggal</label>
                                        <input class="form-control" type="date" id="handoverDate" name="handoverDate" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <br>
                                    <div>
                                        <label for="documentName">Document Name</label>
                                        @if(((substr($handover?->document_name,2,5)) != date('y') . date('n') . date('d')))
                                        <input class="form-control" type="text" id="documentName" name="documentName" value="{{ 'HO' . date('y') . date('n') . date('d') . str_pad(1,4,'0',STR_PAD_LEFT) }}" readonly>
                                        @elseif(((substr($handover?->document_name,2,5)) == (date('y') . date('n') . date('d'))) || ($handover?->document_name ?? ''))
                                        <input class="form-control" type="text" id="documentName" name="documentName" value="{{ 'HO' . date('y') . date('n') . date('d') . str_pad(intval(substr($handover?->document_name,-4)) + 1,4,'0',STR_PAD_LEFT) }}" readonly>
                                        @else
                                        <input class="form-control" type="text" id="documentName" name="documentName" value="{{ 'HO' . date('y') . date('n') . date('d') . str_pad(1,4,'0',STR_PAD_LEFT) }}" readonly>
                                        @endif
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <button id="submit" type="submit" class="btn btn-primary btn-block">Create</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Form Item</h6>
                            </div>
                            <div class="card-body">
                                <div id="itemInput">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <label>Product Name :</label>
                                            <select class="form-control product_id" id="product_id" name="product_id[0][barang_code]" >
                                                <option></option>
                                                @foreach ($items as $item )
                                                    <option value="{{ $item->barang_code }}">{{ $item->barang_code }} - {{ $item->barang_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xl-4">
                                            <label>Quantity :</label>
                                            <input class="form-control" type="number" id="number" name="product_id[0][quantity]" >
                                        </div>
                                        <div class="col-xl-2">
                                            <label></label>
                                            <button type="button" class="btn btn-sm btn-primary btn-block mt-3 add-handover" onclick="">Add</button>
                                        </div>
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
            $("#itemInput").append(`<div class="row"><div class="col-xl-5"><label>Product Name :</label><select class="form-control product_id" id="product_id" name="product_id[${itemIndex}][barang_code]" ><option></option>@foreach ($items as $item )<option value="{{ $item->barang_code }}">{{ $item->barang_code }} - {{ $item->barang_name }}</option>@endforeach</select></div><div class="col-xl-5"><label>Quantity :</label><input class="form-control" type="number" id="number" name="product_id[${itemIndex}][quantity]" ></div><div class="col-xl-2"><label></label><button type="button" class="btn btn-danger btn-block removeThis">Remove</button></div></div>`);
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
          placeholder: 'Choose Product Item',
    });
    $('.handover_name_id').select2({
          allowClear: true,
          placeholder: 'Choose Approval',
    });
    $('.receiver_name_id').select2({
          allowClear: true,
          placeholder: 'Choose Receiver Name',
    });
</script>
</html>