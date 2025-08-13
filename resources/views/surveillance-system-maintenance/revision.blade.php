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
                    <h1 class="h3 mb-0 text-gray-800">Revision Surveillance System Maintenance</h1>
                </div>
                

                <!-- Approach -->
                <form method="post" action="{{ route('surveillance-system-maintenance.update') }}" enctype="multipart/form-data">
                @csrf
                {{-- Other Request --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">PELAKU PEMELIHARAAN/ MAINTENANCE PERFORMER</h6>
                            </div>
                            <input class="form-control" type="hidden" id="surveillance_system_maintenance_id" name="surveillance_system_maintenance_id" value="{{ $surveillanceSystemMaintenance->surveillance_system_maintenance_id }}">
                            <div class="card-body">
                                <div id="employmentIdentity">
                                    <div class="row">
                                        <div class="col-xl-2">
                                            <label>Date of Maintenance :</label>
                                            <input class="form-control" type="date" id="date_of_maintenance" name="date_of_maintenance" value="{{ date('Y-m-d') }}" value="{{$surveillanceSystemMaintenance->date_of_maintenance}}" readonly>
                                        </div>
                                        <div class="col-xl-2">
                                            <label>Document Name :</label>
                                            <input class="form-control" type="text" id="document_name" name="document_name" value="{{ $surveillanceSystemMaintenance->document_name }}" readonly>
                                        </div>
                                        <div class="col-xl-2">
                                            <label>Maintenance performer  :</label>
                                            <input class="form-control" type="text" id="name_performer" name="name_performer" value="{{ $surveillanceSystemMaintenance->name_performer }}" readonly>
                                            <input class="form-control" type="hidden" id="department_performer" name="department_performer" value="{{ $surveillanceSystemMaintenance->performer_dept }}">
                                        </div>
                                        <div class="col-xl-2">
                                            <label>Follow-Up person   :</label>
                                            <input class="form-control" type="text" id="name_follow_up" name="name_follow_up" value="{{ $ItHeadId->name }}" readonly>
                                            <input class="form-control" type="hidden" id="department_follow_up" name="department_follow_up" value="{{ $ItHeadId->dept }}">
                                        </div>
                                        <div class="col-xl-2">
                                            <label>Number Of Camera  :</label>
                                            <input class="form-control" type="number" id="number_of_camera" name="number_of_camera" value="{{ $surveillanceSystemMaintenance->number_of_camera }}" required>
                                        </div>
                                        <div class="col-xl-2">
                                            <label>Number Of Server  :</label>
                                            <input class="form-control" type="number" id="number_of_server" name="number_of_server" value="{{ $surveillanceSystemMaintenance->number_of_server }}" required>
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
                                    <div id="surveillanceCameraLensItems">
                                        @foreach($surveillanceCameraLensItems as $itemQuestion)
                                        <div class="col-xl-12">
                                            <label><b>{!! $loop->iteration .'. '.$itemQuestion->questionnaire_items !!} :</b></label>
                                            @foreach($answerSurveillanceQuestionnaires as $answer)
                                                @if($answer->questionnaire_id == $itemQuestion->id)
                                                    <div class="row mb-3 ml-3 mr-3 justify-content-between">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="surveillanceCameraLensItems[{{ $itemQuestion->id }}]" id="surveillanceCameraLensItems_{{ $itemQuestion->id }}_periksa" value="periksa" {{ $answer->answer == 'periksa' ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="surveillanceCameraLensItems_{{ $itemQuestion->id }}_periksa">Periksa / <i>Inspect</i></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="surveillanceCameraLensItems[{{ $itemQuestion->id }}]" id="surveillanceCameraLensItems_{{ $itemQuestion->id }}_bersihkan" value="bersihkan" {{ $answer->answer == 'bersihkan' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="surveillanceCameraLensItems_{{ $itemQuestion->id }}_bersihkan">Bersihkan / <i>Clean</i></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="surveillanceCameraLensItems[{{ $itemQuestion->id }}]" id="surveillanceCameraLensItems_{{ $itemQuestion->id }}_perbaiki" value="perbaiki" {{ $answer->answer == 'perbaiki' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="surveillanceCameraLensItems_{{ $itemQuestion->id }}_perbaiki">Perbaiki / <i>Repair</i></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="surveillanceCameraLensItems[{{ $itemQuestion->id }}]" id="surveillanceCameraLensItems_{{ $itemQuestion->id }}_mengganti" value="mengganti" {{ $answer->answer == 'mengganti' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="surveillanceCameraLensItems_{{ $itemQuestion->id }}_mengganti">Mengganti / <i>Replace</i></label>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        @endforeach
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
                                        @foreach($checkingRecordingServer as $itemQuestion)
                                        <div class="col-xl-12">
                                            <label><b>{!! $loop->iteration .'. '.$itemQuestion->questionnaire_items !!} :</b></label>
                                            @foreach($answerSurveillanceQuestionnaires as $answer)
                                                @if($answer->questionnaire_id == $itemQuestion->id)
                                                    <div class="row mb-3 ml-3 mr-3 justify-content-between">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="checkingRecordingServer[{{ $itemQuestion->id }}]" id="checkingRecordingServer_{{ $itemQuestion->id }}_periksa" value="periksa" {{ $answer->answer == 'periksa' ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="checkingRecordingServer_{{ $itemQuestion->id }}_periksa">Periksa / <i>Inspect</i></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="checkingRecordingServer[{{ $itemQuestion->id }}]" id="checkingRecordingServer_{{ $itemQuestion->id }}_bersihkan" value="bersihkan" {{ $answer->answer == 'bersihkan' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="checkingRecordingServer_{{ $itemQuestion->id }}_bersihkan">Bersihkan / <i>Clean</i></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="checkingRecordingServer[{{ $itemQuestion->id }}]" id="checkingRecordingServer_{{ $itemQuestion->id }}_perbaiki" value="perbaiki" {{ $answer->answer == 'perbaiki' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="checkingRecordingServer_{{ $itemQuestion->id }}_perbaiki">Perbaiki / <i>Repair</i></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="checkingRecordingServer[{{ $itemQuestion->id }}]" id="checkingRecordingServer_{{ $itemQuestion->id }}_mengganti" value="mengganti" {{ $answer->answer == 'mengganti' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="checkingRecordingServer_{{ $itemQuestion->id }}_mengganti">Mengganti / <i>Replace</i></label>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        @endforeach
                                    </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Periksa infrastruktur jaringan / Check network infrastructure </h6>
                            </div>
                            <div class="card-body">
                                    <div id="hardwareDevice">
                                        @foreach($checkNetworkInfrastructure as $itemQuestion)
                                        <div class="col-xl-12">
                                            <label><b>{!! $loop->iteration .'. '.$itemQuestion->questionnaire_items !!} :</b></label>
                                            @foreach($answerSurveillanceQuestionnaires as $answer)
                                                @if($answer->questionnaire_id == $itemQuestion->id)
                                                    <div class="row mb-3 ml-3 mr-3 justify-content-between">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="checkNetworkInfrastructure[{{ $itemQuestion->id }}]" id="checkNetworkInfrastructure_{{ $itemQuestion->id }}_periksa" value="periksa" {{ $answer->answer == 'periksa' ? 'checked' : '' }} required>
                                                            <label class="form-check-label" for="checkNetworkInfrastructure_{{ $itemQuestion->id }}_periksa">Periksa / <i>Inspect</i></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="checkNetworkInfrastructure[{{ $itemQuestion->id }}]" id="checkNetworkInfrastructure_{{ $itemQuestion->id }}_bersihkan" value="bersihkan" {{ $answer->answer == 'bersihkan' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="checkNetworkInfrastructure_{{ $itemQuestion->id }}_bersihkan">Bersihkan / <i>Clean</i></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="checkNetworkInfrastructure[{{ $itemQuestion->id }}]" id="checkNetworkInfrastructure_{{ $itemQuestion->id }}_perbaiki" value="perbaiki" {{ $answer->answer == 'perbaiki' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="checkNetworkInfrastructure_{{ $itemQuestion->id }}_perbaiki">Perbaiki / <i>Repair</i></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="checkNetworkInfrastructure[{{ $itemQuestion->id }}]" id="checkNetworkInfrastructure_{{ $itemQuestion->id }}_mengganti" value="mengganti" {{ $answer->answer == 'mengganti' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="checkNetworkInfrastructure_{{ $itemQuestion->id }}_mengganti">Mengganti / <i>Replace</i></label>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        @endforeach
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Pengujian Perangkat Lunak / Software Testing </h6>
                            </div>
                            <div class="card-body">
                                <div id="hardwareDevice">
                                    @foreach($softwareTesting as $itemQuestion)
                                    <label><b>{!! $loop->iteration .'. '.$itemQuestion->questionnaire_items !!} :</b></label>
                                        @foreach($answerSurveillanceQuestionnaires as $answer)
                                            @if($answer->questionnaire_id == $itemQuestion->id)
                                                <div class="row mb-3 ml-3 mr-3 justify-content-between">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="softwareTesting[{{ $itemQuestion->id }}]" id="softwareTesting_{{ $itemQuestion->id }}_periksa" value="periksa" {{ $answer->answer == 'periksa' ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="softwareTesting_{{ $itemQuestion->id }}_periksa">Periksa / <i>Inspect</i></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="softwareTesting[{{ $itemQuestion->id }}]" id="softwareTesting_{{ $itemQuestion->id }}_bersihkan" value="bersihkan" {{ $answer->answer == 'bersihkan' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="softwareTesting_{{ $itemQuestion->id }}_bersihkan">Bersihkan / <i>Clean</i></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="softwareTesting[{{ $itemQuestion->id }}]" id="softwareTesting_{{ $itemQuestion->id }}_perbaiki" value="perbaiki" {{ $answer->answer == 'perbaiki' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="softwareTesting_{{ $itemQuestion->id }}_perbaiki">Perbaiki / <i>Repair</i></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="softwareTesting[{{ $itemQuestion->id }}]" id="softwareTesting_{{ $itemQuestion->id }}_mengganti" value="mengganti" {{ $answer->answer == 'mengganti' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="softwareTesting_{{ $itemQuestion->id }}_mengganti">Mengganti / <i>Replace</i></label>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">REKOMENDASI PENGGANTIAN BARU / RECOMMENDATION OF NEW REPLACEMENT</h6>
                            </div>
                            <div class="card-body">
                                <div class="col-xl-12">
                                    <textarea name="recommendation_replacement" class="form-control" rows="5" id="" required>{{ $answerSurveillanceQuestionnaires->where('questionnaire_id', 0)->first()->answer ?? '' }}</textarea>
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