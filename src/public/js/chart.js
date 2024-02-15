`use strict`

// 学習時間
{
  fetch('/get-barChart-data', {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    },
  })
  .then(response => response.json())
  .then(studyHours => {
    studyHoursDate = [];
    studyHoursTime = [];
    studyHours.forEach((element) => {
      studyHoursDate.push(element.date)
      studyHoursTime.push(element.time);
    })

    const ctx = document.getElementById('studyHoursGraph');
    const context = ctx.getContext('2d');
    const grad = context.createLinearGradient( 0 , 200 , 0 , 0 ) ;
    grad.addColorStop(0.0 , '#0f71bc');
    grad.addColorStop(1.0 , "#3ccfff");
  
    const myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: studyHoursDate,
          datasets: [{
              label: '# of Votes',
              data: studyHoursTime,
              backgroundColor: grad,
              borderWidth: 1
          }]
      },
      options: {
        scales: {
          x: {
            grid: {
              display: false,
            },
            ticks: {
              stepSize: 2,
              callback: function(value){
                if(value % 2 != 0  && value != 0){
                  return value + 1;
                };
              }
            },
          },
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 2,
              callback: function(value){
                return value+'h';
              }
            },
          }
        },
        plugins: false
      }
    });
  })
  .catch(error => {
    // エラー処理
    console.log(error);
  });
}

// // Register the plugin to all charts:
Chart.register(ChartDataLabels);

// 学習言語
{
  fetch('/get-languagesPieChart-data', {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    },
  })
  .then(response => response.json())
  .then(languages => {
    const ctx = document.getElementById('languagesPieChart');
    let languagesName = [];
    let languagesHour = [];
    let languagesColor = [];
    languages.forEach((element) => {
      languagesName.push(element.name);
      languagesHour.push(element.hour);
      languagesColor.push(element.color);
    })
    const myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
          labels: languagesName,
          datasets: [{
            data: languagesHour,
            backgroundColor: languagesColor,
            parsing: {
              yAxisKey: 'net'
            }
          }]
      },
      options: {
        plugins: {
          legend: {
            display: false,
          },
          datalabels: {
            labels: {
              title: {
                color: "white",
              },
            },
            formatter: function (value, context) {
              return value + "%";
            },
          },
        }
      }
    });

    const languagesChartWrapper = document.getElementById('languagesChartWrapper');
    let languagesList = `<div class="contents-list">`;
    languages.forEach((element) => {
      languagesList += `<div><span style="color:${element.color}">●</span>${element.name}</div>`;
    });
    languagesList += `</div>`;
    languagesChartWrapper.insertAdjacentHTML("beforeend", languagesList);
  })
  .catch(error => {
    // エラー処理
    console.log(error);
  });
}

// 学習コンテンツ
{
  fetch('/get-contentsPieChart-data', {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    },
  })
  .then(response => response.json())
  .then(contents => {

    const ctx = document.getElementById('contentsPieChart');
    let contentsName = [];
    let contentsHour = [];
    let contentsColor = [];
    contents.forEach((element) => {
      contentsName.push(element.name);
      contentsHour.push(element.hour);
      contentsColor.push(element.color);
    })
    const myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: contentsName,
        datasets: [{
          data: contentsHour,
          backgroundColor: contentsColor,
        }],
      },
      options: {
        plugins: {
          legend: {
            display: false,
          },
          datalabels: {
            labels: {
              title: {
                color: "white",
              },
            },
            formatter: function (value, context) {
              return value + "%";
            },
          },
        }
      }
    });
    
    const contentsChartWrapper = document.getElementById('contentsChartWrapper');
    let contentsList = `<div class="contents-list">`;
    contents.forEach((element) => {
      contentsList += `<div><span style="color:${element.color}">●</span>${element.name}</div>`;
    });
    contentsList += `</div>`;
    contentsChartWrapper.insertAdjacentHTML("beforeend", contentsList);
  })
    .catch(error => {
    // エラー処理
    console.log(error);
  });
}
