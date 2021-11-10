<?php

namespace BusyPHP\wechat\pay;

use BusyPHP\helper\HttpHelper;
use BusyPHP\trade\interfaces\PayRefund;
use BusyPHP\trade\interfaces\PayRefundResult;
use BusyPHP\trade\model\refund\TradeRefundInfo;

/**
 * 退款
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:58 WeChatPayRefund.php $
 */
abstract class WeChatPayRefund extends WeChatPay implements PayRefund
{
    protected $apiUrl = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
    
    
    /**
     * 设置平台退款订单数据对象
     * @param TradeRefundInfo $info
     */
    public function setTradeRefundInfo(TradeRefundInfo $info)
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
    public function setNotifyUrl(string $notifyUrl)
    {
        $this->params['notify_url'] = $notifyUrl;
    }
    
    
    /**
     * 执行退款
     * @return PayRefundResult
     * @throws WeChatPayException
     */
    public function refund() : PayRefundResult
    {
        $http = new HttpHelper();
        $http->setOpt(CURLOPT_SSLCERT, $this->sslCertPath);
        $http->setOpt(CURLOPT_SSLKEY, $this->sslKeyPath);
        $http->setOpt(CURLOPT_CAINFO, $this->caCertPath);
        
        $result = parent::request($http);
        
        $res = new PayRefundResult();
        $res->setApiRefundNo($result['refund_id']);
        
        return $res;
    }
}