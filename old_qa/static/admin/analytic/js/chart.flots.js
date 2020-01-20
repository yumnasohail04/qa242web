$(function() {
  'use strict';





  var newCust = [[0, 2], [1, 3], [2,6], [3, 5], [4, 7], [5, 8], [6, 10]];
  var retCust = [[0, 1], [1, 2], [2,5], [3, 3], [4, 5], [5, 6], [6,9]];



          /**************** PIE CHART *******************/
          var piedata = [
            { label: 'Series 1', data: [[1,10]], color: '#6610f2'},
            { label: 'Series 2', data: [[1,30]], color: '#007bff'},
            { label: 'Series 3', data: [[1,90]], color: '#85d00b'},
            { label: 'Series 4', data: [[1,70]], color: '#00cccc'},
            { label: 'Series 5', data: [[1,80]], color: '#494c57'}
          ];

          $.plot('#flotPie1', piedata, {
            series: {
              pie: {
                show: true,
                radius: 1,
                label: {
                  show: true,
                  radius: 2/3,
                  formatter: labelFormatter,
                  threshold: 0.1
                }
              }
            },
            grid: {
              hoverable: true,
              clickable: true
            }
          });



          function labelFormatter(label, series) {
            return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
          }

        });
