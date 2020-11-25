<?php

namespace BusyPHP\wechat\pay\native;

use BusyPHP\wechat\pay\js\WeChatJSPayRefund;

/**
 * 微信Native支付退款
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2019 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2020/7/8 下午7:21 下午 WeChatNativePayRefund.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_4
 */
class WeChatNativePayRefund extends WeChatJSPayRefund
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