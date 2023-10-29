<div class="grid grid-cols-12 gap-4">
    

    <div class="mt-2 flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
        <div class="px-5 pt-5">
            <header class="flex justify-between items-start mb-2">
               
                <p class="mx-1 w-full">Suma Total de Fondo</p>
                
            </header>
 
            <div class="w-full mb-3 bg-slate-300 dark:bg-slate-900 p-4 rounded">
                <p>Fondo Total Acumulado: {{ $fondoTotal }} CUP</p>
            </div>
        </div>
    
    </div>

    <div class="mt-2 flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
        <div class="px-5 pt-5">
            <header class="flex justify-between items-start mb-2">
               
                <p class="mx-1 w-full">Ingreso Semanal</p>
                
            </header>
 
            <div class="w-full mb-3 bg-slate-300 dark:bg-slate-900 p-4 rounded">
                <p>Ingreso: {{ $ingresoSemanal }} CUP</p>
            </div>
        </div>
    
    </div>

    <div class="mt-2 flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
        <div class="px-5 pt-5">
            <header class="flex justify-between items-start mb-2">
               
                <p class="mx-1 w-full">Deuda Total de Taxistas</p>
                
            </header>
 
            <div class="w-full mb-3 bg-slate-300 dark:bg-slate-900 p-4 rounded">
                <p>Deuda total acumulado: {{ $deudaTotal }} CUP</p>
            </div>
        </div>
    
    </div>

</div>
