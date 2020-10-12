<?php

namespace BusyPHP\wechat\pay\app;


use BusyPHP\wechat\pay\js\WeChatJSPayQueryOrder;

/**
 * 微信APP支付查询订单接口
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2019 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2020/7/8 下午7:37 下午 WeChatAppPayQueryOrder.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_7&index=3
 */
class WeChatAppPayQueryOrder extends WeChatJSPayQueryOrder
{
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'app';
    }
}