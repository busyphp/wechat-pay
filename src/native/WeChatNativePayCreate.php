<?php

namespace BusyPHP\wechat\pay\native;

use BusyPHP\wechat\pay\WeChatPayCreate;
use BusyPHP\wechat\pay\WeChatPayException;

/**
 * 微信扫码支付下单
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:42 WeChatNativePayCreate.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_1
 */
class WeChatNativePayCreate extends WeChatPayCreate
{
    protected $tradeType  = 'NATIVE';
    
    protected $deviceInfo = 'WEB';
    
    
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'native';
    }
    
    
    /**
     * 执行下单
     * @return string 需要生成二维码的内容
     * @throws WeChatPayException
     */
    public function create()
    {
        $this->params['product_id'] = $this->params['out_trade_no'];
        $result                     = parent::create();
        
        return $result['code_url'];
    }
}
