<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800 font-weight-bold"><a href="<?= base_url('input/view'); ?>"><?= $title; ?></a> <small class="text-info"></small></h1>
    <?= $this->session->flashdata('message'); ?>
    <?php
    include 'view-pengawasan.php';
    ?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->