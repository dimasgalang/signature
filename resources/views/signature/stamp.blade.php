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
                    <h1 class="h3 mb-0 text-gray-800">Stamping</h1>
                </div>
                <form method="post" action="{{ route('signature.stamping') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Upload PDF</h6>
                            </div>
                            <div class="card-body">
                                <center>
                                <label for="document-result">
                                    <img src="https://cdn1.iconfinder.com/data/icons/hawcons/32/699329-icon-57-document-download-128.png">
                                    <input type="file" name="pdf-file" id="document-result" accept=".pdf" style="display:none;" />
                                </label>
                                <input class="form-control" type="text" id="namafile" name="namafile" value="-" readonly>
                                </center>
                                <br>
                                <label>Page Number : </label>
                                <input class="form-control" type="text" id="pageNumber" name="pageNumber" value="-" readonly placeholder="Page number">
                                <br>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="button" class="btn btn-primary btn-block" id="prev">Previous</button>
                                    </div>
                                    <div class="col-lg-6">
                                        <button type="button" class="btn btn-primary btn-block" id="next">Next</button>
                                    </div>
                                </div>
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
                                    <div class="flex w-full bg-grey-lighter mt-3" id="canvas-container">
                                        <div class="draggable"><img src="{{ asset('/signature/' . $user[0]->signature_img) }}" width="100%" height="100%"></div>
                                        <canvas class="border-solid border-2 dark:border-zinc-50" id="pdf-canvas"> ~ PDF ~</canvas>
                                    </div>
                                    <input type="hidden" id="stampX" name="stampX">
                                    <input type="hidden" id="stampY" name="stampY">
                                    <input type="hidden" id="stampHeight" name="stampHeight" value="70">
                                    <input type="hidden" id="stampWidth" name="stampWidth" value="70">
                                    <input type="hidden" id="canvasHeight" name="canvasHeight">
                                    <input type="hidden" id="canvasWidth" name="canvasWidth">
            
                                    {{-- btn --}}
                                    <div class="flex w-full items-center justify-center bg-black-#334155">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <span class="mt-2 text-base dark:text-white leading-normal">Submit</span>
                                        </button>
                                    </div>
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
    // Predefine the variables
    var pdfDoc = null,
    pageNum = 1,
    pageRendering = false,
    pageNumPending = null,
    scale = 1,
    canvas = document.getElementById('pdf-canvas'),
    ctx = canvas.getContext('2d');

    document.querySelector("#document-result").addEventListener("change", async function(e){
        var file = e.target.files[0]
        const toBase64 = file => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = reject;
        });
        // console.log(await toBase64(file));
        // Example Base64 string (truncated for brevity)
const base64String =
    `data:application/pdf;base64,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9l+aOx1d9ULaZqcJxUoyXbufQz5+9JpO0tiJiY3hyjlIAAAAAAAAAAAAAAAAAAAAAAAAAOg13qsno/EwpjKU5QyjGHLKWb5VkuwsaaYjLEy88sTwnZRnizj/AGLEd2zd+vi+UMj6GXffY8Wcf7Ff3bJ6jF8oR0+X4o8WMf7Ff3bHUYvlCOny/E8WMf7Ff3bHUYvlB0+X4nixj/Yr+7Y6jF8oOny/E8WMf7Ff3bHUYvlB0+X4nixj/Yr+7Y6jF8oOny/E8WMf7Ff3bHUYvlB0+X4nixj/AGK/u2OoxfKDp8vxStWcf7FiO7ZHUYvlCY0+WPZa/BLg76cLbDEV2VeczjGxOPJluTMnX3ra8TWd2npq2rTazeygsgAAAAAAAAAAAAAAAAAAAAAAAAAjIBkBIAAAAAAAACMgGQEgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAB/9kKZW5kc3RyZWFtCmVuZG9iagoxMSAwIG9iago8PCAvVHlwZSAvRXh0R1N0YXRlCi9CTSAvTm9ybWFsCi9jYSAwLjY3Cj4+CmVuZG9iagoxMiAwIG9iago8PCAvVHlwZSAvRXh0R1N0YXRlCi9CTSAvTm9ybWFsCi9DQSAwLjY3Cj4+CmVuZG9iagoxMyAwIG9iago8PCAvVHlwZSAvRXh0R1N0YXRlCi9CTSAvTm9ybWFsCi9jYSAxCj4+CmVuZG9iagoxNCAwIG9iago8PCAvVHlwZSAvRXh0R1N0YXRlCi9CTSAvTm9ybWFsCi9DQSAxCj4+CmVuZG9iagp4cmVmCjAgMTUKMDAwMDAwMDAwMCA2NTUzNSBmIAowMDAwMDAwMDA5IDAwMDAwIG4gCjAwMDAwMDAwNzQgMDAwMDAgbiAKMDAwMDAwMDEyMCAwMDAwMCBuIAowMDAwMDAwMzc3IDAwMDAwIG4gCjAwMDAwMDA0MTQgMDAwMDAgbiAKMDAwMDAwMDU2MyAwMDAwMCBuIAowMDAwMDAwNjY2IDAwMDAwIG4gCjAwMDAwMDI1MjcgMDAwMDAgbiAKMDAwMDAwMjYzNCAwMDAwMCBuIAowMDAwMDAyNzQ2IDAwMDAwIG4gCjAwMDAwMDY3MDcgMDAwMDAgbiAKMDAwMDAwNjc2NyAwMDAwMCBuIAowMDAwMDA2ODI3IDAwMDAwIG4gCjAwMDAwMDY4ODQgMDAwMDAgbiAKdHJhaWxlcgo8PAovU2l6ZSAxNQovUm9vdCAxIDAgUgovSW5mbyA1IDAgUgovSURbPDE2MThmYTcwMGU2ODViZTgwNzQ5OWM0YjkzNDYyM2M1PjwxNjE4ZmE3MDBlNjg1YmU4MDc0OTljNGI5MzQ2MjNjNT5dCj4+CnN0YXJ0eHJlZgo2OTQxCiUlRU9GCg==`;

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
const blob = base64ToBlob(base64String, 'application/pdf');
console.log(blob);

        document.getElementById('namafile').value = await toBase64(file)
        // console.log(file)
        if(file.type != "application/pdf"){
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

        fileReader.readAsArrayBuffer(file);

        document.getElementsByClassName('draggable')[0].style.display = 'block';
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
    interact('.draggable').draggable({
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
    edges: { left: true, right: true, bottom: true, top: true },

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
        min: { width: 70, height: 70 }
      })
    ],

    inertia: true
  })
</script>

</html>