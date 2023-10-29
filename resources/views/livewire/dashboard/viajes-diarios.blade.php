<!-- Balance Periodo -->
<div class="col-span-full xl:col-span-6 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100 w-[120px] flex-none">Viajes Diarios</h2>
        <div class="grow h-2"></div>
        @role('Administrador')
        <span class="flex-none">
            <span wire:target='mis' wire:loading.remove>
                <label for="mis-diarios">Mis Viajes</label>
                <input type="checkbox" name="mis-diarios" id="mis-diarios" class="form-checkbox" wire:model="mis" >
            </span>
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:target='mis' wire:loading.class.remove="hidden">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </span>
        @endrole
    </header>
    <div class="p-3"> 

        <!-- Card content -->
        <!-- "Today" group -->
        
        <div wire:ignore>
            <canvas id="diario" class="mx-auto" style="height: 350px; width: 100%; max-height: 350px;"></canvas>
        </div>

    </div>
</div> 

@push('code-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        Livewire.on('paintDiario',(labels,cantidad)=>{
            paint(labels,cantidad);
        });

        function paint(labels,cantidad){
            
            // Grafico de viajes diarios
            const viajes = document.getElementById('diario').getContext('2d');
            if (window.myChartViajes) {
                window.myChartViajes.clear();
                window.myChartViajes.destroy();
                window.myChartViajes = null;
            }
            
            window.myChartViajes = new Chart(viajes, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                        label: 'Viajes',
                        data: cantidad,
                        backgroundColor: [ 
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',

                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',

                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',

                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',

                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',

                            'rgba(75, 192, 192, 0.2)'
                            
                        ],
                        borderColor: [
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',

                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',

                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',

                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',

                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',

                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                        },
                    ]
                },
                options: {
                    scales: {
                        y: {
                        beginAtZero: true
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: "Viajes en el Período"
                        },
                    },
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            });

        }

    </script>
@endpush