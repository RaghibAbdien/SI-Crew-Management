@extends('layout.main')

@section('title', 'Pengajuan Cuti')

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
                            <h6 class="page-title">Pengajuan Cuti</h6>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Welcome to Pengajuan Cuti</li>
                            </ol>
                        </div>

                    </div>
                    <div class="row align-items-center mb-0">
                        <div class="col-md-12">
                            <div class="float-end d-md-block">
                                <div class="my-2 text-center">
                                    <button class="btn btn-primary waves-effect waves-light mx-2" type="button" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#AddCuti">
                                        <i class="fa-solid fa-plus me-2"></i> Ajukan Cuti
                                    </button>
                                    @if ($cutis && count($cutis) > 0)
                                        <button class="btn btn-primary waves-effect waves-light mx-2" type="button" onclick="window.location.href='/export-cuti'">
                                        <i class="fa-solid fa-file-export me-2"></i>Export</button>
                                    @endif
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

                                <h1 class="card-title text-center fs-2 pb-3">Pengajuan Cuti</h1>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Keperluan</th>
                                        <th>Tanggal Pengajuan</th>    
                                        <th>Tanggal Mulai</th>    
                                        <th>Tanggal Berakhir</th>    
                                        <th>Surat Pengajuan</th>    
                                        <th>Status</th>    
                                        <th>Aksi</th>    
                                    </tr>
                                    </thead>


                                    <tbody>
                                        @foreach ($cutis as $cuti )
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $cuti->nama_crew }}</td>
                                                <td>{{ $cuti->keperluan }}</td>
                                                <td>{{ $cuti->tgl_pengajuan }}</td>
                                                <td>{{ $cuti->tgl_mulai }}</td>
                                                <td>{{ $cuti->tgl_berakhir }}</td>
                                                <td class="d-flex">
                                                    <a href="{{ Storage::url($cuti->surat_pengajuan) }}" target="_blank" class="mx-auto btn btn-primary"><i class="fa-solid fa-download"></i></a>
                                                </td>
                                                <td>
                                                    <div class=" fs-6
                                                @if ($cuti->status == "Disetujui")
                                                badge rounded-pill bg-success
                                                @elseif ($cuti->status == "Ditolak")
                                                 badge rounded-pill bg-danger
                                                 @else
                                                 badge rounded-pill bg-warning
                                                @endif
                                            ">
                                                        <span>{{ $cuti->status }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($cuti->status == "Pending")
                                                    <button class="btn btn-success" id="tmbl-setuju" data-id="{{ $cuti->id }}"><i class="fa-regular fa-square-check fa-xl"></i></button>
                                                    <button class="btn btn-danger" id="tmbl-tolak" data-id="{{ $cuti->id }}"><i class="fa-regular fa-rectangle-xmark fa-xl"></i></button>
                                                    @endif
                                                    <button class="btn btn-danger" id="tmbl-hapus" data-id="{{ $cuti->id }}"><i class="fa-regular fa-square-minus fa-xl"></i></button>
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

    <!-- Modal Tambah Pengajuan Cuti -->
    <div id="AddCuti" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="cutiForm" action="{{ route('ajukan-cuti') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Ajukan Cuti</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col">
                            <div class="card pb-1">
                                <label for="nama_crew" class="form-label">Nama Crew</label>
                                <select class="form-select" aria-label="Default select example" id="nama_crew" name="id_crew" required>
                                    @foreach($crews as $crew)
                                        <option value="{{ $crew->id_crew }}" {{ old('id_crew') == $crew->id_crew ? 'selected' : '' }}>{{ $crew->nama_crew }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="keperluan">Keperluan</label>
                                <textarea id="keperluan" class="form-control" rows="3" name="keperluan" autocomplete="keperluan" required>{{ old('alamat_crew') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" required value="{{ old('tgl_mulai') }}">
                            </div>
                            <div class="mb-3">
                                <label for="tgl_berakhir" class="form-label">Tanggal Berakhir</label>
                                <input type="date" class="form-control" id="tgl_berakhir" name="tgl_berakhir" required value="{{ old('tgl_berakhir') }}">
                            </div>
                            <div class="mb-3">
                                <label for="surat" class="form-label">Surat Pengajuan</label>
                                <input type="file" class="form-control" id="surat" name="surat_pengajuan" accept=".pdf">
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
                const form = document.getElementById('cutiForm');
                form.addEventListener('submit', function (event) {
                    const submitButton = form.querySelector('button[type="submit"]');
                    submitButton.disabled = true;
                    submitButton.innerText = 'Processing...'; // Optional: Change button text to indicate processing
                });
            });
       </script>

        <script>
            $(document).ready(function() {
                $(document).on('click', '#tmbl-setuju', function() {
                    var id = $(this).data('id');
                    var url = '{{ route("update-cuti", [":id", "setuju"]) }}';
                    url = url.replace(':id', id);
                    var $button = $(this);

                    $button.attr('disabled', 'disabled');

                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Berhasil",
                                showConfirmButton: false,
                                timer: 1750
                            }).then(function() {
                                // Setelah Swal selesai ditampilkan, lakukan redirect
                                window.location.href = '{{ route('pengajuan-cuti') }}';
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Gagal validasi cuti'
                            });

                            $button.removeAttr('disabled');
                        }
                    });
                });

                $(document).on('click', '#tmbl-tolak', function() {
                    var id = $(this).data('id');
                    var url = '{{ route("update-cuti", [":id", "tolak"]) }}';
                    url = url.replace(':id', id);
                    var $button = $(this);

                    $button.attr('disabled', 'disabled');

                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Berhasil",
                                showConfirmButton: false,
                                timer: 1750
                            }).then(function() {
                                // Setelah Swal selesai ditampilkan, lakukan redirect
                                window.location.href = '{{ route('pengajuan-cuti') }}';
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Gagal validasi cuti'
                            });

                            $button.removeAttr('disabled');
                        }
                    });
                });
            });
        </script>

<script>
    $(document).ready(function() {
        $(document).on('click', '#tmbl-hapus', function() {
            var id = $(this).data('id');
            var url = '{{ route("hapus-cuti", ":id") }}';
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
                            Swal.fire(
                                'Terhapus!',
                                'Cuti telah dihapus.',
                                'success'
                            ).then(function() {
                                // Setelah Swal selesai ditampilkan, lakukan redirect
                                window.location.href = '{{ route('pengajuan-cuti') }}';
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Gagal menghapus pengajuan cuti'
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