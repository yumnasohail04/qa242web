$(function(){
  'use strict';

  var morrisData = [
    { y: '2006', a: 100, b: 90 },
    { y: '2007', a: 75,  b: 65 },
    { y: '2008', a: 50,  b: 40 },
    { y: '2009', a: 75,  b: 65 },
    { y: '2010', a: 50,  b: 40 },
    { y: '2011', a: 80, b: 90 },
    { y: '2012', a: 75,  b: 65 },
    { y: '2013', a: 50,  b: 70 }
  ];

  new Morris.Donut({
    element: 'morrisDonut1d',
    data: [
      {label: 'CCP', value: 20},
      {label: 'CCP', value: 80}
    ],
    colors: [ '#DFDFDF','#D14F57'],
    resize: true
  });
  
    new Morris.Donut({
    element: 'morrisDonut2',
    data: [
      {label: 'Pre Op', value: 25},
      {label: 'Pre Op', value: 75}
    ],
    colors: ['#DFDFDF','#4CB581'],
    resize: true
  });
  
    new Morris.Donut({
    element: 'morrisDonut3',
    data: [
      {label: 'ATP swab', value: 5},
      {label: 'ATP swab', value: 95}
    ],
    colors: ['#DFDFDF','#5D89A8'],
    resize: true
  });
  
    new Morris.Donut({
    element: 'morrisDonut4',
    data: [
      {label: 'Recieving Log', value: 40},
      {label: 'Recieving Log', value: 60}
    ],
    colors: [ '#DFDFDF','#EF9738'],
    resize: true
  });

 new Morris.Bar({
    element: 'morrisBar1',
    data: morrisData,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Series A', 'Series B'],
    barColors: ['#D14F57', '#DFDFDF'],
    stacked: true,
    gridTextSize: 11,
    hideHover: 'auto',
    resize: true
  });
  
   new Morris.Bar({
    element: 'morrisBar2',
    data: morrisData,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Series A', 'Series B'],
    barColors: ['#4CB581', '#DFDFDF'],
    stacked: true,
    gridTextSize: 11,
    hideHover: 'auto',
    resize: true
  });
    new Morris.Bar({
    element: 'morrisBar3',
    data: morrisData,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Series A', 'Series B'],
    barColors: ['#5D89A8', '#DFDFDF'],
    stacked: true,
    gridTextSize: 11,
    hideHover: 'auto',
    resize: true
  });
    new Morris.Bar({
    element: 'morrisBar4',
    data: morrisData,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Series A', 'Series B'],
    barColors: ['#EF9738', '#DFDFDF'],
    stacked: true,
    gridTextSize: 11,
    hideHover: 'auto',
    resize: true
  });
  
    new Morris.Line({
    element: 'morrisLine1',
    data: [
      { y: '2006', a: 20, b: 10 },
      { y: '2007', a: 15,  b: 45 },
      { y: '2008', a: 60,  b: 40 },
      { y: '2009', a: 40,  b: 50 },
      { y: '2010', a: 30,  b: 45 },
      { y: '2011', a: 25,  b: 80 },
      { y: '2012', a: 60, b: 20 },
      { y: '2013', a: 20, b: 10 },
      { y: '2014', a: 15,  b: 45 },
      { y: '2015', a: 60,  b: 40 },
      { y: '2016', a: 40,  b: 50 },
      { y: '2017', a: 30,  b: 45 }
    ],
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Series A', 'Series B'],
    lineColors: ['#560bd0', '#007bff'],
    lineWidth: 1,
    ymax: 'auto 100',
    gridTextSize: 11,
    hideHover: 'auto',
    resize: true
  });

});
