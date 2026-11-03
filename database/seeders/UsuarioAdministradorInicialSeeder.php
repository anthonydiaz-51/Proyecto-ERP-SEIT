<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class UsuarioAdministradorInicialSeeder extends Seeder
{
    public function run(): void
    {
        if (!filter_var(env('SEIT_CREATE_INITIAL_ADMIN', false), FILTER_VALIDATE_BOOLEAN)) {
            return;
        }

        $email = trim((string) env('SEIT_ADMIN_EMAIL', ''));
        $password = (string) env('SEIT_ADMIN_PASSWORD', '');
        $nombre = trim((string) env('SEIT_ADMIN_NAME', 'Administrador'));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 12) {
            throw new InvalidArgumentException(
                'Para crear al administrador inicial, define SEIT_ADMIN_EMAIL válido y SEIT_ADMIN_PASSWORD de al menos 12 caracteres.'
            );
        }

        Usuario::query()->firstOrCreate(
            ['email' => $email],
            [
                'nombre' => $nombre !== '' ? $nombre : 'Administrador',
                'apellido' => '',
                'password' => Hash::make($password),
                'rol_id' => 1,
                'activo' => true,
            ]
        );
    }
}
