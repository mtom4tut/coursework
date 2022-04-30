<form class="form auth" action="/admin/statistics_user.php" method="post" autocomplete="off">
    <div class="form__group">
        <label class="form__label" for="date-from">Дата начала периода отчета</label>
        <input class="form__input form__input--date" type="text" name="date-from" id="date-from" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= get_post_val("date-from") ?>">

        <?php if (isset($errors["date-from"])) : ?>
            <p class="form__message"> <?= $errors["date-from"] ?> </p>
        <?php endif; ?>
    </div>

    <div class="form__group">
        <label class="form__label" for="date-to">Дата окончания периода отчета</label>

        <input class="form__input form__input--date" type="text" name="date-to" id="date-to" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= get_post_val("date-to") ?>">

        <?php if (isset($errors["date-to"])) : ?>
            <p class="form__message"> <?= $errors["date-to"] ?> </p>
        <?php endif; ?>
    </div>

    <input type="submit" class="btn-primary" name="" value="Сформировать отчет">

    <a class="btn-primary" href="/pdf/statistic.php"> Сформировать PDF </a>
</form>

<div class="report">
    <?php
    ?>
    <?php if (isset($_SESSION['data_card']) && isset($_SESSION['data_total'])) : ?>
        <div class="report__item">
            <div class="report__info">
                <div><span>Всего новых пользователей: </span><?= $_SESSION['data_total'] ?></div>
                <div><span>Клиенты - участники ПЛ: </span><?= $_SESSION['data_card'] ?></div>
                <div><span>Обычные клиенты: </span><?= $_SESSION['data_total'] - $_SESSION['data_card'] ?></div>
            </div>

            <html>

            <head>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {

                        var data = google.visualization.arrayToDataTable([
                            ['Task', 'Hours per Day'],
                            ['Клиенты - учтстники ПЛ', <?= $_SESSION['data_card'] ?>],
                            ['Обычные клиенты', <?= $_SESSION['data_total'] - $_SESSION['data_card'] ?>]
                        ]);

                        var options = {
                            title: 'Число новых пользователей'
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                        chart.draw(data, options);
                    }
                </script>
            </head>

            <body>
                <div id="piechart" style="width: 900px; height: 500px;"></div>
            </body>

            </html>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['data_order']) && isset($_SESSION['data_order_total'])) : ?>
        <div class="report__item">
            <div class="report__info">
                <div><span>Всего заказов: </span><?= $_SESSION['data_order_total'] ?></div>
                <div><span>Зыказы Клиентов - участников ПЛ: </span><?= $_SESSION['data_order'] ?></div>
                <div><span>Заказы обычных клиентов: </span><?= $_SESSION['data_order_total'] - $_SESSION['data_order'] ?></div>
            </div>

            <html>

            <head>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {

                        var data = google.visualization.arrayToDataTable([
                            ['Task', 'Hours per Day'],
                            ['Зыказы Клиентов - участников ПЛ', <?= $_SESSION['data_order'] ?>],
                            ['Заказы обычных клиентов', <?= $_SESSION['data_order_total'] - $_SESSION['data_order'] ?>]
                        ]);

                        var options = {
                            title: 'Заказы клиентов'
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

                        chart.draw(data, options);
                    }
                </script>
            </head>

            <body>
                <div id="piechart1" style="width: 900px; height: 500px;"></div>
            </body>

            </html>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['data_amount']) && isset($_SESSION['data_amount_total'])) : ?>
        <div class="report__item">
            <div class="report__info">
                <div><span>Общая сумма заказов: </span><?= $_SESSION['data_amount_total'] ?>&#8381;</div>
                <div><span>Сумма заказов Клиентов - участников ПЛ: </span><?= $_SESSION['data_amount'] ?>&#8381;</div>
                <div><span>Сумма заказов обычных клиентов: </span><?= $_SESSION['data_amount_total'] - $_SESSION['data_amount'] ?>&#8381;</div>
            </div>

            <html>

            <head>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {

                        var data = google.visualization.arrayToDataTable([
                            ['Task', 'Hours per Day'],
                            ['Сумма заказов Клиентов - участников ПЛ', <?= $_SESSION['data_amount'] ?>],
                            ['Сумма заказов обычных клиентов', <?= $_SESSION['data_amount_total'] - $_SESSION['data_amount'] ?>]
                        ]);

                        var options = {
                            title: 'Сумма заказов клиентов'
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

                        chart.draw(data, options);
                    }
                </script>
            </head>

            <body>
                <div id="piechart2" style="width: 900px; height: 500px;"></div>
            </body>

            </html>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['data_sale'])) : ?>
        <html>

        <head>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                let dataChart = <?= $_SESSION['data_sale'] ?>;

                dataChart = dataChart.map((item, i) => {
                    if (i === 0) {
                        return [item[0], item[1]];
                    }
                    return [item[0], parseFloat(item[1])];
                })

                function drawChart() {
                    var data = google.visualization.arrayToDataTable(dataChart);

                    var options = {
                        title: 'Выручки по месяцам (руб)',
                        curveType: 'function',
                        legend: {
                            position: 'bottom'
                        }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                    chart.draw(data, options);
                }
            </script>
        </head>

        <body>
            <div id="curve_chart" style="width: 900px; height: 500px"></div>
        </body>

        </html>
    <?php endif; ?>

    <?php if (isset($_SESSION['data_goods'])) : ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {
                packages: ['corechart']
            });

            let dataChartCol = <?= $_SESSION['data_goods'] ?>;
            dataChartCol = dataChartCol.map((item, i) => {
                if (i === 0) {
                    return [item[0], item[1]];
                }
                return [item[0], parseFloat(item[1])];
            })

            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable(dataChartCol);

                var view = new google.visualization.DataView(data);

                var options = {
                    title: "Отражение цены на выбранную категорию",
                    width: 600,
                    height: 400,
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                chart.draw(view, options);
            }
        </script>
        <div id="columnchart_values" style="width: 900px; height: 300px;"></div>
    <?php endif; ?>

    <!-- 1. Диаграмма областей (по оси Ox размещены годы, месяцы или дни, по оси Oy размещены две области: 1) ожидаемая прибыль; 2) фактическая прибыль) -->
    <?php if (isset($_SESSION['data_goods'])) : ?>
        <html>

        <head>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                let dataArea = <?= $_SESSION['data_sale'] ?>;

                dataArea = dataArea.map((item, i) => {
                    if (i === 0) {
                        return ['Месяца', 'Фактическая прибыль', 'Ожидамая прибыль'];
                    }
                    return [item[0], parseFloat(item[1]), parseFloat(item[1]) * Math.random() * 2];
                })

                function drawChart() {
                    var data = google.visualization.arrayToDataTable(dataArea);

                    var options = {
                        title: 'Диаграмма областей',
                        hAxis: {
                            title: 'Месяца',
                            titleTextStyle: {
                                color: '#333'
                            }
                        },
                        vAxis: {
                            minValue: 0,
                            title: 'Прибыль',
                        }
                    };

                    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
            </script>
        </head>

        <body>
            <div id="chart_div" style="width: 100%; height: 500px;"></div>
        </body>

        </html>
    <?php endif; ?>

    <!-- 2. Пузырьковая диаграмма (четыре измерения: 1) цвет – категория товара; 2) размер – количество проданных товаров; 3) ось Х – временная шкала (годы, месяцы или дни); 4) ось Y - цена товара) -->
    <?php if ($_SESSION['data_count_goods']) : ?>
        <html>
        <head>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawSeriesChart);

                let data_count_goods = <?= $_SESSION['data_count_goods'] ?>;
                data_count_goods = data_count_goods.map((item, i) => {
                    if (i === 0) {
                        return [item[0], item[1], item[2], item[3], 'Количество'];
                    }
                    return [item[0], item[1], parseInt(item[2]), item[3], parseInt(item[2])];
                })

                console.log(data_count_goods);

                function drawSeriesChart() {
                    var data = google.visualization.arrayToDataTable(data_count_goods);

                    var options = {
                        title: 'Пузырьковая диаграмма',
                        hAxis: {
                            title: 'Месяца'
                        },
                        vAxis: {
                            title: 'Цена товара'
                        },
                        bubble: {
                            textStyle: {
                                fontSize: 11
                            }
                        }
                    };

                    var chart = new google.visualization.BubbleChart(document.getElementById('series_chart_div'));
                    chart.draw(data, options);
                }
            </script>
        </head>

        <body>
            <div id="series_chart_div" style="width: 900px; height: 500px;"></div>
        </body>

        </html>
    <?php endif; ?>
</div>
