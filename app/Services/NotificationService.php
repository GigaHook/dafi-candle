<?php

namespace App\Services;

class NotificationService {

    public function snackbar(
        string $text, 
        string $icon='mdi-information-variant', 
        string $color='primary'
    ): void {
        session()->flash('snackbar', [
            'text' => $text,
            'icon' => $icon,
            'color' => $color,
            'isShown' => true,
        ]);
    }

    public function alert() {
        //должно добавляет красный кружочек к чему небудь
    }
}