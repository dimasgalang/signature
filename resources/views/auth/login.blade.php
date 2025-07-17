<!DOCTYPE html>
<html lang="en">
@include('layout.header')
<body class="bg-gradient-primary">
    @include('sweetalert::alert')

    <div class="container container-center">
        <div class="text-center">
            <img src="{{ asset('img/chutex.svg') }}" style="width: 150px;">
            <h1 class="h4 text-white"><b>PT. Chutex International Indonesia</b></h1>
            <h1 class="h1 text-white mb-4"><b>E-Signature</b></h1>
        </div>
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Sign In with Email</h1>
                            </div>
                            <form class="user" action="{{ route('login') }}" method="post">
                                @csrf
                                @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>	
                                    <strong>{{ $message }}</strong>
                                </div>
                                @endif

                                @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>	
                                    <strong>{{ $message }}</strong>
                                </div>
                                @endif

                                @if ($message = Session::get('warning'))
                                <div class="alert alert-warning alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>	
                                    <strong>{{ $message }}</strong>
                                </div>
                                @endif

                                @if ($message = Session::get('info'))
                                <div class="alert alert-info alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>	
                                    <strong>{{ $message }}</strong>
                                </div>
                                @endif
                                
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="email" name="email"
                                        placeholder="Email" value="{{ old('email') }}">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="password" name="password"
                                        placeholder="Password">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                </div>
                                <hr>
                            </form>
                            <div class="text-center">
                                <a class="small" href="{{ route('register') }}">Don't have account? Register!</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Sign In with ID Card</h1>
                            </div>
                            <div id="reader"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@include('layout.footerscript')
</body>
<script src="{{ asset('vendor/jquery/html5-qrcode.min.js') }}"></script>
<script>
    let html5QRCodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: {
                width: 150,
                height: 150,
            },
            
            supportedScanTypes: [
                // Html5QrcodeScanType.SCAN_TYPE_FILE, 
                Html5QrcodeScanType.SCAN_TYPE_CAMERA
            ],
        }
    );

    function onScanSuccess(decodedText, decodedResult) {
        // redirect ke link hasil scan
        var decoder = decodedResult.decodedText;
        window.location.href = "/login/qrauth?qrcode=" + decoder;
        // window.location.href = decoder;
        html5QRCodeScanner.clear();
    }
    html5QRCodeScanner.render(onScanSuccess);
</script>
</html>