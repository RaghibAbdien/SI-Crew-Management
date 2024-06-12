@extends('layout.main')

@section('title', 'Management Crew')

@section('content')

    @push('head')
        <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">



        <!-- Responsive datatable examples -->
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
    
        <style>
            .docs{
                display: grid;
                grid-template-columns: repeat(1, auto);
                gap: .5rem;
            }

            .mcu{
                display: grid;
                grid-template-columns: repeat(3, auto);
                gap: .5rem;
            }
        </style>
    @endpush


    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="page-title">Management Crew</h6>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item active">Welcome to Management Crew</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row align-items-center mb-0">
                        <div class="col-md-12">
                            <div class="float-end d-md-block">
                                <div class="my-2 text-center">
                                    <button class="btn btn-primary waves-effect waves-light mx-2" type="button" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#myModal">
                                        <i class="fa-solid fa-plus me-2"></i> Tambah Crew
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

                                <h1 class="card-title text-center fs-2 pb-3">Crew</h1>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Email</th>
                                        <th>No.HP</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                        
                                        
                                    </tr>
                                    </thead>


                                    <tbody>
                                    @foreach($crews as $crew)
                                        <tr>
                                            <td>{{ $crew->id_crew }}</td>
                                            <td>{{ $crew->nama_crew }}</td>
                                            <td>{{ $crew->alamat_crew }}</td>
                                            <td>{{ $crew->email_crew }}</td>
                                            <td>{{ $crew->nohp_crew }}</td>
                                            <td>
                                                <div class="
                                                @if ($crew->status_crew == 1)
                                                badge bg-success
                                                @else
                                                 badge bg-danger
                                                @endif
                                            ">
                                                @if ($crew->status_crew == 1)
                                                    Aktif
                                                @else
                                                    Tidak Aktif    
                                                @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex items-center gap-3">
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myDetail{{ $crew->id_crew }}">
                                                        <i class="mdi mdi-eye"></i>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myUpdate{{ $crew->id_crew }}">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </button>
                                                </div>
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
            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="crewForm" action="{{ route('tambah-crew') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Tambah Crew</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col">
                                    <div class="col-md-12 pb-3">
                                        <label for="id-crew" class="form-label">ID Crew</label>
                                        <input type="text" class="form-control" id="id-crew" name="id_crew" required value="{{ old('id_crew') }}">
                                        @error('id_crew')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 pb-3">
                                        <label for="nama" class="form-label">Nama Crew</label>
                                        <input type="text" class="form-control" id="nama" name="nama_crew" autocomplete="name" required value="{{ old('nama_crew') }}">
                                        @error('nama_crew')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="alamat_crew">Alamat :</label>
                                        <textarea id="alamat_crew" class="form-control" rows="3" name="alamat_crew" autocomplete="alamat_crew" required>{{ old('alamat_crew') }}</textarea>
                                        @error('alamat_crew')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 pb-3">
                                        <label for="email_crew" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email_crew" name="email_crew" autocomplete="email" required value="{{ old('email_crew') }}">
                                        @error('email_crew')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 pb-3">
                                        <label for="nohp_crew" class="form-label">No. HP</label>
                                        <input type="text" class="form-control" id="nohp_crew" name="nohp_crew" autocomplete="nohp_crew" required value="{{ old('nohp_crew') }}">
                                        @error('nohp_crew')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="card pb-1">
                                        <label for="project_crew" class="form-label">Project</label>
                                        <select class="form-select" aria-label="Default select example" id="project_crew" name="project_crew_id" required>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}" {{ old('project_crew_id') == $project->id ? 'selected' : '' }}>{{ $project->nama_proyek }}</option>
                                            @endforeach
                                        </select>
                                        @error('project_crew_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="card pb-3">
                                        <label for="lokasi_crew" class="form-label">Lokasi</label>
                                        <select class="form-select" aria-label="Default select example" id="lokasi_crew" name="lokasi_crew_id" required>
                                            @foreach($lokasis as $lokasi)
                                                <option value="{{ $lokasi->id }}" {{ old('lokasi_crew_id') == $lokasi->id ? 'selected' : '' }}>{{ $lokasi->nama_lokasi }}</option>
                                            @endforeach
                                        </select>
                                        @error('lokasi_crew_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="cv">CV (.pdf) (2MB)</label>
                                        <input type="file" id="cv" class="filestyle" data-buttonname="btn-secondary" name="cv_path" accept=".pdf">
                                        @error('cv_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="ktp">KTP (.pdf) (2MB)</label>
                                        <input type="file" id="ktp" class="filestyle" data-buttonname="btn-secondary" name="ktp_path" accept=".pdf">
                                        @error('ktp_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="vaksin">Vaksin (.pdf) (2MB)</label>
                                        <input type="file" id="vaksin" class="filestyle" data-buttonname="btn-secondary" name="vaksin_path[]" multiple accept=".pdf">
                                        @if($errors->has('vaksin_path.*'))
                                            <div class="text-danger">
                                                @foreach($errors->get('vaksin_path.*') as $message)
                                                    {{ $message[0] }}<br>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="pkwt">PKWT (.pdf) (2MB)</label>
                                        <input type="file" id="pkwt" class="filestyle" data-buttonname="btn-secondary" name="pkwt_path" accept=".pdf">
                                        @error('pkwt_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="sertifikat">Sertifikat (.pdf) (2MB)</label>
                                        <input type="file" id="sertifikat" class="filestyle" data-buttonname="btn-secondary" id="file-sertif" name="sertifikat_path[]" multiple accept=".pdf">
                                        @if($errors->has('sertifikat_path.*'))
                                            <div class="text-danger">
                                                @foreach($errors->get('sertifikat_path.*') as $message)
                                                    {{ $message[0] }}<br>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="ijazah">Ijazah (.pdf) (2MB)</label>
                                        <input type="file" id="ijazah" class="filestyle" data-buttonname="btn-secondary" name="ijazah_path" accept=".pdf">
                                        @error('ijazah_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="foto">Foto Crew</label>
                                        <input type="file" id="foto" class="filestyle" data-buttonname="btn-secondary" name="fotocrew_path" accept="image/*">
                                        @error('fotocrew_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="npwp">NPWP (.pdf) (2MB)</label>
                                        <input type="file" id="npwp" class="filestyle" data-buttonname="btn-secondary" name="npwp_path" accept=".pdf">
                                        @error('npwp_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="skck">SKCK (.pdf) (2MB)</label>
                                        <input type="file" id="skck" class="filestyle" data-buttonname="btn-secondary" name="skck_path" accept=".pdf">
                                        @error('skck_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="mcu">Medical Check Up (.pdf) (2MB)</label>
                                        <input type="file" id="mcu" class="filestyle" data-buttonname="btn-secondary" name="mcu_path[]" multiple accept=".pdf">
                                        @if($errors->has('mcu_path.*'))
                                            <div class="text-danger">
                                                @foreach($errors->get('mcu_path.*') as $message)
                                                    {{ $message[0] }} <br>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="tgl_mcu" class="col-sm-6 col-form-label">Tanggal Pemeriksaan MCU</label>
                                        <input class="form-control" type="date" id="tgl_mcu" required name="tgl_mcu" value="{{ old('tgl_mcu') }}">
                                        @error('tgl_mcu')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="expired_mcu" class="col-sm-6 col-form-label">Tanggal Expired MCU</label>
                                        <input class="form-control" type="date" id="expired_mcu" required name="expired_mcu">
                                        @error('expired_mcu')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="awal_kontrak" class="col-sm-6 col-form-label">Tanggal Mulai Kontrak</label>
                                        <input class="form-control" type="date" id="awal_kontrak" required name="awal_kontrak" value="{{ old('awal_kontrak') }}">
                                        @error('awal_kontrak')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="berakhir_kontrak" class="col-sm-6 col-form-label">Tanggal Berakhir Kontrak</label>
                                        <input class="form-control" type="date" id="berakhir_kontrak" required name="berakhir_kontrak">
                                        @error('berakhir_kontrak')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="card pb-3">
                                        <label for="id_bank" class="form-label">Bank</label>
                                        <select class="form-select" aria-label="Default select example" id="id_bank" name="id_bank" required>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank->id }}" {{ old('id_bank') == $bank->id ? 'selected' : '' }}>{{ $bank->nama_bank }}</option>
                                            @endforeach
                                        </select>
                                        @error('lokasi_crew_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 pb-3">
                                        <label for="no_rekening" class="form-label">No Rekening</label>
                                        <input type="text" class="form-control" id="no_rekening" name="no_rekening" required value="{{ old('no_rekening') }}">
                                        @error('no_rekening')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="submitBtn" class="btn btn-primary waves-effect waves-light">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
    
    
            <!-- Modal Edit Crew -->
            @foreach ($updates as $update )
            @php
                $isEdit = isset($update);
            @endphp
            <div id="myUpdate{{ $update->id_crew }}" class="modal fade update-modal" tabindex="-1" role="dialog" aria-labelledby="myUpdateLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="updateCrewForm" action="{{ route('update-crew', ['id' => $update->id_crew]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Edit Crew</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col">
                                    <div class="col-md-12 pb-3">
                                        <label for="id-crew" class="form-label">ID Crew</label>
                                        <input type="text" class="form-control bg-secondary" id="id-crew" name="id_crew" required value="{{ $update->id_crew }}" disabled>
                                        @error('id_crew')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 pb-3">
                                        <label for="nama" class="form-label">Nama Crew</label>
                                        <input type="text" class="form-control" id="nama" name="nama_crew" autocomplete="name" required value="{{ $update->nama_crew }}">
                                        @error('nama_crew')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="alamat_crew">Alamat :</label>
                                        <textarea id="alamat_crew" class="form-control" rows="3" name="alamat_crew" autocomplete="alamat_crew" required>{{ $update->alamat_crew }}</textarea>
                                        @error('alamat_crew')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 pb-3">
                                        <label for="email_crew" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email_crew" name="email_crew" autocomplete="email" required value="{{ $update->email_crew }}">
                                        @error('email_crew')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 pb-3">
                                        <label for="nohp_crew" class="form-label">No. HP</label>
                                        <input type="text" class="form-control" id="nohp_crew" name="nohp_crew" autocomplete="nohp_crew" required value="{{ $update->nohp_crew }}">
                                        @error('nohp_crew')
                                            <div class="text-danger update">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="card pb-3">
                                        <label for="project_crew" class="form-label">Project</label>
                                        <select class="form-select" aria-label="Default select example" id="project_crew" name="project_crew_id" required>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}" {{ $update->project_crew_id == $project->id ? 'selected' : '' }}>{{ $project->nama_proyek }}</option>
                                            @endforeach
                                        </select>
                                        @error('project_crew_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="card pb-3">
                                        <label for="lokasi_crew" class="form-label">Lokasi</label>
                                        <select class="form-select" aria-label="Default select example" id="lokasi_crew" name="lokasi_crew_id" required>
                                            @foreach($lokasis as $lokasi)
                                                <option value="{{ $lokasi->id }}" {{ $update->lokasi_crew_id == $lokasi->id ? 'selected' : '' }}>{{ $lokasi->nama_lokasi }}</option>
                                            @endforeach
                                        </select>
                                        @error('lokasi_crew_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="card pb-3">
                                        <label for="status-crew" class="form-label">Status Crew</label>
                                        <select class="form-select" name="status_crew" id="status-crew">
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="cv">CV (.pdf) (2MB)</label>
                                        <input type="file" id="cv" class="filestyle" data-buttonname="btn-secondary" name="cv_path">
                                        @error('cv_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="ktp">KTP (.pdf) (2MB)</label>
                                        <input type="file" id="ktp" class="filestyle" data-buttonname="btn-secondary" name="ktp_path">
                                        @error('ktp_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="vaksin">Vaksin (.pdf) (2MB)</label>
                                        <input type="file" id="vaksin" multiple class="filestyle" data-buttonname="btn-secondary" name="vaksin_path[]">
                                        @if($errors->has('vaksin_path.*'))
                                            <div class="text-danger">
                                                @foreach($errors->get('vaksin_path.*') as $message)
                                                    {{ $message[0] }}<br>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="pkwt">PKWT (.pdf) (2MB)</label>
                                        <input type="file" id="pkwt" class="filestyle" data-buttonname="btn-secondary" name="pkwt_path">
                                        @error('pkwt_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="sertifikat">Sertifikat (.pdf) (2MB)</label>
                                        <input type="file" id="sertifikat" class="filestyle" data-buttonname="btn-secondary" name="sertifikat_path[]" multiple>
                                        @if($errors->has('sertifikat_path.*'))
                                            <div class="text-danger">
                                                @foreach($errors->get('sertifikat_path.*') as $message)
                                                    {{ $message[0] }}<br>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="ijazah">Ijazah (.pdf) (2MB)</label>
                                        <input type="file" id="ijazah" class="filestyle" data-buttonname="btn-secondary" name="ijazah_path">
                                        @error('ijazah_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="foto">Foto Crew</label>
                                        <input type="file" id="foto" class="filestyle" data-buttonname="btn-secondary" name="fotocrew_path">
                                        @error('fotocrew_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="npwp">NPWP (.pdf) (2MB)</label>
                                        <input type="file" id="npwp" class="filestyle" data-buttonname="btn-secondary" name="npwp_path">
                                        @error('npwp_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="skck">SKCK (.pdf) (2MB)</label>
                                        <input type="file" id="skck" class="filestyle" data-buttonname="btn-secondary" name="skck_path">
                                        @error('skck_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="mcu">Medical Check Up (.pdf) (2MB)</label>
                                        <input type="file" id="mcu" class="filestyle" data-buttonname="btn-secondary" name="mcu_path[]" multiple>
                                        @error('mcu_path')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="tgl_mcu" class="col-sm-6 col-form-label">Tanggal Pemeriksaan MCU</label>
                                        <input class="form-control" type="date" id="tgl_mcu" required name="tgl_mcu" value="{{ $update->tgl_mcu }}">
                                        @error('tgl_mcu')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="expired_mcu" class="col-sm-6 col-form-label">Tanggal Expired MCU</label>
                                        <input class="form-control" type="date" id="expired_mcu" required name="expired_mcu" value="{{ $update->expired_mcu }}">
                                        @error('expired_mcu')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="awal_kontrak" class="col-sm-6 col-form-label">Tanggal Mulai Kontrak</label>
                                        <input class="form-control" type="date" id="awal_kontrak" required name="awal_kontrak" value="{{ $update->awal_kontrak }}">
                                        @error('awal_kontrak')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="berakhir_kontrak" class="col-sm-6 col-form-label">Tanggal Berakhir Kontrak</label>
                                        <input class="form-control" type="date" id="berakhir_kontrak" required name="berakhir_kontrak" value="{{ $update->berakhir_kontrak }}">
                                        @error('berakhir_kontrak')
                                            <div class="text-danger update">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="card pb-3">
                                        <label for="id_bank" class="form-label">Bank</label>
                                        <select class="form-select" aria-label="Default select example" id="id_bank" name="id_bank" required>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank->id }}" {{ $update->id_bank == $bank->id ? 'selected' : '' }}>{{ $bank->nama_bank }}</option>
                                            @endforeach
                                        </select>
                                        @error('lokasi_crew_id')
                                            <div class="text-danger update">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 pb-3">
                                        <label for="no_rekening" class="form-label">No Rekening</label>
                                        <input type="text" class="form-control" id="no_rekening" name="no_rekening" required value="{{ $update->no_rekening }}">
                                        @error('no_rekening')
                                            <div class="text-danger update">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="submitBtn" class="btn btn-primary waves-effect waves-light">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            @endforeach
            <!-- /.modal -->
    
            <!-- Modal Detail Crew -->
            @foreach ($docs as $doc )
            <div id="myDetail{{ $doc->id_crew }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Detail Crew</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="card mb-3">
                                    <img src="{{ Storage::url($doc->fotocrew_path) }}" class="card-img-top" alt="{{ $doc->fotocrew_path }}">
                                    <div class="card-body">
                                      <h5 class="card-title">Dokumen Crew</h5>
                                      <ul class="card-text">
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>CV</span>
                                                <a href="{{ Storage::url($doc->cv_path) }}" target="_blank" class="btn btn-primary waves-effect waves-light">Lihat CV</a>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>KTP</span>
                                                <a href="{{ Storage::url($doc->ktp_path) }}" target="_blank" class="btn btn-primary waves-effect waves-light">Lihat KTP</a>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>PKWT</span>
                                                <a href="{{ Storage::url($doc->pkwt_path) }}" target="_blank" class="btn btn-primary waves-effect waves-light">Lihat PKWT</a>
                                            </div>
                                        </li>    
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Ijazah</span>
                                                <a href="{{ Storage::url($doc->ijazah_path) }}" target="_blank" class="btn btn-primary waves-effect waves-light">Lihat Ijazah</a>
                                            </div>
                                        </li>    
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>NPWP</span>
                                                <a href="{{ Storage::url($doc->npwp_path) }}" target="_blank" class="btn btn-primary waves-effect waves-light">Lihat NPWP</a>
                                            </div>
                                        </li>    
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>SKCK</span>
                                                <a href="{{ Storage::url($doc->skck_path) }}" target="_blank" class="btn btn-primary waves-effect waves-light">Lihat SKCK</a>
                                            </div>
                                        </li>    
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>No. Rekening</span>
                                                <span class="fs-4 fw-bold">{{ $doc->no_rekening }}</span>
                                            </div>
                                        </li>    
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Bank</span>
                                                <span class="fs-4 fw-bold">{{ $doc->crew->bank->nama_bank }}</span>
                                            </div>
                                        </li>    
                                        @if(!empty($doc->mcu_path))
                                           <li class="list-group-item">
                                               <div class="d-flex flex-column justify-content-between align-items-center">
                                                   <span>MCU</span>
                                                   <div class="mcu my-2">
                                                       @php $no = 1; @endphp
                                                        @foreach(json_decode($doc->mcu_path) as $mcu)
                                                       <a href="{{ Storage::url($mcu) }}" target="_blank" class="btn btn-primary waves-effect waves-light">MCU No. {{ $no }}</a>
                                                       @php $no++; @endphp
                                                       @endforeach
                                                    </div>
                                               </div>
                                           </li>
                                       @endif
                                        @if(!empty($doc->vaksin_path))
                                           <li class="list-group-item">
                                               <div class="d-flex flex-column justify-content-between align-items-center">
                                                   <span>Vaksin</span>
                                                   <div>
                                                       @php $no = 1; @endphp
                                                        @foreach(json_decode($doc->vaksin_path) as $vaksin)
                                                       <a href="{{ Storage::url($vaksin) }}" target="_blank" class="btn btn-primary waves-effect waves-light">Vaksin No. {{ $no }}</a>
                                                       @php $no++; @endphp
                                                       @endforeach
                                                    </div>
                                               </div>
                                           </li>
                                       @endif
                                       @if(!empty($doc->sertifikat_path))
                                        <li class="list-group-item">
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <span>Sertifikat</span>
                                                <div class="docs my-2">
                                                    @php $no = 1; @endphp
                                                    @foreach(json_decode($doc->sertifikat_path) as $index => $sertif)
                                                        <div class="d-flex align-items-center my-2 gap-2">
                                                            <a href="{{ Storage::url($sertif) }}" target="_blank" class="btn btn-primary waves-effect waves-light">Sertif No. {{ $no }}</a>
                                                            <button type="button" class="btn btn-danger ml-2 delete-certificate" data-index="{{ $index }}" data-id="{{ $doc->id }}">Hapus</button>
                                                        </div>
                                                        @php $no++; @endphp
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
    
                                        <form id="delete-certificate-form" action="{{ route('hapus-sertif', $doc->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="index" id="certificate-index">
                                        </form>
                                        @endif
    
                                       <li>MCU Berlaku hingga : <span class="fw-bold">{{ $doc->selisih_hari }}</span> lagi</li>    
                                       <li>Kontrak Berlaku hingga : <span class="fw-bold">{{ $doc->kontrak }}</span> lagi</li>    
                                        
                                      </ul>
                                    </div>
                                  </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                            </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            @endforeach    

    @push('js')

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    
    <!-- Datatable init js -->
    <script src="assets/js/pages/datatables.init.js"></script>   
    
    <!-- Script -->
    <script src="assets/js/script.js"></script>

    @if (session('error'))
        <script>
            Swal.fire({
                position: "center",
                icon: "error",
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 1750
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
        
                // Membuat objek FormData
                var formData = new FormData(form[0]);
        
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: formData,
                    contentType: false, // Tidak mengatur tipe konten
                    processData: false, // Tidak memproses data
                    success: function(response) {
                        // Jika validasi berhasil, redirect atau lakukan tindakan lain
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Berhasil",
                            showConfirmButton: false,
                            timer: 1750
                        }).then(function() {
                            // Setelah Swal selesai ditampilkan, lakukan redirect
                            window.location.href = '{{ route('crew') }}';
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
        

    <script>
        $(document).ready(function() {
            $('.delete-certificate').on('click', function() {
                var index = $(this).data('index');
                var docId = $(this).data('id');
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan bisa mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#certificate-index').val(index);
                        $('#certificate-doc-id').val(docId);
                        $('#delete-certificate-form').submit();
                    }
                });
            });
        });
    </script>

    <script>
    $(document).ready(function() {
        // Ketika modal ditutup, reset form
        $('#myModal').on('hidden.bs.modal', function () {
            $('#crewForm')[0].reset();
        });
    });
    </script>

    @endpush            

@endsection