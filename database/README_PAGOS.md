# Modelo de Base de Datos para Métodos de Pago

Este documento describe el modelo de base de datos implementado para manejar múltiples métodos de pago en el sistema UNISEC v2.

## Tablas Implementadas

### 1. `pagos_paypal`
Tabla para gestionar pagos realizados a través de PayPal.

**Campos principales:**
- `id`: Identificador único
- `usuario_id`: Relación con el usuario que realiza el pago
- `pagable_type` y `pagable_id`: Relación polimórfica con el elemento pagable (curso, taller, concurso, etc.)
- `monto`: Monto del pago
- `moneda`: Código de moneda ISO (USD, MXN, etc.)
- `paypal_payment_id`: ID único de la transacción en PayPal
- `paypal_payer_id`: ID del pagador en PayPal
- `paypal_payment_token`: Token de pago de PayPal
- `paypal_order_id`: ID de orden de PayPal
- `estado`: Estado del pago (pendiente, completado, cancelado, fallido, reembolsado)
- `paypal_response`: Respuesta completa de PayPal en formato JSON
- `email_pagador`: Email del pagador
- `nombre_pagador`: Nombre del pagador
- `fecha_pago`: Fecha cuando se completó el pago
- `fecha_vencimiento`: Fecha de vencimiento del pago
- `descripcion`: Descripción del pago
- `numero_factura`: Número de factura asociado

**Índices:**
- `estado` + `fecha_pago`
- `usuario_id` + `estado`

### 2. `pagos_transferencia`
Tabla para gestionar pagos realizados por transferencia bancaria.

**Campos principales:**
- `id`: Identificador único
- `usuario_id`: Relación con el usuario que realiza el pago
- `pagable_type` y `pagable_id`: Relación polimórfica
- `monto`: Monto del pago
- `moneda`: Código de moneda ISO (principalmente MXN)
- `numero_transferencia`: Número único de la transferencia
- `banco_origen`: Banco desde donde se realizó la transferencia
- `banco_destino`: Banco de destino
- `cuenta_origen`: Número de cuenta origen (últimos 4 dígitos por seguridad)
- `cuenta_destino`: Número de cuenta destino
- `rut_titular_origen`: RFC del titular de la cuenta origen
- `nombre_titular_origen`: Nombre del titular de la cuenta origen
- `rut_titular_destino`: RFC del titular de la cuenta destino
- `nombre_titular_destino`: Nombre del titular de la cuenta destino
- `estado`: Estado del pago (pendiente, verificando, completado, rechazado, reembolsado)
- `fecha_transferencia`: Fecha de la transferencia
- `fecha_verificacion`: Fecha cuando se verificó la transferencia
- `comprobante_archivo`: Ruta del archivo del comprobante
- `observaciones`: Observaciones adicionales
- `motivo_rechazo`: Motivo de rechazo si aplica
- `verificado_por`: Usuario que verificó la transferencia
- `numero_factura`: Número de factura asociado

**Índices:**
- `estado` + `fecha_transferencia`
- `usuario_id` + `estado`
- `numero_transferencia`

### 3. `pagos_webpay`
Tabla para gestionar pagos realizados a través de WebPay Plus (Transbank).

**Campos principales:**
- `id`: Identificador único
- `usuario_id`: Relación con el usuario que realiza el pago
- `pagable_type` y `pagable_id`: Relación polimórfica
- `monto`: Monto del pago
- `moneda`: Código de moneda ISO (principalmente CLP)
- `webpay_token`: Token único de transacción de WebPay
- `webpay_buy_order`: Orden de compra de WebPay
- `webpay_session_id`: ID de sesión de WebPay
- `webpay_authorization_code`: Código de autorización
- `webpay_transaction_date`: Fecha de transacción de WebPay
- `webpay_card_type`: Tipo de tarjeta (Visa, Mastercard, etc.)
- `webpay_card_number`: Últimos 4 dígitos de la tarjeta
- `webpay_installments_number`: Número de cuotas
- `webpay_installments_amount`: Monto de cada cuota
- `estado`: Estado del pago (pendiente, autorizado, completado, anulado, rechazado, reembolsado)
- `webpay_response`: Respuesta completa de WebPay en formato JSON
- `fecha_pago`: Fecha cuando se completó el pago
- `fecha_vencimiento`: Fecha de vencimiento del pago
- `descripcion`: Descripción del pago
- `numero_factura`: Número de factura asociado
- `ip_cliente`: IP del cliente que realizó el pago
- `observaciones`: Observaciones adicionales

**Índices:**
- `estado` + `fecha_pago`
- `usuario_id` + `estado`
- `webpay_token`
- `webpay_buy_order`

### 4. `historial_estados_pagos`
Tabla para auditoría de cambios de estado en los pagos.

**Campos principales:**
- `id`: Identificador único
- `pago_type` y `pago_id`: Relación polimórfica con cualquier tipo de pago
- `estado_anterior`: Estado anterior del pago
- `estado_nuevo`: Nuevo estado del pago
- `motivo`: Motivo del cambio de estado
- `usuario_cambio`: Usuario que realizó el cambio
- `datos_adicionales`: Datos adicionales del cambio en formato JSON
- `created_at`: Fecha del cambio

**Índices:**
- `pago_type` + `pago_id`
- `created_at`

### 5. `configuracion_pagos`
Tabla para configurar los métodos de pago disponibles.

**Campos principales:**
- `id`: Identificador único
- `metodo_pago`: Tipo de método (paypal, transferencia, webpay)
- `activo`: Si el método está activo
- `configuracion`: Configuración específica en formato JSON
- `comision_porcentaje`: Comisión en porcentaje
- `comision_fija`: Comisión fija
- `orden_visualizacion`: Orden de visualización en el frontend
- `descripcion`: Descripción del método de pago
- `icono`: Ruta del icono del método de pago

## Modelos Eloquent

### PagoPaypal
- **Archivo**: `app/Models/PagoPaypal.php`
- **Relaciones**: Usuario, elemento pagable (polimórfica), historial de estados
- **Métodos principales**: `estaCompletado()`, `cambiarEstado()`, `getMontoFormateadoAttribute()`

### PagoTransferencia
- **Archivo**: `app/Models/PagoTransferencia.php`
- **Relaciones**: Usuario, verificador, elemento pagable (polimórfica), historial de estados
- **Métodos principales**: `aprobar()`, `rechazar()`, `tieneComprobante()`, `validarRFC()`, `validarCURP()`

### PagoWebpay
- **Archivo**: `app/Models/PagoWebpay.php`
- **Relaciones**: Usuario, elemento pagable (polimórfica), historial de estados
- **Métodos principales**: `procesarRespuestaWebpay()`, `esEnCuotas()`, `generarBuyOrder()`

### HistorialEstadoPago
- **Archivo**: `app/Models/HistorialEstadoPago.php`
- **Relaciones**: Pago (polimórfica), usuario que realizó el cambio
- **Métodos principales**: `getEstadisticasCambios()`

### ConfiguracionPago
- **Archivo**: `app/Models/ConfiguracionPago.php`
- **Métodos principales**: `calcularComision()`, `validarConfiguracion()`, `obtenerMetodosActivos()`

## Características del Diseño

### 1. Relaciones Polimórficas
Todas las tablas de pagos utilizan relaciones polimórficas (`pagable_type` y `pagable_id`) para poder asociarse con diferentes tipos de elementos:
- Cursos (`InscripcionCurso`)
- Talleres (`InscripcionTaller`)
- Concursos (`InscripcionConcurso`)
- Congresos (`InscripcionCongreso`)
- Ponencias (`InscripcionPonencia`)

### 2. Auditoría Completa
- Historial de cambios de estado
- Registro de usuario que realizó cambios
- Timestamps automáticos
- Soft deletes para mantener integridad histórica

### 3. Seguridad
- Enmascaramiento de datos sensibles (números de tarjeta, cuentas)
- Validación de RFC y CURP mexicanos
- Almacenamiento seguro de tokens y claves

### 4. Flexibilidad
- Configuración dinámica de métodos de pago
- Soporte para múltiples monedas
- Comisiones configurables por método

### 5. Optimización
- Índices estratégicos para consultas frecuentes
- Campos JSON para datos variables
- Scopes para consultas comunes

## Estados de Pagos

### PayPal
- `pendiente`: Pago iniciado pero no completado
- `completado`: Pago exitoso
- `cancelado`: Pago cancelado por el usuario
- `fallido`: Pago falló por error técnico
- `reembolsado`: Pago reembolsado

### Transferencia Bancaria
- `pendiente`: Transferencia reportada, esperando verificación
- `verificando`: En proceso de verificación manual
- `completado`: Transferencia verificada y aprobada
- `rechazado`: Transferencia rechazada
- `reembolsado`: Monto reembolsado

### WebPay Plus
- `pendiente`: Transacción iniciada
- `autorizado`: Transacción autorizada por el banco
- `completado`: Transacción completada exitosamente
- `anulado`: Transacción anulada
- `rechazado`: Transacción rechazada por el banco
- `reembolsado`: Transacción reembolsada

## Instalación y Configuración

### 1. Ejecutar Migraciones
```bash
php artisan migrate
```

### 2. Ejecutar Seeders
```bash
php artisan db:seed --class=ConfiguracionPagosSeeder
```

### 3. Configurar Variables de Entorno
Agregar al archivo `.env`:

```env
# PayPal
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_CLIENT_SECRET=your_paypal_client_secret
PAYPAL_SANDBOX=true

# Transferencia Bancaria
BANCO_NUMERO_CUENTA=your_account_number
BANCO_RFC_TITULAR=your_rfc
BANCO_NOMBRE_TITULAR="Your Name"
BANCO_EMAIL_NOTIFICACION=payments@yoursite.mx

# WebPay Plus
WEBPAY_COMMERCE_CODE=your_commerce_code
WEBPAY_API_KEY=your_api_key
WEBPAY_ENVIRONMENT=integration
```

## Uso Básico

### Crear un Pago PayPal
```php
$pagoPaypal = PagoPaypal::create([
    'usuario_id' => $usuario->id,
    'pagable_type' => InscripcionCurso::class,
    'pagable_id' => $inscripcion->id,
    'monto' => 100.00,
    'moneda' => 'USD',
    'paypal_payment_id' => $paymentId,
    'descripcion' => 'Pago por curso de programación',
]);
```

### Verificar una Transferencia
```php
$transferencia = PagoTransferencia::find($id);
$transferencia->aprobar(
    $usuarioVerificador->id,
    'Comprobante verificado correctamente'
);
```

### Procesar Respuesta de WebPay
```php
$pagoWebpay = PagoWebpay::find($id);
$pagoWebpay->procesarRespuestaWebpay($respuestaTransbank);
```

## Consideraciones de Seguridad

1. **Nunca almacenar**: Números completos de tarjeta, CVV, PINs
2. **Siempre validar**: Montos, estados, permisos de usuario
3. **Encriptar**: Datos sensibles en la base de datos
4. **Auditar**: Todos los cambios de estado y accesos
5. **Verificar**: Firmas y tokens de servicios externos

## Mantenimiento

### Limpieza de Datos
- Eliminar tokens expirados periódicamente
- Archivar pagos antiguos
- Limpiar archivos de comprobantes huérfanos

### Monitoreo
- Alertas por pagos fallidos
- Reportes de comisiones
- Estadísticas de uso por método

### Respaldos
- Respaldo diario de tablas de pagos
- Respaldo de archivos de comprobantes
- Pruebas de restauración regulares