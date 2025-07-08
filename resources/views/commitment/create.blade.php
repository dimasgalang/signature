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
                    <h1 class="h3 mb-0 text-gray-800">Create Commitment</h1>
                </div>
                

                <!-- Approach -->
                <form method="post" action="{{ route('commitment.store') }}" enctype="multipart/form-data">
                 <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Form Create Commitment</h6>
                            </div>
                            <div class="card-body">
                                    @csrf
                                    <input class="form-control" type="hidden" id="id" name="id">
                                    <div>
                                        <label for="document_name">Document Name</label>
                                        @if(((substr($commitment?->document_name,3,5)) != date('y') . date('n') . date('d')))
                                        <input class="form-control" type="text" id="document_name" name="document_name" value="{{ 'CCU' . date('y') . date('n') . date('d') . str_pad(1,4,'0',STR_PAD_LEFT) }}" readonly>
                                        @elseif(((substr($commitment?->document_name,3,5)) == (date('y') . date('n') . date('d'))) || ($commitment?->document_name ?? ''))
                                        <input class="form-control" type="text" id="document_name" name="document_name" value="{{ 'CCU' . date('y') . date('n') . date('d') . str_pad(intval(substr($commitment?->document_name,-4)) + 1,4,'0',STR_PAD_LEFT) }}" readonly>
                                        @else
                                        <input class="form-control" type="text" id="document_name" name="document_name" value="{{ 'CCU' . date('y') . date('n') . date('d') . str_pad(1,4,'0',STR_PAD_LEFT) }}" readonly>
                                        @endif
                                    </div>
                                    <br>
                                    <div>
                                        <label>Name :</label>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                    <select class="form-control npk" id="npk" name="npk" >
                                                        <option></option>
                                                        @foreach ($users as $user )
                                                            <option value="{{ $user->NPK }}">{{ $user->NPK }} - {{ $user->NAMA_KARYAWAN }}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div>
                                        <label>Date :</label>
                                        <input class="form-control" type="date" id="date" name="date" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <input class="form-control" type="hidden" id="name" name="name" value="" required>
                                    <input class="form-control" type="hidden" id="dept" name="dept" value="" required>
                                    <input class="form-control" type="hidden" id="position" name="position" value="" required>
                                    <input class="form-control" type="hidden" id="joining_date" name="joining_date" value="" required>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <button id="submit" type="submit" class="btn btn-primary btn-block">Create</button>
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
    $('.npk').select2({
          allowClear: true,
          placeholder: 'Choose Employee',
    });
    $(document).on("change", "#npk", function(e){
            e.preventDefault();
            var npk = $(this).val();
            if (npk) {
                $.ajax({
                    url: '/commitment/fetchEmployee/'+npk,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#name').val(data[0].NAMA_KARYAWAN);
                        $('#dept').val(data[0].DEPARTEMENT);
                        $('#position').val(data[0].BAG);
                        $('#joining_date').val(data[0].TMK);
                    }
                });
            } else{
                $('#name').empty();
                $('#name').attr('disabled','disabled');
                $('#dept').empty();
                $('#dept').attr('disabled','disabled');
                $('#position').empty();
                $('#position').attr('disabled','disabled');
                $('#joining_date').empty();
                $('#joining_date').attr('disabled','disabled');
            }
        });
</script>
</html>