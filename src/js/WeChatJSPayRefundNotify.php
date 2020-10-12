<?php

namespace BusyPHP\wechat\pay\js;

use BusyPHP\trade\interfaces\PayRefundNotify;
use BusyPHP\trade\interfaces\PayRefundNotifyResult;
use BusyPHP\wechat\pay\WeChatPay;
use BusyPHP\wechat\pay\WeChatPayException;
use think\Response;
use Throwable;

/**
 * 微信H5支付退款异步通知处理类
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2019 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2020/7/8 下午7:24 下午 WeChatJSPayRefundNotify.php $
 * @see https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_16&index=10
 */
class WeChatJSPayRefundNotify extends WeChatPay implements PayRefundNotify
{
    private $requestString;
    
    private $requestParams;
    
    private $refundNo;
    
    private $reqInfo;
    
    
    /**
     * 获取配置名称
     * @return string
     */
    protected function getConfigKey()
    {
        return 'js';
    }
    
    
    /**
     * WeChatH5PayRefundNotify constructor.
     * @throws WeChatPayException
     */
    public function __construct()
    {
        parent::__construct();
        
        $key                 = strtolower(md5($this->payKey));
        $xml                 = $GLOBALS['HTTP_RAW_POST_DATA'];
        $this->requestString = $xml . ', KEY: ' . $key;
        $this->requestParams = self::xmlToArray($xml);
        $this->refundNo      = $this->requestParams['out_trade_no'];
        
        
        // 执行aes-256-ecb解密
        $reqInfo = $this->requestParams['req_info'];
        $reqInfo = base64_decode($reqInfo);
        
        $reqInfo        = openssl_decrypt($reqInfo, 'aes-256-ecb', $key, OPENSSL_RAW_DATA);
        $reqInfo        = self::xmlToArray($reqInfo);
        $this->reqInfo  = $reqInfo;
        $this->refundNo = $this->reqInfo['out_refund_no'];
        if (!$this->reqInfo) {
            throw new WeChatPayException('无法解密reqInfo');
        }
    }
    
    
    /**
     * 执行校验
     * @return PayRefundNotifyResult
     */
    public function notify() : PayRefundNotifyResult
    {
        $res = new PayRefundNotifyResult();
        $res->setPayTradeNo($this->reqInfo['out_trade_no']);
        $res->setRefundTradeNo($this->refundNo);
        $res->setApiRefundTradeNo($this->reqInfo['refund_id']);
        $res->setRefundPrice($this->reqInfo['refund_fee'] / 100);
        $res->setRefundAccount($this->reqInfo['refund_recv_accout']);
        $res->setPrice($this->reqInfo['total_fee'] / 100);
        $res->setApiPayTradeNo($this->reqInfo['transaction_id']);
        $res->setStatus(true);
        
        if ($this->reqInfo['refund_status'] != 'SUCCESS') {
            $res->setStatus(false);
            $res->setErrMsg($this->reqInfo['refund_status'] == 'REFUNDCLOSE' ? '退款关闭' : '退款异常');
        } else {
            $res->setSuccessTime(strtotime($this->reqInfo['success_time']));
        }
        
        return $res;
    }
    
    
    /**
     * 失败通知
     * @param Throwable $e
     * @return Response
     * @throws WeChatPayException
     */
    public function onError(Throwable $e) : Response
    {
        return Response::create(static::arrayToXml([
            'return_code' => 'FAIL',
            'return_msg'  => $e->getMessage()
        ]))->contentType('text/plain');
    }
    
    
    /**
     * 成功通知
     * @param string $message
     * @return Response
     * @throws WeChatPayException
     */
    public function onSuccess($message = '') : Response
    {
        return Response::create(static::arrayToXml([
            'return_code' => 'SUCCESS',
            'return_msg'  => 'OK'
        ]))->contentType('text/plain');
    }
    
    
    /**
     * 获取请求参数
     * @return array
     */
    public function getRequestParams()
    {
        return $this->requestParams;
    }
    
    
    /**
     * 获取请求参数字符
     * @return string
     */
    public function getRequestString()
    {
        return $this->requestString;
    }
    
    
    /**
     * 获取退款单号
     * @return string
     */
    public function getRefundTradeNo()
    {
        return $this->refundNo;
    }
}