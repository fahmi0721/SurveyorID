<script type="text/javascript">
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

    var ctx = document.getElementById("myAreaChart").getContext("2d");
    var data = {
        labels: ["Quartal1", "Quartal2", "Quartal3"],
        datasets: [{
                label: "Samsung",
                fill: false,
                lineTension: 0.3,
                backgroundColor: "rgba(59, 100, 222, 1)",
                borderColor: "rgba(59, 100, 222, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(59, 100, 222, 1)",
                pointHoverBorderColor: "rgba(59, 100, 222, 1)",
                pointHitRadius: 15,
                pointBorderWidth: 4,
                data: ["100", "100"]
            },
            {
                label: "Apple",
                fill: false,
                lineTension: 0.3,
                backgroundColor: "rgba(252, 240, 1, 0.9)",
                borderColor: "rgba(252, 240, 1, 0.9)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(252, 240, 1, 0.9)",
                pointHoverBorderColor: "rgba(252, 240, 1, 0.9)",
                pointHitRadius: 15,
                pointBorderWidth: 4,
                data: ["99", "102", "111"]
            },
            {
                label: "Motorola",
                fill: false,
                lineTension: 0.3,
                backgroundColor: "rgba(201, 29, 29, 1)",
                borderColor: "rgba(201, 29, 29, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(201, 29, 29, 1)",
                pointHoverBorderColor: "rgba(201, 29, 29, 1)",
                pointHitRadius: 15,
                pointBorderWidth: 4,
                data: ["130", "140", '109']
            }
        ]
    };

    var myBarChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            barValueSpacing: 20,
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
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            }
        }
    });
</script>