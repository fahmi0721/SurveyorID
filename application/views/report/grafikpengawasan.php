<div class="col-xl-12 col-md-12 mb-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Grafik Pengawasan Bahan</h6>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChartBahan"></canvas>
            </div>
            <hr>
        </div>
    </div>
</div>

<div class="col-xl-12 col-md-12 mb-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">Grafik Pengawasan Bibit</h6>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChartBibit"></canvas>
            </div>
            <hr>
        </div>
    </div>
</div>

<div class="col-xl-12 col-md-12 mb-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">Grafik Pengawasan Lapangan</h6>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChartLapangan"></canvas>
            </div>
            <hr>
        </div>
    </div>
</div>

<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    // Area Chart myAreaChartBahan
    var ctx = document.getElementById("myAreaChartBahan");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                <?php
                foreach ($tglbahan as $value) {
                    echo '"' . $value['tglbahan'] . '",';
                }
                ?>
            ],
            datasets: [{
                label: "Kegiatan Pengawasan ",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [
                    <?php
                    foreach ($tglbahan as $val) {
                        $jumtgl = $this->report->getKegiatanBahan($val['tglbahan']);
                        echo $jumtgl['jum'] . ", ";
                    }
                    ?>
                ],
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar sign in the ticks
                        callback: function(value, index, values) {
                            return 'Vol ' + number_format(value);
                        }
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgba(255,255,255, 0.9)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 20,
                borderColor: '#dddfeb',
                borderWidth: 2,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': Vol ' + number_format(tooltipItem.yLabel);
                    }
                }
            }
        }
    });

    // Area Chart myAreaChartBibit
    var ctxx = document.getElementById("myAreaChartBibit");
    var myLineChart = new Chart(ctxx, {
        type: 'line',
        data: {
            labels: [
                <?php
                foreach ($tglbibit as $value) {
                    echo '"' . $value['tglbibit'] . '",';
                }
                ?>
            ],
            datasets: [{
                label: "Kegiatan Pengawasan ",
                lineTension: 0.3,
                backgroundColor: "rgba(10, 209, 133, 0.05)",
                borderColor: "rgba(10, 209, 133, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(10, 209, 133, 1)",
                pointBorderColor: "rgba(10, 209, 133, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(10, 209, 133, 1)",
                pointHoverBorderColor: "rgba(10, 209, 133, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [
                    <?php
                    foreach ($tglbibit as $val) {
                        $jumtgl = $this->report->getKegiatanBibit($val['tglbibit']);
                        echo $jumtgl['jum'] . ", ";
                    }
                    ?>
                ],
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar sign in the ticks
                        callback: function(value, index, values) {
                            return 'Vol ' + number_format(value);
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [0],
                        zeroLineBorderDash: [0]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgba(255,255,255, 0.9)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 20,
                borderColor: '#dddfeb',
                borderWidth: 2,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': Vol ' + number_format(tooltipItem.yLabel);
                    }
                }
            }
        }
    });

    // Area Chart myAreaChartLapangan
    var ctxy = document.getElementById("myAreaChartLapangan");
    var myLineChart = new Chart(ctxy, {
        type: 'line',
        data: {
            labels: [
                <?php
                foreach ($tglap as $value) {
                    echo '"' . $value['tglap'] . '",';
                }
                ?>
            ],
            datasets: [{
                label: "Kegiatan Pengawasan ",
                lineTension: 0.3,
                backgroundColor: "rgba(184, 143, 11, 0.05)",
                borderColor: "rgba(184, 143, 11, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(184, 143, 11, 1)",
                pointBorderColor: "rgba(184, 143, 11, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(184, 143, 11, 1)",
                pointHoverBorderColor: "rgba(184, 143, 11, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [
                    <?php
                    foreach ($tglap as $val) {
                        $jumtgl = $this->report->getKegiatanLap($val['tglap']);
                        echo $jumtgl['jum'] . ", ";
                    }
                    ?>
                ],
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar sign in the ticks
                        callback: function(value, index, values) {
                            return 'Vol ' + number_format(value);
                        }
                    }
                }],
            },
            legend: {
                display: true
            },
            tooltips: {
                backgroundColor: "rgba(255,255,255, 0.9)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 20,
                borderColor: '#dddfeb',
                borderWidth: 2,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': Vol ' + number_format(tooltipItem.yLabel);
                    }
                }
            }
        }
    });
</script>