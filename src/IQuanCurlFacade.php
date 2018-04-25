<?php
/**
 *-----------------------------------------
 * Class IQuanCurlFacade
 * Author  ClovisiQuan
 * Date: 2018/04/25
 * Time: 11:30
 *-----------------------------------------
 *
 *-----------------------------------------
 */

namespace IQuanCurl;


use Overtrue\LaravelWeChat\Facade;

class IQuanCurlFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'iquancurl';
    }
}