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
                                        <input class="form-control" type="text" id="document_name" name="document_name">
                                        <input class="form-control" type="hidden" id="base64" name="base64">
                                    </div>
                                    <br>
                                    <div>
                                        <label for="file">File PDF :</label>
                                        <input type="file" id="file" name="file" accept=".pdf" >
                                    </div>
                                    <br>
                                    <div id="approvalInput">
                                        <label>Approval Name :</label>
                                        <div class="row">
                                            <div class="col-xl-9">
                                                <select class="form-control approval_id" id="approval_id" name="approval_id[]" >
                                                    <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-3">
                                                <button type="button" class="btn btn-primary btn-block" onclick="addRecords()">Add</button>
                                            </div>
                                        </div><br>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-block">Create</button>
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
                                <iframe id="pdfPreview" width="100%" height="500px"></iframe>
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

<script type="module" src='https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.0.269/pdf.min.mjs'></script>
<script type="module" src='https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.0.269/pdf.worker.min.mjs'></script>
<script src="https://cdn.jsdelivr.net/npm/interactjs@1.10.20/dist/interact.min.js"></script>

<script>
    document.querySelector("#file").addEventListener("change", async function(e){
        var file = e.target.files[0]
        const toBase64 = file => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = reject;
        });
        console.log(await toBase64(file));

        document.getElementById('base64').value = await toBase64(file);
        if (file.type === "application/pdf") {
            const fileURL = URL.createObjectURL(file);
            document.getElementById('pdfPreview').src = fileURL;
        } else {
            alert("Please upload a valid PDF file.");
        }
    })
</script>
<script type="text/javascript">
    function addRecords() {
        $("#approvalInput").append('<div class="row"><br><br><div class="col-xl-9"><select class="form-control approval_id" id="approval_id" name="approval_id[]">@foreach($users as $user)<option value="{{ $user->id }}">{{ $user->name }}</option>@endforeach</select></div><div class="col-xl-3"><button type="button" class="btn btn-danger btn-block removeThis">Remove</button></div></div>');
        $('.approval_id').select2({
            allowClear: true,
            placeholder: 'Choose Approval',
        });
    }

    $(document).on('click', '.removeThis', function() {
        $(this).parent().parent().remove();
    })
</script>
<script type="text/javascript">
    $('.approval_id').select2({
          allowClear: true,
          placeholder: 'Choose Approval',
    });
</script>
</html>