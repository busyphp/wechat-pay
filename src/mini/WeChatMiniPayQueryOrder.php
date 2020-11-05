<?php

namespace BusyPHP\wechat\pay\mini;

use BusyPHP\helper\util\Str;
use BusyPHP\wechat\pay\WeChatPay;
use BusyPHP\wechat\pay\WeChatPayException;


/**
 * 微信支付查询订单接口
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2019 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2020/7/8 下午7:20 下午 WeChatJSPayQueryOrder.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/wxa/wxa_api.php?chapter=9_2
 */
class WeChatMiniPayQueryOrder extends WeChatPay
{
    /**
     * 密钥
     * @var string
     */
    protected $secret;
    
    protected $apiUrl = 'https://api.mch.weixin.qq.com/pay/orderquery';
    
    
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'mini';
    }
    
    
    /**
     * 实例化
     * WeChatPayQueryOrder constructor.
     * @throws WeChatPayException
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->params['appid']  = $this->appId;
        $this->params['mch_id'] = $this->mchId;
        $this->secret           = $this->payKey;
    }
    
    
    /**
     * 设置支付订单号
     * @param string $payTradeNo
     */
    public function setPayTradeNo($payTradeNo)
    {
        $this->params['transaction_id'] = trim($payTradeNo);
    }
    
    
    /**
     * 设置商户订单号
     * @param string $tradeNo
     */
    public function setTradeNo($tradeNo)
    {
        $this->params['out_trade_no'] = trim($tradeNo);
    }
    
    
    /**
     * 执行查询
     * @return array
     * @throws WeChatPayException
     */
    public function request()
    {
        if (!$this->params['transaction_id'] && !$this->params['out_trade_no']) {
            throw new WeChatPayException('查询交易号不能为空');
        }
        
        $this->params['nonce_str'] = Str::random(32);
        $this->params['sign_type'] = 'MD5';
        $this->params['sign']      = static::createSign(static::createSignTemp($this->params, 'sign'), $this->secret);
        
        return parent::request();
    }
}