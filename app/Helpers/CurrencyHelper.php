<?php

if (!function_exists('currencySymbol')) {
    function currencySymbol(string $currency): string
    {
        return match($currency) {
            'USD' => '$',
            'MYR' => 'RM',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'CNY' => '¥',
            default => '$',
        };
    }
}
