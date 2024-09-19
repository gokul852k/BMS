<?php
require_once './header.php';
require_once './navbar.php';
// require_once '../../../Common/Common file/search_select_cdn.php';
require_once '../Services/FuelReportService.php';

?>

<link rel="stylesheet" href="../../../Common/Common file/card.css">
<link rel="stylesheet" href="../../../Common/Common file/header.css">
<link rel="stylesheet" href="../../../Common/Common file/pop_up.css">
<link rel="stylesheet" href="../../../Common/Common file/search_select.css">
<link rel="stylesheet" href="./Style/driver.css">
<link rel="stylesheet" href="./Style/chart.css">



                            <div class="widget">
                                <canvas id="chart"></canvas>
                            </div>
                            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                            <script>
// Sample data from your PHP script or API
var rawData = [
  {"date": "2024-01-01", "value": 3200000},
  {"date": "2024-02-01", "value": 2800000},
  {"date": "2024-03-01", "value": 3500000},
  {"date": "2024-04-01", "value": 4000000}
];

// Convert data to ApexCharts format
var formattedData = rawData.map(item => [new Date(item.date).getTime(), item.value]);

var options = {
  series: [{
    name: 'XYZ MOTORS',
    data: formattedData
  }],
  chart: {
    type: 'area',
    stacked: false,
    height: 350,
    zoom: {
      type: 'x',
      enabled: true,
      autoScaleYaxis: true
    },
    toolbar: {
      autoSelected: 'zoom'
    }
  },
  dataLabels: {
    enabled: false
  },
  markers: {
    size: 0,
  },
  title: {
    text: 'Stock Price Movement',
    align: 'left'
  },
  fill: {
    type: 'gradient',
    gradient: {
      shadeIntensity: 1,
      inverseColors: false,
      opacityFrom: 0.5,
      opacityTo: 0,
      stops: [0, 90, 100]
    },
  },
  yaxis: {
    labels: {
      formatter: function (val) {
        return (val / 1000000).toFixed(0); // Divide by million for display
      },
    },
    title: {
      text: 'Price'
    },
  },
  xaxis: {
    type: 'datetime',
  },
  tooltip: {
    shared: false,
    y: {
      formatter: function (val) {
        return (val / 1000000).toFixed(0) // Tooltip formatting
      }
    }
  }
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();
</script>

                        </div>



<script src="../../../Common/Common file/pop_up.js"></script>
<script src="../../../Common/Common file/data_table.js"></script>
<script src="../../../Common/Common file/main.js"></script>
<?php
require_once '../../../Common/Common file/search_select_cdn.php';
require_once './footer.php';
?>


<script>
   $(document).ready(function(){
   
   var i = 1;
   var length;
   //var addamount = 0;
    var addamount = 700;
 
   $("#add").click(function(){
    
    addamount += 700;
    console.log('amount: ' + addamount);
    i++;
       $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td>	<td><input type="text" name="amount[]" value="700" placeholder="Enter your Money" class="form-control total_amount"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
     });
 
   $(document).on('click', '.btn_remove', function(){  
   addamount -= 700;
   console.log('amount: ' + addamount);
   
    
     var button_id = $(this).attr("id");     
       $('#row'+button_id+'').remove();  
     });
   
 
 
     $("#submit").on('click',function(event){
     var formdata = $("#add_name").serialize();
     console.log(formdata);
     
     event.preventDefault()
       
       $.ajax({
         url   :"action.php",
         type  :"POST",
         data  :formdata,
         cache :false,
         success:function(result){
           alert(result);
           $("#add_name")[0].reset();
         }
       });
       
     });
   });
</script>