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

use \Closure;

class Stringable
{

    public function __construct($value = '')
    {
        $this->value = (string) $value;
    }

    /**
     * Проверка строки на JSON
     *
     * @return static
     */
    public function isJson()
    {
        return new static(Str::isJson($this->value));
    }

    /**
     * Проверка строки на нижний регистр
     *
     * @return static
     */
    public function isLowerCase()
    {
        return new static(Str::isLowerCase($this->value));
    }


    /**
     * Проверка строки на верхний регистр
     *
     * @return static
     */
    public function isUpperCase()
    {
        return new static(Str::isUpperCase($this->value));
    }

    /**
     * Проверка строки на присутствие только буквенных символов
     *
     * @return static
     */
    public function isAlpha()
    {
        return new static(Str::isAlpha($this->value));
    }

    /**
     * Проверка строки на присутствие только буквенно-цифровые символы
     *
     * @return static
     */
    public function isAlphanumeric()
    {
        return new static(Str::isAlphanumeric($this->value));
    }

    /**
     * Проверка строки на base64
     *
     * @return static
     */
    public function isBase64()
    {
        return new static(Str::isBase64($this->value));
    }

    /**
     * Проверка строки на сериализацию
     *
     * @return static
     */
    public function isSerialized()
    {
        return new static(Str::isSerialized($this->value));
    }

    /**
     * Проверка строки на шестнадцатеричные символы
     *
     * @return static
     */
    public function isHexadecimal()
    {
        return new static(Str::isHexadecimal($this->value));
    }

    /**
     * Проверка строки на символы пробела
     *
     * @return static
     */
    public function isBlank()
    {
        return new static(Str::isBlank($this->value));
    }



    /**
     * Проверка строки на Ascii символы
     *
     * @return static
     */
    public function isAscii()
    {
        return Str::isAscii($this->value);
    }

    /**
     * Проверка строки на телефон
     *
     * @return static
     */
    public function isPhone()
    {
        return Str::isPhone($this->value);
    }

    /**
     * Проверка строки на E-mail адрес
     *
     * @return static    Возвращает true, если $value содержит только E-mail адрес, иначе false.
     */
    public function isEmail()
    {
        return Str::isEmail($this->value);
    }

    /**
     * Проверка строки на содержание в ней хотя бы одного E-mail адрес
     *
     * @param  string    $value Исходная строка
     * @return static    Возвращает true, если в $value содержится хотя бы один E-mail адрес, иначе false.
     */
    public function hasEmail()
    {
        return Str::hasEmail($this->value);
    }


    /**
     * Проверка строки на присутствие хотя бы одного символа нижнего регистра
     *
     * @return static
     */
    public function hasLowerCase()
    {
        return new static(Str::hasLowerCase($this->value));
    }

    /**
     * Проверка строки на присутствие хотя бы одного символа верхнего регистра
     *
     * @return static
     */
    public function hasUpperCase()
    {
        return new static(Str::hasUpperCase($this->value));
    }

    /**
     * Получение нового объекта Stringable для работы с ним
     *
     * @return static
     */
    public function of()
    {
        return new static(Str::of($this->value));
    }


    /**
     * Возвращает остаток строки после первого вхождения заданного значения.
     *
     * @return static
     */
    public function after($search)
    {
        return new static(Str::after($this->value, $search));
    }

    /**
     * Возвращает остаток строки после последнего вхождения заданного значения.
     *
     * @param  string  $search Что искать
     * @return static
     */
    public function afterLast($search)
    {
        return new static(Str::afterLast($this->value, $search));
    }

    /**
     * Возвращает все до первого вхождения заданного значения.
     *
     * @param  string  $search
     * @return static
     */
    public function before($search)
    {
        return new static(Str::before($this->value, $search));
    }

    /**
     * Возвращает все до последнего вхождения заданного значения.
     *
     * @param  string  $search
     * @return static
     */
    public function beforeLast($search)
    {
        return new static(Str::beforeLast($this->value, $search));
    }


    /**
     * Возвращает часть строки между двумя значениями.
     *
     * @param  string  $from
     * @param  string  $to
     * @return static
     */
    public function between($from, $to)
    {
        return new static(Str::between($this->value, $from, $to));
    }

    public function betweenFirst($from, $to) {
        return new static(Str::betweenFirst($this->value, $from, $to));
    }

    /**
     * Повторяет строку указанное количество раз
     *
     * @param  int  $times
     * @return static
     */
    public function repeat(int $times)
    {
        return new static(Str::repeat($this->value, $times));
    }

    /**
     * Append the given values to the string.
     *
     * @param  array  $values
     * @return static
     */
    public function append(...$values)
    {
        return new static($this->value . implode('', $values));
    }


    /**
     * Преобразование строки по паттерну "верблюд".
     *
     * @return static
     */
    public function camel()
    {
        return new static(Str::camel($this->value));
    }

    /**
     * Преобразование строки в слитную строку где каждое слово будет начинаться с заглавной буквы
     *
     * @return static
     */
    public function studly()
    {
        return new static(Str::studly($this->value));
    }


    /**
     * Преобразование строки по паттерну "змейка"
     *
     * @return static
     */
    public function snake($delimiter = '_')
    {
        return new static(Str::snake($this->value, $delimiter));
    }


    /**
     * Преобразование строки по паттерну "кебаб"
     *
     * @return static
     */
    public function kebab()
    {
        return new static(Str::kebab($this->value));
    }

    /**
     * Обрезает строку по словам на указанное значение в конце ставит указанную строку
     *
     * @param  int  $words
     * @param  string  $end
     * @return static
     */
    public function words($words = 100, $end = '...')
    {
        return new static(Str::words($this->value, $words, $end));
    }


    /**
     * Return the length of the given string.
     *
     * @param  string  $encoding
     * @return static
     */
    public function length($encoding = null)
    {
        return Str::length($this->value, $encoding);
    }


    /**
     * Determine if the string is an exact match with the given value.
     *
     * @param  string  $value
     * @return static
     */
    public function exactly($value)
    {
        return $this->value === $value;
    }


    /**
     * Determine if the given string is empty.
     *
     * @return static
     */
    public function isEmpty()
    {
        return $this->value === '';
    }


    /**
     * Determine if the given string is not empty.
     *
     * @return static
     */
    public function isNotEmpty()
    {
        return !$this->isEmpty();
    }

    /**
     * Get the string matching the given pattern.
     *
     * @param  string  $pattern
     * @return static
     */
    public function matching($pattern)
    {
        preg_match($pattern, $this->value, $matches);

        if (!$matches) {
            return new static;
        }

        return new static($matches[1] ?? $matches[0]);
    }


    /**
     * Determine if the string matches the given pattern.
     *
     * @param  string  $pattern
     * @return static
     */
    public function test($pattern)
    {
        return $this->matching($pattern)->isNotEmpty();
    }


    /**
     * Pad both sides of the string with another.
     *
     * @param  int  $length
     * @param  string  $pad
     * @return static
     */
    public function padBoth($length, $pad = ' ')
    {
        return new static(Str::padBoth($this->value, $length, $pad));
    }


    /**
     * Обрезает строку посимвольно на указанное значение в конце ставит указанную строку
     *
     * @param  int  $limit
     * @param  string  $end
     * @return static
     */
    public function limit($limit = 100, $end = '...')
    {
        return new static(Str::limit($this->value, $limit, $end));
    }
    

    /**
     * Преобразует строку к нижнему регистру
     *
     * @return static
     */
    public function lower()
    {
        return new static(Str::lower($this->value));
    }


    /**
     * Преобразует строку к верхнему регистру
     *
     * @return static
     */
    public function upper()
    {
        return new static(Str::upper($this->value));
    }


    /**
     * Преобразует первый символ в верхний регистр
     *
     * @return static
     */
    public function ucfirst()
    {
        return new static(Str::ucfirst($this->value));
    }

    /**
     * Преобразует первый символ в нижний регистр
     *
     * @return static
     */
    public function lcfirst()
    {
        return new static(Str::lcfirst($this->value));
    }

    /**
     * Обрезание строки 
     *
     * @param  int  $start Начало
     * @param  int|null  $length Конец
     * @return static
     */
    public function substr($start, $length = null)
    {
        return new static(Str::substr($this->value, $start, $length));
    }


    /**
     * Pad the left side of the string with another.
     *
     * @param  int  $length
     * @param  string  $pad
     * @return static
     */
    public function padLeft($length, $pad = ' ')
    {
        return new static(Str::padLeft($this->value, $length, $pad));
    }

    /**
     * Pad the right side of the string with another.
     *
     * @param  int  $length
     * @param  string  $pad
     * @return static
     */
    public function padRight($length, $pad = ' ')
    {
        return new static(Str::padRight($this->value, $length, $pad));
    }


    /**
     * Удаляет заданное значение или массив значений из строки.
     *
     * @param string|array<string> $search
     * @param bool $caseSensitive
     * @return static
     */
    public function remove($search, $caseSensitive = true)
    {
        return new static(Str::remove($search, $this->value, $caseSensitive));
    }

    /**
     * Удаляет заданное значение или массив значений из строки.
     *
     * @param string|array<string> $search
     * @param bool $caseSensitive
     * @return static
     */
    public function removeLeft($search, $substring)
    {
        return new static(Str::removeLeft($search, $this->value, $substring));
    }

    /**
     * Удаление из строки суффикса, если таковой имеется.
     *
     * @param string|array<string> $search
     * @param bool $caseSensitive
     * @return static
     */
    public function removeRight($search, $substring)
    {
        return new static(Str::removeRight($search, $this->value, $substring));
    }

    /**
     * Генерация случайной строки из чисел и символов
     * @return static
     */
    public function random($length)
    {
        return new static(Str::random($length, $this->value));
    }

    /**
     * Метод определяет, начинается ли данная строка с заданного значения
     *
     * @return static
     */
    public function startsWith($needles)
    {
        return Str::startsWith($this->value, $needles);
    }


    /**
     * Метод определяет, начинается ли данная строка хотя бы одним из указанных в массиве значением
     *
     * @return static
     */
    public function startsWithAny($needles)
    {
        return Str::startsWithAny($this->value, $needles);
    }


    /**
     * Метод определяет, заканчивается ли данная строка указанным значением
     *
     * @param  string|array  $needles
     * @return static
     */
    public function endsWith($needles)
    {
        return Str::endsWith($this->value, $needles);
    }

    /**
     * Метод определяет, заканчивается ли данная строка хотя бы одним из указанных в массиве значением
     *
     * @param  string|array  $needles
     * @return static
     */
    public function endsWithAny($needles)
    {
        return Str::endsWithAny($this->value, $needles);
    }

    /**
     * Метод определяет, соответствует ли данная строка заданному шаблону.
     *
     * @param  string|array  $pattern
     * @return static
     */
    public function is($pattern)
    {
        return Str::is($pattern, $this->value);
    }


    /**
     * Метод определяет, сколько раз подстрока встречается в указанной строке.
     *
     * @param  string  $needle
     * @param  int|null  $offset
     * @param  int|null  $length
     * @return int
     */
    public function substrCount($needle, $offset = null, $length = null)
    {
        return Str::substrCount($this->value, $needle, $offset, $length);
    }


    /**
     *  Метод добавляет подстроку в начало переданной строки, если она еще не начинается с этой подстроки
     *
     * @param  string  $prefix
     * @return static
     */
    public function start($prefix)
    {
        return new static(Str::start($this->value, $prefix));
    }

    /**
     * Метод добавляет подстроку в конец переданной строки, если она еще не кончается с этой подстроки
     *
     * @param  string  $cap
     * @return static
     */
    public function finish($cap)
    {
        return new static(Str::finish($this->value, $cap));
    }

    /**
     * Метод будет пытаться транслитерировать строку в значение ASCII
     *
     * @param  string  $language
     * @return static
     */
    public function ascii($language = 'en')
    {
        return new static(Str::ascii($this->value, $language));
    }

    /**
     * Синоним метода Str::ascii
     *
     * @param  string  $language
     * @return static
     */
    public function translite($language = 'en')
    {
        return new static(Str::ascii($this->value, $language));
    }

    /**
     * Метод заменяет последнее вхождение подстроки в строке
     *
     * @param  string  $search
     * @param  string  $replace
     * @return static
     */
    public function replaceLast($search, $replace)
    {
        return new static(Str::replaceLast($search, $replace, $this->value));
    }


    /**
     * Метод заменяет первое вхождение подстроки в строке
     *
     * @param  string  $search
     * @param  string  $replace
     * @return static
     */
    public function replaceFirst($search, $replace)
    {
        return new static(Str::replaceFirst($search, $replace, $this->value));
    }


    /**
     * Метод последовательно заменяет заданное значение на значение из указанного массива
     *
     * @param  string  $search
     * @param  array  $replace
     * @return static
     */
    public function replaceArray($search, array $replace)
    {
        return new static(Str::replaceArray($search, $replace, $this->value));
    }


    /**
     * Разберите обратный вызов стиля метода Class [@] на класс и метод.
     *
     * @param  string|null  $default
     * @return array
     */
    public function parseCallback($default)
    {
        return new static(Str::parseCallback($this->value, $default));
    }

    /**
     * Метод преобразует заданную строку в паттерн "Title Case" (capitalize)
     *
     * @return static
     */
    public function title()
    {
        return new static(Str::title($this->value));
    }

    /**
     * Метод определяет, содержит ли данная строка все заданные в массиве значения. Этот метод чувствителен к регистру.
     *
     * @param  array  $needles
     * @return static
     */
    public function containsAll(array $needles)
    {
        return new static(Str::containsAll($this->value, $needles));
    }


    /**
     * Метод определяет, содержит ли данная строка хотя бы одно из заданных в массиве значения. Этот метод чувствителен к регистру.
     *
     * @param  array  $needles
     * @return static
     */
    public function containsAny(array $needles)
    {
        return new static(Str::containsAny($this->value, $needles));
    }

    /**
     * Метод определяет, содержит ли данная строка заданное значение. Этот метод чувствителен к регистру.
     *
     * @param  string|array  $needles
     * @return static
     */
    public function contains($needles)
    {
        return new static(Str::contains($this->value, $needles));
    }


    /**
     * Метод возвращает символ с указанным индексом, начинающимися с 0.
     *
     * @param  int       $index Заданное значение
     * @return string    Возвращает символ с указанным индексом
     */
    public function at($index)
    {
        return new static(Str::substr($this->value, $index));
    }

    /**
     * Метод возвращает массив, состоящий из символов в строке.
     *
     * @return array     Возвращает массив, состоящий из символов в строке.
     */
    public function chars($chars)
    {
        return new static(Str::chars($this->value, $chars));
    }

    /**
     * Метод заменяет последовательные символы пробела одним пробелом. Сюда входят символы табуляции и новой строки, а также многобайтовые пробелы.
     *
     * @param  string    $value Исходная строка
     * @return string    Возвращает строку, с замененными пробелами.
     */
    // public static function collapseWhitespace()
    // {
    //     return Str::trim($this->value);
    // }

    /**
     * Синоним функции Str::collapseWhitespace
     *
     * @param  string    $value Исходная строка
     * @return string    Возвращает строку, с замененными пробелами.
     */
    public function clearSpaces()
    {
        return new static(Str::clearSpaces($this->value));
    }

    /**
     * Возвращает строку с удаленными пробелами в начале и в конце строки. Поддерживает удаление пробелов Unicode. 
     *
     * @param  string  $characters
     * @return static
     */
    public function trim($characters = null)
    {
        return new static(trim(...array_merge([$this->value], func_get_args())));
    }

    /**
     * Метод возвращает указанное количество первых символов в строке
     *
     * @param  string $value Исходная строка
     * @param  int    $n Количество символов
     * @return string Возвращает строку в которой указанное количество первых символов в исходной строки
     */
    public function first($n)
    {
        return new static(Str::first($this->value, $n));
    }

    /**
     * Метод преобразовывает все объекты HTML в соответствующие символы. Псевдоним html_entity_decode. 
     * Список флагов см. На http://php.net/manual/en/function.html-entity-decode.php
     *
     * @param  string|null   $flags флаги
     * @return string        Возвращает строку где все объекты HTML преобразованы в соответствующие символы.
     */
    public function htmlDecode($flags)
    {
        return new static(Str::htmlDecode($this->value, $flags));
    }


    /**
     * Метод преобразовывает все спец. символы в объекты HTML. Псевдоним htmlentities.
     * Список флагов см. На http://php.net/manual/en/function.htmlentities.php 
     *
     * @param  string|null   $flags флаги
     * @return string        Возвращает строку где все спец символы преобразованы в HTML сущности.
     */
    public function htmlEncode($flags)
    {
        return new static(Str::htmlEncode($this->value, $flags));
    }

    /**
     * Метод делает первое слово строки заглавной, заменяет подчеркивание на пробелы и удаляет '_id'.
     *
     * @return string        Возвращает преобразованную (очеловеченную) строку.
     */
    public function humanize()
    {
        return new static(Str::humanize($this->value));
    }

    /**
     * Возвращает индекс первого вхождения в строке и false, если не найдено. 
     *
     * @param  string        $needle Поисковая трока
     * @param  int           $offset Принимает необязательное смещение, с которого следует начать поиск. Отрицательный индекс ищет с конца
     * @return int|bool      Возвращает индекс первого вхождения в строке и false, если не найдено. 
     */
    public function indexOf($needle, $offset)
    {
        return new static(Str::indexOf($this->value, $needle, $offset));
    }


    /**
     * Возвращает индекс последнего вхождения в строке и false, если не найдено. 
     *
     * @param  string        $needle Поисковая трока
     * @param  int           $offset Принимает необязательное смещение, с которого следует начать поиск. Отрицательный индекс ищет с конца
     * @return static      Возвращает индекс последнего вхождения в строке и false, если не найдено. 
     */
    public function indexOfLast($needle, $offset)
    {
        return new static(Str::indexOfLast($this->value, $needle, $offset));
    }


    /**
     * Вставляет указанную подстроку в строку по указанному индексу.
     *
     * @param  string   $value Исходная строка
     * @param  string   $substring Подстрока которую нужно вставить
     * @param  int      $index Индекс куда нужно вставить
     * @return static   Возвращает преобразованную строку, либо исходную если указанный индекс больше длины строки
     */
    public function insert($substring, $index)
    {
        return new static(Str::insert($this->value, $substring, $index));
    }


    /**
     * Метод возвращает указанное количество последних символов в строке
     *
     * @param  int    $n Количество символов
     * @return string Возвращает строку в которой указанное количество последних символов в исходной строке
     */
    public function last($n)
    {

        return new static(Str::last($this->value, $n));
    }


    /**
     * Метод преобразует строку в массив разбивая по переносам
     * 
     * @return static[] Возвращает массив из разбитый строки по переносам
     */
    public function lines()
    {
        return new static(Str::lines($this->value));
    }


    /**
     * Метод разбивает строку на коллекцию Boot\Support\Collection, используя регулярное выражение:
     *
     * @param  string $pattern Регулярное выражение
     * @param  int    $limit Ограничение поиска
     * @param  int    $flags Флаги см. https://www.php.net/manual/ru/function.preg-split.php
     * @return \Boot\Support\Collection  Возвращает коллекцию из разбитой по регулярному выражению строки
     */
    public function split($pattern, $limit, $flags)
    {
        return new static(Str::split($this->value, $pattern, $limit, $flags));
    }


    /**
     * Метод меняет порядок символов строки на обратный.
     *
     * @return string        Возвращает преобразованную (перевернутую) строку.
     */
    public function reverse()
    {
        return new static(Str::reverse($this->value));
    }


    /**
     * Метод перемешивает символы в строке
     *
     * @return string        Возвращает преобразованную (перемешенную) строку.
     */
    public function shuffle()
    {
        return new static(Str::shuffle($this->value));
    }

    /**
     * Метод преобразовывает регистр символов в строке
     *
     * @return string        Возвращает строку где у символов изменен регистр на обратный
     */
    public function swapCase()
    {
        return new static(Str::swapCase($this->value));
    }


    /**
     * Метод возвращает последний компонент имени из указанного пути
     *
     * @param  string  $suffix
     * @return static
     */
    public function basename($suffix = '')
    {
        return new static(basename($this->value, $suffix));
    }


    /**
     * Метод возвращает имя родительского каталога из указанного пути
     *
     * @param  int  $levels
     * @return static
     */
    public function dirname($levels = 1)
    {
        return new static(dirname($this->value, $levels));
    }


    /**
     * Метод заменяет в строке запятые на точки
     *
     * @param  string        $value Исходная строка
     * @return string        Возвращает строку где запятые заменены на точки
     */
    public function commasReplace()
    {
        return new static(Str::commasReplace($this->value));
    }



    /**
     * Метод заменяет в строке точки на запятые
     *
     * @param  string        $value Исходная строка
     * @return string        Возвращает строку где точки заменены на запятые
     */
    public function dotsReplace($value)
    {
        return new static(Str::dotsReplace($this->value));
    }


    /**
     * Метод преобразовывает строку в URL подобный вид
     *
     * @param  string  $separator
     * @param  string|null  $language
     * @return static
     */
    public function slug($separator = '-', $language = 'en')
    {
        return new static(Str::slug($this->value, $separator, $language));
    }


    /**
     * Окружает исходную строку указанной подстрокой
     *
     * @param  string $value Исходная строка
     * @param  string $substring Исходная строка
     * @return static Возвращает строку которую окружает указанная подстрока
     *                 
     */
    public function surround($substring)
    {
        return new static(Str::surround($this->value, $substring));
    }

    /**
     * Удаляет все пробелы в строке. Сюда входят символы табуляции и новой строки, а также многобайтовые пробелы.
     *
     * @param  string $value Исходная строка
     * @return static Возвращает строку без пробелов
     *                 
     */
    public function removeSpaces()
    {
        return new static(Str::removeSpaces($this->value));
    }


    /**
     * Возвращает подстроку, начинающуюся с $start и до $end, не включая индекс, указанный в $end. 
     * Если $end не указан, функция извлекает оставшуюся строку. Если $end отрицательный, то вычисляется с конца строки.
     *
     * @param  int      $start Начало
     * @param  int|null $end конец
     * @return static   Возвращает обрезанную строку
     *                 
     */
    public function slice($start, $end)
    {
        return new static(Str::slice($this->value, $start, $end));
    }


    /**
     * Возвращает строку с умными кавычками, символами многоточия и тире из Windows-1252 (обычно используется в документах Word), замененными их эквивалентами ASCII.
     *
     * @return static   Возвращает строку с преобразованными кавычками тире и многоточиями
     *                 
     */
    public function tidy()
    {
        return new static(Str::tidy($this->value));
    }


    /**
     * Метод возвращает максимально длинный префикс между двумя строками
     *
     * @param  string $other Вторая строка для сравнения
     * @return static Возвращает максимально длинный префикс между двумя строками
     */
    public function longPrefix($other)
    {

        return new static(Str::longPrefix($this->value, $other));
    }


    /**
     * Метод возвращает максимально длинный суффикс между двумя строками
     *
     * @param  string $value Исходная строка
     * @param  string $other Вторая строка для сравнения
     * @return static Возвращает максимально длинный суффикс между двумя строками
     */
    public function longSuffix($other)
    {
        return new static(Str::longSuffix($this->value, $other));
    }

    /**
     * Метод возвращает максимально длинную общую часть между двумя строками
     *
     * @param  string $other Вторая строка для сравнения
     * @return static Возвращает максимально длинную общую часть между двумя строками
     */
    public function longSubstring($other)
    {
        return new static(Str::longSubstring($this->value, $other));
    }


    /**
     * Метод преобразует строку где каждое слово будет начинаться с заглавной буквы. 
     * Также принимает массив $ignore, позволяющий перечислять слова без заглавных букв.
     *
     * @param  array|null $other Массив слов без заглавых букв
     * @return static     Возвращает максимально длинную общую часть между двумя строками
     */
    public function titleize($ignore)
    {
        return new static(Str::titleize($this->value, $ignore));
    }


    /**
     * Возвращает строку с удаленными пробелами только в начале. Поддерживает удаление пробелов Unicode. 
     *
     * @param  string $value Исходная строка
     * @param  string $chars Необязательная строка символов для удаления
     * @return static Возвращает строку с удаленными в начале пробелами
     */
    public function trimLeft($chars)
    {
        return new static(Str::titleize($this->value, $chars));
    }

    /**
     * Возвращает строку с удаленными пробелами только в конце. Поддерживает удаление пробелов Unicode. 
     *
     * @param  string $value Исходная строка
     * @param  string $chars Необязательная строка символов для удаления
     * @return static Возвращает строку с удаленными в конце пробелами
     */
    public function trimRight($chars)
    {
        return new static(Str::titleize($this->value, $chars));
    }


    /**
     * Метод возвращает строку где все найденные подстроки замены на указанное значение
     *
     * @param  string|string[]  $search
     * @param  string|string[]  $replace
     * @return static
     */
    public function replace($search, $replace)
    {
        return new static(Str::replace($search, $replace, $this->value));
    }

    /**
     * Метод преобразовывает русские символы в английские и обратно, аналог Punto switcher
     *
     * @param  int      $type Указывает в какую сторону преобразовывать (0: rus -> eng, 1: eng -> rus)
     * @return string   Возвращает преобразованную строку
     */
    public function switcher($type)
    {
        return new static(Str::switcher($this->value, $type));
    }


    /**
     * Метод преобразует специальные HTML-сущности обратно в соответствующие символы
     *
     * @param  array|null   $request  Массив с параметрами 
     *                      Возможные параметры: (type: тип (default, word), enter: разделитель строки (по умолчанию \n))
     * @return static       Возвращает строку где все специальные HTML-сущности преобразованы обратно в соответствующие символы
     */
    public function ee($request)
    {
        return new static(Str::ee($this->value, $request));
    }



    /**
     * Call the given callback and return a new string.
     *
     * @param callable $callback
     * @return static
     */
    public function pipe(callable $callback)
    {
        return new static(call_user_func($callback, $this));
    }




    /**
     * Prepend the given values to the string.
     *
     * @param  array  $values
     * @return static
     */
    public function prepend(...$values)
    {
        return new static(implode('', $values) . $this->value);
    }



    /**
     * Replace the patterns matching the given regular expression.
     *
     * @param  string  $pattern
     * @param  \Closure|string  $replace
     * @param  int  $limit
     * @return static
     */
    public function replaceMatches($pattern, $replace, $limit = -1)
    {
        if ($replace instanceof Closure) {
            return new static(preg_replace_callback($pattern, $replace, $this->value, $limit));
        }

        return new static(preg_replace($pattern, $replace, $this->value, $limit));
    }




    /**
     * Left trim the string of the given characters.
     *
     * @param  string  $characters
     * @return static
     */
    public function ltrim($characters = null)
    {
        return new static(ltrim(...array_merge([$this->value], func_get_args())));
    }

    /**
     * Right trim the string of the given characters.
     *
     * @param  string  $characters
     * @return static
     */
    public function rtrim($characters = null)
    {
        return new static(rtrim(...array_merge([$this->value], func_get_args())));
    }

    /**
     * Apply the callback's string changes if the given "value" is true.
     *
     * @param  mixed  $value
     * @param  callable  $callback
     * @param  callable|null  $default
     * @return mixed|$this
     */
    public function when($value, $callback, $default = null)
    {
        if ($value) {
            return $callback($this, $value) ?: $this;
        } elseif ($default) {
            return $default($this, $value) ?: $this;
        }

        return $this;
    }

    /**
     * Execute the given callback if the string is empty.
     *
     * @param  callable  $callback
     * @return static
     */
    public function whenEmpty($callback)
    {
        if ($this->isEmpty()) {
            $result = $callback($this);

            return is_null($result) ? $this : $result;
        }

        return $this;
    }




    /**
     * Convert the object to a string when JSON encoded.
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->__toString();
    }

    /**
     * Proxy dynamic properties onto methods.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->{$key}();
    }

    /**
     * Get the raw string value.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }
}
