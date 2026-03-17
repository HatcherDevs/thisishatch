<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class PasswordPolicyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * 🔒 Security: تطبيق سياسة كلمات مرور قوية
     */
    public function boot(): void
    {
        // سياسة كلمات المرور الافتراضية
        Password::defaults(function () {
            $rule = Password::min(8); // الحد الأدنى 8 أحرف

            // في الإنتاج، تطبيق قواعد أقوى
            if ($this->app->environment('production')) {
                $rule->min(12) // 12 حرف في الإنتاج
                    ->mixedCase() // أحرف كبيرة وصغيرة
                    ->letters() // يجب وجود أحرف
                    ->numbers() // يجب وجود أرقام
                    ->symbols() // يجب وجود رموز (!@#$%^&*)
                    ->uncompromised(); // التحقق من قاعدة بيانات كلمات المرور المخترقة
            } else {
                // في التطوير، قواعد أخف
                $rule->letters()
                    ->numbers();
            }

            return $rule;
        });
    }
}
