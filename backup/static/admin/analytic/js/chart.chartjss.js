$(function(){
  'use strict';

  /** AREA CHART **/


  var ctx3 = document.getElementById('chartBar3').getContext('2d');

  var gradient = ctx3.createLinearGradient(0, 0, 0, 250);
  gradient.addColorStop(0, '#560bd0');
  gradient.addColorStop(1, '#00cccc');

  new Chart(ctx3, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
      datasets: [{
        label: '# of Votes',
        data: [12, 39, 20, 10, 25, 18],
        backgroundColor: gradient
      }]
    },
    options: {
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: false,
          labels: {
            display: false
          }
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero:true,
            fontSize: 10,
            max: 80
          }
        }],
        xAxes: [{
          barPercentage: 0.6,
          ticks: {
            beginAtZero:true,
            fontSize: 11
          }
        }]
      }
    }
  });

  
   var ctx9 = document.getElementById('chartArea1');

  var gradient1 = ctx3.createLinearGradient(0, 350, 0, 0);
  gradient1.addColorStop(0, 'rgba(241,0,117,0)');
  gradient1.addColorStop(1, 'rgba(241,0,117,.5)');

  var gradient2 = ctx3.createLinearGradient(0, 280, 0, 0);
  gradient2.addColorStop(0, 'rgba(0,123,255,0)');
  gradient2.addColorStop(1, 'rgba(0,123,255,.3)');

  new Chart(ctx9, {
    type: 'line',
    data: {
      labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12','13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
      datasets: [{
        data: [12, 15, 18, 40, 35, 38, 32, 20, 25, 15, 25, 30,12, 15, 18, 40, 35, 38, 32, 20, 25, 15, 25, 30, 38, 32, 20, 25, 15, 25, 30],
        borderColor: '#f10075',
        borderWidth: 1,
        backgroundColor: gradient1
      }]
    },
    options: {
      maintainAspectRatio: false,
      legend: {
        display: false,
          labels: {
            display: false
          }
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero:true,
            fontSize: 10,
            max: 80
          }
        }],
        xAxes: [{
          ticks: {
            beginAtZero:true,
            fontSize: 11
          }
        }]
      }
    }
  });







});
