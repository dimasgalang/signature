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
                    <h1 class="h3 mb-0 text-gray-800">Create Finger Inspection</h1>
                </div>
                

                <!-- Approach -->
                <form method="post" action="{{ route('finger-inspection.store') }}" enctype="multipart/form-data">
                @csrf
                {{-- Other Request --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Finger Inspection Information</h6>
                            </div>
                            <input class="form-control" type="hidden" id="finger_inspection_id" name="finger_inspection_id" value="{{ $newIdfingerInspection }}" readonly>
                            <div class="card-body">
                                <div id="employmentIdentity">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <label>Document Name :</label>
                                            <input class="form-control" type="text" id="document_name" name="document_name" value="{{ $newIdfingerInspection }}" readonly>
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
                                    <div>
                                        <a class="btn btn-sm btn-primary" id="add-finger-inspection"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <label>Date of Inspection :</label>
                                            <input class="form-control" type="date" id="dateofinspect" name="finger_inspection[0][date_of_inspection]" >
                                        </div>
                                        <div class="col-xl-4">
                                            <label>Machine Number :</label>
                                            <select class="form-control machine_number" data-index="0" name="finger_inspection[0][machine_number]" >
                                                <option></option>
                                                @foreach ($fingerDocs as $finger )
                                                    <option value="{{ $finger->assets_number }}">{{ $finger->item_name }} - {{ $finger->assets_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach ($fingerCheckItems as $fingerCheckItem )
                                            <div class="col-xl-3 mt-3">
                                                <label><b>{{ $fingerCheckItem->questionnaire_items }}</b> :</label>
                                                <div>
                                                    <input type="radio" id="check_item_{{ $fingerCheckItem->id }}_yes" name="finger_inspection[0][check_item][{{ $fingerCheckItem->id }}]" value="true" required>
                                                    <label class="pr-3" for="check_item_{{ $fingerCheckItem->id }}_yes">Yes</label>
                                                    <input type="radio" id="check_item_{{ $fingerCheckItem->id }}_no" name="finger_inspection[0][check_item][{{ $fingerCheckItem->id }}]" value="false" required>
                                                    <label for="check_item_{{ $fingerCheckItem->id }}_no">No</label>
                                                </div>
                                            </div>
                                        @endforeach
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
        $('.device_name').select2({
            allowClear: true,
            placeholder: 'Choose Device Name',
        });

        $('#add-finger-inspection').on('click', function() {
            let fingerInspection = document.getElementById('fingerInspection');
            let fingerInspectionIndex = fingerInspection.children.length;
            
            $("#fingerInspection").append(`<div class="row">
                        {{-- Hardware Device --}}
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 justify-content-between d-flex align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Form Checklist Finger Inspection</h6>
                                    <div>
                                        <a class="btn btn-sm btn-danger" id="remove-finger-inspection"><i class="fas fa-minus"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <label>Date of Inspection :</label>
                                            <input class="form-control" type="date" id="dateofinspect" name="finger_inspection[${fingerInspectionIndex}][date_of_inspection]" >
                                        </div>
                                        <div class="col-xl-4">
                                            <label>Machine Number :</label>
                                            <select class="form-control machine_number" data-index="${fingerInspectionIndex}" name="finger_inspection[${fingerInspectionIndex}][machine_number]" >
                                                <option></option>
                                                @foreach ($fingerDocs as $finger )
                                                    <option value="{{ $finger->assets_number }}">{{ $finger->item_name }} - {{ $finger->assets_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach ($fingerCheckItems as $fingerCheckItem )
                                            <div class="col-xl-3 mt-3">
                                                <label><b>{{ $fingerCheckItem->questionnaire_items }}</b> :</label>
                                                <div>
                                                    <input type="radio" id="check_item_{{ $fingerCheckItem->id }}_yes" name="finger_inspection[${fingerInspectionIndex}][check_item][{{ $fingerCheckItem->id }}]" value="true" required>
                                                    <label class="pr-3" for="check_item_{{ $fingerCheckItem->id }}_yes">Yes</label>
                                                    <input type="radio" id="check_item_{{ $fingerCheckItem->id }}_no" name="finger_inspection[${fingerInspectionIndex}][check_item][{{ $fingerCheckItem->id }}]" value="false" required>
                                                    <label for="check_item_{{ $fingerCheckItem->id }}_no">No</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`);
            $('.machine_number').select2({
                allowClear: true,
                placeholder: 'Choose Machine Number',
            });


        });

        $(document).on('click', '#remove-finger-inspection', function() {
            $(this).parent().parent().parent().remove();
        });

        // $('#additional-notes').hide();

        // // Toggle date period based on checkbox state
        // $('input[name="finger_inspection[0][condition]"]').change(function() {
        //     if (selectedValue === 'Baik') {
        //         // Show with slide down animation
        //         $('#additional-notes').slideUp(400);
        //     } else {
        //         // Hide with slide up animation
        //         $('#additional-notes').slideDown(400);
        //     }
        // });
    });

    // $(document).on("change", ".machine_number", function(e){
    //         e.preventDefault();
    //         var $sel = $(this);
    //         var device_name = $sel.val();
    //         var idx = $sel.data('index');

    //         var $container = $sel.closest('.card-body');

    //         if (device_name) {
    //             $.ajax({
    //                 url: '/finger-inspection/fetchComputerInfo/' + device_name,
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