<?php

namespace BusyPHP\wechat\pay\js;

use BusyPHP\helper\StringHelper;
use BusyPHP\wechat\pay\WeChatPayCreate;
use BusyPHP\wechat\pay\WeChatPayException;

/**
 * 微信JS SDK 支付下单
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:42 WeChatJSPayCreate.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_1
 */
class WeChatJSPayCreate extends WeChatPayCreate
{
    protected $tradeType  = 'JSAPI';
    
    protected $deviceInfo = 'WEB';
    
    
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'js';
    }
    
    
    /**
     * 设置用户Openid
     * @param string $openid
     */
    public function setOpenid(string $openid)
    {
        $this->params['openid'] = $openid;
    }
    
    
    /**
     * 执行下单
     * @return array
     * @throws WeChatPayException
     */
    public function create()
    {
        $this->params['openid'] = $this->params['openid'] ?? '';
        if (!$this->params['openid']) {
            $this->params['openid'] = defined('WECHAT_OPENID') ? WECHAT_OPENID : '';
        }
        
        $result = parent::create();
        
        // 构造签名参数
        $params = [
            'appId'     => $result['appid'],
            'nonceStr'  => StringHelper::random(32),
            'timeStamp' => trim(time()),
            'package'   => "prepay_id={$result['prepay_id']}",
            'signType'  => 'MD5',
        ];
        
        $params['paySign'] = self::sign(self::temp($params, 'sign'), $this->payKey);
        
        return $params;
    }
}