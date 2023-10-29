<!-- Balance Periodo -->
<div class="col-span-full xl:col-span-6 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Balance</h2>
    </header>
    <div class="p-3">

        <!-- Card content -->
        <!-- "Today" group -->
        <div wire:ignore>
            <canvas id="balance" class="mx-auto" style="height: 350px; width: 100%; max-height: 350px;"></canvas>
        </div>

    </div>
</div>

@push('code-js')
    <script>

        Livewire.on('paintBalance',(importe,ganancia)=>{
            paintBalance(importe,ganancia);
        });

        function paintBalance(importe, ganancia){

            // Grafico de Balance
            const balance = document.getElementById('balance').getContext('2d');
            if (window.myChartbalance) {
                window.myChartbalance.clear();
                window.myChartbalance.destroy();
            }

            window.myChartbalance = new Chart(balance, {
                type: 'doughnut',
                data: {
                    labels: ['Importe Total','Ganancia'],
                    datasets: [
                        {
                        label: 'Balance',
                        data: [importe,ganancia],
                        backgroundColor: [ 
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                        },
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Balance del Período'
                    }
                    }
                },
            });

            }
    </script>
@endpush
