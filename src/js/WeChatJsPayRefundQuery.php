<?php

namespace BusyPHP\wechat\pay\js;

use BusyPHP\wechat\pay\WeChatPayRefundQuery;

/**
 * 查询退款
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/10 下午9:53 WeChatJsPayRefundQuery.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_5&index=5
 */
class WeChatJsPayRefundQuery extends WeChatPayRefundQuery
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