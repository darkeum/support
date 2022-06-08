<?php

/*
* @name        JMY CORE
* @link        https://jmy.su/
* @copyright   Copyright (C) 2012-2021 JMY LTD
* @license     LICENSE.txt (see attached file)
* @version     VERSION.txt (see attached file)
* @author      Komarov Ivan & Volkov Aleksandr
* @description Module Helper class
*/

namespace Darkeum\Support;

use \Darkeum\System\Cache\Cache;
use \Organizations\Model\Org;
use \Darkeum\Support\Facades\Config;

class Module
{
    /**
     * Получение данных модуля из конфигурации 
     *
     * @param  string  $module Имя модуля
     * @return array   Массив с данными модуля
     */
    protected static function getModuleInfo($module)
    {
        $config = Config::get('module');
        if (isset($config[$module])) {
            $mc = $config[$module];
            return [
                'prefix' => $mc['prefix'],
                'database' => $mc['database'],
                'model' => $mc['model'] ?? null,
                'datefield' => $mc['datefield'] ?? 'date',
                'datetype' => $mc['datetype'] ?? 'datetime',
            ];
        } else {
            throw new \Exception('Модуль не зарегистрирован');
        }
    }

    /**
     * Получение префикса организации
     *
     * @param  int      $org ID организации
     * @return string   Префикс организации
     */
    protected static function getOrgPrefix($org)
    {
        $cache = new Cache;
        $op = $cache->getItem("org_prefix");
        if ($op->isHit()) {
            $org_prefix = $op->get();
        } else {
            $org_prefix = [];
            foreach (Org::all() as $item) {
                $org_prefix[$item->id] = $item->prefix;
            }
            $op->set($org_prefix);
            $op->expiresAfter(43200);
            $cache->save($op);
        }
        if(isset($org_prefix[$org])){
            return $org_prefix[$org];
        } else {
            throw new \Exception('Организация не найдена');
        }
       
    }

    /**
     * Получение префикса модуля
     *
     * @param  string  $module Имя модуля
     * @return string  Префикс модуля
     */
    public static function clearPrefix($module)
    {
        return static::getModuleInfo($module)['prefix'];
    }

    /**
     * Получение основной модели модуля
     *
     * @param  string  $module Имя модуля
     * @return \Boot\System\Database\Model\Model Возвращает основную модель модуля
     */
    public static function model($module)
    {
        return static::getModuleInfo($module)['model'];
    }

    /**
     * Получение основной базы данных модуля
     *
     * @param  string  $module Имя модуля
     * @return string  Возвращет имя основной базы данных модуля
     */
    public static function database($module)
    {
        return static::getModuleInfo($module)['database'];
    }

    /**
     * Получение префикса модуля с учетом организации
     *
     * @param  string   $module Имя модуля
     * @param  int      $org ID организации
     * @return string   Возвращет префикс модуля с учетом организации
     */
    public static function prefix($module, $org)
    {
        return static::getOrgPrefix($org) . static::clearPrefix($module);
    }

    /**
     * Получение префикса модуля с учетом организации и id
     *
     * @param  string   $module Имя модуля
     * @param  int      $id ID записи
     * @param  int      $org ID организации
     * @return string   Возвращет префикс модуля с учетом организации и id
     */
    public static function prefixWithId($module, $id, $org)
    {
        return static::prefix($module, $org) . '-' . $id;
    }

    /**
     * Получение номера документа с учетом ежегодного обнуления
     *
     * @param  string   $module Имя модуля
     * @param  int      $org ID организации
     * @param  string   $date Дата новой записи
     * @return array    Возвращет массив с счетчиком, префиксом и полным номером документа с учетом указанной даты
     */
    public static function numb($module, $org, $date)
    {
        $m = static::getModuleInfo($module);

        $currentYear = date('Y', strtotime($date));

        $prepareFrom   = $currentYear . '-01-01 00:00:00';
        $prepareTo     = $currentYear . '-12-31 23:59:59';

        switch ($m['datetype']) {
            case 'datetime':
                $from = $prepareFrom;
                $to = $prepareTo;
                break;

            case 'date':
                $from = date('Y-m-d', strtotime($prepareFrom));
                $to = date('Y-m-d', strtotime($prepareTo));
                break;

            case 'timestamp':
                $from = strtotime($prepareFrom);
                $to = strtotime($prepareTo);
                break;

            default:
                throw new \Exception('Неизвестный формат даты');
                break;
        }

        $lastCounter = $m['model']::where('org', $org)->whereBetween($m['datefield'], [$from, $to])->max('numb_counter');

        if (is_numeric($lastCounter)) {
            $currentCounter = $lastCounter + 1;
        } else {
            $currentCounter = 1;
        }

        $prefix = static::prefix($module, $org);
        $numb = $prefix . '-' . $currentCounter;

        return [
            'numb' => $numb,
            'numb_counter' => $currentCounter,
            'prefix' => $prefix,
        ];
    }
}
