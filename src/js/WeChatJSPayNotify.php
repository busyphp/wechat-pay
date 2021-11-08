<?php

namespace BusyPHP\wechat\pay\js;

use BusyPHP\wechat\pay\WeChatPayNotify;
use BusyPHP\wechat\pay\WeChatPayQueryOrder;

/**
 * JS SDK 支付下单异步通知处理
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:55 WeChatJSPayNotify.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_7&index=8
 */
class WeChatJSPayNotify extends WeChatPayNotify
{
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'js';
    }
    
    
    /**
     * 获取订单查询类
     * @return WeChatPayQueryOrder
     */
    protected function getQuery() : WeChatPayQueryOrder
    {
        return new WeChatJSPayQueryOrder();
    }
}