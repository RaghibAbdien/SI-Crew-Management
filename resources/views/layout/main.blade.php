<!doctype html>
<html lang="en">

    <head>

        @include('includes.head')
        @stack('head')
        <style>
            .cursor-pointer{
                cursor: pointer;
            }
        </style>

    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">
            
            <header id="page-topbar">
                @include('includes.header')
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            @include('includes.sidebar')
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            @yield('content')
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->
        @if(session('session_expired'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Sesi Habis',
                text: '{{ session('session_expired') }}'
            });
        </script>
    @endif

         <!-- Modal Notif Content -->
        @foreach ($notifs as $notif )
        <div id="myNotif{{ $notif->id }}" data-bs-backdrop="static" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Notifications</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="font-size-24">{{ $notif->title }}</h5>
                        <div class="mb-3">
                            <h5 class="col-form-label">Untuk:</h5>
                            <span class="form-control">{{ $notif->nama_crew }}</span>
                        </div>
                        <div class="mb-3">
                            <h5 class="col-form-label">Message:</h5>
                            <span class="form-control">{{ $notif->message }}, Mohon segera ditindaklanjuti</span>
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

        @include('includes.footer')

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <!-- FontAwesome Icon Link -->
        <script src="https://kit.fontawesome.com/91441035a6.js" crossorigin="anonymous"></script>

        <script src="assets/js/app.js"></script>

        @stack('js')

        <script>
            // Update Notification
            $(document).ready(function() {
                $('div[id^="myNotif"]').on('shown.bs.modal', function (e) {
                    var modalId = $(this).attr('id');
                    var notifId = modalId.replace('myNotif', '');
                    
                    // Mendapatkan waktu saat ini
                    var currentTime = new Date();

                    // Menambahkan 7 hari ke waktu saat ini
                    currentTime.setDate(currentTime.getDate() + 7);

                    // Mengonversi waktu ke format yang sesuai untuk MySQL (YYYY-MM-DD HH:MM:SS)
                    var year = currentTime.getFullYear();
                    var month = ('0' + (currentTime.getMonth() + 1)).slice(-2);
                    var day = ('0' + currentTime.getDate()).slice(-2);
                    var hours = ('0' + currentTime.getHours()).slice(-2);
                    var minutes = ('0' + currentTime.getMinutes()).slice(-2);
                    var seconds = ('0' + currentTime.getSeconds()).slice(-2);
                    var formattedTime = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

                    $.ajax({
                        url: '/update-notif',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: notifId,
                            duration: formattedTime
                        },
                        success: function(response) {
                            console.log('Notification status updated successfully.');
                        },
                        error: function(error) {
                            console.log('Error updating notification status:', error);
                        }
                    });
                });
            });


            $(document).ready(function() {
                $('div[id^="myNotif"]').on('hidden.bs.modal', function (e) {
                    location.reload(); // Reload halaman saat modal ditutup
                });
            });
        </script>


    </body>

</html>