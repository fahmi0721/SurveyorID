<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= $this->session->flashdata('message'); ?>

    <?php

    // Collapsable Card Blok
    $this->load->view('lokasi/blok');

    // Collapsable Card Desa
    $this->load->view('lokasi/desa');

    // Collapsable Card Kecamatan
    $this->load->view('lokasi/kecamatan');

    // Collapsable Card Kabupaten
    $this->load->view('lokasi/kabupaten');

    ?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->