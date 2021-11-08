<?php

namespace BusyPHP\wechat\pay;

use RuntimeException;
use Throwable;

/**
 * 微信支付异常处理类
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:08 WeChatPayException.php $
 */
class WeChatPayException extends RuntimeException
{
    private static $errors = [
        'NOAUTH'                => '商户无此接口权限',
        'SYSTEMERROR'           => '接口返回错误,系统超时等',
        'BIZERR_NEED_RETRY'     => '退款业务流程错误',
        'TRADE_OVERDUE'         => '订单已经超过可退款的最大期限(支付后一年内可退款), 请选择其他方式自行退款',
        'ERROR'                 => '业务错误',
        'USER_ACCOUNT_ABNORMAL' => '退款请求失败，商户可自行处理退款。',
        'INVALID_REQ_TOO_MUCH'  => '无效请求过多，连续错误请求数过多被系统短暂屏蔽',
        'NOTENOUGH'             => '余额不足',
        'INVALID_TRANSACTIONID' => '无效transaction_id，请求参数错误，检查原交易号是否存在或发起支付交易接口返回失败',
        'PARAM_ERROR'           => '参数错误',
        'APPID_NOT_EXIST'       => '请检查APPID是否正确',
        'MCHID_NOT_EXIST'       => '请检查MCHID是否正确',
        'REQUIRE_POST_METHOD'   => '请使用post方法',
        'SIGNERROR'             => '签名错误',
        'XML_FORMAT_ERROR'      => 'XML格式错误',
        'FREQUENCY_LIMITED'     => '2个月之前的订单申请退款有频率限制，请降低频率后重试',
        'ORDERPAID'             => '商户订单已支付，无需重复操作',
        'ORDERCLOSED'           => '当前订单已关闭，请重新下单',
        'APPID_MCHID_NOT_MATCH' => 'appid和mch_id不匹配',
        'LACK_PARAMS'           => '缺少必要的请求参数',
        'OUT_TRADE_NO_USED'     => '商户订单号重复, 同一笔交易不能多次提交',
        'POST_DATA_EMPTY'       => 'post数据为空',
        'NOT_UTF8'              => '编码格式错误',
        'ORDERNOTEXIST'         => '此交易订单号不存在',
        'REFUNDNOTEXIST'        => '退款订单查询失败',
    ];
    
    /**
     * @var string
     */
    private $errCode;
    
    
    public function __construct($message, string $errCode = '', int $code = 0, Throwable $previous = null)
    {
        $error         = self::$errors[$errCode] ?? '';
        $message       = $error ?: $message;
        $this->errCode = $errCode;
        
        parent::__construct($message, $code, $previous);
    }
    
    
    /**
     * @return string
     */
    public function getErrCode() : string
    {
        return $this->errCode;
    }
}