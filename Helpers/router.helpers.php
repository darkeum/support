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

 

if (!function_exists('router')) {

    function router($name, $params = null)
    {
       return route($name, $params);
    }
}
