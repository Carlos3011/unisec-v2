<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnifiedPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertar tipos de productos
        $tiposProductos = [
            [
                'nombre' => 'concurso_preregistro',
                'descripcion' => 'Pre-registro para concursos',
                'precio_base' => 0.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'concurso_inscripcion',
                'descripcion' => 'Inscripción completa para concursos',
                'precio_base' => 50000.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'congreso_inscripcion',
                'descripcion' => 'Inscripción para congresos',
                'precio_base' => 75000.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'curso_inscripcion',
                'descripcion' => 'Inscripción para cursos',
                'precio_base' => 30000.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'taller_inscripcion',
                'descripcion' => 'Inscripción para talleres',
                'precio_base' => 25000.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'ponencia_inscripcion',
                'descripcion' => 'Inscripción para ponencias',
                'precio_base' => 15000.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('tipos_productos')->insert($tiposProductos);

        // Insertar métodos de pago
        $metodosPago = [
            [
                'nombre' => 'paypal',
                'descripcion' => 'Pago a través de PayPal',
                'activo' => true,
                'configuracion' => json_encode([
                    'client_id' => env('PAYPAL_CLIENT_ID'),
                    'client_secret' => env('PAYPAL_CLIENT_SECRET'),
                    'mode' => env('PAYPAL_MODE', 'sandbox'),
                    'currency' => 'USD'
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'transferencia',
                'descripcion' => 'Transferencia bancaria',
                'activo' => true,
                'configuracion' => json_encode([
                    'banco' => 'Banco Estado',
                    'tipo_cuenta' => 'Cuenta Corriente',
                    'numero_cuenta' => '12345678-9',
                    'rut_titular' => '12.345.678-9',
                    'nombre_titular' => 'UNISEC',
                    'email_notificacion' => 'pagos@unisec.cl'
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'webpay',
                'descripcion' => 'Pago con tarjetas a través de WebPay Plus',
                'activo' => true,
                'configuracion' => json_encode([
                    'commerce_code' => env('WEBPAY_COMMERCE_CODE'),
                    'api_key' => env('WEBPAY_API_KEY'),
                    'environment' => env('WEBPAY_ENVIRONMENT', 'integration'),
                    'return_url' => env('APP_URL') . '/pagos/webpay/return',
                    'final_url' => env('APP_URL') . '/pagos/webpay/final'
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('metodos_pago')->insert($metodosPago);
    }
}