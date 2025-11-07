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
                    <h1 class="h3 mb-0 text-gray-800">Create Computer Inspection</h1>
                </div>
                

                <!-- Approach -->
                <form method="post" action="{{ route('computer-inspection.store') }}" enctype="multipart/form-data">
                @csrf
                {{-- Other Request --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Inspection Information</h6>
                            </div>
                            <input class="form-control" type="hidden" id="computer_inspection_id" name="computer_inspection_id" value="{{ $newIdComputerInspection }}" readonly>
                            <div class="card-body">
                                <div id="employmentIdentity">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <label>Document Name :</label>
                                            <input class="form-control" type="text" id="document_name" name="document_name" value="{{ $newIdComputerInspection }}" readonly>
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
                                    <div>
                                        <a class="btn btn-sm btn-primary" id="add-computer-inspection"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <label>Date of Inspection :</label>
                                            <input class="form-control" type="date" id="dateofinspect" name="computer_inspection[0][date_of_inspection]" >
                                        </div>
                                        <div class="col-xl-4">
                                            <label>Device Name :</label>
                                            <select class="form-control device_name" data-index="0" name="computer_inspection[0][assets_number]" >
                                                <option></option>
                                                @foreach ($computerDocs as $computer )
                                                    <option value="{{ $computer->assets_number }}">{{ $computer->item_name }} - {{ $computer->user }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Location :</label>
                                            <input class="form-control" type="text" id="location_0" name="computer_inspection[0][location]" >
                                            <input class="form-control" type="hidden" id="user_0" name="computer_inspection[0][user]" >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                @foreach ($hardwareCheckItems as $hardcheckItem )
                                                    <div class="col-xl-4 mt-3">
                                                        <label><b>{{ $hardcheckItem->questionnaire_items }}</b> :</label>
                                                        <div>
                                                            <input type="radio" id="check_item_{{ $hardcheckItem->id }}_yes" name="computer_inspection[0][check_item][{{ $hardcheckItem->id }}]" value="true" required>
                                                            <label class="pr-3" for="check_item_{{ $hardcheckItem->id }}_yes">Yes</label>
                                                            <input type="radio" id="check_item_{{ $hardcheckItem->id }}_no" name="computer_inspection[0][check_item][{{ $hardcheckItem->id }}]" value="false" required>
                                                            <label for="check_item_{{ $hardcheckItem->id }}_no">No</label>
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
                                                            <input type="radio" id="check_item_{{ $softcheckItem->id }}_yes" name="computer_inspection[0][check_item][{{ $softcheckItem->id }}]" value="true" required>
                                                            <label class="pr-3" for="check_item_{{ $softcheckItem->id }}_yes">Yes</label>
                                                            <input type="radio" id="check_item_{{ $softcheckItem->id }}_no" name="computer_inspection[0][check_item][{{ $softcheckItem->id }}]" value="false" required>
                                                            <label for="check_item_{{ $softcheckItem->id }}_no">No</label>
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
                                                            <input class="form-check-input" type="radio" name="computer_inspection[0][condition]" value="true" id="condition_{{ $condition->id }}">
                                                            <label class="form-check-label" for="condition_{{ $condition->id }}">
                                                                Baik
                                                            </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input class="form-check-input" type="radio" name="computer_inspection[0][condition]" value="false" id="condition_{{ $condition->id }}">
                                                            <label class="form-check-label" for="condition_{{ $condition->id }}">
                                                                Perbaikan / Servis
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach 
                                            </div>
                                        </div>
                                    </div>
                                    <textarea class="form-control mt-3" rows="3" placeholder="Additional Notes" id="additional-notes" name="computer_inspection[0][additional_notes]"></textarea>
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
        $('.device_name').select2({
            allowClear: true,
            placeholder: 'Choose Device Name',
        });

        $('#add-computer-inspection').on('click', function() {
            let computerInspection = document.getElementById('computerInspection');
            let computerInspectionIndex = computerInspection.children.length;
            
            $("#computerInspection").append(`<div class="row">
                        {{-- Hardware Device --}}
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 justify-content-between d-flex align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Form Checklist Computer Inspection</h6>
                                    <div>
                                        <a class="btn btn-sm btn-danger" id="remove-computer-inspection"><i class="fas fa-minus"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <label>Date of Inspection :</label>
                                            <input class="form-control" type="date" id="dateofinspect" name="computer_inspection[${computerInspectionIndex}][date_of_inspection]" >
                                        </div>
                                        <div class="col-xl-4">
                                            <label>Device Name :</label>
                                            <select class="form-control device_name" data-index="${computerInspectionIndex}" name="computer_inspection[${computerInspectionIndex}][assets_number]" >
                                                <option></option>
                                                @foreach ($computerDocs as $computer )
                                                    <option value="{{ $computer->assets_number }}">{{ $computer->item_name }} - {{ $computer->user }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Location :</label>
                                            <input class="form-control" type="text" id="location_0" name="computer_inspection[${computerInspectionIndex}][location]" >
                                            <input class="form-control" type="hidden" id="user_0" name="computer_inspection[${computerInspectionIndex}][user]" >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                @foreach ($hardwareCheckItems as $hardcheckItem )
                                                    <div class="col-xl-4 mt-3">
                                                        <label><b>{{ $hardcheckItem->questionnaire_items }}</b> :</label>
                                                        <div>
                                                            <input type="radio" id="check_item_{{ $hardcheckItem->id }}_yes" name="computer_inspection[${computerInspectionIndex}][check_item][{{ $hardcheckItem->id }}]" value="true" required>
                                                            <label class="pr-3" for="check_item_{{ $hardcheckItem->id }}_yes">Yes</label>
                                                            <input type="radio" id="check_item_{{ $hardcheckItem->id }}_no" name="computer_inspection[${computerInspectionIndex}][check_item][{{ $hardcheckItem->id }}]" value="false" required>
                                                            <label for="check_item_{{ $hardcheckItem->id }}_no">No</label>
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
                                                            <input type="radio" id="check_item_{{ $softcheckItem->id }}_yes" name="computer_inspection[${computerInspectionIndex}][check_item][{{ $softcheckItem->id }}]" value="true" required>
                                                            <label class="pr-3" for="check_item_{{ $softcheckItem->id }}_yes">Yes</label>
                                                            <input type="radio" id="check_item_{{ $softcheckItem->id }}_no" name="computer_inspection[${computerInspectionIndex}][check_item][{{ $softcheckItem->id }}]" value="false" required>
                                                            <label for="check_item_{{ $softcheckItem->id }}_no">No</label>
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
                                                            <input class="form-check-input" type="radio" name="computer_inspection[${computerInspectionIndex}][condition]" value="true" id="condition_{{ $condition->id }}">
                                                            <label class="form-check-label" for="condition_{{ $condition->id }}">
                                                                Baik
                                                            </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input class="form-check-input" type="radio" name="computer_inspection[${computerInspectionIndex}][condition]" value="false" id="condition_{{ $condition->id }}">
                                                            <label class="form-check-label" for="condition_{{ $condition->id }}">
                                                                Perbaikan / Servis
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach 
                                            </div>
                                        </div>
                                    </div>
                                    <textarea class="form-control mt-3" rows="3" placeholder="Additional Notes" id="additional-notes" name="computer_inspection[${computerInspectionIndex}][additional_notes]"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>`);
            $('.device_name').select2({
                allowClear: true,
                placeholder: 'Choose Device Name',
            });


        });

        $(document).on('click', '#remove-computer-inspection', function() {
            $(this).parent().parent().parent().remove();
        });

        // $('#additional-notes').hide();

        // // Toggle date period based on checkbox state
        // $('input[name="computer_inspection[0][condition]"]').change(function() {
        //     if (selectedValue === 'Baik') {
        //         // Show with slide down animation
        //         $('#additional-notes').slideUp(400);
        //     } else {
        //         // Hide with slide up animation
        //         $('#additional-notes').slideDown(400);
        //     }
        // });
    });

    $(document).on("change", ".device_name", function(e){
            e.preventDefault();
            var $sel = $(this);
            var device_name = $sel.val();
            var idx = $sel.data('index');

            var $container = $sel.closest('.card-body');

            if (device_name) {
                $.ajax({
                    url: '/computer-inspection/fetchComputerInfo/' + device_name,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $container.find('input[name="computer_inspection[' + idx + '][location]"]').val(data.data.location);
                        $container.find('input[name="computer_inspection[' + idx + '][user]"]').val(data.data.user);

                    }
                });
            } else{
                $container.find('input[name="computer_inspection[' + idx + '][location]"]').val('tidak ada data');

            }
        });
</script>
</html>