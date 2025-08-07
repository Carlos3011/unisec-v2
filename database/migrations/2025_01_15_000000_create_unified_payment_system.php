<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Crear tabla de tipos de productos
        Schema::create('tipos_productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // 'concurso_preregistro', 'concurso_inscripcion', 'congreso_inscripcion', 'curso_inscripcion', etc.
            $table->string('descripcion');
            $table->decimal('precio_base', 10, 2)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Crear tabla de métodos de pago
        Schema::create('metodos_pago', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // 'paypal', 'transferencia', 'webpay'
            $table->string('descripcion');
            $table->boolean('activo')->default(true);
            $table->json('configuracion')->nullable(); // Para guardar configuraciones específicas del método
            $table->timestamps();
            $table->softDeletes();
        });

        // Crear tabla unificada de pagos
        Schema::create('pagos_unificados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tipo_producto_id')->constrained('tipos_productos')->onDelete('cascade');
            $table->foreignId('metodo_pago_id')->constrained('metodos_pago')->onDelete('cascade');
            
            // Referencias polimórficas para diferentes tipos de inscripciones
            $table->morphs('inscripcion'); // inscripcion_type, inscripcion_id
            
            $table->decimal('monto', 10, 2);
            $table->string('moneda', 3)->default('CLP');
            $table->string('referencia_externa')->nullable(); // ID de transacción del proveedor
            $table->string('referencia_interna')->unique(); // Referencia interna única
            $table->enum('estado', ['pendiente', 'procesando', 'completado', 'fallido', 'cancelado', 'reembolsado'])->default('pendiente');
            
            // Datos específicos del método de pago
            $table->json('datos_pago')->nullable(); // Para guardar datos específicos según el método
            
            // Fechas importantes
            $table->timestamp('fecha_pago')->nullable();
            $table->timestamp('fecha_vencimiento')->nullable();
            $table->timestamp('fecha_confirmacion')->nullable();
            
            // Información adicional
            $table->text('notas')->nullable();
            $table->string('ip_origen')->nullable();
            $table->string('user_agent')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para optimizar consultas
            $table->index(['usuario_id', 'estado']);
            $table->index(['tipo_producto_id', 'estado']);
            $table->index(['metodo_pago_id', 'estado']);
            $table->index(['inscripcion_type', 'inscripcion_id']);
        });

        // Crear tabla para detalles de PayPal
        Schema::create('pagos_paypal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_unificado_id')->constrained('pagos_unificados')->onDelete('cascade');
            $table->string('paypal_order_id')->nullable();
            $table->string('paypal_payment_id')->nullable();
            $table->string('paypal_payer_id')->nullable();
            $table->string('paypal_status')->nullable();
            $table->json('paypal_response')->nullable(); // Respuesta completa de PayPal
            $table->timestamps();
        });

        // Crear tabla para detalles de transferencias
        Schema::create('pagos_transferencia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_unificado_id')->constrained('pagos_unificados')->onDelete('cascade');
            $table->string('numero_transferencia')->nullable();
            $table->string('banco_origen')->nullable();
            $table->string('banco_destino')->nullable();
            $table->string('cuenta_origen')->nullable();
            $table->string('cuenta_destino')->nullable();
            $table->string('rut_transferente')->nullable();
            $table->string('nombre_transferente')->nullable();
            $table->string('comprobante_archivo')->nullable(); // Ruta del archivo de comprobante
            $table->enum('estado_verificacion', ['pendiente', 'verificado', 'rechazado'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->timestamp('fecha_transferencia')->nullable();
            $table->timestamps();
        });

        // Crear tabla para detalles de WebPay
        Schema::create('pagos_webpay', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_unificado_id')->constrained('pagos_unificados')->onDelete('cascade');
            $table->string('webpay_token')->nullable();
            $table->string('webpay_order_id')->nullable();
            $table->string('webpay_session_id')->nullable();
            $table->string('webpay_transaction_id')->nullable();
            $table->string('webpay_authorization_code')->nullable();
            $table->string('webpay_card_type')->nullable();
            $table->string('webpay_card_last_digits', 4)->nullable();
            $table->enum('webpay_status', ['INITIALIZED', 'AUTHORIZED', 'REVERSED', 'FAILED', 'NULLIFIED'])->nullable();
            $table->json('webpay_response')->nullable(); // Respuesta completa de WebPay
            $table->timestamps();
        });

        // Crear tabla de historial de estados de pago
        Schema::create('historial_estados_pago', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_unificado_id')->constrained('pagos_unificados')->onDelete('cascade');
            $table->string('estado_anterior')->nullable();
            $table->string('estado_nuevo');
            $table->text('motivo')->nullable();
            $table->foreignId('usuario_cambio_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_estados_pago');
        Schema::dropIfExists('pagos_webpay');
        Schema::dropIfExists('pagos_transferencia');
        Schema::dropIfExists('pagos_paypal');
        Schema::dropIfExists('pagos_unificados');
        Schema::dropIfExists('metodos_pago');
        Schema::dropIfExists('tipos_productos');
    }
};