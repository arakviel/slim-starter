<?php

namespace Insid\Blogonslim\Persistence\Util;

class StringUtil
{
    /**
     * From snake_case to camelCase converter
     *
     * @param string $source snake_case text
     * @return string camelCase result
     */
    public static function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace("_", "", ucwords($source, "_")));
    }

    /**
     * camelCase to snake_case converter
     *
     * @param string $source camelCase text
     * @return string snake_case result
     */
    public static function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace("/(?<!^)[A-Z]/", "_$0", $source));
    }

}
