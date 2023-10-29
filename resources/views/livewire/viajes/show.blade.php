<div class="mt-10 mb-10" x-data="showViaje">
    <h1 class="text-3xl text-slate-800 dark:text-slate-100 font-bold mb-6 mx-auto">Información del Viaje</h1>

    <livewire:viajes.card :viaje="$viaje" >
</div>


@push('code-js')
        <script>
            document.addEventListener('alpine:init', () => {
                
                Alpine.data('showViaje', () => ({
                    
                    init() {

                        window.livewire.on('checkTaxista', (taxista) => {
                            this.infoTaxista = `${taxista.name} ${taxista.marca} ${taxista.modelo} ${taxista.color}`;
                            this.fondo = taxista.fondo;
                            this.checkTaxista = true; 
                        });
                    },
                    copyUrl(){
                        var aux = document.createElement('input');
                        aux.setAttribute('value', window.location.href.split('?')[0].split('#')[0]);
                        document.body.appendChild(aux);
                        aux.select();
                        document.execCommand('copy');
                        document.body.removeChild(aux);
                    }

                }))
                
            })
        </script>

    @endpush