<?php
  include('includes/header.php');
  include('includes/topbar.php');
  include('includes/sidebar.php');
  include('config/dbcon.php');
?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">My Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">My Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Future Year Count</span>
              <span class="info-box-number">
                <?php
                  $query = "SELECT * FROM black_data WHERE start_year >= YEAR(CURDATE())";
                  $query_run = mysqli_query($con, $query);
                  $row_count = $query_run->num_rows;
                  echo $row_count;
                ?>
              </span>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Previous Year Count</span>
              <span class="info-box-number">
                <?php
                  $query = "SELECT * FROM black_data WHERE start_year <= YEAR(CURDATE())";
                  $query_run = mysqli_query($con, $query);
                  $row_count = $query_run->num_rows;
                  echo $row_count;
                ?>
              </span>
            </div>
          </div>
        </div>
        <div class="clearfix hidden-md-up"></div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Number of Sectors</span>
              <span class="info-box-number">
                <?php
                  $query = "SELECT COUNT(DISTINCT sector) AS category_count FROM black_data";
                  $query_run = mysqli_query($con, $query);
                  $row = $query_run->fetch_assoc();
                  $category_count = $row['category_count'];
                  echo $category_count;
                ?>
              </span>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Number of Pestle</span>
              <span class="info-box-number">
                <?php
                  $query = "SELECT COUNT(DISTINCT pestle) AS pestle_count FROM black_data";
                  $query_run = mysqli_query($con, $query);
                  $row = $query_run->fetch_assoc();
                  $pestle_count = $row['pestle_count'];
                  echo $pestle_count;
                ?>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Yearly Recap Report</h5>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <p class="text-center">
                    <strong>Insight Data Published Visualization Based on the Year</strong>
                  </p>
                  <div class="chart">
                    <?php
                      $query =  "SELECT start_year, COUNT(*) AS total_published
                      FROM black_data
                      WHERE published IS NOT NULL AND published != ''
                      AND start_year IS NOT NULL AND start_year != ''
                      GROUP BY start_year";

                      $result = mysqli_query($con, $query);
                      if ($result) {
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                          $data2[] = array(
                              "start_year" => $row["start_year"],
                              "published" => $row["total_published"]
                          );
                        }
                        mysqli_free_result($result);
                      } else {
                        echo "Error: " . mysqli_error($con);
                      }
                    ?>
                    <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <?php
                      $query = "SELECT start_year, COUNT(*) AS total_published
                      FROM black_data
                      WHERE published IS NOT NULL AND published != ''
                          AND start_year IS NOT NULL AND start_year != ''
                      GROUP BY start_year
                      ORDER BY total_published DESC
                      LIMIT 1";

                      $query_run = mysqli_query($con, $query);
                      $row_count = $query_run->fetch_assoc();
                      $total_published = $row_count['total_published'];
                      $year = $row_count['start_year'];
                    ?>
                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> <?php echo $total_published ?></span>
                    <h5 class="description-header"><?php echo $year ?></h5>
                    <span class="description-text">HIGH PUBLISH IN YEAR</span>
                  </div>
                </div>
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <?php
                      $query = "SELECT DISTINCT region, COUNT(insight) AS insight_count FROM black_data
                      WHERE  region IS NOT NULL AND  region != ''
                      GROUP BY  region
                      ORDER BY insight_count DESC
                      LIMIT 1";

                      $query_run = mysqli_query($con, $query);
                      $row_count = $query_run->fetch_assoc();
                      $insight_count = $row_count['insight_count'];
                      $region = $row_count['region'];
                    ?>
                    <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> <?php echo $insight_count ?></span>
                    <h5 class="description-header"><?php echo $region ?> Region</h5>
                    <span class="description-text">High Insight Count In Region</span>
                  </div>
                </div>
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <?php
                      $query = "SELECT DISTINCT swot, COUNT(insight) AS insight_count FROM black_data
                      WHERE  swot IS NOT NULL AND  swot != ''
                      GROUP BY  swot
                      ORDER BY insight_count DESC
                      LIMIT 1";

                      $query_run = mysqli_query($con, $query);
                      $row_count = $query_run->fetch_assoc();
                      $insight_count = $row_count['insight_count'];
                      $swot = $row_count['swot'];
                    ?>
                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> <?php echo $insight_count ?></span>
                    <h5 class="description-header"><?php echo $swot ?> Swot</h5>
                    <span class="description-text">High Insight Count In Swot</span>
                  </div>
                </div>
                <div class="col-sm-3 col-6">
                  <div class="description-block">
                    <?php
                      $query = "SELECT DISTINCT sector, COUNT(insight) AS insight_count FROM black_data
                      WHERE  sector IS NOT NULL AND  sector != ''
                      GROUP BY  sector
                      ORDER BY insight_count DESC
                      LIMIT 1";

                      $query_run = mysqli_query($con, $query);
                      $row_count = $query_run->fetch_assoc();
                      $insight_count = $row_count['insight_count'];
                      $sector = $row_count['sector'];
                    ?>
                    <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> <?php echo $insight_count ?></span>
                    <h5 class="description-header"><?php echo $sector ?></h5>
                    <span class="description-text">High Insight Count In Sector</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">All Data Report With Data Filter</h5>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Visitors Report</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="d-md-flex">
                <div class="p-1 flex-fill" style="overflow: hidden">
                  <!-- Map will be created here -->
                  <div id="world-map-markers" style="height: 325px; overflow: hidden">
                    <div class="map"></div>
                  </div>
                </div>
                <div class="card-pane-right bg-success pt-2 pb-2 pl-4 pr-4">
                <div class="description-block mb-4">
                  <?php
                    $query = "SELECT COUNT(DISTINCT city) AS category_count FROM black_data";
                    $query_run = mysqli_query($con, $query);
                    $row_count = $query_run->fetch_assoc();
                    $city_count = $row_count['category_count'];
                    
                  ?>
                    
                    <h5 class="description-header"><?php echo $city_count ?></h5>
                    <span class="description-text">Total Number of City</span>
                  </div>
                  <div class="description-block mb-4">
                  <?php
                    $query = "SELECT COUNT(DISTINCT region) AS category_count FROM black_data";
                    $query_run = mysqli_query($con, $query);
                    $row_count = $query_run->fetch_assoc();
                    $region_count = $row_count['category_count'];
                    
                  ?>
                    
                    <h5 class="description-header"><?php echo $region_count ?></h5>
                    <span class="description-text">Total Number of Region</span>
                  </div>
                  <!-- /.description-block -->
                  <div class="description-block mb-4">
                  <?php
                    $query = "SELECT COUNT(DISTINCT country) AS category_count FROM black_data";
                    $query_run = mysqli_query($con, $query);
                    $row_count = $query_run->fetch_assoc();
                    $country_count = $row_count['category_count'];
                    
                  ?>
                    <h5 class="description-header"><?php echo $country_count ?></h5>
                    <span class="description-text">Total Number of Country</span>
                  </div>
                  
                  <!-- /.description-block -->
                </div><!-- /.card-pane-right -->
              </div><!-- /.d-md-flex -->
            </div>
            <!-- /.card-body -->
          </div>
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Latest Year Data</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                  <tr>
                    <th>Intensity</th>
                    <th>Likelihood</th>
                    <th>Relevance</th>
                    <th>Start Year</th>
                    <th>Topics</th>
                    <th>Region</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $query = "SELECT * FROM black_data WHERE start_year >= YEAR(CURDATE())";
                    $query_run = mysqli_query($con, $query);
                    if(mysqli_num_rows($query_run) > 0){
                      foreach($query_run as $row){
                        ?>
                      <tr>
                        <td><?php echo $row['intensity']; ?></td>
                        <td><?php echo $row['likelihood']; ?></td>
                        <td><?php echo $row['relevance']; ?></td>
                        <td><?php echo $row['start_year']; ?></td>
                        <td><?php echo $row['topic']; ?></td>
                        <td><?php echo $row['region']; ?></td>
                      </tr>
                      <?php
                      }
                    } else {
                      ?>
                        <tr>
                          <td> No record Found!</td>
                        </tr>
                      <?php
                    }
                  ?>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <a href="./data.php" class="btn btn-sm btn-secondary float-right">View All Data</a>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-6 col-md-4">
          <!-- Info Boxes Style 2 -->
          <div class="info-box mb-3 bg-warning">
            <span class="info-box-icon"><i class="fas fa-tag"></i></span>

            <div class="info-box-content">
                <?php
                    $query = "SELECT COUNT(*) AS total_insight  FROM black_data";
                    $query_run = mysqli_query($con, $query);
                    $row_count = $query_run->fetch_assoc();
                    $total_insights = $row_count['total_insight'];
                    
                  ?>
              <span class="info-box-text">Number of Insight</span>
              <span class="info-box-number"><?php echo $total_insights ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box mb-3 bg-success">
            <span class="info-box-icon"><i class="far fa-heart"></i></span>

            <div class="info-box-content">
            <?php
                    $query = "SELECT COUNT(DISTINCT swot) AS category_count FROM black_data";
                    $query_run = mysqli_query($con, $query);
                    $row_count = $query_run->fetch_assoc();
                    $total_swot = $row_count['category_count'];
                    
                  ?>
              <span class="info-box-text">Number of Swot</span>
              <span class="info-box-number"><?php echo $total_swot ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box mb-3 bg-danger">
            <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

            <div class="info-box-content">
            <?php
                    $query = "SELECT COUNT(DISTINCT topic) AS category_count FROM black_data";
                    $query_run = mysqli_query($con, $query);
                    $row_count = $query_run->fetch_assoc();
                    $total_topic = $row_count['category_count'];
                    
                  ?>
              <span class="info-box-text">Number of Topic</span>
              <span class="info-box-number"><?php echo $total_topic ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box mb-3 bg-info">
            <span class="info-box-icon"><i class="far fa-comment"></i></span>

            <div class="info-box-content">
            <?php
                    $query = "SELECT COUNT(DISTINCT source) AS category_count FROM black_data";
                    $query_run = mysqli_query($con, $query);
                    $row_count = $query_run->fetch_assoc();
                    $total_source = $row_count['category_count'];
                    
                  ?>
              <span class="info-box-text">Number of Source</span>
              <span class="info-box-number"><?php echo $total_source ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->

          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Insight Data Chart Based on Swot</h5>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="chart-responsive">
                  <?php
                      $query =  "SELECT start_year, end_year, swot, COUNT(*) AS insight_count 
                      FROM black_data 
                      WHERE start_year IN (
                          SELECT DISTINCT start_year FROM black_data
                      ) 
                      AND end_year IN (
                          SELECT DISTINCT end_year FROM black_data
                      ) 
                      AND swot IS NOT NULL AND swot != ''
                      GROUP BY swot";

                    $result = mysqli_query($con, $query);
                    if ($result) {
                      // Fetch the result rows
                      $data = array();
                      while($row = $result->fetch_assoc()) {
                          $data[] = array(
                              "swot" => $row["swot"],
                              "insight" => $row["insight_count"]
                          );
                      }
                      
                      // Free the result set
                      mysqli_free_result($result);
                    } else {
                      // Handle query error
                      echo "Error: " . mysqli_error($con);
                    }
                    ?>
                    <canvas id="pieChart" height="150"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <ul class="chart-legend clearfix">
                    <li><i class="far fa-circle text-success"></i>120 Insight</li>
                    <li><i class="far fa-circle text-info"></i>41 Insight</li>
                    <li><i class="far fa-circle text-primary"></i>23 Insight</li>
                    <li><i class="far fa-circle text-warning"></i>20 Insight</li>
                  </ul>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <!-- /.footer -->
          </div>
          <!-- /.card -->
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Insight Chart Based on Sector</h5>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="chart-responsive">
                  <?php
                      $query =  "SELECT start_year, end_year, sector, COUNT(*) AS insight_count 
                      FROM black_data 
                      WHERE start_year IN (
                          SELECT DISTINCT start_year FROM black_data
                      ) 
                      AND end_year IN (
                          SELECT DISTINCT end_year FROM black_data
                      ) 
                      AND sector IS NOT NULL AND sector != ''
                      GROUP BY sector";

                    $result = mysqli_query($con, $query);
                    if ($result) {
                      // Fetch the result rows
                      $data1 = array();
                      while($row = $result->fetch_assoc()) {
                          $data1[] = array(
                              "sector" => $row["sector"],
                              "insight" => $row["insight_count"]
                          );
                      }
                      
                      // Free the result set
                      mysqli_free_result($result);
                    } else {
                      // Handle query error
                      echo "Error: " . mysqli_error($con);
                    }
                    ?>
                    <canvas id="pieChart1" height="150"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <ul class="chart-legend clearfix">
                    <li><i class="far fa-circle text-success"></i>15 Insight</li>
                    <li><i class="far fa-circle text-info"></i>160 Insight</li>
                    <li><i class="far fa-circle text-primary"></i>58 Insight</li>
                    <li><i class="far fa-circle text-warning"></i>52 Insight</li>
                  </ul>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <!-- /.footer -->
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
</div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2024-2029 <a href="#">My-Dashboard</a>.</strong>
    All rights reserved.
</footer>
</div>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<script src="assets/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="assets/dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->

<!-- DataTables -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>


<!-- jQuery Mapael -->
<script src="assets/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="assets/plugins/raphael/raphael.min.js"></script>
<script src="assets/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="assets/plugins/chart.js/Chart.min.js"></script>
<script>
  const swotArrayJS = <?php echo json_encode(array_column($data, 'swot')); ?>;
  const insightArrayJS = <?php echo json_encode(array_column($data, 'insight')); ?>;
  const sectorArrayJS = <?php echo json_encode(array_column($data1, 'sector')); ?>;
  const insightArrayJS1 = <?php echo json_encode(array_column($data1, 'insight')); ?>;
  const startYearArrayJS = <?php echo json_encode(array_column($data2, 'start_year')); ?>;
  const publishedArrayJS1 = <?php echo json_encode(array_column($data2, 'published')); ?>;
  
var salesChartCanvas = $('#salesChart').get(0).getContext('2d')

var salesChartData = {
  labels  : startYearArrayJS,
  datasets: [
    {
      label               : 'Digital Goods',
      backgroundColor     : 'rgba(60,141,188,0.9)',
      borderColor         : 'rgba(60,141,188,0.8)',
      pointRadius          : false,
      pointColor          : '#3b8bba',
      pointStrokeColor    : 'rgba(60,141,188,1)',
      pointHighlightFill  : '#fff',
      pointHighlightStroke: 'rgba(60,141,188,1)',
      data                : publishedArrayJS1
      }
  ]
}

var salesChartOptions = {
  maintainAspectRatio : false,
  responsive : true,
  legend: {
    display: false
  },
  scales: {
    xAxes: [{
      gridLines : {
        display : false,
      }
    }],
    yAxes: [{
      gridLines : {
        display : false,
      }
    }]
  }
}

// This will get the first returned node in the jQuery collection.
var salesChart = new Chart(salesChartCanvas, { 
    type: 'line', 
    data: salesChartData, 
    options: salesChartOptions
  }
)


  //-------------
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = {
      labels: swotArrayJS,
      datasets: [
        {
          data: insightArrayJS,
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var pieOptions     = {
      legend: {
        display: false
      }
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'doughnut',
      data: pieData,
      options: pieOptions      
    })

  //-----------------
  //- END PIE CHART -
  //-----------------

  //-------------
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $('#pieChart1').get(0).getContext('2d')
    var pieData        = {
      labels: sectorArrayJS,
      datasets: [
        {
          data: insightArrayJS1,
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de','#007bff','#6c757d','#17a2b8','#ffc107',
            '#6610f2','#001f3f','#605ca8','#f012be','#ff851b','#d81b60','#01ff70','#39cccc','#3d9970','32012F','FFB1B1','948979','910A67'
          ],
        }
      ]
    }
    var pieOptions     = {
      legend: {
        display: false
      }
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'doughnut',
      data: pieData,
      options: pieOptions      
    })

  //-----------------
  //- END PIE CHART -
  //-----------------

  /* jVector Maps
   * ------------
   * Create a world map with markers
   */
  $('#world-map-markers').mapael({
      map: {
        name : "usa_states",
        zoom: {
          enabled: true,
          maxLevel: 10
        },
      },
    }
  );

</script>
</body>
</html>
