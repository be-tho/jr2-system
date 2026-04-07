<?php

namespace App\Exceptions;

use Exception;

class VentaException extends Exception
{
    protected $message = 'Error al procesar la venta';

    public function __construct($message = null, $code = 500, Exception $previous = null)
    {
        if ($message) {
            $this->message = $message;
        }
        
        parent::__construct($this->message, $code, $previous);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $this->getMessage(),
                'error_code' => 'VENTA_ERROR',
                'code' => $this->getCode()
            ], $this->getCode());
        }

        return redirect()->back()
            ->withInput()
            ->with('error', $this->getMessage());
    }
}
