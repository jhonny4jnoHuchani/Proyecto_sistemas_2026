<?php

namespace Database\Seeders;

use App\Models\Docente;
use Illuminate\Database\Seeder;

class DocenteSeeder extends Seeder
{
    public function run(): void
    {
        $docentes = [
            ['user_id' => 1,  'nombre' => 'Juan',     'apellido' => 'Pérez',      'ci' => '12345678', 'especialidad' => 'Matemáticas',       'estado' => true],
            ['user_id' => 2,  'nombre' => 'María',    'apellido' => 'González',   'ci' => '87654321', 'especialidad' => 'Física',             'estado' => true],
            ['user_id' => 3,  'nombre' => 'Carlos',   'apellido' => 'Rodríguez',   'ci' => '45678912', 'especialidad' => 'Química',            'estado' => true],
            ['user_id' => 4,  'nombre' => 'Ana',      'apellido' => 'Flores',      'ci' => '11223344', 'especialidad' => 'Lenguaje',           'estado' => true],
            ['user_id' => 5,  'nombre' => 'Luis',     'apellido' => 'Mamani',      'ci' => '22334455', 'especialidad' => 'Lenguaje',           'estado' => true],
            ['user_id' => 6,  'nombre' => 'Patricia', 'apellido' => 'Choque',      'ci' => '33445566', 'especialidad' => 'Ciencias Naturales', 'estado' => true],
            ['user_id' => 7,  'nombre' => 'Roberto',  'apellido' => 'Quispe',      'ci' => '44556677', 'especialidad' => 'Ciencias Sociales',  'estado' => true],
            ['user_id' => 8,  'nombre' => 'Daniela',  'apellido' => 'Vargas',      'ci' => '55667788', 'especialidad' => 'Inglés',             'estado' => true],
            ['user_id' => 9,  'nombre' => 'Jorge',    'apellido' => 'Mendoza',     'ci' => '66778899', 'especialidad' => 'Educación Física',   'estado' => true],
            ['user_id' => 10, 'nombre' => 'Carla',    'apellido' => 'Soto',        'ci' => '77889900', 'especialidad' => 'Artes Plásticas',    'estado' => true],
            ['user_id' => 11, 'nombre' => 'Fernando', 'apellido' => 'Aramayo',     'ci' => '88990011', 'especialidad' => 'Música',             'estado' => true],
            ['user_id' => 12, 'nombre' => 'Gabriela', 'apellido' => 'Cruz',        'ci' => '99001122', 'especialidad' => 'Religión',           'estado' => true],
            ['user_id' => 13, 'nombre' => 'Ricardo',  'apellido' => 'Fernández',   'ci' => '10293847', 'especialidad' => 'Computación',        'estado' => true],
            ['user_id' => 14, 'nombre' => 'Sandra',   'apellido' => 'Ortiz',       'ci' => '20384756', 'especialidad' => 'Biología',           'estado' => true],
            ['user_id' => 15, 'nombre' => 'Mauricio', 'apellido' => 'Apaza',       'ci' => '30475869', 'especialidad' => 'Filosofía',          'estado' => true],
            ['user_id' => 16, 'nombre' => 'Pedro',    'apellido' => 'Limachi',     'ci' => '40586970', 'especialidad' => 'Matemáticas',        'estado' => true],
            ['user_id' => 17, 'nombre' => 'Lucía',    'apellido' => 'Tórrez',      'ci' => '50697081', 'especialidad' => 'Física',             'estado' => false],
        ];

        foreach ($docentes as $docente) {
            Docente::create($docente);
        }
    }
}