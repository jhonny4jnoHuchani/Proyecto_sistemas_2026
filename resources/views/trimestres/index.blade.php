@extends('adminlte::page')

@section('title', 'Gestión de Trimestres')

@section('content_header')
    <h1><i class="fas fa-calendar-alt"></i> Control de Trimestres</h1>
@stop

@section('content')
    @if(!$gestionActiva)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> No hay ninguna Gestión Académica activa en este momento. Por favor, active una desde el módulo de Gestiones.
        </div>
    @else
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-check"></i> Trimestres de la Gestión <strong>{{ $gestionActiva->anio }}</strong>
                </h3>
            </div>
            <div class="card-body">
                
                <div class="alert alert-info py-2">
                    <i class="fas fa-info-circle"></i> <strong>Aviso:</strong> Activa el interruptor para permitir a los docentes subir calificaciones en ese periodo. Desactívalo para bloquear el sistema.
                </div>

                <div class="row mt-4">
                    @forelse($trimestres as $trimestre)
                        <div class="col-md-4">
                            <div class="card {{ $trimestre->estado ? 'card-success' : 'card-secondary' }} card-outline shadow-sm text-center trimestre-card" id="card-{{ $trimestre->id }}">
                                <div class="card-body">
                                    <h4 class="font-weight-bold">{{ $trimestre->nombre }}</h4>
                                    <hr>
                                    
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success mt-3">
                                        <input type="checkbox" class="custom-control-input toggle-trimestre" 
                                            id="switch-{{ $trimestre->id }}" 
                                            data-id="{{ $trimestre->id }}"
                                            {{ $trimestre->estado ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="switch-{{ $trimestre->id }}">
                                            <span id="label-{{ $trimestre->id }}">
                                                {{ $trimestre->estado ? 'Abierto (Permite Notas)' : 'Cerrado (Bloqueado)' }}
                                            </span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted">
                            No se encontraron trimestres para esta gestión.
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    @endif
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('.toggle-trimestre').change(function() {
            let estadoSwitch = $(this).prop('checked');
            let trimestreId = $(this).data('id');
            let url = "{{ route('trimestres.toggle', ':id') }}";
            url = url.replace(':id', trimestreId);

            // Petición AJAX a Laravel
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // Si todo sale bien, actualizamos la interfaz visualmente
                    let label = $('#label-' + trimestreId);
                    let card = $('#card-' + trimestreId);

                    if(response.nuevo_estado) {
                        label.text('Abierto (Permite Notas)');
                        card.removeClass('card-secondary').addClass('card-success');
                    } else {
                        label.text('Cerrado (Bloqueado)');
                        card.removeClass('card-success').addClass('card-secondary');
                    }
                },
                error: function(error) {
                    alert('Hubo un error al cambiar el estado. Recarga la página y vuelve a intentarlo.');
                    // Revertimos visualmente el switch si hubo error
                    $('#switch-' + trimestreId).prop('checked', !estadoSwitch);
                }
            });
        });
    });
</script>
@stop