<?php

if (!function_exists('theme')) {
    function theme() {
        // Return an instance of the theme manager or whatever the intended functionality is
        return app()->make(\App\Services\ThemeManager::class);
    }
}


?>