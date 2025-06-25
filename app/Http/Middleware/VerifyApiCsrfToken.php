<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyApiCsrfToken extends BaseVerifier
{
    protected $except = [
        'api/analyze-invoice',
        'api/invoices',
        'api/*',
    ];

    public function handle($request, Closure $next)
    {
        return parent::handle($request, $next);
    }
}