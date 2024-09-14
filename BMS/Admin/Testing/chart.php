<div class="box-container tms-card">
                    <div class="tms-card-head">
                        <div><i class="fa-duotone fa-chart-line-up"></i></div>
                        <div>Fuel Cost</div>
                    </div>
                    <div class="container tms-card-body" style="margin:0;height: 100%;width: 100%;">
                        <div class="row row-head">
                            <div class="widget">
                                <canvas id="chart"></canvas>
                            </div>
                            <script>
                                const ctx = document.getElementById("chart");

                                Chart.defaults.color = "#272626";
                                // Chart.defaults.font.family = "Poppins";

                                new Chart(ctx, {
                                    type: "line",
                                    data: {
                                        labels: [
                                            "Jan",
                                            "Feb",
                                            "Mar",
                                            "Apr",
                                            "May",
                                            "Jun",
                                            "Jul",
                                            "Aug",
                                            "Sep",
                                            "Oct",
                                            "Nov",
                                            "Dec",
                                        ],
                                        datasets: [
                                            {
                                                label: "",
                                                data: [2235, 3250, 1890, 5400, 20240, 6254, 12325, 4856, 10325, 2254, 22356, 8486],
                                                backgroundColor: "black",
                                                borderColor: "coral",
                                                borderRadius: 6,
                                                cubicInterpolationMode: 'monotone',
                                                fill: false,
                                                borderSkipped: false,
                                            },
                                        ],
                                    },
                                    options: {
                                        interaction: {
                                            intersect: false,
                                            mode: 'index'
                                        },
                                        elements: {
                                            point: {
                                                radius: 0
                                            }
                                        },
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: {
                                                display: false,
                                            },
                                            tooltip: {
                                                backgroundColor: "orange",
                                                bodyColor: "#272626",
                                                yAlign: "bottom",
                                                cornerRadius: 4,
                                                titleColor: "#272626",
                                                usePointStyle: true,
                                                callbacks: {
                                                    label: function (context) {
                                                        if (context.parsed.y !== null) {
                                                            const label = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'INR' }).format(context.parsed.y);
                                                            return label;
                                                        }
                                                        return null;
                                                    }
                                                }
                                            },
                                        },
                                        scales: {
                                            x: {
                                                border: {
                                                    dash: [4, 4],
                                                },
                                                title: {
                                                    text: "2023",
                                                },
                                            },
                                            y: {
                                                grid: {
                                                    color: "#27292D",
                                                },
                                                border: {
                                                    dash: [1, 2],
                                                }
                                            },
                                        },
                                    },
                                });
                            </script>
                        </div>
                    </div>
                </div>