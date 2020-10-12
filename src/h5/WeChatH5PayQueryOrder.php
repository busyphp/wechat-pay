<?php

namespace BusyPHP\wechat\pay\h5;

use BusyPHP\wechat\pay\js\WeChatJSPayQueryOrder;

/**
 * 微信APP支付查询订单接口
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2019 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2020/7/8 下午7:11 下午 WeChatH5PayQueryOrder.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_2
 */
class WeChatH5PayQueryOrder extends WeChatJSPayQueryOrder
{
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'h5';
    }
}