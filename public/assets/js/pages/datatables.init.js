// $(document).ready(function(){$("#datatable").DataTable(),$("#datatable-buttons").DataTable({lengthChange:!1,buttons:["copy","excel","pdf","colvis"]}).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),$(".dataTables_length select").addClass("form-select form-select-sm")});

$(document).ready(function(){
    $("#datatable").DataTable({
        lengthChange: false, // Menonaktifkan pilihan untuk mengubah jumlah tampilan data per halaman
        buttons: [] // Tidak menambahkan button apapun
    });
    
    $(".dataTables_length select").addClass("form-select form-select-sm");
});

$(document).ready(function(){
    $("#datatable2").DataTable({
        lengthChange: false, // Menonaktifkan pilihan untuk mengubah jumlah tampilan data per halaman
        buttons: [] // Tidak menambahkan button apapun
    });
    
    $(".dataTables_length select").addClass("form-select form-select-sm");
});
