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
                        <h1 class="h3 mb-0 text-gray-800">Create Approval</h1>
                    </div>


                    <!-- Approach -->
                    <form method="post" action="{{ route('approval.store') }}" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Form Create Approval</h6>
                                    </div>
                                    <div class="card-body">
                                        @csrf
                                        <input class="form-control" type="hidden" id="preparer_id" name="preparer_id" value="{{ Auth::user()->id }}">
                                        <div>
                                            <label>Document Name :</label>
                                            <input class="form-control" type="text" id="document_name" name="document_name" value="{{$clearance->document_name}}" required readonly>
                                            <input class="form-control" type="hidden" id="original_name" name="original_name" value="{{$clearance->original_name}}">
                                            <input class="form-control" type="hidden" id="base64" name="base64" value="{{$clearance->base64}}">
                                            <input class="form-control" type="hidden" id="type" name="type" value="clearance">
                                        </div>
                                        <br>
                                        <div id="approvalInput">
                                            <label>Approval Name :</label>
                                            <div class="row">
                                                <div class="col-xl-9">
                                                    <select class="form-control approval_id" id="approval_id" name="approval_id[]">
                                                        <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-xl-3">
                                                    <button type="button" class="btn btn-primary btn-block add-approval" >Add</button>
                                                </div>
                                            </div><br>
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
                                    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                                        <h6 class="m-0 font-weight-bold text-primary">Display PDF</h6>
                                    </div>
                                    <div class="card-body">
                                        <iframe src="{{$clearance->base64}}" id="pdfPreview" width="100%" height="500px"></iframe>
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
    function addRecords() {
        $("#approvalInput").append('<div class="row"><br><br><div class="col-xl-9"><select class="form-control approval_id" id="approval_id" name="approval_id[]">@foreach($users as $user)<option value="{{ $user->id }}">{{ $user->name }}</option>@endforeach</select></div><div class="col-xl-3"><button type="button" class="btn btn-danger btn-block removeThis">Remove</button></div></div>');
        $('.approval_id').select2({
            allowClear: true,
            placeholder: 'Choose Approval',
        });
    }

    // $(document).on('click', '.removeThis', function() {
    //     $(this).parent().parent().remove();
    // })
</script>
{{-- <script type="text/javascript">
    $('.approval_id').select2({
        allowClear: true,
        placeholder: 'Choose Approval',
    });
</script> --}}


<script type="text/javascript">

    $(document).ready(function() {
        // Inisialisasi Select2
        $('.approval_id').select2({
            allowClear: true,
            placeholder: 'Choose Approval',
        });

        // Fungsi untuk memperbarui opsi di semua dropdown
        function updateDropdownOptions() {
            // Ambil semua nilai yang dipilih
            let selectedValues = [];
            $('.approval_id').each(function() {
                let value = $(this).val();
                if (value) {
                    selectedValues.push(value);
                }
            });

            // Perbarui opsi di setiap dropdown
            $('.approval_id').each(function() {
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
        $(document).on('change', '.approval_id', function() {
            updateDropdownOptions();
        });

        $('.add-approval').on('click', function() {
            $("#approvalInput").append('<div class="row"><br><br><div class="col-xl-9"><select class="form-control approval_id" id="approval_id" name="approval_id[]"><option></option>@foreach($users as $user)<option value="{{ $user->id }}">{{ $user->name }}</option>@endforeach</select></div><div class="col-xl-3"><button type="button" class="btn btn-danger btn-block removeThis">Remove</button></div></div>');
            // console.log(itemIndex);
            $('.approval_id').select2({
                placeholder: 'Choose Approval',
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
    });
</script>

</html>