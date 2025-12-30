var colors = ["#f1556c"],
    dataColors = $("#total-revenue").data("colors");
dataColors && (colors = dataColors.split(","));
var options = {
        series: [68],
        chart: {
            height: 242,
            type: "radialBar"
        },
        plotOptions: {
            radialBar: {
                hollow: {
                    size: "65%"
                }
            }
        },
        colors: colors,
        labels: ["Revenue"]
    },
    chart = new ApexCharts(document.querySelector("#total-revenue"), options);
chart.render();
