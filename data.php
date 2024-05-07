<?php
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('config/dbcon.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">My Data List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./index.php" >Home</a></li>
              <li class="breadcrumb-item active">Data List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
      <!-- Main content -->
      <section class="content">
      <div class="container-fluid">
      <table id="example" class="display" style="width:100%">
                <thead>
                  <tr>
                    <th>Sector</th>
                    <th>Start Year</th>
                    <th>End Year</th>
                    <th>Country</th>
                    <th>Topics</th>
                    <th>City</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                      $query = "SELECT * FROM black_data";
                      $query_run = mysqli_query($con, $query);
                      if(mysqli_num_rows($query_run) > 0){
                        foreach($query_run as $row){
                          ?>
                          <tr>
                          
                          <td><?php echo $row['sector']; ?></td>
                          <td><?php echo $row['start_year']; ?></td>
                          <td><?php echo $row['end_year']; ?></td>
                          <td><?php echo $row['country']; ?></td>
                          <td><?php echo $row['topic']; ?></td>
                          <td><?php echo $row['city']; ?></td>
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
        <tfoot>
            <tr>
            <th>Sector</th>
                        <th>Start Year</th>
                        <th>End Year</th>
                        <th>Country</th>
                        <th>Topics</th>
                        <th>City</th>
            </tr>
        </tfoot>
    </table>
      </div>
      <!-- /.container-fluid -->
    </section>
  </div>
  
  <!-- /.content-wrapper -->
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
<!-- jQuery Mapael -->
<script src="assets/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="assets/plugins/raphael/raphael.min.js"></script>
<script src="assets/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="assets/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="assets/plugins/chart.js/Chart.min.js"></script>

<!-- DataTables -->
<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
 $(document).ready(function () {
  var exampleDataTable = $('#example').DataTable({
    responsive:true,
    initComplete: function () {
      this.api().columns().every(function () {
        var column = this;
        var select = $('<select><option value=""></option></select>')
          .appendTo($(column.footer()).empty())
          .on('change', function () {
            var val = $.fn.dataTable.util.escapeRegex(
              $(this).val()
            );

            column
              .search(val ? '^' + val + '$' : '', true, false)
              .draw();
          });

        column.data().unique().sort().each(function (d, j) {
          select.append('<option value="' + d + '">' + d + '</option>')
        });
      });
    }
  });

  // Event handler when position select is changed
  $(exampleDataTable.columns(1).footer()).find('select').on('change', function () {
    var nextSelect = $(exampleDataTable.columns(2).footer()).find('select');
    var nextColumn = exampleDataTable.column(2);
    var nextColumnResults = exampleDataTable.column(2, { search: 'applied' });
    nextColumn.search('').draw();
    nextSelect.empty();
    nextSelect.append('<option value=""></option>');
    nextColumnResults.data().unique().sort().each(function (d, j) {
      nextSelect.append('<option value="' + d + '">' + d + '</option>')
    });
  });
});
</script>
</body>
</html>
