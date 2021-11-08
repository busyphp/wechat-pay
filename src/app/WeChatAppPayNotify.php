<?php

namespace BusyPHP\wechat\pay\app;

use BusyPHP\wechat\pay\WeChatPayNotify;
use BusyPHP\wechat\pay\WeChatPayQueryOrder;

/**
 * APP支付下单异步通知处理
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:53 WeChatAppPayNotify.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_7&index=3
 */
class WeChatAppPayNotify extends WeChatPayNotify
{
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'app';
    }
    
    
    /**
     * 获取订单查询类
     * @return WeChatPayQueryOrder
     */
    protected function getQuery() : WeChatPayQueryOrder
    {
        return new WeChatAppPayQueryOrder();
    }
}