<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meliora Dashboard</title>
  <!-- Add Bootstrap CSS for styling -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet">
  <style>
    /* Custom styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }

    #wrapper {
      display: flex;
      width: 100%;
    }

    #sidebar-wrapper {
      min-height: 100vh;
      padding-top: 20px;
    }

    .bg-dark {
      background-color: #343a40 !important;
    }

    .text-white {
      color: #fff !important;
    }

    .sidebar-heading {
      font-size: 1.5em;
      font-weight: bold;
      padding: 1rem;
    }

    .list-group-item {
      border: none;
      padding: 15px 20px;
      margin-bottom: 10px;
      font-size: 1.1em;
    }

    .card {
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      margin-bottom: 30px;
    }

    .card-body {
      font-size: 1.2em;
    }

    .card-footer {
      font-size: 0.9em;
    }

    .chart-container {
      position: relative;
      height: 40vh;
      width: 100%;
    }

  </style>
</head>
<body>
  <div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark border-right" id="sidebar-wrapper">
      <div class="sidebar-heading text-white">Meliora</div>
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">Dashboard</a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">Profile</a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">Make Complaint</a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">Inprogress Complaint</a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">Completed complaints</a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">History</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
      </nav>

      <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <div class="row">
          <div class="col-lg-4 col-md-6">
            <div class="card bg-primary text-white">
              <div class="card-body">Pending Complaints</div>
              <div class="card-footer d-flex align-items-center justify-content-between">
                <span class="small text-white">0</span>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="card bg-warning text-white">
              <div class="card-body">In Progress Complaints</div>
              <div class="card-footer d-flex align-items-center justify-content-between">
                <span class="small text-white">0</span>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="card bg-success text-white">
              <div class="card-body">Completed Complaints</div>
              <div class="card-footer d-flex align-items-center justify-content-between">
                <span class="small text-white">0</span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Complaints Overview</h5>
                <div class="chart-container">
                  <canvas id="complaintsChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /#page-content-wrapper -->
  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Toggle the sidebar menu
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });

    // Chart.js example
    var ctx = document.getElementById('complaintsChart').getContext('2d');
    var complaintsChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Pending', 'In Progress', 'Completed'],
        datasets: [{
          label: 'Number of Complaints',
          data: [5, 10, 15], // Example data
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(75, 192, 192, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(75, 192, 192, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</body>
</html>
