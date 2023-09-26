<?php

if (!function_exists('toast')) { 
    function toast(string $text, string $type='DEFAULT'): void {
        session()->flash('toast', [
            'text' => $text,
            'type' => $type,
        ]);
    }
}
