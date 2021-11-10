<?php

namespace BusyPHP\wechat\pay;

/**
 * 微信支付查询订单接口
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:45 WeChatPayQueryOrder.php $
 */
abstract class WeChatPayQueryOrder extends WeChatPay
{
    protected $apiUrl = 'https://api.mch.weixin.qq.com/pay/orderquery';
    
    
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
        
        return parent::request();
    }
}