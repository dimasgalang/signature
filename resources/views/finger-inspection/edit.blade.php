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
                    <h1 class="h3 mb-0 text-gray-800">Update Finger Inspection</h1>
                </div>
                

                <!-- Approach -->
                <form method="post" action="{{ route('finger-inspection.update') }}" enctype="multipart/form-data">
                @csrf
                {{-- Other Request --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Inspection Information</h6>
                            </div>
                            <input class="form-control" type="hidden" id="finger_inspection_id" name="finger_inspection_id" value="{{ $fingerInspection->finger_inspection_id }}" readonly>
                            <div class="card-body">
                                <div id="employmentIdentity">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <label>Document Name :</label>
                                            <input class="form-control" type="text" id="document_name" name="document_name" value="{{ $fingerInspection->finger_inspection_id }}" readonly>
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

                <div id="fingerInspection">
                    <div class="row">
                        {{-- Hardware Device --}}
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 justify-content-between d-flex align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Form Checklist Finger Inspection</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <label>Date of Inspection :</label>
                                            <input type="hidden" name="id" value="{{ $fingerInspection->id }}">
                                            <input class="form-control" type="date" id="dateofinspect" name="date_of_inspection" value="{{$fingerInspection->date_of_inspection}}" readonly>
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Machine Number :</label>
                                            <input class="form-control" type="text" id="machine_number" name="machine_number" value="{{$fingerInspection->machine_number}}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                @foreach ($fingerCheckItems as $fingerCheckItem )
                                                    <div class="col-xl-3 mt-3">
                                                        <label><b>{{ $fingerCheckItem->questionnaire_items }}</b> :</label>
                                                        <div>
                                                            @foreach($fingerAnswerItems as $key => $value)
                                                                @if($value->questionnaire_id == $fingerCheckItem->id)
                                                                    <input type="radio" id="check_item_{{ $fingerCheckItem->id }}_yes" name="finger_inspection[check_item][{{ $fingerCheckItem->id }}]" value="true" {{ $value->answer == 'true' ? 'checked' : '' }}>
                                                                    <label class="pr-3" for="check_item_{{ $fingerCheckItem->id }}_yes">Yes</label>
                                                                    <input type="radio" id="check_item_{{ $fingerCheckItem->id }}_no" name="finger_inspection[check_item][{{ $fingerCheckItem->id }}]" value="false" {{ $value->answer == 'false' ? 'checked' : '' }}>
                                                                    <label for="check_item_{{ $fingerCheckItem->id }}_no">No</label>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-xl-12 mt-3">
                                            <label><b>Additional Notes :</b></label>
                                            <textarea class="form-control" rows="3" placeholder="Additional Notes" id="additional-notes" name="finger_inspection[additional_notes]">{{$conditionAnswerItem->notes}}</textarea>
                                        </div>
                                    </div> --}}
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
        $('.machine_number').select2({
            allowClear: true,
            placeholder: 'Choose Machine Number',
        });


        // });

        // $(document).on('click', '#remove-finger-inspection', function() {
        //     $(this).parent().parent().parent().remove();
        // });

        // $('#additional-notes').hide();

        // // Toggle date period based on checkbox state
        // $('input[name="finger_inspection[condition]"]').change(function() {
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
    //                 url: '/finger-inspection/fetchFingerInfo/' + device_name,
    //                 type: "GET",
    //                 dataType: "json",
    //                 success:function(data) {
    //                     $container.find('input[name="finger_inspection[' + idx + '][location]"]').val(data.data.location);
    //                     $container.find('input[name="finger_inspection[' + idx + '][user]"]').val(data.data.user);

    //                 }
    //             });
    //         } else{
    //             $container.find('input[name="finger_inspection[' + idx + '][location]"]').val('tidak ada data');

    //         }
    //     });
</script>
</html>