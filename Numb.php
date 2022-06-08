<?php

/*
* @name        JMY CORE
* @link        https://jmy.su/
* @copyright   Copyright (C) 2012-2021 JMY LTD
* @license     LICENSE.txt (see attached file)
* @version     VERSION.txt (see attached file)
* @author      Komarov Ivan & Volkov Aleksander
* @description Str Helper class
*/

namespace Darkeum\Support;


class Numb
{
    /**
     * Функция заменяет запятые на точки.
     */
    public static function commasReplace($value)
    {
        return str_replace(',', '.', $value);
    }

    /**
     * Функция заменяет точки на запятые.
     */
    public static function dotsReplace($value)
    {
        return str_replace('.', ',', $value);
    }


    /**
     * Подготовка числа.
     * Функция сначала меняет запятые на точки потом приводит к числу и если $dotsReplace = true то меняет обратно точки на запятые.
     */
    public static function prepareNumeric($value, $dotsReplace = false)
    {
        $value = static::commasReplace($value);
        $value =  floatval($value);
        if ($dotsReplace === true) {
            $value = static::dotsReplace($value);
        }
        return $value;
    }
}
