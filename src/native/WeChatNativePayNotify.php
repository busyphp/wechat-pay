<?php

namespace BusyPHP\wechat\pay\native;

use BusyPHP\wechat\pay\WeChatPayNotify;
use BusyPHP\wechat\pay\WeChatPayQueryOrder;

/**
 * 微信Native支付下单异步通知处理
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:57 WeChatNativePayNotify.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_7&index=8
 */
class WeChatNativePayNotify extends WeChatPayNotify
{
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'native';
    }
    
    
    /**
     * 获取订单查询类
     * @return WeChatPayQueryOrder
     */
    protected function getQuery() : WeChatPayQueryOrder
    {
        return new WeChatNativePayQueryOrder();
    }
}