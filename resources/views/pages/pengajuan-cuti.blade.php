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
                                    <button class="btn btn-primary waves-effect waves-light mx-2" type="button" onclick="window.location.href='/export-absensi'">
                                            <i class="fa-solid fa-file-export me-2"></i>Export</button>
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
                                        <th>Waktu Kehadiran</th>
                                        <th>Aksi</th>    
                                    </tr>
                                    </thead>


                                    <tbody>
                                        
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

    @push('js')
       <!-- Required datatable js -->
       <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
       <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

       <!-- Responsive examples -->
       <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
       <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
       
       <!-- Datatable init js -->
       <script src="assets/js/pages/datatables.init.js"></script>  
    @endpush
@endsection