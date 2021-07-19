<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Electricity Monitoring</title>

        <link rel="icon" type="image/x-icon" href="/favicon.ico">
        <link rel="stylesheet" href="css/bootstrap.min.css">

    </head>
    <body class="antialiased">
        <navbar>
            <h2 class="bg-secondary text-white display-6 text-center p-3">
                <strong>Electricity Monitoring</strong>
            </h2>
        </navbar>
        
        <div class="container">
            <section class="my-4">
                <form action="index.php" method="post">
                    <div class="row g-2">
                        <div class="col-md">
                            <div class="row">
                                <label for="dbMeter" class="col-sm-3 col-form-label">DB Meter Reading:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="dbMeter" id="dbMeter" value="<?php $POST['dbMeter'] ?? '' ?>">
                                    @error('dbMeter')
                                        <div class="invalid-feedback">
                                            <?php echo $errors['dbMeter'] ?>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="row">
                                <label for="units_purchased" class="col-sm-3 col-form-label">Units Purchased:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="units_purchased" id="units_purchased" placeholder="0">
                                    @error('units_purchased')
                                    <div class="invalid-feedback">
                                        <?php echo $errors['units_purchased'] ?>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button class="btn btn-sm btn-dark mt-2" type="submit" name="submit">Submit</button>
                </form>
            </section>
            <section>
                <div class="row align-items-start">
                    <div class="col">
                        <canvas id="barchart" ></canvas>
                    </div>
                    <div class="col">
                        <table id="meterTable" class="table is-striped is-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Previou Meter Reading</th>
                                    <th>DB Meter Reading</th>
                                    <th>Units Used</th>
                                    <th>Units Purchased</th>
                                </tr>
                            </thead>
                            <tbody id="meterTableBody">
                                <?php foreach($readings as $reading) { ?>
                                <tr>
                                    <td>{{ date("Y/m/d", strtotime($reading->created_at)) }}</td>
                                    <td>{{ $reading->previous_meter_reading }}</td>
                                    <td>{{ $reading->meter_reading }}</td>
                                    <td>{{ intval($reading->previous_meter_reading) - intval($reading->meter_reading) - intval($reading->units_purchased) }}</td>
                                    <td>{{ $reading->units_purchased }}</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <div id="output"></div>
                        </table>
                    </div>
                </div>
            </section>
        </div>
        <footer class="footer mt-auto py-3 bg-light">
            <div class="container">
                <div class="text-muted text-center">
                    <h5 class="m-0">Designed by Werner Barnard.</h5>
                </div>
            </div>
        </footer>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.min.js"></script>
        <script type="text/javascript">
            let ctx = document.getElementById("barchart").getContext('2d');
            ctx.width  = 800;
            ctx.height = 600;
            let myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels:<?php echo json_encode(''); ?>,
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
                        data:<?php echo json_encode(''); ?>,
                    }]
                },
                options: {
                    legend: {
                    display: true,
                    position: 'bottom',

                    labels: {
                        fontColor: '#71748d',
                        fontFamily: 'Circular Std Book',
                        fontSize: 14,
                    }
                },
            }
            });
        </script>
    </body>
</html>
