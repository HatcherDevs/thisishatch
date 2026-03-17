<?php

if (!function_exists('isRTL')) {
    function isRTL() {
        return app()->getLocale() === 'ar';
    }
}

if (!function_exists('isArabic')) {
    function isArabic() {
        return app()->getLocale() === 'ar';
    }
}
