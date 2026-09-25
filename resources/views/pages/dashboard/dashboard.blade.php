@include('layouts.header')
<!-- MAIN BODY / CONTENT -->
<main class="flex-1 p-4 lg:p-8 space-y-6">

    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <!-- HEADER -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">
                    Problem Statistics
                </h3>
                <p class="text-sm text-gray-500">
                    Monthly Problem & Resolution Duration
                </p>
            </div>
            <!-- FILTER YEAR -->
            <form method="GET">
                <select
                    name="year"
                    onchange="this.form.submit()"
                    class="border border-gray-200 rounded-lg px-4 py-2 text-sm bg-white">

                    @for ($y = now()->year; $y >= 2020; $y--)

                    <option
                        value="{{ $y }}"
                        {{ $year == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>

                    @endfor

                </select>

            </form>

        </div>

        <!-- CHART -->
        <div class="relative w-full h-[300px]">
            <canvas id="problemChart"></canvas>
        </div>

    </div>
    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-4">


        <!-- Card 4 -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Problem</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $totalProblem }}</p>

            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation text-lg"></i>
            </div>
        </div>
        <!-- Card 4 -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Duration</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $formattedDuration }}</p>

            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i class="fa-solid fa-clock text-lg"></i>
            </div>
        </div>
        <!-- Card 4 -->
    </div>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const canvas = document.getElementById('problemChart');

        if (!canvas) return;

        // DATA FROM CONTROLLER
        const months = @json($months);
        const monthlyProblems = @json($monthlyProblems);
        const monthlyDurations = @json($monthlyDurations);

        // FORMAT DURATION
        function formatDuration(totalMinutes) {

            const total = Math.round(Number(totalMinutes) || 0);

            const hours = Math.floor(total / 60);
            const minutes = total % 60;

            if (hours === 0) {
                return `${minutes} Menit`;
            }

            return `${hours} Jam ${minutes} Menit`;
        }

        // DESTROY EXISTING CHART
        const existingChart = Chart.getChart(canvas);

        if (existingChart) {
            existingChart.destroy();
        }

        // CREATE COMBO CHART
        new Chart(canvas, {

            data: {
                labels: months,

                datasets: [

                    // BAR - QTY PROBLEM
                    {
                        type: 'bar',
                        label: 'Qty Problem',
                        data: monthlyProblems,

                        backgroundColor: '#2563eb',
                        hoverBackgroundColor: '#1d4ed8',

                        borderRadius: 6,
                        maxBarThickness: 42,

                        yAxisID: 'y',
                        order: 2
                    },

                    // LINE - TOTAL DURATION
                    {
                        type: 'line',
                        label: 'Total Duration',
                        data: monthlyDurations,

                        borderColor: '#f97316',
                        backgroundColor: '#f97316',

                        borderWidth: 3,
                        tension: 0.3,

                        pointRadius: 5,
                        pointHoverRadius: 7,

                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#f97316',
                        pointBorderWidth: 2,

                        fill: false,

                        yAxisID: 'y1',
                        order: 1
                    }

                ]
            },

            options: {

                responsive: true,
                maintainAspectRatio: false,

                interaction: {
                    mode: 'index',
                    intersect: false
                },

                plugins: {

                    legend: {
                        display: true,
                        position: 'bottom',

                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },

                    tooltip: {
                        callbacks: {

                            label: function(context) {

                                if (context.dataset.type === 'line') {

                                    return 'Total Duration: ' +
                                        formatDuration(context.parsed.y);
                                }

                                return 'Qty Problem: ' +
                                    context.parsed.y;
                            }
                        }
                    }
                },

                scales: {

                    // LEFT AXIS - QTY
                    y: {
                        type: 'linear',
                        position: 'left',
                        beginAtZero: true,

                        title: {
                            display: true,
                            text: 'Qty Problem'
                        },

                        ticks: {
                            precision: 0
                        }
                    },

                    // RIGHT AXIS - DURATION
                    y1: {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,

                        title: {
                            display: true,
                            text: 'Total Duration'
                        },

                        grid: {
                            drawOnChartArea: false
                        },

                        ticks: {
                            callback: function(value) {
                                return formatDuration(value);
                            }
                        }
                    },

                    // X AXIS - MONTH
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

    });
</script>

@include('layouts.footer',['months'=>$months])