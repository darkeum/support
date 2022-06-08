<?php

/*
* @name        JMY CORE
* @link        https://jmy.su/
* @copyright   Copyright (C) 2012-2021 JMY LTD
* @license     LICENSE.txt (see attached file)
* @version     VERSION.txt (see attached file)
* @author      Komarov Ivan & Volkov Aleksandr
* @description Str Helper class
*/

namespace Darkeum\Support;

use Ramsey\Uuid\Uuid;
use voku\helper\ASCII;

class Str
{
    //кэш строк для паттерна "верблюд"
    protected static $camelCache = [];

    //кэш строк верблюдов
    protected static $studlyCache = [];

    //кэш строк для паттерна "змейка"
    protected static $snakeCache = [];

    /**
     * The callback that should be used to generate UUIDs.
     *
     * @var callable
     */
    protected static $uuidFactory;

    /**
     * Проверка строки на JSON
     *
     * @param  string   $value Исходная строка
     * @return bool     Возвращает true если $value содержит JSON, иначе false.
     */
    public static function isJson($value)
    {
        if (!static::length($value)) {
            return false;
        }
        json_decode($value);
        return (json_last_error() === JSON_ERROR_NONE);
    }

    /**
     * Проверка строки на нижний регистр
     *
     * @param  string    $value Исходная строка
     * @return bool      true если $value содержит только символы нижнего регистра, иначе false.
     */
    public static function isLowerCase($value)
    {
        return static::matchesPattern('^[[:lower:]]*$', $value);
    }

    /**
     * Проверка строки на верхний регистр
     *
     * @param  string    $value Исходная строка
     * @return bool      true если $value содержит только символы верхнего регистра, иначе false.
     */
    public static function isUpperCase($value)
    {
        return static::matchesPattern('^[[:upper:]]*$', $value);
    }

    /**
     * Проверка строки на присутствие только буквенных символов
     *
     * @param  string    $value Исходная строка
     * @return bool      true если $value содержит только буквенные символы, иначе false.
     */
    public static function isAlpha($value)
    {
        return static::matchesPattern('^[[:alpha:]]*$', $value);
    }

    /**
     * Проверка строки на присутствие только буквенно-цифровые символы
     *
     * @param  string    $value Исходная строка
     * @return bool      true если $value содержит только буквенно-цифровые символы, иначе false.
     */
    public static function isAlphanumeric($value)
    {
        return static::matchesPattern('^[[:alnum:]]*$', $value);
    }

    /**
     * Проверка строки на base64
     *
     * @param  string    $value Исходная строка
     * @return bool      Возвращает true, если $value закодирована в base64, иначе false.
     */
    public static function isBase64($value)
    {
        return (base64_encode(base64_decode($value, true)) === $value);
    }

    /**
     * Проверка строки на сериализацию
     *
     * @param  string    $value Исходная строка
     * @return bool      Возвращает true, если $value сериализована, иначе false.
     */
    public static function isSerialized($value)
    {
        return $value === 'b:0;' || @unserialize($value) !== false;
    }

    /**
     * Проверка строки на шестнадцатеричные символы
     *
     * @param  string    $value Исходная строка
     * @return bool      Возвращает true, если $value содержит только шестнадцатеричные символы, иначе false.
     */
    public static function isHexadecimal($value)
    {
        return static::matchesPattern('^[[:xdigit:]]*$', $value);
    }

    /**
     * Проверка строки на символы пробела
     *
     * @param  string    $value Исходная строка
     * @return bool      Возвращает true, если $value содержит только символы пробела, иначе false.
     */
    public static function isBlank($value)
    {
        return static::matchesPattern('^[[:space:]]*$', $value);
    }

    /**
     * Проверка строки на Ascii символы
     *
     * @param  string    $value Исходная строка
     * @return bool      Возвращает true, если $value содержит только Ascii символы, иначе false.
     */
    public static function isAscii($value)
    {
        return ASCII::is_ascii((string) $value);
    }


    /**
     * Проверка строки на телефон
     *
     * @param  string    $value Исходная строка
     * @return bool      Возвращает true, если $value содержит только телефонный номер , иначе false.
     */
    public static function isPhone($value)
    {
        if (preg_match('/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/', $value)) {
            return  true;
        } else {
            return  false;
        }
    }

    /**
     * Проверка строки на E-mail адрес
     *
     * @param  string    $value Исходная строка
     * @return bool      Возвращает true, если $value содержит только E-mail адрес, иначе false.
     */
    public static function isEmail($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return  true;
        } else {
            return  false;
        }
    }

    /**
     * Проверка строки на содержание в ней хотя бы одного E-mail адрес
     *
     * @param  string    $value Исходная строка
     * @return bool      Возвращает true, если в $value содержится хотя бы один E-mail адрес, иначе false.
     */
    public static function hasEmail($value)
    {
        if (preg_match('/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/', $value)) {
            return  true;
        } else {
            return  false;
        }
    }


    /**
     * Проверка строки на присутствие хотя бы одного символа нижнего регистра
     *
     * @param  string    $value Исходная строка
     * @return bool      Возвращает true, если в $value содержится хотя бы один символ нижнего регистра, иначе false.
     */
    public static function hasLowerCase($value)
    {
        return static::matchesPattern('.*[[:lower:]]', $value);
    }

    /**
     * Проверка строки на присутствие хотя бы одного символа верхнего регистра
     *
     * @param  string    $value Исходная строка
     * @return bool      Возвращает true, если в $value содержится хотя бы один символ верхнего регистра, иначе false.
     */
    public static function hasUpperCase($value)
    {
        return static::matchesPattern('.*[[:upper:]]', $value);
    }

    /**
     * Получение нового объекта Stringable для работы с ним
     *
     * @param  string  $string Исходная строка
     * @return \Boot\Support\Stringable
     */
    public static function of($string)
    {
        return new Stringable($string);
    }

    /**
     * Возвращает остаток строки после первого вхождения заданного значения.
     *
     * @param  string  $subject Исходная строка
     * @param  string  $search Что искать
     * @return string  Остаток строки либо вся строка будет, если заданного значения нет в строке 
     */
    public static function after($subject, $search)
    {
        return $search === '' ? $subject : array_reverse(explode($search, $subject, 2))[0];
    }

    /**
     * Возвращает остаток строки после последнего вхождения заданного значения.
     *
     * @param  string  $subject Исходная строка
     * @param  string  $search Что искать
     * @return string  Остаток строки либо вся строка будет, если заданного значения нет в строке
     */


    public static function afterLast($subject, $search)
    {
        if ($search === '') {
            return $subject;
        }
        $position = strrpos($subject, (string) $search);
        if ($position === false) {
            return $subject;
        }
        return substr($subject, $position + strlen($search));
    }

    /**
     * Возвращает все до первого вхождения заданного значения.
     *
     * @param  string  $subject Исходная строка
     * @param  string  $search Что искать
     * @return string  Возвращает все до заданного значения либо всю строку, если заданного значения нет в строке
     */
    public static function before($subject, $search)
    {
        if ($search === '') {
            return $subject;
        }
        $result = strstr($subject, (string) $search, true);

        return $result === false ? $subject : $result;
    }

    /**
     * Возвращает все до последнего вхождения заданного значения.
     *
     * @param  string  $subject Исходная строка
     * @param  string  $search Что искать
     * @return string  Возвращает все до заданного значения либо всю строку, если заданного значения нет в строке
     */
    public static function beforeLast($subject, $search)
    {
        if ($search === '') {
            return $subject;
        }
        $pos = mb_strrpos($subject, $search);
        if ($pos === false) {
            return $subject;
        }
        return static::substr($subject, 0, $pos);
    }

    /**
     * Возвращает часть строки между двумя значениями.
     *
     * @param  string  $subject Исходная строка
     * @param  string  $from Начало
     * @param  string  $to Конец
     * @return string  Возвращает часть строки между двумя значениями.
     */
    public static function between($subject, $from, $to)
    {
        if ($from === '' || $to === '') {
            return $subject;
        }
        return static::beforeLast(static::after($subject, $from), $to);
    }

    /**
     * Повторяет строку указанное количество раз
     *
     * @param  string  $string Исходная строка
     * @param  int     $times Количество повторов
     * @return string  Повторяет строку $string $times раз
     */
    public static function repeat(string $string, int $times)
    {
        return str_repeat($string, $times);
    }

    /**
     * Проверяет строку по заданному регулярному выражению
     *
     * @param  string  $pattern Шаблон регулярного выражения для сопоставления
     * @param  string  $value Исходная строка
     * @return string  Возвращает true, если $value соответствует заданному шаблону, иначе false.
     */
    protected static function matchesPattern($pattern, $value)
    {
        $match = mb_ereg_match($pattern, $value);
        return $match;
    }

    /**
     * Преобразование строки по паттерну "верблюд"
     *
     * @param  string  $value Исходная строка
     * @return string  Возвращает строку преобразованную по паттерну "верблюд".
     */
    public static function camel($value)
    {
        if (isset(static::$camelCache[$value])) {
            return static::$camelCache[$value];
        }
        return static::$camelCache[$value] = lcfirst(static::studly($value));
    }

    /**
     * Преобразование строки в слитную строку где каждое слово будет начинаться с заглавной буквы
     *
     * @param  string  $value Исходная строка
     * @return string  Возвращает слитную строку где каждое слово будет начинаться с заглавной буквы
     */
    public static function studly($value)
    {
        $key = $value;
        if (isset(static::$studlyCache[$key])) {
            return static::$studlyCache[$key];
        }
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        return static::$studlyCache[$key] = str_replace(' ', '', $value);
    }

    /**
     * Преобразование строки по паттерну "змейка"
     *
     * @param  string  $value Исходная строка
     * @param  string  $delimiter Разделитель
     * @return string  Возвращает строку преобразованную по паттерну "змейка".
     */
    public static function snake($value, $delimiter = '_')
    {
        $key = $value;
        if (isset(static::$snakeCache[$key][$delimiter])) {
            return static::$snakeCache[$key][$delimiter];
        }
        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));

            $value = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value));
        }
        return static::$snakeCache[$key][$delimiter] = $value;
    }

    /**
     * Преобразование строки по паттерну "кебаб"
     *
     * @param  string  $value Исходная строка
     * @return string  Возвращает строку преобразованную по паттерну "кебаб".
     */
    public static function kebab($value)
    {
        return static::snake($value, '-');
    }

    /**
     * Обрезает строку по словам на указанное значение в конце ставит указанную строку
     *
     * @param  string  $value Исходная строка
     * @param  int     $words Количество слов
     * @param  string  $end Заглушка в конце
     * @return string  Возвращает обрезанную на $words слов строку с заглушкой $end в конце
     */
    public static function words($value, $words = 100, $end = '...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,' . $words . '}/u', $value, $matches);
        if (!isset($matches[0]) || static::length($value) === static::length($matches[0])) {
            return $value;
        }
        return rtrim($matches[0]) . $end;
    }

    /**
     * Получение длины строки
     *
     * @param  string        $value Исходная строка
     * @param  string|null   $encoding Кодировка
     * @return int          Возвращает длину строки $value
     */
    public static function length($value, $encoding = null)
    {
        if ($encoding) {
            return mb_strlen($value, $encoding);
        }
        return mb_strlen($value);
    }

    /**
     * Обрезает строку посимвольно на указанное значение в конце ставит указанную строку
     *
     * @param  string  $value Исходная строка
     * @param  int     $limit Количество символов
     * @param  string  $end Заглушка в конце
     * @return string  Возвращает обрезанную на $limit символов строку с заглушкой $end в конце
     */
    public static function limit($value, $limit = 100, $end = '...')
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }
        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
    }

    /**
     * Преобразует строку к нижнему регистру
     *
     * @param  string  $value Исходная строка
     * @return string  Возвращает строку преобразованную к нижнему регистру
     */
    public static function lower($value)
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * Преобразует строку к верхнему регистру
     *
     * @param  string  $value Исходная строка
     * @return string  Возвращает строку преобразованную к верхнему регистру
     */
    public static function upper($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    /**
     * Преобразует первый символ в верхний регистр
     *
     * @param  string  $value Исходная строка
     * @return string  Возвращает строку где первый символ переведен в верхний регистр
     */
    public static function ucfirst($string)
    {
        return static::upper(static::substr($string, 0, 1)) . static::substr($string, 1);
    }

    /**
     * Преобразует первый символ в нижний регистр
     *
     * @param  string  $value Исходная строка
     * @return string  Возвращает строку где первый символ переведен в нижний регистр
     */
    public static function lcfirst($string)
    {
        return static::lower(static::substr($string, 0, 1)) . static::substr($string, 1);
    }

    /**
     * Обрезание строки 
     *
     * @param  string    $string Исходная строка
     * @param  int       $start Начало
     * @param  int|null  $length Конец
     * @return string    Возвращает часть строки, указанную параметрами start и length.
     */
    public static function substr($string, $start, $length = null)
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    /**
     * Получение суммы прописью
     *
     * @param  float     $num Сумма
     * @return string    Возвращает сумму (число) прописью 
     */
    public static function numbToString($num)
    {
        $morph = function ($n, $f1, $f2, $f5) {
            $n = abs(intval($n)) % 100;
            if ($n > 10 && $n < 20) return $f5;
            $n = $n % 10;
            if ($n > 1 && $n < 5) return $f2;
            if ($n == 1) return $f1;
            return $f5;
        };

        $nul = 'ноль';
        $ten = array(
            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять')
        );
        $a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
        $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
        $hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
        $unit = array(
            array('копейка', 'копейки',   'копеек',     1),
            array('рубль',    'рубля',     'рублей',     0),
            array('тысяча',   'тысячи',    'тысяч',      1),
            array('миллион',  'миллиона',  'миллионов',  0),
            array('миллиард', 'миллиарда', 'миллиардов', 0),
        );

        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) {
                if (!intval($v)) continue;
                $uk = sizeof($unit) - $uk - 1;
                $gender = $unit[$uk][3];
                $vv = str_split($v, 1) ?: [];
                list($i1, $i2, $i3) = array_map('intval', $vv);
                // mega-logic
                $out[] = $hundred[$i1]; // 1xx-9xx
                if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; // 20-99
                else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; // 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1) $out[] = $morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
            }
        } else {
            $out[] = $nul;
        }
        $out[] = $morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        $out[] = $kop . ' ' . $morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
    }



    public static function numberFormatter($value, $language = 'ru', $style = \NumberFormatter::SPELLOUT, $pattern = null)
    {
        $value = Numb::commasReplace($value);
        $format = new \NumberFormatter($language, $style, $pattern);
        return $format->format($value);
    }

    /**
     * Дополняет строку до заданной длины. С указанием типа дополнения (справа, слева, по середине)
     *
     * @param  string    $value Исходная строка
     * @param  int       $length Длина до который нужно дополнить
     * @param  string    $pad Заполнение
     * @param  string    $padType Тип дополнения (right, left, both)
     * @return string    Возвращает строку $value дополненною указанными символами до указанной длины, по указанному шаблону 
     */
    public static function pad($value, $length, $pad = ' ', $padType = 'right')
    {
        if (!in_array($padType, ['left', 'right', 'both'])) {
            throw new \InvalidArgumentException('Pad expects $padType ' .
                "to be one of 'left', 'right' or 'both'");
        }
        switch ($padType) {
            case 'left':
                return static::padLeft($value, $length, $pad);
            case 'right':
                return static::padRight($value, $length, $pad);
            default:
                return static::padBoth($value, $length, $pad);
        }
    }

    /**
     * Дополняет строку справа до заданной длины. 
     *
     * @param  string    $value Исходная строка
     * @param  int       $length Длина до который нужно дополнить
     * @param  string    $pad Заполнение
     * @return string    Возвращает строку $value дополненною справа указанными символами до указанной длины. 
     */
    public static function padRight($value, $length, $pad = ' ')
    {
        return str_pad($value, $length, $pad, STR_PAD_RIGHT);
    }

    /**
     * Дополняет строку слева до заданной длины. 
     *
     * @param  string    $value Исходная строка
     * @param  int       $length Длина до который нужно дополнить
     * @param  string    $pad Заполнение
     * @return string    Возвращает строку $value дополненною слева указанными символами до указанной длины. 
     */
    public static function padLeft($value, $length, $pad = ' ')
    {
        return str_pad($value, $length, $pad, STR_PAD_LEFT);
    }

    /**
     * Дополняет строку по середине до заданной длины. 
     *
     * @param  string    $value Исходная строка
     * @param  int       $length Длина до который нужно дополнить
     * @param  string    $pad Заполнение
     * @return string    Возвращает строку $value дополненною по середине указанными символами до указанной длины. 
     */
    public static function padBoth($value, $length, $pad = ' ')
    {
        return str_pad($value, $length, $pad, STR_PAD_BOTH);
    }


    /**
     * Удаляет заданное значение или массив значений из строки.
     *
     * @param  string|array<string>   $search Значение или массив значение для удаления
     * @param  string                 $length Исходная трока
     * @param  bool                   $pad Чувствительность к регистру
     * @return string                 Возвращает строку где удалены все указанные значения. 
     */
    public static function remove($search, $subject, $caseSensitive = true)
    {
        $subject = $caseSensitive ? str_replace($search, '', $subject) : str_ireplace($search, '', $subject);
        return $subject;
    }

    /**
     * Удаление из строки префикса, если таковой имеется.
     *
     * @param  string $substring Префикс
     * @return string Возвращает строку с удаленным префиксом $substring, если таковой имеется.
     */
    public static function removeLeft($value, $substring)
    {
        if (static::startsWith($value, $substring)) {
            $substringLength = mb_strlen($substring);
            return static::substr($value, $substringLength);
        }
        return $value;
    }

    /**
     * Удаление из строки суффикса, если таковой имеется.
     *
     * @param  string $substring Суффикс
     * @return string Возвращает строку с удаленным суффиксом $substring, если таковой имеется.
     */
    public static function removeRight($value, $substring)
    {
        if (static::endsWith($value, $substring)) {
            $substringLength = mb_strlen($substring);
            return static::substr($value, 0, static::length($value) - $substringLength);
        }
        return $value;
    }

    /**
     * Генерация случайной строки из чисел и символов
     *
     * @param  int  $length Количество символов
     * @return string Возвращает строку из случайных символов указанной длины.
     */
    public static function random($length = 16)
    {
        $string = '';
        while (($len = strlen($string)) < $length) {
            $size = $length - $len;
            $bytes = random_bytes($size);
            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }
        return $string;
    }

    /**
     * Метод определяет, начинается ли данная строка с заданного значения
     *
     * @param  string  $haystack Исходная строка
     * @param  string  $needles Значения для поиска
     * @return bool    Возвращает true если в начале строки есть указанное значение, иначе false.
     */
    public static function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Метод определяет, начинается ли данная строка хотя бы одним из указанных в массиве значением
     *
     * @param  string    $haystack Исходная строка
     * @param  string[]  $needles Значения для поиска
     * @return bool      Возвращает true если в начале строки есть хотя бы одно из указанных в массиве значение, иначе false.
     */
    public static function startsWithAny($haystack, $needles)
    {
        if (empty($needles)) {
            return false;
        }
        foreach ($needles as $substring) {
            if (static::startsWith($haystack, $substring)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Метод определяет, заканчивается ли данная строка указанным значением
     *
     * @param  string  $haystack Исходная строка
     * @param  string  $needles Значения для поиска
     * @return bool    Возвращает true если в конце строки есть указанное значение, иначе false.
     */
    public static function endsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && substr($haystack, -strlen($needle)) === (string) $needle) {
                return true;
            }
        }
        return false;
    }

    /**
     * Метод определяет, заканчивается ли данная строка хотя бы одним из указанных в массиве значением
     *
     * @param  string    $haystack Исходная строка
     * @param  string[]  $needles Значения для поиска
     * @return bool      Возвращает true если в конце строки есть хотя бы одно из указанных в массиве значение, иначе false.
     */
    public static function endsWithAny($haystack, $needles)
    {
        if (empty($needles)) {
            return false;
        }
        foreach ($needles as $substring) {
            if (static::endsWith($haystack, $substring)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Метод определяет, соответствует ли данная строка заданному шаблону.
     *
     * @param  string|array $pattern Регулярное выражение или массив регулярных выражений
     * @param  string       $value Исходная трока
     * @return bool         Возвращает true, если строка соответствует указанному шаблону
     */
    public static function is($pattern, $value)
    {
        $patterns = Arr::wrap($pattern);
        if (empty($patterns)) {
            return false;
        }
        foreach ($patterns as $pattern) {
            if ($pattern === $value) {
                return true;
            }
            $pattern = preg_quote($pattern, '#');
            $pattern = str_replace('\*', '.*', $pattern);
            if (preg_match('#^' . $pattern . '\z#u', $value) === 1) {
                return true;
            }
        }
        return false;
    }

    /**
     * Метод определяет, сколько раз подстрока встречается в указанной строке.
     *
     * @param  string        $haystack Исходная строка
     * @param  string        $needles Значения для поиска
     * @param  string        $offset Смещение начала отсчёта
     * @param  string|null   $length Максимальная длина строки
     * @return int           Возвращает количество вхождений подстроки.
     */
    public static function substrCount($haystack, $needle, $offset = 0, $length = null)
    {
        if (!is_null($length)) {
            return substr_count($haystack, $needle, $offset, $length);
        } else {
            return substr_count($haystack, $needle, $offset);
        }
    }

    /**
     * Метод добавляет подстроку в начало переданной строки, если она еще не начинается с этой подстроки
     *
     * @param  string   $value Исходная строка
     * @param  string   $prefix Значения для поиска
     * @return string   Возвращает строку с префиксом.
     */
    public static function start($value, $prefix)
    {
        $quoted = preg_quote($prefix, '/');
        return $prefix . preg_replace('/^(?:' . $quoted . ')+/u', '', $value);
    }

    /**
     * Метод добавляет подстроку в конец переданной строки, если она еще не кончается с этой подстроки
     *
     * @param  string   $value Исходная строка
     * @param  string   $prefix Значения для поиска
     * @return string   Возвращает строку с суффиксом.
     */
    public static function finish($value, $cap)
    {
        $quoted = preg_quote($cap, '/');
        return preg_replace('/(?:' . $quoted . ')+$/u', '', $value) . $cap;
    }

    /**
     * Метод будет пытаться транслитерировать строку в значение ASCII
     *
     * @param  string   $value Исходная строка
     * @param  string   $language Язык
     * @return string   Возвращает строку приведенную к ASCII
     */
    public static function ascii($value, $language = 'en')
    {
        return ASCII::to_ascii((string) $value, $language);
    }

    /**
     * Синоним метода Str::ascii
     *
     * @param  string   $value Исходная строка
     * @param  string   $language Язык
     * @return string   Возвращает строку приведенную к ASCII
     */
    public static function translite($value, $language = 'en')
    {
        return static::ascii($value, $language);
    }

    /**
     * Метод заменяет последнее вхождение подстроки в строке
     *
     * @param  string   $search Строка поиска
     * @param  string   $replace Строка замены
     * @param  string   $subject Исходная строка
     * @return string   Возвращает строку с замененным в ее конце значении
     */
    public static function replaceLast($search, $replace, $subject)
    {
        if ($search === '') {
            return $subject;
        }
        $position = strrpos($subject, $search);
        if ($position !== false) {
            return substr_replace($subject, $replace, $position, strlen($search));
        }
        return $subject;
    }

    /**
     * Метод заменяет первое вхождение подстроки в строке
     *
     * @param  string   $search Строка поиска
     * @param  string   $replace Строка замены
     * @param  string   $subject Исходная строка
     * @return string   Возвращает строку с замененным в ее начале значении
     */
    public static function replaceFirst($search, $replace, $subject)
    {
        $search = (string) $search;
        if ($search === '') {
            return $subject;
        }
        $position = strpos($subject, $search);
        if ($position !== false) {
            return substr_replace($subject, $replace, $position, strlen($search));
        }
        return $subject;
    }

    /**
     * Метод последовательно заменяет заданное значение на значение из указанного массива
     *
     * @param  string                        $search Строка поиска
     * @param  array<int|string, string>     $replace массив замены
     * @param  string                        $subject Исходная строка
     * @return string                        Возвращает строку с замененным значении
     */
    public static function replaceArray($search, array $replace, $subject)
    {
        $segments = explode($search, $subject);
        $result = array_shift($segments);
        foreach ($segments as $segment) {
            $result .= (array_shift($replace) ?? $search) . $segment;
        }
        return $result;
    }

    /**
     * Разберите обратный вызов стиля метода Class [@] на класс и метод.
     *
     * @param  string  $callback
     * @param  string|null  $default
     * @return array<int, string|null>
     */
    public static function parseCallback($callback, $default = null)
    {
        return static::contains($callback, '@') ? explode('@', $callback, 2) : [$callback, $default];
    }

    /**
     * Метод преобразует заданную строку в паттерн "Title Case" (capitalize)
     *
     * @param  string  $value Исходная строка
     * @return string  Возвращает преобразованную строку
     */
    public static function title($value)
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Метод определяет, содержит ли данная строка все заданные в массиве значения. Этот метод чувствителен к регистру.
     *
     * @param  array     $haystack Исходная строка
     * @param  string[]  $needles Массив значений
     * @return bool      Возвращает true если данная строка содержит все заданные в массиве значения, иначе false
     */
    public static function containsAll($haystack, array $needles)
    {
        foreach ($needles as $needle) {
            if (!static::contains($haystack, $needle)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Метод определяет, содержит ли данная строка хотя бы одно из заданных в массиве значения. Этот метод чувствителен к регистру.
     *
     * @param  array     $haystack Исходная строка
     * @param  string[]  $needles Массив значений
     * @return bool      Возвращает true если данная строка содержит хотя бы одно из заданных в массиве значения, иначе false
     */
    public static function containsAny($haystack, array $needles)
    {
        if (empty($needles)) {
            return false;
        }
        foreach ($needles as $needle) {
            if (!static::contains($haystack, $needle)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Метод определяет, содержит ли данная строка заданное значение. Этот метод чувствителен к регистру.
     *
     * @param  string  $haystack Исходная строка
     * @param  string  $needles Заданное значение
     * @return bool    Возвращает true если данная строка содержит значение, иначе false
     */
    public static function contains($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Метод возвращает символ с указанным индексом, начинающимися с 0.
     *
     * @param  string    $value Исходная строка
     * @param  int       $index Заданное значение
     * @return string    Возвращает символ с указанным индексом
     */
    public static function at($value, $index)
    {
        return static::substr($value, $index, 1);
    }

    /**
     * Метод возвращает массив, состоящий из символов в строке.
     *
     * @param  string    $value Исходная строка
     * @return array     Возвращает массив, состоящий из символов в строке.
     */
    public static function chars($value)
    {
        $chars = array();
        for ($i = 0, $l = static::length($value); $i < $l; $i++) {
            $chars[] = static::at($value, $i);
        }
        return $chars;
    }

    /**
     * Метод заменяет последовательные символы пробела одним пробелом. Сюда входят символы табуляции и новой строки, а также многобайтовые пробелы.
     *
     * @param  string    $value Исходная строка
     * @return string    Возвращает строку, с замененными пробелами.
     */
    public static function collapseWhitespace($value)
    {
        return static::trim(static::eregReplace('[[:space:]]+', ' ', $value));
    }

    /**
     * Синоним функции Str::collapseWhitespace
     *
     * @param  string    $value Исходная строка
     * @return string    Возвращает строку, с замененными пробелами.
     */
    public static function clearSpaces($value)
    {
        return static::collapseWhitespace($value);
    }


    /**
     * Возвращает строку с удаленными пробелами в начале и в конце строки. Поддерживает удаление пробелов Unicode. 
     *
     * @param  string $value Исходная строка
     * @param  string $chars Необязательная строка символов для удаления
     * @return string Возвращает строку, с удаленными в начале и конце пробелами.
     */
    public static function trim($value, $chars = null)
    {
        $chars = ($chars) ? preg_quote($chars) : '[:space:]';
        return static::eregReplace("^[$chars]+|[$chars]+\$", '', $value);
    }


    /**
     * Метод возвращает указанное количество первых символов в строке
     *
     * @param  string $value Исходная строка
     * @param  int    $n Количество символов
     * @return string Возвращает строку в которой указанное количество первых символов в исходной строки
     */
    public static function first($value, $n)
    {
        if ($n < 0) {
            return '';
        }
        return static::substr($value, 0, $n);
    }

    /**
     * Метод преобразовывает все объекты HTML в соответствующие символы. Псевдоним html_entity_decode. 
     * Список флагов см. На http://php.net/manual/en/function.html-entity-decode.php
     *
     * @param  string        $value Исходная строка
     * @param  string|null   $flags флаги
     * @return string        Возвращает строку где все объекты HTML преобразованы в соответствующие символы.
     */
    public static function htmlDecode($value, $flags = ENT_COMPAT)
    {
        return html_entity_decode($value, $flags);
    }

    /**
     * Метод преобразовывает все спец. символы в объекты HTML. Псевдоним htmlentities.
     * Список флагов см. На http://php.net/manual/en/function.htmlentities.php 
     *
     * @param  string        $value Исходная строка
     * @param  string|null   $flags флаги
     * @return string        Возвращает строку где все спец символы преобразованы в HTML сущности.
     */
    public static function htmlEncode($value, $flags = ENT_COMPAT)
    {
        return htmlentities($value, $flags);
    }


    /**
     * Метод делает первое слово строки заглавной, заменяет подчеркивание на пробелы и удаляет '_id'.
     *
     * @param  string        $value Исходная строка
     * @return string        Возвращает преобразованную (очеловеченную) строку.
     */
    public static function humanize($value)
    {
        return static::ucfirst(static::trim(str_replace(['_id', '_'], ['', ' '], $value)));
    }

    /**
     * Возвращает индекс первого вхождения в строке и false, если не найдено. 
     *
     * @param  string        $value Исходная строка
     * @param  string        $needle Поисковая трока
     * @param  int           $offset Принимает необязательное смещение, с которого следует начать поиск. Отрицательный индекс ищет с конца
     * @return int|bool      Возвращает индекс первого вхождения в строке и false, если не найдено. 
     */
    public static function indexOf($value, $needle, $offset = 0)
    {
        return mb_strpos($value, (string) $needle, (int) $offset);
    }

    /**
     * Возвращает индекс последнего вхождения в строке и false, если не найдено. 
     *
     * @param  string        $value Исходная строка
     * @param  string        $needle Поисковая трока
     * @param  int           $offset Принимает необязательное смещение, с которого следует начать поиск. Отрицательный индекс ищет с конца
     * @return int|bool      Возвращает индекс последнего вхождения в строке и false, если не найдено. 
     */
    public static function indexOfLast($value, $needle, $offset = 0)
    {
        return mb_strrpos($value, (string) $needle, (int) $offset);
    }

    /**
     * Вставляет указанную подстроку в строку по указанному индексу.
     *
     * @param  string   $value Исходная строка
     * @param  string   $substring Подстрока которую нужно вставить
     * @param  int      $index Индекс куда нужно вставить
     * @return static   Возвращает преобразованную строку, либо исходную если указанный индекс больше длины строки
     */
    public static function insert($value, $substring, $index)
    {
        if ($index > static::length($value)) {
            return $value;
        }
        $start = mb_substr($value, 0, $index);
        $end = mb_substr($value, $index, static::length($value));
        return  $start . $substring . $end;
    }

    /**
     * Метод возвращает указанное количество последних символов в строке
     *
     * @param  string $value Исходная строка
     * @param  int    $n Количество символов
     * @return string Возвращает строку в которой указанное количество последних символов в исходной строке
     */
    public static function last($value, $n)
    {
        if ($n <= 0) {
            return '';
        }
        return static::substr($value, -$n);
    }

    /**
     * Метод преобразует строку в массив разбивая по переносам
     * 
     * @param  string $value Исходная строка
     * @return static[] Возвращает массив из разбитый строки по переносам
     */
    public static function lines($value)
    {
        return static::split($value, '/[\r\n]{1,2}/')->toArray();
    }

    /**
     * Метод разбивает строку на коллекцию Boot\Support\Collection, используя регулярное выражение:
     *
     * @param  string $value Исходная строка
     * @param  string $pattern Регулярное выражение
     * @param  int    $limit Ограничение поиска
     * @param  int    $flags Флаги см. https://www.php.net/manual/ru/function.preg-split.php
     * @return \Boot\Support\Collection  Возвращает коллекцию из разбитой по регулярному выражению строки
     */
    public static function split($value, $pattern, $limit = -1, $flags = 0)
    {
        if (filter_var($pattern, FILTER_VALIDATE_INT) !== false) {
            return cc(mb_str_split($value, $pattern));
        }
        $segments = preg_split($pattern, $value, $limit, $flags);
        return !empty($segments) ? cc($segments) : cc();
    }

    /**
     * Метод меняет порядок символов строки на обратный.
     *
     * @param  string        $value Исходная строка
     * @return string        Возвращает преобразованную (перевернутую) строку.
     */
    public static function reverse($value)
    {
        $reversed = '';
        for ($i = static::length($value) - 1; $i >= 0; $i--) {
            $reversed .= mb_substr($value, $i, 1);
        }
        return $reversed;
    }

    /**
     * Метод перемешивает символы в строке
     *
     * @param  string        $value Исходная строка
     * @return string        Возвращает преобразованную (перемешенную) строку.
     */
    public static function shuffle($value)
    {
        $indexes = range(0, static::length($value) - 1);
        shuffle($indexes);
        $shuffledStr = '';
        foreach ($indexes as $i) {
            $shuffledStr .= \mb_substr($value, $i, 1);
        }
        return $shuffledStr;
    }

    /**
     * Метод преобразовывает регистр символов в строке
     *
     * @param  string        $value Исходная строка
     * @return string        Возвращает строку где у символов изменен регистр на обратный
     */
    public static function swapCase($value)
    {
        return preg_replace_callback(
            '/[\S]/u',
            function ($match) {
                if ($match[0] == \mb_strtoupper($match[0])) {
                    return \mb_strtolower($match[0]);
                }
                return \mb_strtoupper($match[0]);
            },
            $value
        );
    }

    /**
     * Метод возвращает последний компонент имени из указанного пути
     *
     * @param  string        $value Исходная строка
     * @param  string        $suffix Если компонент имени заканчивается на suffix, то он также будет отброшен.
     * @return string        Возвращает последний компонент имени из указанного пути
     */
    public static function basename($value, $suffix = '')
    {
        return basename($value, $suffix);
    }

    /**
     * Метод возвращает имя родительского каталога из указанного пути
     *
     * @param  string        $value Исходная строка
     * @param  int           $levels Уровень каталога
     * @return string        Возвращает имя родительского каталога из указанного пути
     */
    public static function dirname($value, $levels = 1)
    {
        return dirname($value, $levels);
    }

    /**
     * Метод заменяет в строке запятые на точки
     *
     * @param  string        $value Исходная строка
     * @return string        Возвращает строку где запятые заменены на точки
     */
    public static function commasReplace($value)
    {
        return str_replace(',', '.', $value);
    }

    /**
     * Метод заменяет в строке точки на запятые
     *
     * @param  string        $value Исходная строка
     * @return string        Возвращает строку где точки заменены на запятые
     */
    public static function dotsReplace($value)
    {
        return str_replace('.', ',', $value);
    }


    /**
     * Метод преобразовывает строку в URL подобный вид
     *
     * @param  string        $title Исходная строка
     * @param  string        $separator Разделитель
     * @param  string        $language Язык поддерживается только en 
     * @return string        Возвращает строку преобразованную к URL адресу
     */
    public static function slug($title, $separator = '-', $language = 'en')
    {
        $title = $language ? static::ascii($title, $language) : $title;
        $flip = $separator === '-' ? '_' : '-';
        $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);
        $title = str_replace('@', $separator . 'at' . $separator, $title);
        $title = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', static::lower($title));
        $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);
        return trim($title, $separator);
    }

    /**
     * Окружает исходную строку указанной подстрокой
     *
     * @param  string $value Исходная строка
     * @param  string $substring Исходная строка
     * @return static Возвращает строку которую окружает указанная подстрока
     *                 
     */
    public static function surround($value, $substring)
    {
        return implode('', [$substring, $value, $substring]);
    }

    /**
     * Удаляет все пробелы в строке. Сюда входят символы табуляции и новой строки, а также многобайтовые пробелы.
     *
     * @param  string $value Исходная строка
     * @return static Возвращает строку без пробелов
     *                 
     */
    public static function removeSpaces($value)
    {
        return static::eregReplace('[[:space:]]+', '', $value);
    }

    /**
     * Alias for mb_ereg_replace with a fallback to preg_replace if the
     * mbstring module is not installed.
     */
    public static function eregReplace($pattern, $replacement, $string, $option = 'msr')
    {
        return mb_ereg_replace($pattern, $replacement, $string, $option);
    }

    /**
     * Возвращает подстроку, начинающуюся с $start и до $end, не включая индекс, указанный в $end. 
     * Если $end не указан, функция извлекает оставшуюся строку. Если $end отрицательный, то вычисляется с конца строки.
     *
     * @param  string   $value Исходная строка
     * @param  int      $start Начало
     * @param  int|null $end конец
     * @return static   Возвращает обрезанную строку
     *                 
     */
    public static function slice($value, $start, $end = null)
    {
        if ($end === null) {
            $length = static::length($value);
        } elseif ($end >= 0 && $end <= $start) {
            return '';
        } elseif ($end < 0) {
            $length = static::length($value) + $end - $start;
        } else {
            $length = $end - $start;
        }
        return static::substr($value, $start, $length);
    }

    /**
     * Возвращает строку с умными кавычками, символами многоточия и тире из Windows-1252 (обычно используется в документах Word), замененными их эквивалентами ASCII.
     *
     * @param  string   $value Исходная строка
     * @return static   Возвращает строку с преобразованными кавычками тире и многоточиями
     *                 
     */
    public static function tidy($value)
    {
        return preg_replace([
            '/\x{2026}/u',
            '/[\x{201C}\x{201D}]/u',
            '/[\x{2018}\x{2019}]/u',
            '/[\x{2013}\x{2014}]/u',
        ], [
            '...',
            '"',
            "'",
            '-',
        ], $value);
    }


    /**
     * Метод возвращает максимально длинный префикс между двумя строками
     *
     * @param  string $value Исходная строка
     * @param  string $other Вторая строка для сравнения
     * @return static Возвращает максимально длинный префикс между двумя строками
     */
    public static function longPrefix($value, $other)
    {
        $maxLength = min(static::length($value), static::length($other));
        $longPrefix = '';
        for ($i = 0; $i < $maxLength; $i++) {
            $char = \mb_substr($value, $i, 1);
            if ($char == \mb_substr($other, $i, 1)) {
                $longPrefix .= $char;
            } else {
                break;
            }
        }
        return $longPrefix;
    }

    /**
     * Метод возвращает максимально длинный суффикс между двумя строками
     *
     * @param  string $value Исходная строка
     * @param  string $other Вторая строка для сравнения
     * @return static Возвращает максимально длинный суффикс между двумя строками
     */
    public static function longSuffix($value, $other)
    {
        $maxLength = min(static::length($value), static::length($other));
        $longSuffix = '';
        for ($i = 1; $i <= $maxLength; $i++) {
            $char = \mb_substr($value, -$i, 1);
            if ($char == \mb_substr($other, -$i, 1)) {
                $longSuffix = $char . $longSuffix;
            } else {
                break;
            }
        }
        return $longSuffix;
    }

    /**
     * Метод возвращает максимально длинную общую часть между двумя строками
     *
     * @param  string $value Исходная строка
     * @param  string $other Вторая строка для сравнения
     * @return static Возвращает максимально длинную общую часть между двумя строками
     */
    public static function longSubstring($value, $other)
    {
        $strLength = static::length($value);
        $otherLength = static::length($other);
        if ($strLength == 0 || $otherLength == 0) {
            return '';
        }
        $len = 0;
        $end = 0;
        $table = array_fill(0, $strLength + 1, array_fill(0, $otherLength + 1, 0));
        for ($i = 1; $i <= $strLength; $i++) {
            for ($j = 1; $j <= $otherLength; $j++) {
                $strChar = \mb_substr($value, $i - 1, 1);
                $otherChar = \mb_substr($other, $j - 1, 1);
                if ($strChar == $otherChar) {
                    $table[$i][$j] = $table[$i - 1][$j - 1] + 1;
                    if ($table[$i][$j] > $len) {
                        $len = $table[$i][$j];
                        $end = $i;
                    }
                } else {
                    $table[$i][$j] = 0;
                }
            }
        }
        return \mb_substr($value, $end - $len, $len);
    }

    /**
     * Метод преобразует строку где каждое слово будет начинаться с заглавной буквы. 
     * Также принимает массив $ignore, позволяющий перечислять слова без заглавных букв.
     *
     * @param  string     $value Исходная строка
     * @param  array|null $other Массив слов без заглавых букв
     * @return static     Возвращает максимально длинную общую часть между двумя строками
     */
    public static function titleize($value, $ignore = null)
    {
        $str = static::trim($value);
        return  preg_replace_callback(
            '/([\S]+)/u',
            function ($match) use ($ignore) {
                if ($ignore && in_array($match[0], $ignore)) {
                    return $match[0];
                }
                return (string) static::ucfirst(static::lower($match[0]));
            },
            $str
        );
    }


    /**
     * Возвращает строку с удаленными пробелами только в начале. Поддерживает удаление пробелов Unicode. 
     *
     * @param  string $value Исходная строка
     * @param  string $chars Необязательная строка символов для удаления
     * @return static Возвращает строку с удаленными в начале пробелами
     */
    public static function trimLeft($value, $chars = null)
    {
        $chars = ($chars) ? preg_quote($chars) : '[:space:]';
        return static::eregReplace("^[$chars]+", '', $value);
    }

    /**
     * Возвращает строку с удаленными пробелами только в конце. Поддерживает удаление пробелов Unicode. 
     *
     * @param  string $value Исходная строка
     * @param  string $chars Необязательная строка символов для удаления
     * @return static Возвращает строку с удаленными в конце пробелами
     */
    public static function trimRight($value, $chars = null)
    {
        $chars = ($chars) ? preg_quote($chars) : '[:space:]';
        return static::eregReplace("[$chars]+\$", '', $value);
    }


    /**
     * Метод возвращает строку где все найденные подстроки замены на указанное значение
     *
     * @param  string $value Исходная строка
     * @param  string $search Строка поиска
     * @param  string $replacement Строка замены
     * @return static Возвращает строку где все найденные подстроки замены на указанное значение
     */
    public static function replace($value, $search, $replacement)
    {
        return static::eregReplace(preg_quote($search), $replacement, $value);
    }



    /**
     * Метод преобразовывает русские символы в английские и обратно, аналог Punto switcher
     *
     * @param  string   $value Исходный текст
     * @param  int      $type Указывает в какую сторону преобразовывать (0: rus -> eng, 1: eng -> rus)
     * @return string   Возвращает преобразованную строку
     */
    public static function switcher(string $value, int $type = 0)
    {
        $str[0] = array('й' => 'q', 'ц' => 'w', 'у' => 'e', 'к' => 'r', 'е' => 't', 'н' => 'y', 'г' => 'u', 'ш' => 'i', 'щ' => 'o', 'з' => 'p', 'х' => '[', 'ъ' => ']', 'ф' => 'a', 'ы' => 's', 'в' => 'd', 'а' => 'f', 'п' => 'g', 'р' => 'h', 'о' => 'j', 'л' => 'k', 'д' => 'l', 'ж' => ';', 'э' => '\'', 'я' => 'z', 'ч' => 'x', 'с' => 'c', 'м' => 'v', 'и' => 'b', 'т' => 'n', 'ь' => 'm', 'б' => ',', 'ю' => '.', 'Й' => 'Q', 'Ц' => 'W', 'У' => 'E', 'К' => 'R', 'Е' => 'T', 'Н' => 'Y', 'Г' => 'U', 'Ш' => 'I', 'Щ' => 'O', 'З' => 'P', 'Х' => '[', 'Ъ' => ']', 'Ф' => 'A', 'Ы' => 'S', 'В' => 'D', 'А' => 'F', 'П' => 'G', 'Р' => 'H', 'О' => 'J', 'Л' => 'K', 'Д' => 'L', 'Ж' => ';', 'Э' => '\'', '?' => 'Z', 'ч' => 'X', 'С' => 'C', 'М' => 'V', 'И' => 'B', 'Т' => 'N', 'Ь' => 'M', 'Б' => ',', 'Ю' => '.',);
        $str[1] = array('q' => 'й', 'w' => 'ц', 'e' => 'у', 'r' => 'к', 't' => 'е', 'y' => 'н', 'u' => 'г', 'i' => 'ш', 'o' => 'щ', 'p' => 'з', '[' => 'х', ']' => 'ъ', 'a' => 'ф', 's' => 'ы', 'd' => 'в', 'f' => 'а', 'g' => 'п', 'h' => 'р', 'j' => 'о', 'k' => 'л', 'l' => 'д', ';' => 'ж', '\'' => 'э', 'z' => 'я', 'x' => 'ч', 'c' => 'с', 'v' => 'м', 'b' => 'и', 'n' => 'т', 'm' => 'ь', ',' => 'б', '.' => 'ю', 'Q' => 'Й', 'W' => 'Ц', 'E' => 'У', 'R' => 'К', 'T' => 'Е', 'Y' => 'Н', 'U' => 'Г', 'I' => 'Ш', 'O' => 'Щ', 'P' => 'З', '[' => 'Х', ']' => 'Ъ', 'A' => 'Ф', 'S' => 'Ы', 'D' => 'В', 'F' => 'А', 'G' => 'П', 'H' => 'Р', 'J' => 'О', 'K' => 'Л', 'L' => 'Д', ';' => 'Ж', '\'' => 'Э', 'Z' => '?', 'X' => 'ч', 'C' => 'С', 'V' => 'М', 'B' => 'И', 'N' => 'Т', 'M' => 'Ь', ',' => 'Б', '.' => 'Ю',);
        return strtr($value, isset($str[$type]) ? $str[$type] : array_merge($str[0], $str[1]));
    }

    /**
     * Метод преобразует специальные HTML-сущности обратно в соответствующие символы
     *
     * @param  string       $value Исходная строка
     * @param  array|null   $request  Массив с параметрами 
     *                      Возможные параметры: (type: тип (default, word), enter: разделитель строки (по умолчанию \n))
     * @return string       Возвращает строку где все специальные HTML-сущности преобразованы обратно в соответствующие символы
     */
    public static function ee($value, $request = [])
    {
        $type = empty($request["type"]) ? false : $request["type"];
        switch ($type) {
            default:
                $enter = "\n";
                break;
            case "word":
                $enter = "<w:br/>";
                break;
        }
        $enter = empty($request["enter"]) ? $enter : $request["enter"];
        $new_value = $value;
        $new_value = str_replace("&lt;br&gt;", $enter, $new_value);
        $new_value = str_replace("&amp;lt;br&amp;gt;;", $enter, $new_value);
        $new_value = str_replace("&amp;amp;lt;br&amp;amp;gt;;", $enter, $new_value);
        $new_value = str_replace("&amp;", "&", $new_value);
        $new_value = html_entity_decode(htmlspecialchars_decode($new_value, ENT_QUOTES), ENT_QUOTES);
        return $new_value;
    }


    /**
     * Generate a UUID (version 4).
     *
     * @return \Ramsey\Uuid\UuidInterface
     */
    public static function uuid()
    {
        return static::$uuidFactory
            ? call_user_func(static::$uuidFactory)
            : Uuid::uuid4();
    }


    /**
     * Get the plural form of an English word.
     *
     * @param  string  $value
     * @param  int  $count
     * @return string
     */
    public static function plural($value, $count = 2)
    {
        return Pluralizer::plural($value, $count);
    }

    /**
     * Pluralize the last word of an English, studly caps case string.
     *
     * @param  string  $value
     * @param  int  $count
     * @return string
     */
    public static function pluralStudly($value, $count = 2)
    {
        $parts = preg_split('/(.)(?=[A-Z])/u', $value, -1, PREG_SPLIT_DELIM_CAPTURE);

        $lastWord = array_pop($parts);

        return implode('', $parts) . self::plural($lastWord, $count);
    }

}
