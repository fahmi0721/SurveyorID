<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <?= $this->session->flashdata('message'); ?>
    <?php
    include 'spk-lapangan.php';
    include 'spk-bahan.php';
    include 'spk-bibit.php';
    ?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->