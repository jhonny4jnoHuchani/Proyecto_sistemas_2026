@extends('adminlte::page')
@section('title','Añadir Curso')

@section('content_header')
    <h1>Registrar Nuevo Curso</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-6"> <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Datos del Curso</h3>
                </div>
                
                <form action="{{ route('cursos.store') }}" method="POST">
                    
                    {{-- ¡ATENCIÓN A ESTA LÍNEA! Es vital en Laravel --}}
                    @csrf 

                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="nombre">Nombre del Curso</label>
                            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Ej: Primero de Secundaria" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="paralelo">Paralelo</label>
                            <input type="text" name="paralelo" class="form-control" id="paralelo" placeholder="Ej: A, B, C" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="turno">Turno</label>
                            <select name="turno" class="form-control" id="turno" required>
                                <option value="">Seleccione un turno...</option>
                                <option value="Mañana">Mañana</option>
                                <option value="Tarde">Tarde</option>
                                <option value="Noche">Noche</option>
                            </select>
                        </div>

                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar Curso</button>
                        <a href="{{ route('cursos.index') }}" class="btn btn-default float-right">Cancelar</a>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
@stop

