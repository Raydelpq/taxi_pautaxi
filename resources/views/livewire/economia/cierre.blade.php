<div class="mt-4">
    
    <div x-data="{
        fechas: @entangle('fechas').defer,
        
        addClass(){
            const el = document.getElementsByClassName('flatpickr-calendar');
            el.classList.add('mx-auto');
        }
    }">
        <div class="w-5/6 mx-auto grid justify-center">
            <label for="filterRange">Seleccione Rango de Fecha</label>
            <div class="inline-flex">
                <input
                    type="text"
                    x-model='fechas'
                    id="filterRange"
                    class="form-input w-full"
                    placeholder="Seleccione"
                    x-on:click="addClass();"
                />
                
                <!--    -->
                <button class="btn bg-green-600 hover:bg-green-700 text-white ml-3 disabled:bg-slate-500" wire:click="procesarFecha" x-bind:disabled=' !fechas '>
                    <i wire:target="procesarFecha" wire:loading.remove="" class="fas fa-check"></i>
                    <svg class="animate-spin h-5 w-6 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:target="procesarFecha" wire:loading.class.remove="hidden">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    @if($cargado)

    <div class="mt-3 p-4 grid grid-cols-1 gap-2">
        <div class="col-span-full bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 p-4 mt-3">
            <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Contabilidad Semanal:</h2> 
            </header>
            <div class="p-3">

                <div class="grid grid-cols-2">

                    <div class="col-span-2 sm:col-span-1">
                        Ingresos Totales: {{ $this->getIngresosSemanales() + $ingresos }} CUP
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        Gastos Totales: {{ ($salarios + $gastos) }} CUP
                    </div>
                    <hr class="col-span-full">
                    <div class="col-span-full mt-3">
                        Utilidad o Perdida Semanal: {{ ($this->getIngresosSemanales() + $ingresos) - ($salarios + $gastos) }} CUP
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="mt-3 p-4 grid grid-cols-1 gap-2">
        <div class="col-span-full bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 p-4 mt-3">
            <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Informacion:</h2> 
            </header>
            <div class="p-3">

                <div class="grid grid-cols-2">

                    <div class="col-span-2 sm:col-span-1">
                        Utilidades: {{ $montoTotal - ($salarios + $gastos) }} CUP
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        Ingresos: {{ $ingresos }} CUP
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        Gastos: {{ $gastos }} CUP
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        Salarios: {{ $salarios }} CUP
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        Monto Total: {{ $montoTotal }} CUP
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        Viajes: {{ $viajesTotal }}
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        Viajes Cancelados: {{ $viajesEliminados }}
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="mt-3 p-4 grid grid-cols-12 gap-2">
        
        <!-- Gastos -->
        <div class="col-span-full xl:col-span-6 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 animate-pulse">
            <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Gastos</h2>
            </header>
            <div class="p-3">
        
                <!-- Card content -->
                <!-- "Today" group -->
                <div>
                    <header class="text-right text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm font-semibold p-2">
                        {{ $gastos }} CUP
                    </header>
                    <ul class="my-1 z">
                        @foreach ($listGatos as $gasto)
                            <!-- Item -->
                            <li class="flex px-2">
                                <div class="grow flex items-center border-b border-slate-100 dark:border-slate-700 text-sm py-2">
                                    <div class="grow flex justify-between">
                                        <div class="self-center"> {{ $gasto->name }}</div>
                                        <div class="shrink-0 self-start ml-2">
                                            <span class="font-medium text-slate-800 dark:text-slate-100">{{ $gasto->valor }}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
        
            </div>
        </div>

        <!-- Salarios -->
        <div class="col-span-full xl:col-span-6 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 animate-pulse">
            <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Salarios</h2>
            </header>
            <div class="p-3 animate-pulse">
        
                <!-- Card content -->
                <!-- "Today" group -->
                <div>
                    <header class="text-right text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm font-semibold p-2">
                        {{ $salarios }} CUP
                    </header>
                    <ul class="my-1">
                        
                        @foreach ($empleados as $empleado)
                       
                            <!-- Item -->
                            <li class="flex px-2">
                                <div class="grow flex items-center border-b border-slate-100 dark:border-slate-700 text-sm py-2">
                                    <div class="grow flex justify-between">
                                        <div class="self-center"> {{ $empleado->name }} {{ $empleado->apellidos }}</div>
                                        <div class="shrink-0 self-start ml-2">
                                            <span class="font-medium text-slate-800 dark:text-slate-100">{{ $empleado->salario }} CUP</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
        
            </div>
        </div>

        <!-- Balance Diario -->
        <div class="col-span-full xl:col-span-6 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 animate-pulse">
            <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Balance de Viajes Diario</h2>
            </header>
            <div class="p-3">
        
                <!-- Card content -->
                <!-- "Today" group -->
                <div wire:ignore>
                    <canvas id="diario"></canvas>
                </div>
        
            </div>
        </div>

        <!-- Balance Viajes Eliminados -->
        <div class="col-span-full xl:col-span-6 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 animate-pulse">
            <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Balance de Viajes Eliminados</h2>
            </header>
            <div class="p-3">
        
                <!-- Card content -->
                <!-- "Today" group -->
                <div wire:ignore>
                    <canvas id="eliminados"></canvas>
                </div>
        
            </div>
        </div>

        <!-- Balance Viajes Eliminados -->
        <div class="col-span-full bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 animate-pulse">
            <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Viajes por Colaboradores</h2>
            </header>
            <div class="p-3">
                <livewire:economia.colaboraciones :star="$star" :end="$end"/>
            </div>
        </div>

        <!-- Balance Periodo -->
        <div class="col-span-full bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
            <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Balance de Económico</h2>
            </header>
            <div class="p-3"> 
        
                <!-- Card content -->
                <!-- "Today" group -->
                <div wire:ignore>
                    <canvas id="balance" class="mx-auto" style="width: 400px !important; height: 400px; !important"></canvas>
                </div>
        
            </div>
        </div>

        <div>
            <button class="btn bg-indigo-500 hover:bg-indigo700 disabled:bg-slate-500 text-white w-[130px]" wire:click='save' wire:loading.attr='disabled' wire:target='save'>
                <svg class="animate-spin h-5 w-6 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" wire:target="save" wire:loading.class.remove="hidden">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="flex" wire:target="save" wire:loading.remove>
                    <i class="fas fa-save mt-1"></i> &nbsp;
                    Guardar
                </span>
            </button>
        </div>

    </div>
    @endif

</div>

@push('code-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 

<script>

    Livewire.on('endLoad', ()=>{
        Livewire.emit('loadState'); 
    });
    
    
    Livewire.on('ready', ()=>{
        const els = document.querySelectorAll('.animate-pulse');
        console.log(els);
        for (let i = 0; i < els.length; i++) {
            els[i].classList.remove('animate-pulse');
            console.log(els[i]);
        }
    });
    

    
    Livewire.on('paint', (labels,viajesDiarios,labelEliminados,viajesDiariosEliminados)=>{
        paint(labels,viajesDiarios,labelEliminados,viajesDiariosEliminados);
    });

    flatpickr('#filterRange', {
            @if($lastCierre != null)
            defaultDate: [new Date('{{ $lastCierre->end }}').fp_incr(1)] ,
            @endif
            dateFormat:'Y-m-d', 
            altFormat:'j F Y', 
            altInput:true, 
            static: true,
            locale: "es",
            mode: "range",
        });

    function paint(labels,viajesDiarios,labelsEliminados,viajesDiariosEliminados){
        
        // Grafico de viajes diarios
        const viajes = document.getElementById('diario').getContext('2d');
        if (window.myChartViajes) {
            window.myChartViajes.clear();
            window.myChartViajes.destroy();
        }
        
        window.myChartViajes = new Chart(viajes, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                    label: 'Viajes',
                    data: viajesDiarios,
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

        // Grafico de viajes eliminados
        const viajesEliminados = document.getElementById('eliminados').getContext('2d');
        if (window.myChartViajesEliminados) {
            window.myChartViajesEliminados.clear();
            window.myChartViajesEliminados.destroy();
        }

        window.myChartViajesEliminados = new Chart(viajesEliminados, {
            type: 'bar',
            data: {
                labels: labelsEliminados,
                datasets: [
                    {
                    label: 'Viajes Cancelados',
                    data: viajesDiariosEliminados, 
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
                        text: "Viajes Eliminados en el Período"
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

    Livewire.on('paintBalance', (gastos, salarios, ganancia) => {
        paintBalance(gastos, salarios, ganancia);
    });


    function paintBalance(gastos, salarios, ganancia){

        // Grafico de Balance
        const balance = document.getElementById('balance').getContext('2d');
        if (window.myChartbalance) {
            window.myChartbalance.clear();
            window.myChartbalance.destroy();
        }

        window.myChartbalance = new Chart(balance, {
            type: 'doughnut',
            data: {
                labels: ['Gastos','Salarios','Ganancias'],
                datasets: [
                    {
                    label: 'Economía',
                    data: [gastos,salarios,ganancia],
                    backgroundColor: [ 
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
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
