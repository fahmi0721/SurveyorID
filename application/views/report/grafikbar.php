<!-- // Bar chart Kabupaten -->
<div class="col-xl-12 col-md-12 mb-4">
    <div class="card shadow mb-4">
        <div class="card-header">
            <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-fw fa-chart-bar"></i> Diagram Kemajuan Rehabilitasi DAS - Semua Kabupaten</h4>
        </div>
        <div class="card-body">
            <canvas id="myChart"></canvas>
            <hr>
        </div>
    </div>
</div>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
            labels: [
                <?php
                foreach ($kabupaten as $value) {
                    echo '"' . $value['nm_kabupaten'] . '",';
                }
                ?>
            ],
            datasets: [{
                    label: 'Target Volume SPK',
                    data: [
                        <?php
                        foreach ($kabupaten as $value) {
                            $spk = $this->report->LoadSPK($value['id_kabupaten']);
                            echo '"' . $spk['totalSpk'] . '", ';
                        }
                        ?>
                    ],
                    backgroundColor: 'rgb(3, 140, 83)',
                    borderColor: 'rgb(56, 86, 255)',
                },
                {
                    label: 'Terealisasi',
                    data: [
                        <?php
                        foreach ($kabupaten as $value) {
                            $spkReal = $this->report->LoadRealisasi($value['id_kabupaten']);
                            if ($spkReal['totalRealisasi'] == '') {
                                echo '0, ';
                            } else {
                                echo '"' . $spkReal['totalRealisasi'] . '",';
                            }
                        }
                        ?>
                    ],
                    backgroundColor: 'rgb(096, 099, 999)',
                    borderColor: 'rgb(3, 140, 83)',
                }
            ]
        },

        // Configuration options go here
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    }
                }]
            },
            legend: {
                display: true
            },
            pieceLabel: {
                fontColor: '#4f0202',
                fontSize: 16,
                position: 'inside',
                segment: true
            },
            animation: {
                duration: 1,
                onComplete: function() {
                    var chartInstance = this.chart,
                        ctx = chartInstance.ctx;
                    ctx.textAlign = 'center';
                    ctx.fillStyle = "rgba(0, 0, 132, 1)";
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function(dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function(bar, index) {
                            var data = number_format(dataset.data[index], '0', '.', ',');
                            ctx.fillText(data, bar._model.x, bar._model.y - 5);

                        });
                    });
                }
            },
        }
    });
</script>