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
                    <h1 class="h3 mb-0 text-gray-800">Update User Account Deactivation</h1>
                </div>
                

                <!-- Approach -->
                <form method="post" action="{{ route('cyber-user.update') }}" enctype="multipart/form-data">
                @csrf
                {{-- Other Request --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Deactivate Information Request</h6>
                            </div>
                            <input class="form-control" type="hidden" id="deactivation_request_id" name="deactivation_request_id" value="{{ $deactivateRequest->deactivation_request_id }}">
                            <div class="card-body">
                                <div id="deactivateRequest">
                                    <div class="row mb-3">
                                        <div class="col-xl-3">
                                            <label>Date of Request :</label>
                                            <input class="form-control" type="date" id="date_of_request" name="date_of_request" value="{{ $deactivateRequest->date_of_request }}" readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Document Name :</label>
                                            <input class="form-control" type="text" id="document_name" name="document_name" value="{{ $deactivateRequest->document_name }}" readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Name :</label>
                                            <input class="form-control" type="text" id="name" name="name" value="{{ $deactivateRequest->preparer_name }}" readonly>
                                            <input class="form-control" type="hidden" id="preparer_id" name="preparer_id" value="{{ $deactivateRequest->preparer_id }}">
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Dept :</label>
                                            <input class="form-control" type="text" id="department" name="department" value="{{ $deactivateRequest->preparer_dept }}" readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-xl-3">
                                            <label>Employee Name :</label>
                                            <input class="form-control" type="hidden" id="employee_id" name="employee_id" value="{{ $userDeactive[0]->NPK }}" readonly>
                                            <input class="form-control" type="text" id="employee_name" name="employee_name" value="{{ $userDeactive[0]->NAMA_KARYAWAN }}" readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label>NPK :</label>
                                            <input class="form-control" type="text" id="npk" name="npk" value="{{ $userDeactive[0]->NPK }}" readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Posisi :</label>
                                            <input class="form-control" type="text" id="position" name="position" value="{{ $userDeactive[0]->BAG }}" readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Dept :</label>
                                            <input class="form-control" type="text" id="department-employee" name="department-employee" value="{{ $userDeactive[0]->BAG }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">PENONAKTIFAN PENGGUNA CYBER / DEACTIVATION OF CYBER USER:</h6>
                            </div>
                            <div class="card-body">
                                <div id="employmentIdentity">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <input type="radio" name="deactivate" value="permanent" id="deactivate_permanent" class="mr-2" {{$deactivateRequest->deactivate == 'permanent' ? 'checked' : ''}}>
                                            <label for="deactivate">Menghapus atau menghentikan secara permanen seluruh hak akses terkait Cyber dan IT terhadap sistem informasi Perusahaan. <br><i>Remove or terminate permanently the whole Cyber and IT related access right to Company’s information systems.</i></label>
                                        </div>
                                        <div class="col-xl-12">
                                            <input type="radio" name="deactivate" value="temporarily" id="deactivate_temporarily" class="mr-2" {{$deactivateRequest->deactivate == 'temporarily' ? 'checked' : ''}}>
                                            <label for="deactivate">Menonaktifkan sementara seluruh hak akses terkait Cyber dan IT terhadap sistem informasi Perusahaan dalam kurun waktu di bawah ini: <br><i>Deactivate temporarily the whole Cyber and IT related access right to Company’s information systems within the below period:</i></label>
                                        </div>
                                    </div>

                                    {{-- div start date to end date --}}
                                    <div class="row mb-3" id="deactivate-period">
                                        <div class="col-xl-6">
                                            <label>Start Date:</label>
                                            <input class="form-control deactivate" type="date" id="start_date" name="start_date" value="{{ $deactivateRequest->start_date }}">
                                        </div>
                                        <div class="col-xl-6">
                                            <label>End Date:</label>
                                            <input class="form-control deactivate" type="date" id="end_date" name="end_date" value="{{ $deactivateRequest->end_date }}">
                                        </div>
                                    </div>
                                    {{-- div start date to end date --}}

                                    {{-- <br> --}}
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <label>Alasan Penonaktifan:</label>
                                            <select class="form-control reason_id" id="reason_id" name="reason_id" >
                                                <option></option>
                                                @foreach ($reasons as $reason)
                                                    <option value="{{ $reason->id }}" {{ $reason->id == $deactivateRequest->reason_id ? 'selected' : '' }}>{{ $reason->reason }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button id="submit" type="submit" class="btn btn-primary btn-block">Update</button>
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
    // var start_date;
    // var end_date;

    $(document).ready(function() {
        // Inisialisasi Select2
        $('.employee_id').select2({
            allowClear: true,
            placeholder: 'Choose Employee Name',
        });

        $('.reason_id').select2({
            allowClear: true,
            placeholder: 'Choose Reason Deactivate',
        });

        var selectedValue = $('input[name="deactivate"]:checked').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        // // Toggle date period based on checkbox state
        $('input[name="deactivate"]').on('change', function() {
                var selectedValue = $(this).val();
                
                if (selectedValue === 'temporarily') {
                    // Show with slide down animation
                    $('#deactivate-period').slideDown(400);
                    
                    // Optional: Set the date values to empty
                    $('#start_date').val(start_date);
                    $('#end_date').val(end_date);
                } else {
                    // Hide with slide up animation
                    $('#deactivate-period').slideUp(400);
                    
                    // Optional: Clear the date values when hiding
                    $('#start_date').val('');
                    $('#end_date').val('');
                }
            });
        
        $(document).on("change", "#employee_id", function(e){
            e.preventDefault();
            var employee_id = $(this).val();
            if (employee_id) {
                $.ajax({
                    url: '/cyber-user/fetchEmployee/'+employee_id,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        console.log(data);
                        
                        $('#npk').val(data[0].NPK);
                        $('#position').val(data[0].BAG);
                        $('#department-employee').val(data[0].DEPARTEMENT);
                    }
                });
            } else{
                $('#npk').empty();
                $('#npk').attr('disabled','disabled');

                $('#position').empty();
                $('#position').attr('disabled','disabled');

                $('#department-employee').empty();
                $('#department-employee').attr('disabled','disabled');
            }
        });
    });
</script>
</html>