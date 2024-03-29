/*
*  Document   : compCharts.js
*  Author     : pixelcave
*/
var CompCharts1 = function () {
    return {
        init: function () {
            function o(o, i) {
                return Math.floor(Math.random() * (i - o + 1)) + o
            }

            function i() {
                for (g.length > 0 && (g = g.slice(1)); g.length < 300; ) {
                    var o = g.length > 0 ? g[g.length - 1] : 50,
                        i = o + 10 * Math.random() - 5;
                    0 > i && (i = 0), i > 100 && (i = 100), g.push(i)
                }
                for (var t = [], l = 0; l < g.length; ++l) t.push([l, g[l]]);
                return $("#chart-live-info").html(i.toFixed(0) + "%"), t
            }

            function t() {
                n.setData([i()]), n.draw(), setTimeout(t, 60)
            }
            var l = {
                type: "bar",
                barWidth: 6,
                barSpacing: 5,
                height: "50px",
                tooltipOffsetX: -25,
                tooltipOffsetY: 20,
                barColor: "#9b59b6",
                tooltipPrefix: "",
                tooltipSuffix: " Projects",
                tooltipFormat: "{{prefix}}{{value}}{{suffix}}"
            };
            $("#mini-chart-bar1").sparkline("html", l), l.barColor = "#2ecc71", l.tooltipPrefix = "$ ", l.tooltipSuffix = "", $("#mini-chart-bar2").sparkline("html", l), l.barColor = "#1bbae1", l.tooltipPrefix = "", l.tooltipSuffix = " Updates", $("#mini-chart-bar3").sparkline("html", l);
            var a = {
                type: "line",
                width: "80px",
                height: "50px",
                tooltipOffsetX: -25,
                tooltipOffsetY: 20,
                lineColor: "#c0392b",
                fillColor: "#e74c3c",
                spotColor: "#555555",
                minSpotColor: "#555555",
                maxSpotColor: "#555555",
                highlightSpotColor: "#555555",
                highlightLineColor: "#555555",
                spotRadius: 3,
                tooltipPrefix: "",
                tooltipSuffix: " Projects",
                tooltipFormat: "{{prefix}}{{y}}{{suffix}}"
            };
            $("#mini-chart-line1").sparkline("html", a), a.lineColor = "#16a085", a.fillColor = "#1abc9c", a.tooltipPrefix = "$ ", a.tooltipSuffix = "", $("#mini-chart-line2").sparkline("html", a), a.lineColor = "#7f8c8d", a.fillColor = "#95a5a6", a.tooltipPrefix = "", a.tooltipSuffix = " Updates", $("#mini-chart-line3").sparkline("html", a);
            var r;
            $(".toggle-pies").click(function () {
                $(".pie-chart").each(function () {
                    r = o(1, 100), $(this).data("easyPieChart").update(r), $(this).find("span").text(r + "%")
                })
            });
            var e = $("#chart-classic"),
                s = $("#chart-stacked"),
                n = $("#chart-live"),
                c = $("#chart-bars"),
                p = $("#chart-pie1"),
                f = [
                    [1, 1560],
                    [2, 1650],
                    [3, 1320],
                    [4, 1950],
                    [5, 1800],
                    [6, 2400],
                    [7, 2100],
                    [8, 2550],
                    [9, 3300],
                    [10, 3900],
                    [11, 4200],
                    [12, 4500]
                ],
                h = [
                    [1, 500],
                    [2, 420],
                    [3, 480],
                    [4, 350],
                    [5, 600],
                    [6, 850],
                    [7, 1100],
                    [8, 950],
                    [9, 1220],
                    [10, 1300],
                    [11, 1500],
                    [12, 1700]
                ],
                d = [
                    [1, 150],
                    [3, 200],
                    [5, 250],
                    [7, 300],
                    [9, 420],
                    [11, 350],
                    [13, 450],
                    [15, 600],
                    [17, 580],
                    [19, 810],
                    [21, 1120]
                ],
                b = [
                    [1, "Jan"],
                    [2, "Feb"],
                    [3, "Mar"],
                    [4, "Apr"],
                    [5, "May"],
                    [6, "Jun"],
                    [7, "Jul"],
                    [8, "Aug"],
                    [9, "Sep"],
                    [10, "Oct"],
                    [11, "Nov"],
                    [12, "Dec"]
                ];
            $.plot(e, [{
                label: "Earnings",
                data: f,
                lines: {
                    show: !0,
                    fill: !0,
                    fillColor: {
                        colors: [{
                            opacity: .25
                        }, {
                            opacity: .25
                        }]
                    }
                },
                points: {
                    show: !0,
                    radius: 6
                }
            }, {
                label: "Sales",
                data: h,
                lines: {
                    show: !0,
                    fill: !0,
                    fillColor: {
                        colors: [{
                            opacity: .15
                        }, {
                            opacity: .15
                        }]
                    }
                },
                points: {
                    show: !0,
                    radius: 6
                }
            }], {
                colors: ["#3498db", "#333333"],
                legend: {
                    show: !0,
                    position: "nw",
                    margin: [15, 10]
                },
                grid: {
                    borderWidth: 0,
                    hoverable: !0,
                    clickable: !0
                },
                yaxis: {
                    ticks: 4,
                    tickColor: "#eeeeee"
                },
                xaxis: {
                    ticks: b,
                    tickColor: "#ffffff"
                }
            });
            var u = null,
                x = null;
            e.bind("plothover", function (o, i, t) {
                if (t) {
                    if (u !== t.dataIndex) {
                        u = t.dataIndex, $("#chart-tooltip").remove();
                        var l = (t.datapoint[0], t.datapoint[1]);
                        x = 1 === t.seriesIndex ? "<strong>" + l + "</strong> sales" : "$ <strong>" + l + "</strong>", $('<div id="chart-tooltip" class="chart-tooltip">' + x + "</div>").css({
                            top: t.pageY - 45,
                            left: t.pageX + 5
                        }).appendTo("body").show()
                    }
                } else $("#chart-tooltip").remove(), u = null
            }), $.plot(c, [{
                label: "Sales",
                data: d,
                bars: {
                    show: !0,
                    lineWidth: 0,
                    fillColor: {
                        colors: [{
                            opacity: .5
                        }, {
                            opacity: .5
                        }]
                    }
                }
            }], {
                colors: ["#9b59b6"],
                legend: {
                    show: !0,
                    position: "nw",
                    margin: [15, 10]
                },
                grid: {
                    borderWidth: 0
                },
                yaxis: {
                    ticks: 4,
                    tickColor: "#eeeeee"
                },
                xaxis: {
                    ticks: 10,
                    tickColor: "#ffffff"
                }
            });
            var g = [],
                n = $.plot(n, [{
                    data: i()
                }], {
                    series: {
                        shadowSize: 0
                    },
                    lines: {
                        show: !0,
                        lineWidth: 1,
                        fill: !0,
                        fillColor: {
                            colors: [{
                                opacity: .2
                            }, {
                                opacity: .2
                            }]
                        }
                    },
                    colors: ["#34495e"],
                    grid: {
                        borderWidth: 0,
                        color: "#aaaaaa"
                    },
                    yaxis: {
                        show: !0,
                        min: 0,
                        max: 110
                    },
                    xaxis: {
                        show: !1
                    }
                });
            t(), $.plot(p, [{
                label: "M.S",
                data: 20
            }, {
                label: "Ph.D",
                data: 45
            }, {
                label: "PDF",
                data: 35
            }], {
                colors: ["#333333", "#1abc9c", "#16a085"],
                legend: {
                    show: !1
                },
                series: {
                    pie: {
                        show: !0,
                        radius: 1,
                        label: {
                            show: !0,
                            radius: .75,
                            formatter: function (o, i) {
                                return '<div class="chart-pie1-label">' + o + "<br>" + Math.round(i.percent) + "%</div>"
                            },
                            background: {
                                opacity: .75,
                                color: "#000000"
                            }
                        }
                    }
                }
            }), $.plot(s, [{
                label: "Sales",
                data: h
            }, {
                label: "Earnings",
                data: f
            }], {
                colors: ["#f1c40f", "#f39c12"],
                series: {
                    stack: !0,
                    lines: {
                        show: !0,
                        fill: !0
                    }
                },
                lines: {
                    show: !0,
                    lineWidth: 0,
                    fill: !0,
                    fillColor: {
                        colors: [{
                            opacity: .75
                        }, {
                            opacity: .75
                        }]
                    }
                },
                legend: {
                    show: !0,
                    position: "nw",
                    margin: [15, 10],
                    sorted: !0
                },
                grid: {
                    borderWidth: 0
                },
                yaxis: {
                    ticks: 4,
                    tickColor: "#eeeeee"
                },
                xaxis: {
                    ticks: b,
                    tickColor: "#ffffff"
                }
            })
        }
    }
} ();