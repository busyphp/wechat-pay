<?php

namespace BusyPHP\wechat\pay\js;

use BusyPHP\wechat\pay\WeChatPayQueryOrder;

/**
 * 微信JSSDK支付查询订单接口
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:48 WeChatJSPayQueryOrder.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_2
 */
class WeChatJSPayQueryOrder extends WeChatPayQueryOrder
{
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'js';
    }
}