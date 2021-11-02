"use strict";
/*-----------------------
    Select Type Change
  --------------------------*/
var id = $("#select_type_change option:selected").val();
loadEarningPerformance(id)
  
  $('#select_type_change').on('change',function(e){
    e.preventDefault();
    var id = $("#select_type_change").val();
    loadEarningPerformance(id)
  });

function loadEarningPerformance(id) {
    var url = $('#date_wise_url').val();
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type: 'POST',
        url: url,
        data: { id: id },
        success: function (response) {
          console.log(response);
          var month_year=[];
          var dates=[];
          var totals=[];
          $('.earning_loader').hide();
          
          if (id != 365) {
            $.each(response, function(index, value){
              var total =value.amount;
              var dte = value.date;
              totals.push(total);
              dates.push(dte);
            });
            render_chart(dates,totals,'Orders');
          }
          else{
            $.each(response, function(index, value){
              var month=value.month;
              var total=value.amount;
              month_year.push(moment(month, 'M').format('MMMM') + '-' + value.year);
              totals.push(total);
            });
            render_chart(month_year,totals,'Orders');
          }
        },
        error: function(xhr, status, error) 
        {
          $('.basicbtn').removeAttr('disabled')
          $('.errorarea').show();
          $.each(xhr.responseJSON.errors, function (key, item) 
          {
            Sweet('error',item)
            $("#errors").html("<li class='text-danger'>"+item+"</li>")
          });
          errosresponse(xhr, status, error);
        }
      })
}
  
function render_chart(type, totals, label) {
    var ctx = document.getElementById("earningchart").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'line',
        data: {
        labels: type,
        datasets: [{
          label: label,
          data: totals,
          borderWidth: 2,
          backgroundColor: '#6777ef',
          borderColor: '#6777ef',
          borderWidth: 2.5,
          pointBackgroundColor: '#ffffff',
          pointRadius: 4
        }]
      },
      options: {
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
              stepSize: 150
            }
          }],
          xAxes: [{
            ticks: {
              display: true
            },
            gridLines: {
              display: false
            }
          }]
        },
      }
    });
        
}
    

var planduration = $("#planduration option:selected").val();
loadPlanData(planduration)
  
$('#planduration').on('change',function(e){
e.preventDefault();
var id = $("#planduration").val();
loadPlanData(id)
});

function loadPlanData(planduration) {
    
    var url = $('#plan_datewise_url').val();
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type: 'POST',
        url: url,
        data: { id: planduration },
        success: function (response) {
          var month_year=[];
          var dates=[];
          var totals=[];
            $('.plan_loader').hide();
            
            if (planduration != 365) {
              
            $.each(response, function(index, value){
              var total =value.amount;
              var dte = value.date;
              totals.push(total);
              dates.push(dte);
            });
            render_planchart(dates,totals);
          }
          else{
            $.each(response, function(index, value){
              var month=value.month;
              var total=value.amount;
              month_year.push(moment(month, 'M').format('MMMM') + '-' + value.year);
              totals.push(total);
            });
            render_planchart(month_year,totals);
          }
        },
        error: function(xhr, status, error) 
        {
          $('.basicbtn').removeAttr('disabled')
          $('.errorarea').show();
          $.each(xhr.responseJSON.errors, function (key, item) 
          {
            Sweet('error',item)
            $("#errors").html("<li class='text-danger'>"+item+"</li>")
          });
          errosresponse(xhr, status, error);
        }
      })
}

function render_planchart(label, values) {
    var ctx = document.getElementById("planchart").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'line',
        data: {
        labels: label,
        datasets: [{
          label: 'Amount',
          data: values,
          borderWidth: 2,
          backgroundColor: '#6777ef',
          borderColor: '#6777ef',
          borderWidth: 2.5,
          pointBackgroundColor: '#ffffff',
          pointRadius: 4
        }]
      },
      options: {
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
              stepSize: 150
            }
          }],
          xAxes: [{
            ticks: {
              display: true
            },
            gridLines: {
              display: false
            }
          }]
        },
      }
    });
        
    }