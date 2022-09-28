<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Base64PDF implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(isset($value['base64'])) $value = $value['base64'];
        try {
            $start = strpos($value, ":") + 1;
            $finish = strpos($value, ";");
            $length = $finish - $start;
            $extension = substr($value, $start, $length);
            return $extension === "application/pdf";
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'É permitido apenas arquivos do tipo PDF.';
    }
}
