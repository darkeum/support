<?php

/*
* @name        JMY CORE
* @link        https://jmy.su/
* @copyright   Copyright (C) 2012-2021 JMY LTD
* @license     LICENSE.txt (see attached file)
* @version     VERSION.txt (see attached file)
* @author      Komarov Ivan & Volkov Aleksandr
* @description Helpers public function
*/

//подключение всех вспомогательных функций
foreach (glob(ROOT . 'boot/Support/Helpers/*.helpers.php') as $listed) {
    if (file_exists($listed) && is_file($listed)) {
        require_once($listed);
    }
}

if (!function_exists('ee')) {
    /**
     * Функция преобразует специальные HTML-сущности обратно в соответствующие символы
     *
     * @param  string       $value Исходная строка
     * @param  array|null   $request  Массив с параметрами 
     *                      Возможные параметры: (type: тип (default, word), enter: разделитель строки (по умолчанию \n))
     * @return string       Возвращает строку где все специальные HTML-сущности преобразованы обратно в соответствующие символы
     */
    function ee($value, $request = [])
    {
        return \Darkeum\Support\Str::ee($value, $request);
    }
}

if (!function_exists('env')) {
    /**
     * Функция получает значение из среды окружения (environment)
     *
     * @param  string  $key Ключ параметра
     * @param  mixed   $default Значение по умолчанию
     * @return mixed   Возвращает найденное по ключу значение, иначе возвращает $default
     */
    function env($key, $default = null)
    {
        return \Darkeum\Support\Env::get($key, $default);
    }
}
