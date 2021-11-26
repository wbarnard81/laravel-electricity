<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.min.js"></script>
<script type="text/javascript">
    let ctx = document.getElementById("canvas").getContext('2d');
    let myChart1 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels:<?php echo json_encode($chartData['date']); ?>,
            datasets: [{
                label: "Units used",
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1,
                data:<?php echo json_encode($chartData['units']); ?>,
            }]
        },
        options: {
            legend: {
            display: true,
            position: 'bottom',
            responsive: true,
            maintainAspectRatio: true,
            labels: {
                fontColor: '#71748d',
                fontFamily: 'Circular Std Book',
                fontSize: 14,
            }
        },
    }
    });
</script>