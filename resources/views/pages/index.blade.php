@extends('layout.main')

@section('title', 'Dashboard')


@section('content')
<div class="main-content">

    @push('head')
        <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">



        <!-- Responsive datatable examples -->
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
    @endpush

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="page-title">Dashboard</h6>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Welcome to Veltrix Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stat bg-primary text-white">
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="float-start mini-stat-img me-4">
                                    <i class="fa-solid fa-user-group fa-2x"></i>
                                </div>
                                <h5 class="font-size-16 text-uppercase text-white-50">Crew</h5>
                                <h4 class="fw-medium font-size-24">{{ $jmlhCrew }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stat bg-primary text-white">
                        <div class="card-body">
                            <div class="mb-4 cursor-pointer" data-bs-toggle="modal" data-bs-target="#myLokasi">
                                <div class="float-start mini-stat-img me-4">
                                    <i class="fa-solid fa-map-location-dot fa-2x"></i>
                                </div>
                                <h5 class="font-size-16 text-uppercase text-white-50">Lokasi</h5>
                                <h4 class="fw-medium font-size-24">{{ $jmlhLokasi }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stat bg-primary text-white">
                        <div class="card-body">
                            <div class="mb-4 cursor-pointer" data-bs-toggle="modal" data-bs-target="#myProjects">
                                <div class="float-start mini-stat-img me-4">
                                    <i class="fa-solid fa-helmet-safety fa-2x"></i>
                                </div>
                                <h5 class="font-size-16 text-uppercase text-white-50">Proyek</h5>
                                <h4 class="fw-medium font-size-24">{{ $jmlhProyek }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>

<!--  Modal Projects -->
<div id="myProjects" data-bs-backdrop="static" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Projects</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button class="btn btn-primary waves-effect waves-light mx-2" type="button" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#AddProject">
                    <i class="fa-solid fa-plus me-2"></i> Tambah Project
                </button>
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Proyek</th>
                        <th>Lokasi</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($projects as $project )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $project->nama_proyek }}</td>
                                <td>{{ $project->lokasi->nama_lokasi }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--  Modal Lokasi -->
<div id="myLokasi" data-bs-backdrop="static" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lokasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button class="btn btn-primary waves-effect waves-light mx-2" type="button" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#AddLokasi">
                    <i class="fa-solid fa-plus me-2"></i> Tambah Lokasi
                </button>
                <table id="datatable2" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Lokasi</th>
                    </tr>
                    </thead>


                    <tbody>
                        @foreach ($lokasis as $lokasi )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lokasi->nama_lokasi }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal Tambah Lokasi -->
<div id="AddLokasi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="lokasiForm" action="{{ route('tambah-lokasi') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Lokasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <div class="card pb-3">
                            <label for="nama_lokasi" class="form-label">Nama Lokasi</label>
                            <input type="text" name="nama_lokasi" id="nama_lokasi">
                            @error('nama_lokasi')
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
<!-- Modal Tambah Project -->
<div id="AddProject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="projectForm" action="{{ route('tambah-project') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <div class="card pb-3">
                            <label for="nama_proyek" class="form-label">Nama Project</label>
                            <input type="text" name="nama_proyek" id="nama_proyek">
                        </div>
                        <div class="card pb-3">
                            <label for="lokasi_crew" class="form-label">Lokasi</label>
                            <select class="form-select" aria-label="Default select example" id="lokasi_crew" name="lokasi_proyek_id" required>
                                @foreach($lokasis as $lokasi)
                                    <option value="{{ $lokasi->id }}" {{ old('lokasi_proyek_id') == $lokasi->id ? 'selected' : '' }}>{{ $lokasi->nama_lokasi }}</option>
                                @endforeach
                            </select>
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

@push('js')
    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    
    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>

        @if (session('error'))
        <script>
            Swal.fire({
                position: "center",
                icon: "error",
                title: "{{ session('error') }}",
                showConfirmButton: true,
            });
        </script>
        @endif


        <script>
            $(document).ready(function() {
                $('form:not(#formToExclude)').on('submit', function(event) {
                    event.preventDefault();
                    var form = $(this);
                    // Menonaktifkan tombol submit 
                    form.find('button[type="submit"]').prop('disabled', true);
                    
                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {
                            // Jika validasi berhasil, redirect atau lakukan tindakan lain
                            window.location.href = '{{ route('dashboard') }}';
                            Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "Berhasil",
                                    showConfirmButton: false,
                                    timer: 1750
                            });
                        },
                        error: function(xhr) {
                            // Jika validasi gagal, tampilkan pesan kesalahan menggunakan SweetAlert
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';

                            $.each(errors, function(index, value) {
                                errorMessage += value + '<br>';
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: errorMessage
                            });

                            // Mengaktifkan kembali tombol submit 
                            form.find('button[type="submit"]').prop('disabled', false);
                            }
                    });
                });
            });
        </script>
@endpush
@endsection