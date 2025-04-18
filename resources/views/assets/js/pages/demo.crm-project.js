!(function (e) {
  "use strict";
  function t() {
    (this.$body = e("body")), (this.charts = []);
  }
  (t.prototype.init = function () {
    this.initCharts();
  }),
    (t.prototype.initCharts = function () {
      var t = ["#727cf5", "#0acf97"],
        o = e("#crm-project-statistics").data("colors");
      o && (t = o.split(","));
      var r = {
        chart: { height: 327, type: "bar", toolbar: { show: !1 } },
        plotOptions: {
          bar: { horizontal: !1, endingShape: "rounded", columnWidth: "25%" },
        },
        dataLabels: { enabled: !1 },
        stroke: { show: !0, width: 3, colors: ["transparent"] },
        colors: t,
        series: [
          {
            name: "Previous Week Sale",
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
          },
          {
            name: "This Week Sale",
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
          },
        ],
        xaxis: {
          categories: [
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
          ],
        },
        legend: { offsetY: 7 },
        yaxis: { title: { text: "$ (thousands)" } },
        fill: { opacity: 1 },
        grid: {
          row: { colors: ["transparent", "transparent"], opacity: 0.2 },
          borderColor: "#f1f3fa",
          padding: { bottom: 5 },
        },
        tooltip: {
          y: {
            formatter: function (t) {
              return "$ " + t + "K";
            },
          },
        },
      };
      new ApexCharts(
        document.querySelector("#crm-project-statistics"),
        r
      ).render();
      t = ["#727cf5", "#0acf97"];
      (o = e("#monthly-target").data("colors")) && (t = o.split(","));
      r = {
        chart: { height: 255, type: "donut" },
        legend: { show: !1 },
        stroke: { colors: ["transparent"] },
        series: [60, 40],
        labels: ["Panding Projects", "Done Projects"],
        colors: t,
        responsive: [
          {
            breakpoint: 480,
            options: { chart: { width: 200 }, legend: { position: "bottom" } },
          },
        ],
      };
      new ApexCharts(document.querySelector("#monthly-target"), r).render();
    }),
    (e.CrmProject = new t()),
    (e.CrmProject.Constructor = t);
})(window.jQuery),
  (function (o) {
    "use strict";
    o(document).ready(function (t) {
      o.CrmProject.init();
    });
  })(window.jQuery);
var colors = ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"],
  dataColors = $("#project-overview-chart").data("colors");
dataColors && (colors = dataColors.split(","));
var options = {
    chart: { height: 326, type: "radialBar" },
    colors: colors,
    series: [85, 70, 80, 65],
    labels: [
      "AKM",
      "PM",
      "Norinko",
      "PK",
    ],
    plotOptions: { radialBar: { track: { margin: 5 } } },
  },
  chart = new ApexCharts(
    document.querySelector("#project-overview-chart"),
    options
  );
chart.render();
