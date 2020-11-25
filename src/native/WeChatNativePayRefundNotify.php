<?php

namespace BusyPHP\wechat\pay\native;

use BusyPHP\wechat\pay\js\WeChatJSPayRefundNotify;

/**
 * 微信Native退款异步通知处理类
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2019 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2020/7/8 下午7:24 下午 WeChatNativePayRefundNotify.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_16&index=11
 */
class WeChatNativePayRefundNotify extends WeChatJSPayRefundNotify
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