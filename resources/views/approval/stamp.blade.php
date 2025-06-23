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
                    <h1 class="h3 mb-0 text-gray-800">Approval</h1>
                </div>
                <form method="post" action="{{ route('approval.stamping') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Document Detail</h6>
                            </div>
                            <div class="card-body">
                                <input class="form-control" type="hidden" id="id" name="id" value="{{ $approval[0]->id }}" readonly>
                                <input class="form-control" type="hidden" id="url" name="url" value="{{ url()->current() }}" readonly>
                                <input class="form-control" type="hidden" id="type" name="type" value="{{ $approval[0]->type }}" readonly>
                                <input class="form-control" type="hidden" id="token" name="token" value="{{ $approval[0]->token }}" readonly>
                                <input class="form-control" type="hidden" id="preparer_id" name="preparer_id" value="{{ $approval[0]->preparer_id }}" readonly>
                                <input class="form-control" type="hidden" id="approval_base64" name="approval_base64" value="{{ $approval[0]->approval_base64 }}" readonly>
                                <input class="form-control" type="hidden" id="approval_progress" name="approval_progress" value="{{ $approval[0]->approval_progress }}" readonly>
                                <input class="form-control" type="hidden" id="stamp_img" name="stamp_img" value="chutex_stamp.png" readonly>
                                <input class="form-control" type="hidden" id="original_name" name="original_name" value="{{ $approval[0]->original_name }}" readonly>
                                <input class="form-control" type="hidden" id="document_approve" name="document_approve" value="{{ $approval[0]->document_approve }}" readonly>
                                <label>Document Name : </label>
                                <input class="form-control" type="text" id="document_name" name="document_name" value="{{ $approval[0]->document_name }}" readonly>
                                <br>
                                <label>Page Number : </label>
                                <input class="form-control" type="text" id="pageNumber" name="pageNumber" value="-" readonly>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="button" class="btn btn-primary btn-block" id="prev">Previous</button>
                                    </div>
                                    <div class="col-lg-6">
                                        <button type="button" class="btn btn-primary btn-block" id="next">Next</button>
                                    </div>
                                </div>
                                <br>
                                {{-- btn --}}
                                <button id="submit" type="submit" class="btn btn-primary btn-block">
                                    <span class="mt-2 text-base dark:text-white leading-normal">Submit</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Stamping</h6>
                            </div>
                            <div class="card-body">
                                <center>
                                    <div id=parent>
                                        <div class="draggable-2"><img src="{{ asset('/storage/signature/chutex_stamp.png') }}" width="100%" height="100%"></div>
                                        <canvas class="border-solid border-2 dark:border-zinc-50" id="pdf-canvas"></canvas>
                                    </div>
                                    <input type="hidden" id="stampX" name="stampX">
                                    <input type="hidden" id="stampY" name="stampY">
                                    <input type="hidden" id="stampHeight" name="stampHeight" value="35">
                                    <input type="hidden" id="stampWidth" name="stampWidth" value="60">
                                    <input type="hidden" id="canvasHeight" name="canvasHeight">
                                    <input type="hidden" id="canvasWidth" name="canvasWidth">
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
                
            </form>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->


@include('layout.footer')
</body>
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
<script src="{{asset('vendor/jquery/jquery-ui.min.js')}}"></script>

<script type="module" src='https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.0.269/pdf.min.mjs'></script>
<script type="module" src='https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.0.269/pdf.worker.min.mjs'></script>

<script>
    $("#submit").click(function() {
        $(this).hide();
    });
    // Predefine the variables
    var pdfDoc = null,
    pageNum = 1,
    pageRendering = false,
    pageNumPending = null,
    scale = 0.9, //default 1.7
    canvas = document.getElementById('pdf-canvas'),
    ctx = canvas.getContext('2d');

    $(document).ready(function() {
        var file = document.getElementById('approval_base64').value
        // console.log(file)
        // Function to convert Base64 string to Blob
        function base64ToBlob(base64, contentType = '', sliceSize = 512) {
            const byteCharacters = atob(base64.split(',')[1]);
            const byteArrays = [];

            for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                const slice = byteCharacters.slice(offset, offset + sliceSize);

                const byteNumbers = new Array(slice.length);
                for (let i = 0; i < slice.length; i++) {
                    byteNumbers[i] = slice.charCodeAt(i);
                }

                const byteArray = new Uint8Array(byteNumbers);
                byteArrays.push(byteArray);
            }

            const blob = new Blob(byteArrays, { type: contentType });
            return blob;
        }

        // Convert the Base64 string to a Blob
        const blob = base64ToBlob(file, 'application/pdf');
        console.log(blob);
        if(blob.type != "application/pdf"){
            alert(file.name, "is not a pdf file.")
            return
        }

        var fileReader = new FileReader();  

        fileReader.onload = async function() {
            var typedarray = new Uint8Array(this.result);

            const loadingTask = pdfjsLib.getDocument(typedarray);
            loadingTask.promise.then(pdf => {
                // Set pdfDoc to the PDFJS object so we can reference it globally
                pdfDoc = pdf
                // Get Page number
                pageNum = pdfDoc.numPages

                document.getElementById('pageNumber').value = pageNum;
                // Last page rendering
                renderPage(pageNum);
            });
        };

        fileReader.readAsArrayBuffer(blob);

        document.getElementsByClassName('draggable-2')[0].style.display = 'block';
    })
    
    /**
     * Get page info from document, resize canvas accordingly, and render page.
     * @param num Page number.
     */
     function renderPage(num) {
        pageRendering = true;
        // Using promise to fetch the page
        pdfDoc.getPage(num).then(function(page) {
            var viewport = page.getViewport({scale: scale});
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            document.getElementById('canvasHeight').value = viewport.height;
            document.getElementById('canvasWidth').value = viewport.width;

            // Render PDF page into canvas context
            var renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            var renderTask = page.render(renderContext);

            // Wait for rendering to finish
            renderTask.promise.then(function() {
                pageRendering = false;
                if (pageNumPending !== null) {
                    // New page rendering is pending
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });
    }

    /**
     * If another page rendering in progress, waits until the rendering is
     * finised. Otherwise, executes rendering immediately.
     */
    function queueRenderPage(num) {
        document.getElementById('pageNumber').value = num;
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    /**
     * Displays previous page.
     */
    function onPrevPage() {
        if (pageNum <= 1) {
            return;
        }
        pageNum--;

        queueRenderPage(pageNum);
    }
    document.getElementById('prev').addEventListener('click', onPrevPage);

    /**
     * Displays next page.
     */
    function onNextPage() {
        if (pageNum >= pdfDoc.numPages) {
            return;
        }
        pageNum++;
        queueRenderPage(pageNum);
    }
    document.getElementById('next').addEventListener('click', onNextPage);
</script>

<script src="https://cdn.jsdelivr.net/npm/interactjs@1.10.20/dist/interact.min.js"></script>

<script>
    const position = { x: 0, y: 0 }
    interact('.draggable-2').draggable({
        listeners: {
            move (event) {
                position.x += event.dx
                position.y += event.dy

                event.target.style.transform =
                    `translate(${position.x}px, ${position.y}px)`
            },
            end (event) {
                var style = window.getComputedStyle(event.target);
                var matrix = new WebKitCSSMatrix(style.transform);

                console.log(matrix.m41, matrix.m42)
                document.getElementById('stampX').value = matrix.m41;
                document.getElementById('stampY').value = matrix.m42;
            }
        },
        inertia: true,
        modifiers: [
            interact.modifiers.restrictRect({
                restriction: 'parent',
                endOnly: true
            })
        ],
    }).resizable({
    // resize from all edges and corners
    edges: { left: false, right: true, bottom: true, top: false },

    listeners: {
      move (event) {
        var target = event.target
        var x = (parseFloat(target.getAttribute('data-x')) || 0)
        var y = (parseFloat(target.getAttribute('data-y')) || 0)

        // update the element's style
        target.style.width = event.rect.width + 'px'
        target.style.height = event.rect.height + 'px'

        // translate when resizing from top or left edges
        x += event.deltaRect.left
        y += event.deltaRect.top

        target.style.transform =
                    `translate(${position.x}px, ${position.y}px)`

        target.setAttribute('data-x', x)
        target.setAttribute('data-y', y)
      },
      end (event) {
            console.log(event.target.style.width, event.target.style.height)
            document.getElementById('stampHeight').value = parseInt(event.target.style.height);
            document.getElementById('stampWidth').value = parseInt(event.target.style.width);
        }
    },
    modifiers: [
      // keep the edges inside the parent
      interact.modifiers.restrictEdges({
        outer: 'parent'
      }),

      // minimum size
      interact.modifiers.restrictSize({
        min: { width: 60, height: 35 }
      })
    ],

    inertia: true
  })
</script>

</html>