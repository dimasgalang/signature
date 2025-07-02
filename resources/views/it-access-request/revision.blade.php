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
                    <h1 class="h3 mb-0 text-gray-800">Approval IT Access Request</h1>
                </div>
                

                <!-- Approach -->
                <form method="post" action="{{ route('it-access-request.approvedItem') }}" enctype="multipart/form-data">
                @csrf
                {{-- Other Request --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Employment Identity</h6>
                            </div>
                            <input class="form-control" type="hidden" id="access_request_id" name="access_request_id" value="{{ $accessRequest->id_request_access }}">
                            <div class="card-body">
                                <div id="employmentIdentity">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <label>Date of Request :</label>
                                            <input class="form-control" type="date" id="date_of_request" name="date_of_request" value="{{ $accessRequest->date_of_request }}">
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Document Name :</label>
                                            <input class="form-control" type="text" id="document_name" name="document_name" value="{{ $accessRequest->document_name }}">
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Name :</label>
                                            <input class="form-control" type="text" id="name" name="name" value="{{ $accessRequest->preparer_name }}">
                                            <input class="form-control" type="hidden" id="department" name="department" value="{{ $accessRequest->preparer_dept }}">
                                            <input class="form-control" type="hidden" id="employee_id" name="employee_id" value="{{ $accessRequest->employee_id }}">
                                        </div>
                                        <div class="col-xl-3">
                                            <label>Need Approve:</label>
                                            <input class="form-control" type="text" id="approval_it_id" name="approval_it_id" value="{{ $accessRequest->need_approve }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                 <div class="row">
                    {{-- Hardware Device --}}
                    @if (count($hardwareRequests) > 0)
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Form Create Hardware Device Request</h6>
                            </div>
                            <div class="card-body">
                                    <div id="hardwareDevice">
                                        @foreach ($hardwareRequests as $key => $hardwareRequest)
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <label>Hardware Device :</label>
                                                    <input class="form-control" type="hidden" id="id" name="hardware_device[{{$key}}][id]" value="{{$hardwareRequest->id}}">
                                                    <select class="form-control hardware_id" id="hardware_id" name="hardware_device[{{$key}}][hardware_name]">
                                                        <option></option>
                                                        <option value="komputer" {{ $hardwareRequest->hardware_device == 'Komputer' ? 'selected' : ''}}>Komputer</option>
                                                        <option value="router" {{ $hardwareRequest->hardware_device == 'Router' ? 'selected' : ''}}>Router</option>
                                                        <option value="printer" {{ $hardwareRequest->hardware_device == 'Printer' ? 'selected' : ''}}>Printer</option>
                                                        <option value="smart_it" {{ $hardwareRequest->hardware_device == 'Smart IT' ? 'selected' : ''}}>Smart IT</option>
                                                        {{-- @foreach ($items as $item )
                                                            <option value="{{ $item->barang_code }}">{{ $item->barang_code }} - {{ $item->barang_name }}</option>
                                                        @endforeach --}}
                                                    </select>
                                                </div>
                                                <div class="col-xl-3 mb-2">
                                                    <label>Quantity :</label>
                                                    <input class="form-control" type="number" id="qty" name="hardware_device[{{$key}}][quantity]" value="{{ $hardwareRequest->qty }}">
                                                </div>
                                                @if (Auth::user()->id == '1')
                                                    <div class="col-xl-3 mb-2">
                                                        {{-- buatkan select untuk approve dan tolak --}}
                                                        <label>Status</label>
                                                        <select class="form-control status" id="status" name="hardware_device[{{$key}}][status]">
                                                            <option>select status</option>
                                                            <option value="true">Approved</option>
                                                            <option value="false">Rejected</option>
                                                        </select>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- File Folder Access --}}
                    @if (count($fileFolderAccesses) > 0)
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Form Create File Folder Access Request</h6>
                            </div>
                            <div class="card-body">
                                <div id="fileFolderAccess">
                                    @foreach ($fileFolderAccesses as $key => $fileFolderAccess)
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <label>File/Folder Access :</label>
                                                <input class="form-control" type="hidden" id="id" name="file_folder_access[{{$key}}][id]" value="{{$fileFolderAccess->id}}">
                                                <input class="form-control" type="text" id="file_folder_access" value="{{ $fileFolderAccess->file_folder_name }}" name="file_folder_access[{{$key}}][file_folder_access]">
                                            </div>
                                            {{-- buat checkbox read/white yang bisa dickeck dua duanya--}}
                                            <div class="col-xl-3">
                                                <label>Access Rights :</label>
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check input mr-2" type="checkbox" id="read_access" name="file_folder_access[{{$key}}][read]" value="{{ $fileFolderAccess->read }}" {{ $fileFolderAccess->read == 'true' ? 'checked' : '' }} onclick="return false;">
                                                    <label class="form-check-label" for="read_access">Read</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check input mr-2" type="checkbox" id="write_access" name="file_folder_access[{{$key}}][write]" value="{{ $fileFolderAccess->write }}" {{ $fileFolderAccess->write == 'true' ? 'checked' : '' }} onclick="return false;">
                                                    <label class="form-check-label" for="write_access">Write</label>
                                                </div>
                                            </div>
                                            @if (Auth::user()->id == '1')
                                                <div class="col-xl-3 mb-2">
                                                    {{-- buatkan select untuk approve dan tolak --}}
                                                    <label>Status</label>
                                                    <select class="form-control status" id="status" name="file_folder_access[{{$key}}][status]">
                                                        <option>select status</option>
                                                        <option value="true">Approved</option>
                                                        <option value="false">Rejected</option>
                                                    </select>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="row">
                    {{-- Company Domain User Account --}}
                    @if (count($userAccounts) > 0)
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Form Create Company Domain User Account</h6>
                            </div>
                            <div class="card-body">
                                    <div id="userAccount">
                                        @foreach ($userAccounts as $key => $userAccount)
                                            <div class="row">
                                                <div class="col-xl-8">
                                                    <label>Account Name :</label>
                                                    <input class="form-control" type="hidden" id="id" name="user_account[{{$key}}][id]" value="{{$userAccount->id}}">
                                                    <input class="form-control" type="text" id="account_name" name="user_account[{{$key}}][account_name]" value="{{ $userAccount->account_name }}">
                                                </div>
                                                @if (Auth::user()->id == '1')
                                                    <div class="col-xl-4 mb-2">
                                                        {{-- buatkan select untuk approve dan tolak --}}
                                                        <label>Status</label>
                                                        <select class="form-control status" id="status" name="user_account[{{$key}}][status]">
                                                            <option>select status</option>
                                                            <option value="true">Approved</option>
                                                            <option value="false">Rejected</option>
                                                        </select>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Email Address --}}
                    @if (count($emailAccount) > 0)
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Form Create Email Address</h6>
                            </div>
                            <div class="card-body">
                                <div id="emailAddress">
                                    @foreach ($emailAccount as $key => $emailAddress)
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <label>Email Address :</label>
                                                <input class="form-control" type="hidden" id="id" name="email_address[{{$key}}][id]" value="{{$emailAddress->id}}">
                                                <input class="form-control" type="text" id="email_address" name="email_address[{{$key}}][email_address]" value="{{ $emailAddress->email_address }}">
                                            </div>
                                            <div class="col-xl-3">
                                                <label>Purpose :</label>
                                                <textarea class="form-control" id="purpose" name="email_address[{{$key}}][purpose]">{{ $emailAddress->purpose }}</textarea>
                                            </div>
                                            <div class="col-xl-3">
                                                <label>Restriction :</label>
                                                <textarea class="form-control" id="restriction" name="email_address[{{$key}}][restriction]">{{ $emailAddress->restriction }}</textarea>
                                            </div>

                                            @if (Auth::user()->id == '1')
                                                <div class="col-xl-3 mb-2">
                                                    {{-- buatkan select untuk approve dan tolak --}}
                                                    <label>Status</label>
                                                    <select class="form-control status" id="status" name="email_address[{{$key}}][status]">
                                                        <option>select status</option>
                                                        <option value="true">Approved</option>
                                                        <option value="false">Rejected</option>
                                                    </select>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="row">
                    {{-- Application Program Access Request --}}
                    @if (count($applicationPrograms) > 0)
                        <div class="col-lg-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Form Create Application Program Access Request</h6>
                                </div>
                                <div class="card-body">
                                        <div id="applicationProgram">
                                            @foreach ($applicationPrograms as $key => $applicationProgram)
                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <label>Application Name :</label>
                                                        <input class="form-control" type="hidden" id="id" name="application_program[{{$key}}][id]" value="{{$applicationProgram->id}}">
                                                        <input class="form-control" type="text" id="application_name" name="application_program[{{$key}}][application_name]" value="{{ $applicationProgram->application_name }}">
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <label>Login Name :</label>
                                                        <input class="form-control" type="text" id="login_name" name="application_program[{{$key}}][login_name]" value="{{ $applicationProgram->login_name }}">
                                                    </div>
                                                    @if (Auth::user()->id == '1')
                                                        <div class="col-xl-4 mb-2">
                                                            {{-- buatkan select untuk approve dan tolak --}}
                                                            <label>Status</label>
                                                            <select class="form-control status" id="status" name="application_program[{{$key}}][status]">
                                                                <option>select status</option>
                                                                <option value="true">Approved</option>
                                                                <option value="false">Rejected</option>
                                                            </select>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- Internet Access Request --}}
                    @if (count($internetAccess) > 0)
                        <div class="col-lg-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Form Create Internet Access Request</h6>
                                </div>
                                <div class="card-body">
                                    <div id="internetAccess">
                                        @foreach ($internetAccess as $key => $internetAccess)
                                            <div class="row">
                                                <div class="col-xl-4">
                                                    <label>Purpose :</label>
                                                    <input class="form-control" type="hidden" id="id" name="internet_access[{{$key}}][id]" value="{{$internetAccess->id}}">
                                                    <textarea class="form-control" id="purpose" name="internet_access[{{$key}}][purpose]">{{ $internetAccess->purpose }}</textarea>
                                                </div>
                                                <div class="col-xl-4">
                                                    <label>Restriction :</label>
                                                    <textarea class="form-control" id="restriction" name="internet_access[{{$key}}][restriction]">{{ $internetAccess->restriction }}</textarea>
                                                </div>
                                                @if (Auth::user()->id == '1')
                                                    <div class="col-xl-4 mb-2">
                                                        {{-- buatkan select untuk approve dan tolak --}}
                                                        <label>Status</label>
                                                        <select class="form-control status" id="status" name="internet_access[{{$key}}][status]">
                                                            <option>select status</option>
                                                            <option value="true">Approved</option>
                                                            <option value="false">Rejected</option>
                                                        </select>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Other Request --}}
                @if (count($otherRequests) > 0)
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Form Create Other Request</h6>
                                </div>
                                <div class="card-body">
                                    <div id="otherRequest">
                                        @foreach ($otherRequests as $key => $otherRequest)
                                            <div class="row">
                                                <div class="col-xl-3">
                                                    <label>Other Request :</label>
                                                    <input class="form-control" type="hidden" id="id" name="other_request[{{$key}}][id]" value="{{$otherRequest->id}}">
                                                    <input class="form-control" type="text" id="other_request" name="other_request[{{$key}}][other_request]" value="{{ $otherRequest->other_request }}">
                                                </div>
                                                <div class="col-xl-3">
                                                    <label>Purpose :</label>
                                                    <textarea class="form-control" id="purpose" name="other_request[{{$key}}][purpose]">{{ $otherRequest->purpose }}</textarea>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label>Restriction :</label>
                                                    <textarea class="form-control" id="restriction" name="other_request[{{$key}}][restriction]">{{ $otherRequest->restriction }}</textarea>
                                                </div>
                                                @if (Auth::user()->id == '1')
                                                    <div class="col-xl-3 mb-2">
                                                        {{-- buatkan select untuk approve dan tolak --}}
                                                        <label>Status</label>
                                                        <select class="form-control status" id="status" name="other_request[{{$key}}][status]">
                                                            <option>select status</option>
                                                            <option value="true">Approved</option>
                                                            <option value="false">Rejected</option>
                                                        </select>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (Auth::user()->id == '1')
                <div class="row">
                    <div class="col-12">
                        <button id="submit" type="submit" class="btn btn-primary btn-block">Approved</button>
                    </div>
                </div>
                @endif
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
            readOnly: true,
            placeholder: 'Choose Hardware Device',
        });

        $('.approval_hod_id').select2({
            allowClear: true,
            placeholder: 'Choose Your HOD',
        });

        $('.add-hardware-device').on('click', function() {
            let hardwareDevice = document.getElementById('hardwareDevice');
            let hardwareDeviceIndex = hardwareDevice.children.length;
            $("#hardwareDevice").append(`<div class="row"><div class="col-xl-6"><label>Hardware Device :</label><select class="form-control hardware_id" id="hardware_id" name="hardware_device[${hardwareDeviceIndex}][hardware_name]"><option></option><option>Komputer</option><option>Router</option><option>Printer</option><option>Smart IT</option></select></div><div class="col-xl-4"><label>Quantity :</label><input class="form-control" type="number" id="qty" name="hardware_device[${hardwareDeviceIndex}][quantity]" ></div><div class="col-xl-2"><label></label><button type="button" class="btn btn-danger btn-block removeThis">Remove</button></div></div>`);
            $('.hardware_id').select2({
                allowClear: true,
                placeholder: 'Choose Hardware Device',
            });
        });

        $('.add-file-folder-access').on('click', function() {
            let fileFolderAccess = document.getElementById('fileFolderAccess');
            let fileFolderAccessIndex = fileFolderAccess.children.length;
            $("#fileFolderAccess").append(`<div class="row"><div class="col-xl-6"><label>File/Folder Access :</label><input class="form-control" type="text" id="file_folder_access" name="file_folder_access[${fileFolderAccessIndex}][file_folder_access]" placeholder="Enter File/Folder Access"></div><div class="col-xl-4"><label>Access Rights :</label><br><div class="form-check form-check-inline"><input class="form-check input mr-2" type="checkbox" id="read_access" name="file_folder_access[${fileFolderAccessIndex}][read]" value="true"><label class="form-check-label" for="read_access">Read</label></div><div class="form-check form-check-inline"><input class="form-check input mr-2" type="checkbox" id="write_access" name="file_folder_access[${fileFolderAccessIndex}][write]" value="true"><label class="form-check-label" for="write_access">Write</label></div></div><div class="col-xl-2"><label></label><button type="button" class="btn btn-danger btn-block removeThis">Remove</button></div></div>`);
        });

        $('.add-user-account').on('click', function() {
            let userAccount = document.getElementById('userAccount');
            let userAccountIndex = userAccount.children.length;
            $("#userAccount").append(`<div class="row"><div class="col-xl-10"><label>Account Name :</label><input class="form-control" type="text" id="account_name" name="user_account[${userAccountIndex}][account_name]"placeholder="Enter Account Name" ></div><div class="col-xl-2"><label></label><button type="button" class="btn btn-danger btn-block removeThis">Remove</button></div></div>`);
        });

        $('.add-email-address').on('click', function() {
            let emailAddress = document.getElementById('emailAddress');
            let emailAddressIndex = emailAddress.children.length;
            $("#emailAddress").append(`
            <div class="row"><div class="col-xl-4"><label>Email Address :</label><input class="form-control" type="text" id="email_address" name="email_address[${emailAddressIndex}][email_address]" placeholder="Enter Account Name" ></div><div class="col-xl-3"><label>Purpose :</label><textarea class="form-control" id="purpose" name="email_address[${emailAddressIndex}][purpose]" placeholder="Enter Purpose" ></textarea></div><div class="col-xl-3"><label>Restriction :</label><textarea class="form-control" id="restriction" name="email_address[${emailAddressIndex}][restriction]" placeholder="Enter Restriction" ></textarea></div><div class="col-xl-2"><label></label><button type="button" class="btn btn-danger btn-block removeThis">Remove</button></div></div>
            `);
        });

        $('.add-application-program').on('click', function() {
            let applicationProgram = document.getElementById('applicationProgram');
            let applicationProgramIndex = applicationProgram.children.length;
            $("#applicationProgram").append(`
            <div class="row"><div class="col-xl-5"><label>Application Name :</label><input class="form-control" type="text" id="application_name" name="application_program[${applicationProgramIndex}][application_name]" ></div><div class="col-xl-5"><label>Login Name :</label><input class="form-control" type="text" id="login_name" name="application_program[${applicationProgramIndex}][login_name]" ></div><div class="col-xl-2"><label></label><button type="button" class="btn btn-danger btn-block removeThis">Remove</button></div></div>
            `);
        });

        $('.add-internet-access').on('click', function() {
            let internetAccess = document.getElementById('internetAccess');
            let internetAccessIndex = internetAccess.children.length;
            $("#internetAccess").append(`
            <div class="row"><div class="col-xl-5"><label>Purpose :</label><textarea class="form-control" id="purpose" name="internet_access[${internetAccessIndex}][purpose]" placeholder="Enter Purpose" ></textarea></div><div class="col-xl-5"><label>Restriction :</label><textarea class="form-control" id="restriction" name="internet_access[${internetAccessIndex}][restriction]" placeholder="Enter Restriction" ></textarea></div><div class="col-xl-2"><label></label><button type="button" class="btn btn-danger btn-block removeThis">Remove</button></div></div>
            `);
        });

        $('.add-other-request').on('click', function() {
            let otherRequest = document.getElementById('otherRequest');
            let otherRequestIndex = otherRequest.children.length;
            $("#otherRequest").append(`
            <div class="row"><div class="col-xl-4"><label>Other Request :</label><input class="form-control" type="text" id="other_request" name="other_request[${otherRequestIndex}][other_request]" placeholder="Enter Other Request" ></div><div class="col-xl-3"><label>Purpose :</label><textarea class="form-control" id="purpose" name="other_request[${otherRequestIndex}][purpose]" placeholder="Enter Purpose" ></textarea></div><div class="col-xl-3"><label>Restriction :</label><textarea class="form-control" id="restriction" name="other_request[${otherRequestIndex}][restriction]" placeholder="Enter Restriction" ></textarea></div><div class="col-xl-2"><label></label><button type="button" class="btn btn-danger btn-block removeThis">Remove</button></div></div>
            `);
        });

        $(document).on('click', '.removeThis', function() {
            $(this).parent().parent().remove();
        });

    });
</script>
</html>