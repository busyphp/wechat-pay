<?php

namespace BusyPHP\wechat\pay\mini;

use BusyPHP\wechat\pay\WeChatPayNotify;
use BusyPHP\wechat\pay\WeChatPayQueryOrder;

/**
 * 小程序支付下单异步通知处理
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:56 WeChatMiniPayNotify.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/wxa/wxa_api.php?chapter=9_7&index=8
 */
class WeChatMiniPayNotify extends WeChatPayNotify
{
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'mini';
    }
    
    
    /**
     * 获取订单查询类
     * @return WeChatPayQueryOrder
     */
    protected function getQuery() : WeChatPayQueryOrder
    {
        return new WeChatMiniPayQueryOrder();
    }
}