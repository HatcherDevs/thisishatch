<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminIpWhitelist
{
    /**
     * 🔒 Security: قائمة IPs المسموح لها بالوصول للوحة التحكم
     *
     * يمكن تعيين القائمة في .env:
     * ADMIN_WHITELIST_IPS=127.0.0.1,::1,192.168.1.100
     */
    public function handle(Request $request, Closure $next): Response
    {
        // تعطيل IP Whitelist في بيئة التطوير local
        if (app()->environment('local')) {
            return $next($request);
        }

        $whitelist = $this->getWhitelist();

        // إذا لم يتم تعيين قائمة IPs، السماح للجميع (لتجنب قفل النظام)
        if (empty($whitelist)) {
            return $next($request);
        }

        $clientIp = $request->ip();

        // التحقق من IP العميل
        if (! in_array($clientIp, $whitelist)) {
            abort(403, 'Access denied. Your IP address is not whitelisted.');
        }

        return $next($request);
    }

    /**
     * الحصول على قائمة IPs من .env
     */
    protected function getWhitelist(): array
    {
        $ips = env('ADMIN_WHITELIST_IPS', '');

        if (empty($ips)) {
            return [];
        }

        return array_map('trim', explode(',', $ips));
    }
}
