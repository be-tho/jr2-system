<?php

namespace App\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    protected $message = 'Stock insuficiente para completar la operación';

    public function __construct($message = null, $code = 422, Exception $previous = null)
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
                'error_code' => 'INSUFFICIENT_STOCK',
                'code' => $this->getCode()
            ], $this->getCode());
        }

        return redirect()->back()
            ->withInput()
            ->with('error', $this->getMessage());
    }
}
