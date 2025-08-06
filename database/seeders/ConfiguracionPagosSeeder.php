<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConfiguracionPago;

class ConfiguracionPagosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Configuración para PayPal
        ConfiguracionPago::updateOrCreate(
            ['metodo_pago' => ConfiguracionPago::METODO_PAYPAL],
            [
                'activo' => true,
                'configuracion' => [
                    'client_id' => env('PAYPAL_CLIENT_ID', ''),
                    'client_secret' => env('PAYPAL_CLIENT_SECRET', ''),
                    'sandbox' => env('PAYPAL_SANDBOX', true),
                    'moneda_default' => 'USD',
                    'webhook_url' => env('APP_URL') . '/webhooks/paypal',
                ],
                'comision_porcentaje' => 3.49, // Comisión típica de PayPal
                'comision_fija' => 0.30,
                'orden_visualizacion' => 1,
                'descripcion' => 'Paga de forma segura con tu cuenta PayPal o tarjeta de crédito/débito.',
                'icono' => 'images/payment-icons/paypal.svg',
            ]
        );

        // Configuración para Transferencia Bancaria
        ConfiguracionPago::updateOrCreate(
            ['metodo_pago' => ConfiguracionPago::METODO_TRANSFERENCIA],
            [
                'activo' => true,
                'configuracion' => [
                    'banco_destino' => 'bbva_bancomer',
                    'numero_cuenta' => env('BANCO_NUMERO_CUENTA', ''),
                    'tipo_cuenta' => 'corriente',
                    'rfc_titular' => env('BANCO_RFC_TITULAR', ''),
                    'nombre_titular' => env('BANCO_NOMBRE_TITULAR', ''),
                    'email_notificacion' => env('BANCO_EMAIL_NOTIFICACION', 'pagos@unisec.mx'),
                    'verificacion_automatica' => false,
                    'tiempo_expiracion_horas' => 72,
                ],
                'comision_porcentaje' => 0.00, // Sin comisión para transferencias
                'comision_fija' => 0.00,
                'orden_visualizacion' => 2,
                'descripcion' => 'Realiza una transferencia bancaria a nuestra cuenta. Debes subir el comprobante para verificación.',
                'icono' => 'images/payment-icons/transferencia.svg',
            ]
        );

        // Configuración para WebPay Plus
        ConfiguracionPago::updateOrCreate(
            ['metodo_pago' => ConfiguracionPago::METODO_WEBPAY],
            [
                'activo' => true,
                'configuracion' => [
                    'commerce_code' => env('WEBPAY_COMMERCE_CODE', '597055555532'),
                    'api_key' => env('WEBPAY_API_KEY', '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C'),
                    'environment' => env('WEBPAY_ENVIRONMENT', 'integration'),
                    'return_url' => env('APP_URL') . '/pagos/webpay/return',
                    'final_url' => env('APP_URL') . '/pagos/webpay/final',
                    'timeout_minutes' => 10,
                ],
                'comision_porcentaje' => 2.95, // Comisión típica de WebPay
                'comision_fija' => 0.00,
                'orden_visualizacion' => 3,
                'descripcion' => 'Paga con tarjeta de crédito o débito a través de WebPay Plus de Transbank.',
                'icono' => 'images/payment-icons/webpay.svg',
            ]
        );

        $this->command->info('Configuraciones de métodos de pago creadas exitosamente.');
    }
}