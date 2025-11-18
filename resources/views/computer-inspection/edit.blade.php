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
                    <h1 class="h3 mb-0 text-gray-800">Update Computer Inspection</h1>
                </div>
                

                <!-- Approach -->
                <form method="post" action="{{ route('computer-inspection.update') }}" enctype="multipart/form-data">
                @csrf
                {{-- Other Request --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Inspection Information</h6>
                            </div>
                            <input class="form-control" type="hidden" id="computer_inspection_id" name="computer_inspection_id" value="{{ $computerInspection->computer_inspection_id }}" readonly>
                            <div class="card-body">
                                <div id="employmentIdentity">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <label>Document Name :</label>
                                            <input class="form-control" type="text" id="document_name" name="document_name" value="{{ $computerInspection->computer_inspection_id }}" readonly>
                                        </div>
                                        <div class="col-xl-6">
                                            <label>Person In Charge :</label>
                                            <input class="form-control" type="text" id="name" name="name" value="{{ Auth::user()->name . ' - ' . Auth::user()->dept }}" readonly>
                                            <input class="form-control" type="hidden" id="person_in_charge" name="person_in_charge" value="{{ Auth::user()->id }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="computerInspection">
                    <div class="row">
                        {{-- Hardware Device --}}
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 justify-content-between d-flex align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Form Checklist Computer Inspection</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <label>Date of Inspection :</label>
                                            <input type="hidden" name="id" value="{{ $computerInspection->id }}">
                                            <input class="form-control" type="date" id="dateofinspect" name="date_of_inspection" value="{{$computerInspection->date_of_inspection}}" readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Device Name :</label>
                                            <input class="form-control" type="text" id="deviceName" name="device_name" value="{{$computerInspection->assets_number}}" readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label>User :</label>
                                            <input class="form-control" type="text" id="user_0" name="user" value="{{$computerInspection->user}} " readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Location :</label>
                                            <input class="form-control" type="text" id="location_0" name="location" value="{{$computerInspection->location}}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                @foreach ($hardwareCheckItems as $hardcheckItem )
                                                    <div class="col-xl-4 mt-3">
                                                        <label><b>{{ $hardcheckItem->questionnaire_items }}</b> :</label>
                                                        <div>
                                                            @foreach($hardwareAnswerItems as $key => $value)
                                                                @if($value->questionnaire_id == $hardcheckItem->id)
                                                                    <input type="radio" id="check_item_{{ $hardcheckItem->id }}_yes" name="computer_inspection[check_item][{{ $hardcheckItem->id }}]" value="true" {{ $value->answer == 'true' ? 'checked' : '' }}>
                                                                    <label class="pr-3" for="check_item_{{ $hardcheckItem->id }}_yes">Yes</label>
                                                                    <input type="radio" id="check_item_{{ $hardcheckItem->id }}_no" name="computer_inspection[check_item][{{ $hardcheckItem->id }}]" value="false" {{ $value->answer == 'false' ? 'checked' : '' }}>
                                                                    <label for="check_item_{{ $hardcheckItem->id }}_no">No</label>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                @foreach ($softwareCheckItems as $softcheckItem )
                                                    <div class="col-xl-4 mt-3">
                                                        <label><b>{{ $softcheckItem->questionnaire_items }}</b> :</label>
                                                        <div>
                                                            @foreach($softwareAnswerItems as $key => $value)
                                                            {{-- {{$value-}} --}}
                                                                @if($value->questionnaire_id == $softcheckItem->id)
                                                                    <input type="radio" id="check_item_{{ $softcheckItem->id }}_yes" name="computer_inspection[check_item][{{ $softcheckItem->id }}]" value="true" {{ $value->answer == 'true' ? 'checked' : '' }}>
                                                                    <label class="pr-3" for="check_item_{{ $softcheckItem->id }}_yes">Yes</label>
                                                                    <input type="radio" id="check_item_{{ $softcheckItem->id }}_no" name="computer_inspection[check_item][{{ $softcheckItem->id }}]" value="false" {{ $value->answer == 'false' ? 'checked' : '' }}>
                                                                    <label for="check_item_{{ $softcheckItem->id }}_no">No</label>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-2 mt-3">
                                            <label><b>Kondisi : </b></label>
                                            <div>
                                                @foreach($computerConditions as $condition)
                                                    <div class="form-check row">
                                                        <div class="col-md-4">
                                                            <input class="form-check-input" type="radio" name="computer_inspection[condition]" value="true" id="condition_{{ $condition->id }}" {{ $conditionAnswerItem->answer == 'true' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="condition_{{ $condition->id }}">
                                                                Baik
                                                            </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input class="form-check-input" type="radio" name="computer_inspection[condition]" value="false" id="condition_{{ $condition->id }}" {{ $conditionAnswerItem->answer == 'false' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="condition_{{ $condition->id }}">
                                                                Perbaikan / Servis
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 mt-3">
                                            <label><b>Additional Notes :</b></label>
                                            <textarea class="form-control" rows="3" placeholder="Additional Notes" id="additional-notes" name="computer_inspection[additional_notes]">{{$conditionAnswerItem->notes}}</textarea>
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

    $(document).ready(function() {
        // Inisialisasi Select2
        $('.device_name').select2({
            allowClear: true,
            placeholder: 'Choose Device Name',
        });


        // });

        $(document).on('click', '#remove-computer-inspection', function() {
            $(this).parent().parent().parent().remove();
        });

        // $('#additional-notes').hide();

        // // Toggle date period based on checkbox state
        // $('input[name="computer_inspection[condition]"]').change(function() {
        //     if (selectedValue === 'Baik') {
        //         // Show with slide down animation
        //         $('#additional-notes').slideUp(400);
        //     } else {
        //         // Hide with slide up animation
        //         $('#additional-notes').slideDown(400);
        //     }
        // });
    });

    // $(document).on("change", ".device_name", function(e){
    //         e.preventDefault();
    //         var $sel = $(this);
    //         var device_name = $sel.val();
    //         var idx = $sel.data('index');

    //         var $container = $sel.closest('.card-body');

    //         if (device_name) {
    //             $.ajax({
    //                 url: '/computer-inspection/fetchComputerInfo/' + device_name,
    //                 type: "GET",
    //                 dataType: "json",
    //                 success:function(data) {
    //                     $container.find('input[name="computer_inspection[' + idx + '][location]"]').val(data.data.location);
    //                     $container.find('input[name="computer_inspection[' + idx + '][user]"]').val(data.data.user);

    //                 }
    //             });
    //         } else{
    //             $container.find('input[name="computer_inspection[' + idx + '][location]"]').val('tidak ada data');

    //         }
    //     });
</script>
</html>