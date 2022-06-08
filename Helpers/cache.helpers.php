<?php

/*
* @name        JMY CORE
* @link        https://jmy.su/
* @copyright   Copyright (C) 2012-2021 JMY LTD
* @license     LICENSE.txt (see attached file)
* @version     VERSION.txt (see attached file)
* @author      Komarov Ivan & Volkov Aleksander
* @description Cache helper function 
*/


if (!function_exists('hasCache')) {
    /**
     * Проверка наличия кэша по ключу
     *
     * @param  string  $key Ключ кэша
     * @return bool    Возвращает true если кэш найден, иначе false
     */
    function hasCache($key)
    {
        return \Darkeum\Support\Cache::has($key);
    }
}

if (!function_exists('getCache')) {
    /**
     * Получение кэша по ключу
     *
     * @param  string               $key Ключ кэша
     * @return string|array|bool    Возвращает значение ключа кэша, если данного ключа нет возвращает false
     */
    function getCache($key)
    {
        return \Darkeum\Support\Cache::get($key);
    }
}

if (!function_exists('setCache')) {
    /**
     * Создание кэша
     *
     * @param  string               $key Ключ кэша
     * @param  string|array         $value Значение кэша
     * @param  int|null             $expires Время действия кэша, если null (по умолчанию) то без ограничения по времени
     * @return string|array|bool    Возвращает значение записанного кэша
     */
    function setCache($key, $value, $expires = null)
    {
        return \Darkeum\Support\Cache::set($key, $value, $expires);
    }
}

if (!function_exists('delCache')) {
    /**
     * Удаление кэша
     *
     * @param  string  $key Ключ кэша
     * @return bool    Возвращает true если удалено успешно, иначе false записанного кэша
     */
    function delCache($key)
    {
        return \Darkeum\Support\Cache::del($key);
    }
}

if (!function_exists('clearCache')) {
    /**
     * Очистить все ключи кеша
     *     
     * @return bool  Возвращает true если удалено успешно, иначе false записанного кэша
     */
    function clearCache()
    {
        return \Darkeum\Support\Cache::clear();
    }
}
