"use strict";

var day = $('#day option:selected').val();
loadEarningPerformance(day)


$('#day').on('change', function() {
    day = $(this).val();
    loadEarningPerformance(day)
})

$('#public_key').on('click', function (e) {
    e.preventDefault()
    generateKeys('public_key')
})

$('#private_key').on('click', function (e) {
    e.preventDefault()
    generateKeys('private_key')
})

function generateKeys(type) {
    var url = $('#keygenerate').val();
    $.ajax({
        type: 'get',
        url: url + '/' + type,
        dataType: 'json',
        beforeSend: function() {
            
        },
        success: function(response) {
            $('input[name='+type+']').val(response)
        }
    })
}


function loadEarningPerformance(day) {
    var url = $('#earningurl').val();
    $.ajax({
        type: 'get',
        url: url + '/' + day,
        dataType: 'json',
        beforeSend: function() {
            $('.chart_loader').show();
        },
        success: function(response) {
            var month_year = [];
            var dates = [];
            var totals = [];
            $('.chart_loader').hide();
            console.log(response);
            if (day != 365) {
                $.each(response, function(index, value) {
                    var total = value.amount;
                    var dte = value.date;
                    totals.push(total);
                    dates.push(dte);
                });
                render_chart(dates, totals);
            } else {
                $.each(response, function(index, value) {
                    var month = value.month;
                    var total = value.amount;
                    month_year.push(moment(month, 'M').format('MMMM') + '-' + value.year);
                    totals.push(total);
                });
                render_chart(month_year, totals);
            }

        }
    })
}

renderData();

function renderData() {
    var url = $('#statsurl').val();
    var viewurl = $('#paymentview').val();
    $.ajax({
        type: 'get',
        url: url,
        dataType: 'json',
        beforeSend: function() {
            // setting a timeout
            $('.payment_loader').show();
        },
        success: function(response) {
            var html = ''
            $('.payment_loader').hide();
            if (response) {
                $('#total_earning').html(response.total_earning)
                $('#total_payment').html(response.total_payments)
                $('#total_request').html(response.total_requests)
                $('#expire_date').html(response.expire_date)
                $('.plan_name').html(response.user_plan.name)
                $('.plan_expire').html(response.expire_date)
                $('.storage').html(response.storage + ' MB')
                $('.daily_request').html(`${response.daily_request}/${response.user_plan.daily_req}`)
                $('.monthly_request').html(`${response.monthly_request}/${response.user_plan.monthly_req}`)
                $('.expire_loader').hide();
                console.log(response);
                $.each(response.recent_payments, function(index, value) {
                    html += `<tr>`
                    html += `<td>${index+1}</td>`
                    html += `<td>${value.amount}</td>`
                    html += `<td>${value.getway.name}</td>`
                    html += `<td>${value.trx_id}</td>`
                    html += `<td>${moment(value.created_at).format('LLL')}</td>`
                    html += `<td><a class="btn btn-primary" href="${viewurl}/${value.id}"><i class="far fa-eye"></i>View</a></td>`
                    html += `</tr>`
                });

                $('#payments').append(html)
            }
        }
    })
}




function render_chart(type, totals) {

    var ctx = document.getElementById("earningchart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: type,
            datasets: [{
                label: 'Amount',
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