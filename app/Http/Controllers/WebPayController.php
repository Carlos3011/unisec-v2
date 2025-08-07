<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebPayController extends Controller
{
    /**
     * Recibe la notificación POST desde WebPay Plus
     */
    public function notify(Request $request)
    {
        // 1. Recuperar parámetro cifrado
        $encryptedResponse = $request->input('strResponse');

        if (!$encryptedResponse) {
            Log::error("WebPay: strResponse no recibido.");
            return response('Faltan datos', 400);
        }

        // 2. Decodificar URL
        $decodedResponse = urldecode($encryptedResponse);

        // 3. Desencriptar usando AES-128
        $decryptedXml = $this->decryptWebPay($decodedResponse);

        if (!$decryptedXml) {
            Log::error("WebPay: Error al desencriptar respuesta.");
            return response('Error de descifrado', 500);
        }

        // 4. Procesar XML
        $xml = simplexml_load_string($decryptedXml);

        if (!$xml) {
            Log::error("WebPay: XML mal formado: " . $decryptedXml);
            return response('XML inválido', 422);
        }

        // 5. Guardar información importante (ajusta según tus necesidades)
        $reference     = (string) $xml->reference ?? null;
        $amount        = (string) $xml->amount ?? null;
        $authCode      = (string) $xml->auth ?? null;
        $folioPagos    = (string) $xml->foliocpagos ?? null;
        $maskedCard    = (string) $xml->cc_mask ?? null;
        $responseType  = (string) $xml->response ?? null;

        Log::info("WebPay: Transacción recibida", [
            'reference' => $reference,
            'amount' => $amount,
            'auth' => $authCode,
            'folio' => $folioPagos,
            'card' => $maskedCard,
            'response' => $responseType,
        ]);

        // Aquí puedes guardar los datos en tu base de datos si lo deseas.

        return response('OK', 200);
    }

    /**
     * Vista mostrada al usuario tras redirección (opcional)
     */
    public function result(Request $request)
    {
        return view('webpay.result'); // Crea esta vista en /resources/views/webpay/result.blade.php
    }

    /**
     * Función para desencriptar strResponse con AES-128-ECB
     */
    private function decryptWebPay($cipher)
    {
        try {
            $aesKey = config('webpay.aes_key'); // Llave AES en config/webpay.php
            $binaryKey = hex2bin($aesKey);

            $decrypted = openssl_decrypt(base64_decode($cipher), 'aes-128-ecb', $binaryKey, OPENSSL_RAW_DATA);
            return $decrypted;
        } catch (\Exception $e) {
            Log::error("WebPay: Error en desencriptado - " . $e->getMessage());
            return null;
        }
    }
}