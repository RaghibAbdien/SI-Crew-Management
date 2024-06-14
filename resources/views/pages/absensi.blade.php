@extends('layout.main')

@section('title', 'Absensi Crew')

@section('content')

    @push('head')
        <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">

        <!-- Responsive datatable examples -->
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">

    @endpush

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="page-title">Absensi Crew</h6>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Welcome to Absensi Crew</li>
                            </ol>
                        </div>

                    </div>
                    <div class="row align-items-center mb-0">
                        <div class="col-md-12">
                            <div class="float-end d-md-block">
                                <div class="my-2 text-center">
                                    <button class="btn btn-primary waves-effect waves-light mx-2" type="button" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#AddAbsensi">
                                        <i class="fa-solid fa-plus me-2"></i> Tambah Absensi
                                    </button>
                                    <button class="btn btn-primary waves-effect waves-light mx-2" type="button" onclick="window.location.href='/export-absensi'">
                                            <i class="fa-solid fa-file-export me-2"></i>Export Crew
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h1 class="card-title text-center fs-2 pb-3">Absensi</h1>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Waktu Kehadiran</th>
                                        <th>Aksi</th>    
                                    </tr>
                                    </thead>


                                    <tbody>
                                        @foreach ($absensis as $index => $absen )
                                        <tr>
                                            <td>{{ $index+1 }}</td>
                                            <td>{{ $absen->nama_crew }}</td>
                                            <td>{{ $absen->kehadiran }}</td>
                                            <td>
                                                    <button id="hapus-absen" class="btn btn-danger" data-id="{{ $absen->id }}">Hapus</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

    </div>

    

    <!-- Modal Tambah Crew -->
    <div id="AddAbsensi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="absensiForm" action="{{ route('tambah-kehadiran') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Tambah Absensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col">
                            <div class="card pb-3">
                                <label for="nama_crew" class="form-label">Nama Crew</label>
                                <select class="form-select" aria-label="Default select example" id="nama_crew" name="id_crew" required>
                                    @foreach($crews as $crew)
                                        <option value="{{ $crew->id_crew }}" {{ old('id_crew') == $crew->id_crew ? 'selected' : '' }}>{{ $crew->nama_crew }}</option>
                                    @endforeach
                                </select>
                                @error('id_crew')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 pb-3">
                                <label for="waktu-crew" class="form-label">Waktu Kehadiran</label>
                                <input type="datetime-local" class="form-control" id="waktu-crew" name="kehadiran" required value="{{ old('kehadiran') }}">
                                @error('kehadiran')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    
    
    @push('js')

        <!-- Required datatable js -->
        <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

        <!-- Responsive examples -->
        <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        
        <!-- Datatable init js -->
        <script src="assets/js/pages/datatables.init.js"></script> 

        <script>

        document.addEventListener('DOMContentLoaded', function () {
            // Reset form dan hapus pesan error saat modal ditutup
            var modalElement = document.getElementById('AddAbsensi');
            var formElement = document.getElementById('absensiForm');
            var errorElements = document.querySelectorAll('.text-danger');
            
            modalElement.addEventListener('hidden.bs.modal', function (event) {
                formElement.reset();
                formElement.querySelectorAll('.form-control').forEach(function(input) {
                    input.value = '';
                });
                formElement.querySelectorAll('.form-select').forEach(function(select) {
                    select.selectedIndex = 0;
                });
                // Hapus error messages
                errorElements.forEach(function(error) {
                    error.textContent = '';
                });
            });

            // Tampilkan modal saat ada error validasi
            @if ($errors->any() && !$isEdit)  
            var myModal = new bootstrap.Modal(document.getElementById('AddAbsensi'));
            myModal.show();
            @endif

        });

        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('absensiForm');
                form.addEventListener('submit', function (event) {
                    const submitButton = form.querySelector('button[type="submit"]');
                    submitButton.disabled = true;
                    submitButton.innerText = 'Processing...'; // Optional: Change button text to indicate processing
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $(document).on('click', '#hapus-absen', function() {
                    var id = $(this).data('id');
                    var url = '{{ route("hapus-absen", ":id") }}';
                    url = url.replace(':id', id);
                    var $button = $(this); // Cache the button jQuery object

                    // Tampilkan SweetAlert untuk konfirmasi
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda tidak akan dapat mengembalikan ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Disable the button
                            $button.attr('disabled', 'disabled');

                            // Kirim permintaan hapus menggunakan AJAX
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    console.log("Success: ", response); // Debug log
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "Absensi berhasil dihapus",
                                        showConfirmButton: false,
                                        timer: 1750
                                    }).then(function() {
                                        // Setelah Swal selesai ditampilkan, lakukan redirect
                                        window.location.href = '{{ route('absensi-crew') }}';
                                    });
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Gagal menghapus absensi'
                                    });

                                    $button.removeAttr('disabled');
                                },
                                complete: function() {
                                    // Enable the button after the request completes
                                    $button.removeAttr('disabled');
                                }
                            });
                        }
                    });
                });
            });
        </script>

        @if(session('error'))
        <script>
            // Tampilkan SweetAlert2 dengan pesan error
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}'
            });
        </script>
        @endif

        @if (session('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1750
            });
        </script>
        @endif

    @endpush

@endsection

