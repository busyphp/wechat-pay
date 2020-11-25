<?php

namespace BusyPHP\wechat\pay\js;

use BusyPHP\helper\net\Http;
use BusyPHP\helper\util\Str;
use BusyPHP\trade\interfaces\PayRefund;
use BusyPHP\trade\interfaces\PayRefundResult;
use BusyPHP\trade\model\refund\TradeRefundField;
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
    protected $apiUrl = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
    
    
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
    }
    
    
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'js';
    }
    
    
    /**
     * 设置平台退款订单数据对象
     * @param TradeRefundField $info
     */
    public function setTradeRefundInfo(TradeRefundField $info)
    {
        $this->params['out_refund_no']  = $info->refundNo;
        $this->params['out_trade_no']   = $info->payTradeNo;
        $this->params['transaction_id'] = $info->payApiTradeNo;
        $this->params['total_fee']      = intval($info->payPrice * 100);
        $this->params['refund_fee']     = intval($info->refundPrice * 100);
        $this->params['refund_desc']    = $info->remark;
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
        $this->params['sign']      = static::createSign(static::createSignTemp($this->params, 'sign'), $this->payKey);
        
        $http = new Http();
        $http->setOpt(CURLOPT_SSLCERT, $this->sslCertPath);
        $http->setOpt(CURLOPT_SSLKEY, $this->sslKeyPath);
        $http->setOpt(CURLOPT_CAINFO, $this->caCertPath);
        
        $result = parent::request($http);
        
        $res = new PayRefundResult();
        $res->setApiRefundTradeNo($result['refund_id']);
        
        return $res;
    }
}