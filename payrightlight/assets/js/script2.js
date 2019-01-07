// Statistic for Attendance
$(function () {
  var myChart =
    Highcharts.chart('my-chartz', {
      chart: {
        type: 'column'
      },
      title: {
        text: ''
      },
      colors: ['#FF572F', '#8e44ad', '#f39c12','#3498db'],
      xAxis: {
        // Total of Month
        categories: [
          'Jan',
          'Feb',
          'Mar',
          'Apr',
          'May',
          'Jun',
          'Jul',
          'Aug',
          'Sep',
          'Oct',
          'Nov',
          'Dec'
        ],
        crosshair: true
      },
      yAxis: {
        min: 0,
        title: {
          text: 'Jumlah Hari'
        }
      },
      tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
          '<td style="padding:0"><b>{point.y:f} Hari</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
      },
      plotOptions: {
        column: {
          pointPadding: 0.2,
          borderWidth: 0
        }
      },
      // Data
      series: [{
        name: 'Alpa',
        data: [1, 5, 12, 8, 1, 4, 4, 1, 2, 1, 0, 3]

      }, {
        name: 'Izin',
        data: [6, 8, 5, 4, 0, 5, 0, 3, 2, 5, 6, 3]

      }, {
        name: 'Sakit',
        data: [9, 8, 3, 4, 0, 3, 0, 6, 4, 2, 3, 2]

      }, {
        name: 'Cuti',
        data: [4, 2, 5, 7, 6, 5, 4, 4, 6, 1, 8, 1]

      }]
    });
});

// Statistic for How Many Employee
$(function () {
  // Employee Status & Number of Employee
  var status = [
    ['Pekerja Tetap', 77],
    ['Pekerja Paruh Waktu', 20],
    ['Pekerja Kontrak', 81],
    ['Pekerja Magang', 15],
    ['Pekerja Lepas', 3],
  ];

  // For Parsing Float
  var total = 0.00

  $.each(status, function (k, v) {
    var value = 0.00
    if($.isArray) {
      value = v[1]
    } else if ($.isPlainObject(v)) {
      value = v.y
    }

    value = parseFloat(value, 10)

    if (value) {
      total += value
    }
  })
  var myChart = Highcharts.chart('my-chartz2', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
      },
      title: {
        text: 'TOTAL<br>KARYAWAN<br>'+total,
        align: 'center',
        verticalAlign: 'middle',
        y: 40
      },
    colors: ['red', '#2B7BE1', '#4A35E4', '#FFCF1E','yellow'],
      tooltip: {
        pointFormat: 'Jumlah Karyawan: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
        pie: {
          dataLabels: {
            enabled: true,
            distance: -50,
            style: {
              fontWeight: 'bold',
              color: 'white'
            }
          },
          startAngle: -90,
          endAngle: 90,
          center: ['50%', '75%'],
          size: '110%'
        }
      },
      series: [{
        type: 'pie',
        name: '',
        innerSize: '50%',
        data: status
      }]
    });


});

// chartJS Using PHP Json

function chartJs() {
  'use strict';

  window.chartColors = {
    red: '#eb5757',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    blue: '#2B7BE1',
    purple: 'rgb(153, 102, 255)',
    grey: 'rgb(201, 203, 207)'
  };


  // Start Line Chart
  var valval = document.getElementById('canvas');
  var datdat = valval.getAttribute('data-chart') || '[]';
  datdat = JSON.parse(datdat) || [];
  var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  var config = {
    type: 'line',
    data: {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'June', 'August', 'September', 'October', 'November', 'December'],
      datasets: [{
        label: 'Sakit',
        backgroundColor: window.chartColors.red,
        borderColor: window.chartColors.red,
        data: datdat.sakit,
        fill: false,
      }, {
        label: 'Izin',
        fill: false,
        backgroundColor: window.chartColors.blue,
        borderColor: window.chartColors.blue,
        data: datdat.izin,
      }, {
        label: 'Alpa',
        fill: false,
        backgroundColor: window.chartColors.yellow,
        borderColor: window.chartColors.yellow,
        data: datdat.alfa,
      }]
    },
    options: {
      responsive: true,
      title: {
        display: false,
        text: ''
      },
      tooltips: {
        mode: 'index',
        intersect: false,
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: false,
            labelString: ''
          }
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Hari'
          }
        }]
      }
    }
  };

    var ctx = document.getElementById('canvas').getContext('2d');
    window.myLine = new Chart(ctx, config);
}


// Table Responsive
(function () {
  function responsiveGenerate(table) {
  document.querySelectorAll(table).forEach(function (e) {
      if (e)
        e.outerHTML = '<div class="table-responsive --autoG">' + e.outerHTML + '</div>';

      var a = document.getElementById('sortable_table');
      if (a)
        a.outerHTML = '<div class="table-responsive --autoG">' + a.outerHTML + '</div>';
    });
    
  }

  function responsiveDisable () {
    document.querySelectorAll('.table-responsive.--autoG').forEach(function (v) {
      v.setAttribute('class', 'table-responsive --autoG unresponsive');
    });
  }

  function responsiveEnable() {
    document.querySelectorAll('.table-responsive.--autoG').forEach(function (v) {
      v.setAttribute('class', 'table-responsive --autoG');
    });  
  }

  function tableResponsiveListener () {

    var ww = document.documentElement["clientWidth"];

    if (ww <= 500) {
      var _isGenerated = document.querySelector('.table-responsive.--autoG');
      if(!_isGenerated) {
        responsiveGenerate('table.list');
        responsiveGenerate('table.sectioned_list')
      } else {
        responsiveEnable()
      }
    } else {
      responsiveDisable()
    };
  };

  // Move an element .link
  function move_element() {
    var company_id = document.getElementById('company_id');
    if (company_id) {
      var link = document.querySelector('form > .link');
      if (link) {
        company_id.parentNode.appendChild(link);
      }
    }
  }

  // Remove inline style
  function isPage(page) {
    return location.pathname.indexOf(page);
  }

  // Remove inline style company_shift
  function removeFloat() {
    if (isPage('companyshift')) {
      document.querySelectorAll('table .item > div').forEach(function (e) {
        e.style.float = "";
        e.style.margin = "1rem";
      });
    }
  }

  // Remove inline style employeecompanypersonalinformation
  function removeAlign() {
    if (isPage('employeecompanypersonalinformation')) {
      document.querySelectorAll('.list_title').forEach(function (e) {
        e.style.textAlign = "center";
      });
    }
  }

  // Add margin in menulist
  function addMargin() {
    if (isPage('menulist')) {
      document.querySelectorAll('table.list').forEach(function (e) {
        e.style.marginTop = "1.5rem";
      });
    }
  }

  // Add margin in companylist
  function addMarginCompanyList() {
    if (isPage('companylist')) {
      document.querySelectorAll('.selection_box').forEach(function (e) {
        e.style.marginBottom = "1.5rem";
      });
    }
  }

  // Editing button height & weight
  function editButtonEmployeedashboard() {
    if (isPage('employeedashboard')) {
      document.querySelectorAll('.no-border').forEach(function (e) {
        e.style.width = "30px";
        e.style.height = "30px";
        e.style.marginTop = "1rem";
      });
    }
  }


  // Wait till browsers ready to read using DOMContentLoaded
  window.addEventListener("DOMContentLoaded", function () {
    tableResponsiveListener();
    move_element();
    removeFloat();
    removeAlign();
    addMargin();
    addMarginCompanyList();
    editButtonEmployeedashboard();
    chartJs();
  });

  window.addEventListener('resize', tableResponsiveListener);
  window.tableResponsiveListener = tableResponsiveListener;
})();




