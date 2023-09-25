<?php

if (!function_exists('toast')) { 
    function toast(string $text, string $type='DEFAULT'): void {
        session()->flash('toast', [
            'text' => $text,
            'type' => $type,
        ]);
    }
}

if (!function_exists('badge')) {
    function badge(string $elem, int $value=1) {
        
    }
} 
