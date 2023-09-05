<?php

if (!function_exists('toast')) { 
    function toast(string $text, string $type='default'): void {
        session()->flash('toast', [
            'text' => $text,
            'type' => $type,
        ]);
    }
}
