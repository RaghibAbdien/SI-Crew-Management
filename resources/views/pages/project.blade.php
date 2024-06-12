@extends('layout.main')

@section('title', 'Proyek')

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
                <div class="page-title-box mb-1">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="page-title">Proyek Crew</h6>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Welcome to Proyek Crew</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h1 class="card-title text-center fs-2 pb-3">Proyek Crew</h1>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Project</th>
                                        <th>Lokasi</th>
                                        
                                        
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($crews as $crew )
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $crew->nama_crew }}</td>
                                                <td>{{ $crew->proyeks->nama_proyek }}</td>
                                                <td>{{ $crew->lokasi->nama_lokasi }}</td>
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