

/* making the number REAL LIFE TIME CHANGING */
let counters = document.querySelectorAll('.counter');
setInterval(() => {
    counters.forEach(counter => {
        let value = parseInt(counter.textContent);
        counter.textContent = value;
    });
}, 1000);





document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('Events').getContext('2d');
    const eventLabels = JSON.parse(document.querySelector('#evtLabels').dataset.myVariable);
    const eventData = JSON.parse(document.querySelector('#evtData').dataset.myVariable);
    // Group labels into broader categories
    const categoryLabels = ['Festivals', 'Sports', 'Concerts', 'Theatre', 'Cinema', 'Other'];
    const groupedData = [[], [], [], [], [], []];
    for (let i = 0; i < eventLabels.length; i++) {
        groupedData[i].push(eventData[i]);
    }
    // Create chart
    const eventsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: " ",
            datasets: [{
                label: 'Festivals',
                data: groupedData[0],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }, {
                label: 'Sports',
                data: groupedData[1],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: 'Concerts',
                data: groupedData[2],
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }, {
                label: 'Theatre',
                data: groupedData[3],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }, {
                label: 'Cinema',
                data: groupedData[4],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }, {
                label: 'Other',
                data: groupedData[5],
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    stacked: true,
                    barPercentage: 1,
                    categoryPercentage: 0.5,
                }],
                yAxes: [{
                    stacked: true,
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    // Remove each bar on click of corresponding  label
    const chartContainer = document.querySelector('.chart-container');
    chartContainer.addEventListener('click', function() {
        chartContainer.classList.toggle('expanded');
        eventsChart.resize();
    });
});

