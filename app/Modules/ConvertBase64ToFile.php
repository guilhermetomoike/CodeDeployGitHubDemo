<?php

namespace App\Modules;

class ConvertBase64ToFile
{
    public static function run(string $base64): string
    {
        $start = strpos($base64, ',') + 1;
        $data = substr($base64, $start);

        return base64_decode($data);
    }

    public static function validate(string $extension, string $base64): bool
    {
        $fullExtension = self::getFullExtension($base64);

        return $fullExtension === $extension;
    }

    public static function getExtension(string $base64): string
    {
        $extension = self::getFullExtension($base64);

        if (!$extension) {
            return '';
        }

        return '.' . substr($extension, strpos($extension,'/') + 1);
    }

    private static function getFullExtension(string $base64): ?string
    {
        try {
            $start = strpos($base64, ':') + 1;
            $finish = strpos($base64, ';');
            $length = $finish - $start;

            return substr($base64, $start, $length);
        } catch (\Exception $exception) {
            return null;
        }
    }
}
