<?php

namespace BusyPHP\wechat\pay\native;


use BusyPHP\wechat\pay\js\WeChatJSPayQueryOrder;

/**
 * 微信Native支付查询订单接口
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2019 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2020/7/8 下午7:32 下午 WeChatNativePayQueryOrder.php $
 */
class WeChatNativePayQueryOrder extends WeChatJSPayQueryOrder
{
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'native';
    }
}