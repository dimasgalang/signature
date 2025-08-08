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
                    <h1 class="h3 mb-0 text-gray-800">Create Surveillance System Maintenance</h1>
                </div>
                

                <!-- Approach -->
                <form method="post" action="{{ route('surveillance-system-maintenance.store') }}" enctype="multipart/form-data">
                @csrf
                {{-- Other Request --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">PELAKU PEMELIHARAAN/ MAINTENANCE PERFORMER</h6>
                            </div>
                            <input class="form-control" type="hidden" id="surveillance_system_maintenance_id" name="surveillance_system_maintenance_id" value="{{ $newIdSurveillanceSystemMaintenance  }}">
                            <div class="card-body">
                                <div id="employmentIdentity">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <label>Date of Maintenance :</label>
                                            <input class="form-control" type="date" id="date_of_maintenance" name="date_of_maintenance" value="{{ date('Y-m-d') }}" readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Document Name :</label>
                                            <input class="form-control" type="text" id="document_name" name="document_name" value="{{ $newIdSurveillanceSystemMaintenance }}" readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Maintenance performer  :</label>
                                            <input class="form-control" type="text" id="name_performer" name="name_performer" value="{{ $performerId->name }}" readonly>
                                            <input class="form-control" type="hidden" id="department_performer" name="department_performer" value="{{ $performerId->dept }}">
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Follow-Up person   :</label>
                                            <input class="form-control" type="text" id="name_follow_up" name="name_follow_up" value="{{ $ItHeadId->name }}" readonly>
                                            <input class="form-control" type="hidden" id="department_follow_up" name="department_follow_up" value="{{ $ItHeadId->dept }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- PERANGKAT KERAS / HARDWARE --}}
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Lensa Kamera Pengawas / Surveillance Camera Lens </h6>
                            </div>
                            <div class="card-body">
                                    <div id="hardwareDevice">
                                        <div class="col-xl-12">
                                            <label>Purpose :</label>
                                            <div class="row">
                                                <input type="radio" name="hardware_device[0][purpose]" id="purpose1" value="Purpose 1">
                                                <label for="purpose1">Purpose 1</label>
                                                <input type="radio" name="hardware_device[0][purpose]" id="purpose2" value="Purpose 2">
                                                <label for="purpose2">Purpose 2</label>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Memeriksa server rekaman/ Checking recording server </h6>
                            </div>
                            <div class="card-body">
                                    <div id="hardwareDevice">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <label>Purpose :</label>
                                                <textarea class="form-control" id="purpose" name="hardware_device[0][purpose]" placeholder="Enter Purpose" ></textarea>
                                            </div>
                                            <div class="col-xl-6">
                                                <label>Restriction :</label>
                                                <textarea class="form-control" id="restriction" name="hardware_device[0][restriction]" placeholder="Enter Restriction" ></textarea>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-12">
                        <button id="submit" type="submit" class="btn btn-primary btn-block">Create</button>
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

    });
</script>
</html>