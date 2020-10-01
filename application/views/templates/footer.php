<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Alimalhaq <?= date('Y'); ?></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->

<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.js"></script>
<!-- script untuk ajax  -->

<!-- Page Data Tables level plugins -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- jquery-3.5.1.min.js -->
<!-- <script src="assets/jquery-3.5.1.min.js"></script> -->
<!-- Page Data Tables level custom scripts -->
<script type="text/JavaScript">

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    // untuk data table 
    $(document).ready(function() {
        $('#dataTableBlok').DataTable();
    }); 
    $(document).ready(function() {
        $('#dataTables').DataTable();
    });
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
    $(document).ready(function() {
        $('#dataTabl').DataTable();
    });
    $(document).ready(function() {
        $('#dataTab').DataTable();
    });
    $(document).ready(function() {
        $('#dataTableDes').DataTable();
    });

    // js untuk input type="file"
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // js untuk role change 
    $(".changeAccess").on("click", function() {
            const menuId = $(this).data('menu');
            const roleId = $(this).data('role');
            var confir = confirm("Are you sure want to change this access?");
		if (confir == true) {
            $.ajax({
                url: "<?= base_url('admin/changeaccess'); ?>",
                type: 'post',
                data: {
                    menuId: menuId,
                    roleId: roleId
                },
                success: function() {
                    document.location.href = "<?= base_url('admin/roleAccess/'); ?>" + roleId;
                }
            });
        }
    });

    // js ajax untuk sub form select 
    $(document).ready(function() {
        $('#kabu').change(function() {
            // var confir = confirm("Are you sure want to change this access?");
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('lokasi/kecAjax'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = "<option value=''>Pilih Kecamatan</option>";
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id_kecamatan + '>' + data[i].nm_kecamatan + '</option>';
                    }
                    $('#keca').html(html);
                }
            });
            return false;
        });
    });
    
    // js ajax untuk sub form select kabupaten Edit Desa
    $(document).ready(function() {
        $('#kabuE').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('lokasi/kecAjax'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = "<option value=''>Pilih Kecamatan</option>";
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id_kecamatan + '>' + data[i].nm_kecamatan + '</option>';
                    }
                    $('#kecaE').html(html);
                }
            });
            return false;
        });
    });
    
    // js ajax untuk Input Pengawasan form kecamatan
    $(document).ready(function() {
        $('#kabupat').change(function() {
            // var confir = confirm("Are you sure want to change this access?");
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('input/kecAjax'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = "<option value=''>Pilih Kecamatan</option>";
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id_kecamatan + '>' + data[i].nm_kecamatan + '</option>';
                    }
                    $('#kecamat').html(html);
                }
            });
            return false;
        });
    });
    // js ajax untuk Input Pengawasan form Desa
    $(document).ready(function() {
        $('#kecamat').change(function() {
            // var confir = confirm("Are you sure want to change this access?");
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('input/desaAjax'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = "<option value=''>Pilih Desa</option>";
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id_desa + '>' + data[i].nm_desa + '</option>';
                    }
                    $('#deselect').html(html);
                }
            });
            return false;
        });
    });

    // validasi ukuran input file foto maksimal 1 MB 
    function ValidateSize(file) {
        var pathFile = file.value;
        var ekstensiOk = /(\.jpg|\.jpeg|\.png|\.gif|\.JPG|\.JPEG|\.PNG|\.GIF)$/i; //tipe file
        var FileSize = file.files[0].size / 1024 / 1024; // in MB
        if (FileSize > 1) {
            alert('Ukuran File Melebihi 1 MB');
            $(file).val(''); //for clearing with Jquery
        }else if(!ekstensiOk.exec(pathFile)) {
            alert('Ekstensi file tidak mendukung. Silakan upload file yang memiliki ekstensi .jpeg/.jpg/.png/.gif');
            $(file).val(''); //for clearing with Jquery
        }
    }
    
    // validasi ukuran input file Video maksimal 20 MB 
    function ValidateVid(video) {
        var pathFile = video.value;
        var ekstensiOk = /(\.mp4|\.3gp|\.flv)$/i; //tipe file
        var FileSize = video.files[0].size / 5480 / 5480; // in MB
        if (FileSize > 1) {
            alert('Ukuran File Melebihi 20 MB');
            $(video).val(''); //for clearing with Jquery
        }else if(!ekstensiOk.exec(pathFile)) {
            alert('Ekstensi file tidak mendukung. Silakan upload file yang memiliki Tipe file mp4/3gp/flv');
            $(video).val(''); //for clearing with Jquery
        }
    }


    // js ajax untuk Input Pengawasan form kecamatan Di blok.php
    $(document).ready(function() {
        $('#kabAjx').change(function() {
            // var confir = confirm("Are you sure want to change this access?");
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('input/kecAjax'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = "<option value=''>Pilih Kecamatan</option>";
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id_kecamatan + '>' + data[i].nm_kecamatan + '</option>';
                    }
                    $('#kecAjx').html(html);
                }
            });
            return false;
        });
    });
    // js ajax untuk Input Pengawasan form Desa Di blok.php
    $(document).ready(function() {
        $('#kecAjx').change(function() {
            // var confir = confirm("Are you sure want to change this access?");
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('input/desaAjax'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = "<option value=''>Pilih Desa</option>";
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id_desa + '>' + data[i].nm_desa + '</option>';
                    }
                    $('#desAjax').html(html);
                }
            });
            return false;
        });
    });
    
    // js ajax untuk form Add Blok select Blok berdasarkan desa
    $(document).ready(function() {
        $('#desaBlokAjax').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('lokasi/desblAjax'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = "<option value=''>Pilih Blok</option>";
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id_blok + '>' + data[i].nm_blok + '</option>';
                    }
                    $('#blokAjax').html(html);
                }
            });
            return false;
        });
    });
    // js ajax untuk form Pengawasan select Blok berdasarkan desa
    $(document).ready(function() {
        $('#deselect').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('input/desblAjax'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = "<option value=''>Pilih Blok</option>";
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id_blok + '>' + data[i].nm_blok + '</option>';
                    }
                    $('#blok').html(html);
                }
            });
            return false;
        });
    });
    // js ajax untuk form Pengawasan select Petak berdasarkan Blok
    $(document).ready(function() {
        $('#blok').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('input/blpetAjax'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = "<option value=''>Pilih Petak</option>";
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id_petak + '>' + data[i].nm_petak + '</option>';
                    }
                    $('#petak').html(html);
                }
            });
            return false;
        });
    });
    // js ajax untuk form Add SPK Lapangan Select Desa ke Blok
    $(document).ready(function() {
        $('#desalap').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('input/desblAjax'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = "<option value=''>Pilih Blok</option>";
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id_blok + '>' + data[i].nm_blok + '</option>';
                    }
                    $('#bloklap').html(html);
                }
            });
            return false;
        });
    });
    // js ajax untuk form Add SPK Lapangan Select Blok ke Petak
    $(document).ready(function() {
        $('#bloklap').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('input/blpetAjax'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = "<option value=''>Pilih Petak</option>";
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id_petak + '>' + data[i].nm_petak + '</option>';
                    }
                    $('#petaklap').html(html);
                }
            });
            return false;
        });
    });
    // js ajax untuk form SPK Bibit select Blok berdasarkan desa
    $(document).ready(function() {
        $('#desbibit').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('input/desblAjax'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = "<option value=''>Pilih Blok</option>";
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id_blok + '>' + data[i].nm_blok + '</option>';
                    }
                    $('#blokbibit').html(html);
                }
            });
            return false;
        });
    });
    // js ajax untuk form SPK Bibit select Petak berdasarkan Blok
    $(document).ready(function() {
        $('#blokbibit').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('input/blpetAjax'); ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = "<option value=''>Pilih Petak</option>";
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].id_petak + '>' + data[i].nm_petak + '</option>';
                    }
                    $('#petakbibit').html(html);
                }
            });
            return false;
        });
    });


</script>

</body>

</html>