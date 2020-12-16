function trigger_bar_grphs(ppc_pie_report,ccp_pie_report,atp_swab_pie_report,receivinglog_pie_report){
      if (document.getElementById("productChartNoShadow1")) {
        var productChartNoShadow1 = document
          .getElementById("productChartNoShadow1")
          .getContext("2d");
        var myChart = new Chart(productChartNoShadow1, {
          type: "bar",
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              yAxes: [
                {
                  gridLines: {
                    display: true,
                    lineWidth: 1,
                    color: "rgba(0,0,0,0.1)",
                    drawBorder: false
                  },
                  ticks: {
                    beginAtZero: true,
                    stepSize: 100,
                    min: 300,
                    max: 800,
                    padding: 20
                  }
                }
              ],
              xAxes: [
                {
                  gridLines: {
                    display: false
                  }
                }
              ]
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12
              }
            }
          },
          data: {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [
              {
                label: "Cakes",
                borderColor: themeColor1,
                backgroundColor: themeColor1_10,
                data: [456, 479, 324, 569, 702, 600],
                borderWidth: 2
              },
              {
                label: "Desserts",
                borderColor: themeColor2,
                backgroundColor: themeColor2_10,
                data: [364, 504, 605, 400, 345, 320],
                borderWidth: 2
              }
            ]
          }
        });
      }
      if (document.getElementById("productChartNoShadow2")) {
        var productChartNoShadow2 = document
          .getElementById("productChartNoShadow2")
          .getContext("2d");
        var myChart = new Chart(productChartNoShadow2, {
          type: "bar",
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              yAxes: [
                {
                  gridLines: {
                    display: true,
                    lineWidth: 1,
                    color: "rgba(0,0,0,0.1)",
                    drawBorder: false
                  },
                  ticks: {
                    beginAtZero: true,
                    stepSize: 100,
                    min: 300,
                    max: 800,
                    padding: 20
                  }
                }
              ],
              xAxes: [
                {
                  gridLines: {
                    display: false
                  }
                }
              ]
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12
              }
            }
          },
          data: {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [
              {
                label: "Cakes",
                borderColor: themeColor1,
                backgroundColor: themeColor1_10,
                data: [456, 479, 324, 569, 702, 600],
                borderWidth: 2
              },
              {
                label: "Desserts",
                borderColor: themeColor2,
                backgroundColor: themeColor2_10,
                data: [364, 504, 605, 400, 345, 320],
                borderWidth: 2
              }
            ]
          }
        });
      }
      if (document.getElementById("productChartNoShadow3")) {
        var productChartNoShadow3 = document
          .getElementById("productChartNoShadow3")
          .getContext("2d");
        var myChart = new Chart(productChartNoShadow3, {
          type: "bar",
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              yAxes: [
                {
                  gridLines: {
                    display: true,
                    lineWidth: 1,
                    color: "rgba(0,0,0,0.1)",
                    drawBorder: false
                  },
                  ticks: {
                    beginAtZero: true,
                    stepSize: 100,
                    min: 300,
                    max: 800,
                    padding: 20
                  }
                }
              ],
              xAxes: [
                {
                  gridLines: {
                    display: false
                  }
                }
              ]
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12
              }
            }
          },
          data: {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [
              {
                label: "Cakes",
                borderColor: themeColor1,
                backgroundColor: themeColor1_10,
                data: [456, 479, 324, 569, 702, 600],
                borderWidth: 2
              },
              {
                label: "Desserts",
                borderColor: themeColor2,
                backgroundColor: themeColor2_10,
                data: [364, 504, 605, 400, 345, 320],
                borderWidth: 2
              }
            ]
          }
        });
      }
      if (document.getElementById("productChartNoShadow4")) {
        var productChartNoShadow4 = document
          .getElementById("productChartNoShadow4")
          .getContext("2d");
        var myChart = new Chart(productChartNoShadow4, {
          type: "bar",
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              yAxes: [
                {
                  gridLines: {
                    display: true,
                    lineWidth: 1,
                    color: "rgba(0,0,0,0.1)",
                    drawBorder: false
                  },
                  ticks: {
                    beginAtZero: true,
                    stepSize: 100,
                    min: 300,
                    max: 800,
                    padding: 20
                  }
                }
              ],
              xAxes: [
                {
                  gridLines: {
                    display: false
                  }
                }
              ]
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12
              }
            }
          },
          data: {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [
              {
                label: "Cakes",
                borderColor: themeColor1,
                backgroundColor: themeColor1_10,
                data: [456, 479, 324, 569, 702, 600],
                borderWidth: 2
              },
              {
                label: "Desserts",
                borderColor: themeColor2,
                backgroundColor: themeColor2_10,
                data: [364, 504, 605, 400, 345, 320],
                borderWidth: 2
              }
            ]
          }
        });
      }

    }
</script>
