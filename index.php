<?php
include('session.php');
?>

<?php
  require_once('dashboard/functions.php');
  initFunctions();
?>
<?php require_once DBAPI; ?>

<?php include(HEADER_TEMPLATE); ?>


<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    function drawChart() {
      var jsonData = $.ajax({
          url: "charts/most_wanted_courses.php",
          dataType:"json",
          async: false
          }).responseText;

      var jsonData2 = $.ajax({
          url: "charts/better_customers.php",
          dataType:"json",
          async: false
          }).responseText;

      var jsonData3 = $.ajax({
          url: "charts/company_performance.php",
          dataType:"json",
          async: false
          }).responseText;

      var jsonData4 = $.ajax({
          url: "charts/gender.php",
          dataType:"json",
          async: false
          }).responseText;

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);
       var options = {'title':'Os dez cursos mais procurados',
                     'width':800,
                     'height':400};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, options);

      // Create our data table out of JSON data loaded from server.
      var data2 = new google.visualization.DataTable(jsonData2);
       var options2 = {'title':'Os dez maiores clientes',
                     'width':800,
                     'height':400};

      // Instantiate and draw our chart, passing in some options.
      var chart2 = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
      chart2.draw(data2, options2);

     /* var data3 = google.visualization.arrayToDataTable([
          ['Year', 'Receitas', 'Despesas'],
          ['2013',  1000,      400],
          ['2014',  1170,      460],
          ['2015',  660,       1120],
          ['2016',  1030,      540]
        ]);

        var options3 = {
          title: 'Performance da Compania',
          hAxis: {title: 'Ano',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart3 = new google.visualization.AreaChart(document.getElementById('chart_div3'));
        chart3.draw(data3, options3);*/

        var data3 = new google.visualization.DataTable(jsonData3);

        var options3 = {
          title: 'Performance da Compania',
          hAxis: {title: 'Ano',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart3 = new google.visualization.AreaChart(document.getElementById('chart_div3'));
        chart3.draw(data3, options3);

          var data4 = new google.visualization.DataTable(jsonData4);



        var options4 = {
          title: 'Clientes por Gênero',
          'width':800,
           'height':400,
          is3D: true,

        };

        var chart4 = new google.visualization.PieChart(document.getElementById('chart_div4'));
        chart4.draw(data4, options4);


    }

    </script>



<div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row" id="main" >
                <div class="col-sm-12 col-md-12 well" id="content">
                        <div class="container">
    <div class="row">
        <div class="col-sm-3">
            <div class="hero-widget well well-sm">
                <div class="icon">
                     <i class="glyphicon glyphicon-user"></i>
                </div>
                <div class="text">
                    <var><?php if(isset($counterCustomers)) { echo $counterCustomers; } else { echo 0;} ?></var>
                    <label class="text-muted">clientes registrados</label>
                </div>

            </div>
        </div>
        <div class="col-sm-3">
            <div class="hero-widget well well-sm">
                <div class="icon">
                     <i class="glyphicon glyphicon-star"></i>
                </div>
                <div class="text">
                    <var>0</var>
                    <label class="text-muted">curtidas na página</label>
                </div>

            </div>
        </div>
        <div class="col-sm-3">
            <div class="hero-widget well well-sm">
                <div class="icon">
                     <i class="fa fa-fw fa-graduation-cap"></i>
                </div>
                <div class="text">
                    <var><?php if(isset($coursesOpen)) { echo $coursesOpen; } else { echo 0;} ?></var>
                    <label class="text-muted">cursos em aberto</label>
                </div>

            </div>
        </div>
        <div class="col-sm-3">
            <div class="hero-widget well well-sm">
                <div class="icon">
                     <i class="fa fa-fw fa-dollar"></i>
                </div>
                <div class="text">
                    <var>R$ <?php if(isset($currentBalance)) { echo $currentBalance['balance_dec']; } else { echo 0;} ?></var>
                    <label class="text-muted">lucro previsto (mês)</label>
                </div>

            </div>
        </div>
    </div>
</div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

        <a class="anchor" id="a-competencies"></a>
    <!-- /.row -->
    <section class="">
        <div class="container">
            <div class="row">

                <div class="col-lg-12">
                    <div class="sectionTitle">Preenchimento dos cursos (eventos mais próximos)</div>
                    <div id="skillgraph" class="panel panel-default row">
                        <div class='panel-title text-Left '></div>
                        <?php if ($coursesFill) : ?>
                        <?php foreach ($coursesFill as $courseFill) : ?>
                        <div class='row skill-row'>
                            <span class='skillLabel'><?php $date = date_create($courseFill['event_date_dt']); echo $courseFill['name_var'] . " - Data do Evento: " . date_format($date, 'd/m/Y'); ?></span>
                            <span class='skillData-Wrapper'>
                        <span class='skillData bg-blue text-center' data-percent='<?php echo ($courseFill['numSlotsTaken_int']/$courseFill['numSlots_int']*100); ?>'> <?php echo ($courseFill['numSlotsTaken_int']/$courseFill['numSlots_int']*100); ?>%</span></span>

                        </div>
                         <?php endforeach; ?>
                      <?php endif; ?>
                    </div>

                </div>

            </div>
             <div class="row">
             <div class="col-sm-12 col-md-10 well">
                        <div id="chart_div3"  style="width: 100%; height: 500px;"></div>
                    </div>
                    <div class="col-sm-12 col-md-10 well">
                        <div id="chart_div4"></div>
                    </div>
                    <div class="col-sm-12 col-md-10 well">
                        <div id="chart_div"></div>
                    </div>
                    <div class="col-sm-12 col-md-10 well">
                        <div id="chart_div2"></div>
                    </div>
            </div>

        </div>
        <!-- /.container -->
    </section>
    </div>

<?php include(FOOTER_TEMPLATE); ?>