<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $fillable = ['nombre', 'apellido', 'email', 'password', 'rol_id', 'activo'];
    protected $hidden = ['password'];

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new class($token) extends ResetPassword
        {
            protected function buildMailMessage($url): MailMessage
            {
                $minutos = (int) config('auth.passwords.users.expire', 60);

                return (new MailMessage)
                    ->subject('Restablecer contraseña - ERP SEIT')
                    ->greeting('Hola')
                    ->line('Recibimos una solicitud para cambiar la contraseña de tu cuenta de ERP SEIT.')
                    ->action('Crear nueva contraseña', $url)
                    ->line("El enlace vence en {$minutos} minutos y solo puede utilizarse una vez.")
                    ->line('Si no solicitaste este cambio, ignora este correo. Tu contraseña seguirá siendo la misma.')
                    ->salutation('SEIT GDL');
            }
        });
    }

    public function movimientosInventario()
    {
        return $this->hasMany(MovimientoInventario::class, 'usuario_id');
    }
}

