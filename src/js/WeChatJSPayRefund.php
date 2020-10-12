<?php

namespace BusyPHP\wechat\pay\js;

use BusyPHP\helper\net\Http;
use BusyPHP\helper\util\Str;
use BusyPHP\trade\interfaces\PayRefund;
use BusyPHP\trade\interfaces\PayRefundResult;
use BusyPHP\trade\model\pay\TradePayField;
use BusyPHP\wechat\pay\WeChatPayException;
use BusyPHP\wechat\pay\WeChatPay;

/**
 * JSSDK 支付退款
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2019 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2020/7/8 下午7:21 下午 WeChatJSPayRefund.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_4
 */
class WeChatJSPayRefund extends WeChatPay implements PayRefund
{
    /**
     * 密钥
     * @var string
     */
    protected $secret;
    
    protected $apiUrl = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
    
    
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'js';
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
     * 设置平台交易订单数据对象
     * @param TradePayField $info
     */
    public function setTradeInfo(TradePayField $info)
    {
        $this->params['out_trade_no']   = $info->payTradeNo;
        $this->params['transaction_id'] = $info->apiTradeNo;
        $this->params['total_fee']      = intval($info->apiPrice * 100);
    }
    
    
    /**
     * 设置退款单号
     * @param string $refundNo
     */
    public function setRefundTradeNo($refundNo)
    {
        $this->params['out_refund_no'] = trim($refundNo);
    }
    
    
    /**
     * 设置要申请退款的金额
     * @param float $refundPrice 精确到小数点2位
     */
    public function setRefundPrice($refundPrice)
    {
        $this->params['refund_fee'] = intval($refundPrice * 100);
    }
    
    
    /**
     * 设置退款原因
     * @param string $reason
     */
    public function setRefundReason($reason)
    {
        $this->params['refund_desc'] = trim($reason);
    }
    
    
    /**
     * 设置退款结果通知url
     * @param string $notifyUrl
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->params['notify_url'] = trim($notifyUrl);
    }
    
    
    /**
     * 执行退款
     * @return PayRefundResult
     * @throws WeChatPayException
     */
    public function refund() : PayRefundResult
    {
        $this->params['nonce_str'] = Str::random(32);
        $this->params['sign_type'] = 'MD5';
        $this->params['sign']      = static::createSign(static::createSignTemp($this->params, 'sign'), $this->secret);
        
        $http = new Http();
        $http->setOpt(CURLOPT_SSLCERT, $this->sslCertPath);
        $http->setOpt(CURLOPT_SSLKEY, $this->sslKeyPath);
        $http->setOpt(CURLOPT_CAINFO, $this->caCertPath);
        
        $result = parent::request($http);
        
        $res = new PayRefundResult();
        $res->setRefundTradeNo($result['out_refund_no']);
        $res->setApiPayTradeNo($result['transaction_id']);
        $res->setPayTradeNo($result['out_trade_no']);
        $res->setRefundPrice($result['refund_fee'] / 100);
        $res->setApiRefundTradeNo($result['refund_id']);
        
        
        return $res;
    }
}