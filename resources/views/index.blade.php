<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">


    <title>AWS File System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css"
      integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous"/>
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">


<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-4 col-sm-6">
                            <div class="search-box mb-2 me-2">
                                <div class="position-relative">
                                    <input type="text" class="form-control bg-light border-light rounded"
                                           placeholder="Search...">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"
                                         class="eva eva-search-outline search-icon">
                                        <g data-name="Layer 2">
                                            <g data-name="search">
                                                <rect width="24" height="24" opacity="0"></rect>
                                                <path
                                                    d="M20.71 19.29l-3.4-3.39A7.92 7.92 0 0 0 19 11a8 8 0 1 0-8 8 7.92 7.92 0 0 0 4.9-1.69l3.39 3.4a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 11a6 6 0 1 1 6 6 6 6 0 0 1-6-6z"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-6">
                            <div class="mt-4 mt-sm-0 d-flex align-items-center justify-content-sm-end">
                                <div class="mb-2 me-2">
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-plus me-1"></i> Create New
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal"
                                               data-bs-target="#createFolderModal"><i
                                                    class="mdi mdi-folder-outline me-1"></i> Folder</a>
                                            <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal"
                                               data-bs-target="#fileUploadModal"><i
                                                    class="mdi mdi-file-outline me-1"></i> File</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown mb-0">
                                    <a class="btn btn-link text-muted dropdown-toggle p-1 mt-n2" role="button"
                                       data-bs-toggle="dropdown" aria-haspopup="true">
                                        <i class="mdi mdi-dots-vertical font-size-20"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Share Files</a>
                                        <a class="dropdown-item" href="#">Share with me</a>
                                        <a class="dropdown-item" href="#">Other Actions</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="font-size-16 me-3 mb-0">My Files</h5>
                    <div class="row mt-4">
                        <div class="col-xl-4 col-sm-6">
                            <div class="card shadow-none border">
                                <div class="card-body p-3">
                                    <div class>
                                        <div class="dropdown float-end">
                                            <a class="text-muted dropdown-toggle font-size-16" href="#" role="button"
                                               data-bs-toggle="dropdown" aria-haspopup="true">
                                                <i class="bx bx-dots-vertical-rounded font-size-20"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Edit</a>
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Remove</a>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar align-self-center me-3">
                                                <div
                                                    class="avatar-title rounded bg-soft-primary text-primary font-size-24">
                                                    <i class="mdi mdi-google-drive"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h5 class="font-size-15 mb-1">Google Drive</h5>
                                                <a href class="font-size-13 text-muted"><u>View Folder</u></a>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-1">
                                            <div class="d-flex justify-content-between">
                                                <p class="text-muted font-size-13 mb-1">20GB</p>
                                                <p class="text-muted font-size-13 mb-1">50GB used</p>
                                            </div>
                                            <div class="progress animated-progess custom-progress">
                                                <div class="progress-bar bg-gradient bg-primary" role="progressbar"
                                                     style="width: 90%" aria-valuenow="90" aria-valuemin="0"
                                                     aria-valuemax="90">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6">
                            <div class="card shadow-none border">
                                <div class="card-body p-3">
                                    <div class>
                                        <div class="dropdown float-end">
                                            <a class="text-muted dropdown-toggle font-size-16" href="#" role="button"
                                               data-bs-toggle="dropdown" aria-haspopup="true">
                                                <i class="bx bx-dots-vertical-rounded font-size-20"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Edit</a>
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Remove</a>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar align-self-center me-3">
                                                <div class="avatar-title rounded bg-soft-info text-info font-size-24">
                                                    <i class="mdi mdi-dropbox"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h5 class="font-size-15 mb-1">Dropbox</h5>
                                                <a href class="font-size-13 text-muted"><u>View Folder</u></a>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-1">
                                            <div class="d-flex justify-content-between">
                                                <p class="text-muted font-size-13 mb-1">20GB</p>
                                                <p class="text-muted font-size-13 mb-1">50GB used</p>
                                            </div>
                                            <div class="progress animated-progess custom-progress">
                                                <div class="progress-bar bg-gradient bg-info" role="progressbar"
                                                     style="width: 90%" aria-valuenow="90" aria-valuemin="0"
                                                     aria-valuemax="90">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6">
                            <div class="card shadow-none border">
                                <div class="card-body p-3">
                                    <div class>
                                        <div class="dropdown float-end">
                                            <a class="text-muted dropdown-toggle font-size-16" href="#" role="button"
                                               data-bs-toggle="dropdown" aria-haspopup="true">
                                                <i class="bx bx-dots-vertical-rounded font-size-20"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Edit</a>
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Remove</a>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar align-self-center me-3">
                                                <div
                                                    class="avatar-title rounded bg-soft-primary text-primary font-size-24">
                                                    <i class="mdi mdi-apple-icloud"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h5 class="font-size-15 mb-1">One Drive</h5>
                                                <a href class="font-size-13 text-muted"><u>View Folder</u></a>
                                            </div>
                                        </div>
                                        <div class="mt-3 pt-1">
                                            <div class="d-flex justify-content-between">
                                                <p class="text-muted font-size-13 mb-1">20GB</p>
                                                <p class="text-muted font-size-13 mb-1">50GB used</p>
                                            </div>
                                            <div class="progress animated-progess custom-progress">
                                                <div class="progress-bar bg-gradient bg-primary" role="progressbar"
                                                     style="width: 90%" aria-valuenow="90" aria-valuemin="0"
                                                     aria-valuemax="90">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <h5 class="font-size-16 me-3 mb-0">Folders</h5>
                    <div class="row mt-4">
                        <div class="col-xl-4 col-sm-6">
                            <div class="card shadow-none border">
                                <div class="card-body p-3">
                                    <div class>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bx bxs-folder h1 mb-0 text-warning"></i>
                                            </div>
                                            <div class="avatar-group">
                                                <div class="avatar-group-item">
                                                    <a href="javascript: void(0);" class="d-inline-block">
                                                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                             alt class="rounded-circle avatar-sm">
                                                    </a>
                                                </div>
                                                <div class="avatar-group-item">
                                                    <a href="javascript: void(0);" class="d-inline-block">
                                                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png"
                                                             alt class="rounded-circle avatar-sm">
                                                    </a>
                                                </div>
                                                <div class="avatar-group-item">
                                                    <a href="javascript: void(0);" class="d-inline-block">
                                                        <div class="avatar-sm">
<span class="avatar-title rounded-circle bg-success text-white font-size-16">
A
</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex mt-3">
                                            <div class="overflow-hidden me-auto">
                                                <h5 class="font-size-15 text-truncate mb-1"><a
                                                        href="javascript: void(0);" class="text-body">Analytics</a></h5>
                                                <p class="text-muted text-truncate mb-0">12 Files</p>
                                            </div>
                                            <div class="align-self-end ms-2">
                                                <p class="text-muted mb-0 font-size-13"><i class="mdi mdi-clock"></i> 15
                                                    min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6">
                            <div class="card shadow-none border">
                                <div class="card-body p-3">
                                    <div class>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bx bxs-folder h1 mb-0 text-warning"></i>
                                            </div>
                                            <div class="avatar-group">
                                                <div class="avatar-group-item">
                                                    <a href="javascript: void(0);" class="d-inline-block">
                                                        <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                                             alt class="rounded-circle avatar-sm">
                                                    </a>
                                                </div>
                                                <div class="avatar-group-item">
                                                    <a href="javascript: void(0);" class="d-inline-block">
                                                        <img src="https://bootdey.com/img/Content/avatar/avatar4.png"
                                                             alt class="rounded-circle avatar-sm">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex mt-3">
                                            <div class="overflow-hidden me-auto">
                                                <h5 class="font-size-15 text-truncate mb-1"><a
                                                        href="javascript: void(0);" class="text-body">Sketch Design</a>
                                                </h5>
                                                <p class="text-muted text-truncate mb-0">235 Files</p>
                                            </div>
                                            <div class="align-self-end ms-2">
                                                <p class="text-muted mb-0 font-size-13"><i class="mdi mdi-clock"></i> 23
                                                    min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6">
                            <div class="card shadow-none border">
                                <div class="card-body p-3">
                                    <div class>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bx bxs-folder h1 mb-0 text-warning"></i>
                                            </div>
                                            <div class="avatar-group">
                                                <div class="avatar-group-item">
                                                    <a href="javascript: void(0);" class="d-inline-block">
                                                        <div class="avatar-sm">
<span class="avatar-title rounded-circle bg-info text-white font-size-16">
K
</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="avatar-group-item">
                                                    <a href="javascript: void(0);" class="d-inline-block">
                                                        <img src="https://bootdey.com/img/Content/avatar/avatar5.png"
                                                             alt class="rounded-circle avatar-sm">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex mt-3">
                                            <div class="overflow-hidden me-auto">
                                                <h5 class="font-size-15 text-truncate mb-1"><a
                                                        href="javascript: void(0);" class="text-body">Applications</a>
                                                </h5>
                                                <p class="text-muted text-truncate mb-0">20 Files</p>
                                            </div>
                                            <div class="align-self-end ms-2">
                                                <p class="text-muted mb-0 font-size-13"><i class="mdi mdi-clock"></i> 45
                                                    min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex flex-wrap">
                        <h5 class="font-size-16 me-3">{{ $path ? $path : "(Root Directory)" }}</h5>
                    </div>
                    <hr class="mt-2">
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Date modified</th>
                                <th scope="col">Size</th>
                                <th scope="col" colspan="2">Uploaded By</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($files as $file)
                                <tr>
                                    @php
                                        $link = $file->is_file ? 'javascript:;' : route('show-path', ['path' => "$path/$file->name"]);
                                    @endphp
                                    <td><a href="{{ $link }}" class="text-dark fw-medium">
                                            <i class="mdi {{ $file->is_file ? 'mdi-file-document' : 'mdi-folder' }} font-size-16 align-middle {{ $file->is_file ? 'text-primary' : 'text-warning' }} me-2"></i>
                                            {{ $file->name  }}
                                        </a>
                                    </td>
                                    <td>{{ $file->created_at }}</td>
                                    <td>09 KB</td>
                                    <td style="display: flex; flex-direction: row; align-items: center">
                                        <div class="avatar-group" style="margin-right: 5px">
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block">
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt
                                                         class="rounded-circle avatar-sm">
                                                </a>
                                            </div>
                                        </div>
                                        <div>{{ $file->uploaded_by }}</div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="font-size-16 text-muted" role="button" data-bs-toggle="dropdown"
                                               aria-haspopup="true">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Open</a>
                                                <a class="dropdown-item" href="#">Edit</a>
                                                <a class="dropdown-item" href="#">Rename</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">Remove</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="position-fixed top-0 end-0 p-3 " style="z-index: 99999">
    <div id="errorToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <!-- Error message will be displayed here -->
        </div>
    </div>
</div>


<div class="position-fixed top-0 end-0 p-3 " style="z-index: 99999">
    <div id="successToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <!-- Error message will be displayed here -->
        </div>
    </div>
</div>


<!-- START OF FILE CREATION MODAL -->
<div class="modal fade" id="fileUploadModal" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload a file</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/upload"
                      class="dropzone"
                      id="file-upload-dropzone">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- END OF FILE CREATION MODAL -->

<!-- START OF FOLDER CREATION MODAL -->
<div class="modal fade" id="createFolderModal" tabindex="-1" aria-labelledby="createFolderModalLabel"
     aria-hidden="true">
    <form action="/folder" method="POST">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Folder Name</label>
                        <input type="text" class="form-control" name="name">
                        <input type="hidden" name="path" value="{{$path}}"/>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- END OF FOLDER CREATION MODAL -->

<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script type="text/javascript">
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    Dropzone.options.fileUploadDropzone = {
        paramName: "file",
        maxFileSize: "500",
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        dictDefaultMessage: "Drop your file here to upload",
        init: function () {
            this.on("error", function (file, errorMessage, xhr) {
                if (xhr.status === 400) {
                    // Extract error message from response
                    var response = JSON.parse(xhr.responseText);
                    var errorMessageFromServer = response.message;
                    console.error("Server error message:", errorMessageFromServer);

                    // Display error message in Bootstrap toaster
                    var toast = new bootstrap.Toast(document.getElementById('errorToast'));
                    var toastBody = document.querySelector('#errorToast .toast-body');
                    toastBody.textContent = errorMessageFromServer;
                    toast.show();
                    $("#fileUploadModal").modal('hide');

                    this.removeAllFiles();
                }
            });

            this.on("success", function (file, response) {
                // Handle success
                console.log("File uploaded successfully.", response);
                // Display success toast
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
                $("#fileUploadModal").modal('hide');
                this.removeAllFiles();
                window.location.reload();
            });

            this.on("sending", function (file, xhr, formData) {
                // Add extra parameter to the request
                formData.append('path', "{{ $path }}"); // Replace '/your/path' with your desired path
            });
        }
    };
</script>
</body>
</html>
