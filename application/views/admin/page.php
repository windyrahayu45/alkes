<script src="<?=base_url('file/modules')?>/chart.min.js"></script>
<script src="<?=base_url('file/js/page')?>/modules-chartjs.js"></script>
<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>

    <div class="row">
      <div class="col-12 col-sm-12 col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Kondisi Peralatan Medis</h4>
             
            </div>
            <div class="card-body">
              <canvas id="myChart3" height="180"></canvas>
              
            </div>
          </div>
      </div>

      <div class="col-12 col-sm-12 col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Data Peralatan Medis</h4>
              
            </div>
            <div class="card-body" id="graph-container">
              <canvas id="myChart4" height="180"></canvas>
              
            </div>
          </div>

          
      </div>
    </div>  

    <div class="row">
       <div class="col-12 col-sm-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Jumlah Peralatan Medis Per  Tahun </h4>
              <div class="card-header-action">
                
             

              </div>
            </div>
            <div class="card-body" id="graph-container2">
              <canvas id="myChart2" height="180"></canvas>
              
            </div>
          </div>
        </div>
    </div>     

       
          
        
</section>

<script type="text/javascript">
  var ctx = document.getElementById("myChart3").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      datasets: [{
        data: [
          <?=$baik?>,
          <?=$rusak?>,
         
        ],
        backgroundColor: [
         
          '#6777ef',
          '#fc544b',
         
        ],
        label: 'Dataset 1'
      }],
      labels: [
        'Baik',
        'Rusak Berat',
        
      ],
    },
    options: {
      responsive: true,
      legend: {
        position: 'bottom',
      },
    }
  });


  var ctx = document.getElementById("myChart4").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
      datasets: [{
        data: [
         
          <?=$afkir?>,
          <?=$total?>,
         
        ],
        backgroundColor: [
          '#191d21',
          '#ffa426',
          
        ],
        label: 'Dataset 1'
      }],
      labels: [
        'Afkir',
        'Total Alat',
        
      ],
    },
    options: {
      responsive: true,
      legend: {
        position: 'bottom',
      },
    }
  });


var users = <?php echo json_encode($label); ?>;
var tahun = <?php echo json_encode($tahun); ?>;
console.log(tahun);


var ctx = document.getElementById("myChart2").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: users,
    datasets: [{
      label: 'Statistics',
      data: tahun,
      borderWidth: 2,
      backgroundColor: '#6777ef',
      borderColor: '#6777ef',
      borderWidth: 2.5,
      pointBackgroundColor: '#ffffff',
      pointRadius: 4
    }]
  },
  options: {
    scaleShowValues: true,
    responsive: true,
    legend: {
      display: false
    },
    scales: {
      yAxes: [{
        gridLines: {
          drawBorder: false,
          color: '#f2f2f2',
        },
        ticks: {
          beginAtZero: true,
          
        }
      }],
      xAxes: [{
        ticks: {
          maxRotation: 50,
          minRotation: 30,
          padding: 10,
          autoSkip: false,
          fontSize: 10
        },
        gridLines: {
          display: false
        }
      }]
    },
  }
});
</script>