<?php

namespace App\Helpers;

class Helper
{
    public static function camelCaseToUnderscore($input): string
    {
        $pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
        preg_match_all($pattern, $input, $matches);

        $ret = $matches[0];
        foreach ($ret as $match) {
            $result[] = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $result);
    }

    public static function underscoreToCamelCase($input, bool $capitalizeFirstCharacter = false)
    {
        $str = str_replace('_', '', ucwords($input, '_'));

        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }

        return $str;
    }
}
