<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureFileUpload
{
    /**
     * 🔒 Security: فحص الملفات المرفوعة لمنع رفع ملفات خطيرة
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasFile('file') || $request->hasFile('files')) {
            $files = $request->hasFile('file')
                ? [$request->file('file')]
                : $request->file('files');

            foreach ((array) $files as $file) {
                if (! $file) {
                    continue;
                }

                // فحص الامتداد
                $extension = strtolower($file->getClientOriginalExtension());
                $dangerousExtensions = [
                    'php', 'phtml', 'php3', 'php4', 'php5', 'phps', 'pht', 'phar',
                    'exe', 'bat', 'cmd', 'com', 'msi',
                    'sh', 'bash', 'zsh',
                    'jar', 'war',
                    'js', 'vbs', 'wsf',
                    'asp', 'aspx', 'jsp',
                    'cgi', 'pl',
                    'dll', 'so',
                    'htaccess', 'htpasswd',
                ];

                if (in_array($extension, $dangerousExtensions)) {
                    return response()->json([
                        'error' => true,
                        'message' => "File type '{$extension}' is not allowed for security reasons.",
                    ], 403);
                }

                // فحص MIME type الحقيقي
                $mimeType = $file->getMimeType();
                $dangerousMimes = [
                    'application/x-httpd-php',
                    'application/x-php',
                    'application/php',
                    'text/x-php',
                    'text/php',
                    'application/x-executable',
                    'application/x-msdownload',
                    'application/x-sh',
                    'text/x-shellscript',
                ];

                if (in_array($mimeType, $dangerousMimes)) {
                    return response()->json([
                        'error' => true,
                        'message' => 'This file type is not allowed for security reasons.',
                    ], 403);
                }

                // فحص محتوى الملف (البحث عن PHP tags)
                $fileContent = file_get_contents($file->getRealPath());
                if (preg_match('/<\?php|<\?=|<script/i', $fileContent)) {
                    return response()->json([
                        'error' => true,
                        'message' => 'File contains potentially dangerous content.',
                    ], 403);
                }

                // فحص حجم الملف (أقصى 50MB)
                $maxSize = 50 * 1024 * 1024; // 50MB
                if ($file->getSize() > $maxSize) {
                    return response()->json([
                        'error' => true,
                        'message' => 'File size exceeds maximum limit of 50MB.',
                    ], 413);
                }
            }
        }

        return $next($request);
    }
}
