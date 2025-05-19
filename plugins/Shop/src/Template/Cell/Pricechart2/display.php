<?php
global $is_status;
if($is_status == 'single'){
    echo $this->html->script(['/shop/js/chart.js'],['nonce'=>get_nonce])?>
    <script nonce="<?=get_nonce?>">
        window.chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(26, 188, 156)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(201, 203, 207)'
        };

        window.randomScalingFactor = function() {
            return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
        };
        var config = {
            type: 'line',
            data: {
                labels: [<?= isset($data[1])?implode(',',$data[1]):''?>],
                datasets: [{
                    label: "فروشگاه",
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: [<?= isset($data[0])?implode(',',$data[0]):''?>],
                    fill: false,
                }/* , {
                    label: "",
                    fill: false,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: [],
                } */]
            },
            options: {
                responsive: true,
                /* title:{display:true,text:'Chart'}, */
                tooltips: {mode: 'index',intersect: false,},
                hover: {mode: 'nearest',intersect: true},
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {display: true,labelString: 'تاریخ'}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {display: true,labelString: 'قیمت محصول'}
                    }]
                }
            }
        };
        window.onload = function() {
            var ctx = document.getElementById("pricechart-0").getContext("2d");
            window.myLine = new Chart(ctx, config);
        };
    </script>
<?php
}
?>