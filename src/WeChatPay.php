<?php

namespace BusyPHP\wechat\pay;

use BusyPHP\App;
use BusyPHP\helper\HttpHelper;
use BusyPHP\helper\StringHelper;
use BusyPHP\Request;
use BusyPHP\trade\defines\PayType;
use BusyPHP\wechat\pay\app\WeChatAppPayCreate;
use BusyPHP\wechat\pay\app\WeChatAppPayNotify;
use BusyPHP\wechat\pay\app\WeChatAppPayRefund;
use BusyPHP\wechat\pay\app\WeChatAppPayRefundNotify;
use BusyPHP\wechat\pay\app\WeChatAppPayRefundQuery;
use BusyPHP\wechat\pay\h5\WeChatH5PayCreate;
use BusyPHP\wechat\pay\h5\WeChatH5PayNotify;
use BusyPHP\wechat\pay\h5\WeChatH5PayRefund;
use BusyPHP\wechat\pay\h5\WeChatH5PayRefundNotify;
use BusyPHP\wechat\pay\h5\WeChatH5PayRefundQuery;
use BusyPHP\wechat\pay\js\WeChatJSPayCreate;
use BusyPHP\wechat\pay\js\WeChatJSPayNotify;
use BusyPHP\wechat\pay\js\WeChatJSPayRefund;
use BusyPHP\wechat\pay\js\WeChatJSPayRefundNotify;
use BusyPHP\wechat\pay\js\WeChatJsPayRefundQuery;
use BusyPHP\wechat\pay\mini\WeChatMiniPayCreate;
use BusyPHP\wechat\pay\mini\WeChatMiniPayNotify;
use BusyPHP\wechat\pay\mini\WeChatMiniPayRefund;
use BusyPHP\wechat\pay\mini\WeChatMiniPayRefundNotify;
use BusyPHP\wechat\pay\mini\WeChatMiniPayRefundQuery;
use BusyPHP\wechat\pay\native\WeChatNativePayCreate;
use BusyPHP\wechat\pay\native\WeChatNativePayNotify;
use BusyPHP\wechat\pay\native\WeChatNativePayRefund;
use BusyPHP\wechat\pay\native\WeChatNativePayRefundNotify;
use BusyPHP\wechat\pay\native\WeChatNativePayRefundQuery;
use BusyPHP\wechat\WithWeChatConfig;
use Throwable;

/**
 * 微信支付基本类
 * @author busy^life <busy.life@qq.com>
 * @copyright (c) 2015--2021 ShanXi Han Tuo Technology Co.,Ltd. All rights reserved.
 * @version $Id: 2021/11/9 上午12:07 WeChatPay.php $
 */
abstract class WeChatPay
{
    use WithWeChatConfig;
    
    /**
     * 请求地址
     * @var string
     */
    protected $apiUrl = '';
    
    /**
     * 请求参数
     * @var array
     */
    protected $params = [];
    
    /**
     * App ID
     * @var string
     */
    protected $appId;
    
    /**
     * App Key
     * @var string
     */
    protected $payKey;
    
    /**
     * 商户号
     * @var string
     */
    protected $mchId;
    
    /**
     * 公钥证书路径
     * @var string
     */
    protected $sslCertPath;
    
    /**
     * 私钥证书路径
     * @var string
     */
    protected $sslKeyPath;
    
    /**
     * ca证书路径
     * @var string
     */
    protected $caCertPath;
    
    /**
     * 支付类型
     * @var string
     */
    protected $type;
    
    /**
     * @var App
     */
    protected $app;
    
    /**
     * @var Request
     */
    protected $request;
    
    
    /**
     * WeChatPay constructor.
     * @throws WeChatPayException
     */
    public function __construct()
    {
        $name = "pay.{$this->getConfigKey()}.";
        
        $this->app         = App::getInstance();
        $this->request     = $this->app->request;
        $this->appId       = $this->getWeChatConfig($name . 'app_id', '');
        $this->payKey      = $this->getWeChatConfig($name . 'pay_key', '');
        $this->mchId       = $this->getWeChatConfig($name . 'mch_id', '');
        $this->sslCertPath = $this->getWeChatConfig($name . 'ssl_cert_path', '');
        $this->sslKeyPath  = $this->getWeChatConfig($name . 'ssl_key_path', '');
        $this->caCertPath  = $this->getWeChatConfig($name . 'ca_cert_path', '');
        $this->type        = $this->getWeChatConfig($name . 'type', '');
        
        if (!$this->appId) {
            throw new WeChatPayException('没有配置参数: app_id');
        }
        if (!$this->payKey) {
            throw new WeChatPayException('没有配置参数: pay_key');
        }
        if (!$this->mchId) {
            throw new WeChatPayException('没有配置参数: mch_id');
        }
        if (!is_file($this->sslCertPath)) {
            throw new WeChatPayException('没有配置参数或文件不存在: ssl_cert_path');
        }
        if (!is_file($this->sslKeyPath)) {
            throw new WeChatPayException('没有配置参数或文件不存在: ssl_key_path');
        }
        if (!is_file($this->caCertPath)) {
            throw new WeChatPayException('没有配置参数或文件不存在: ca_cert_path');
        }
    }
    
    
    /**
     * 获取配置名称
     * @return string
     */
    protected abstract function getConfigKey();
    
    
    /**
     * 初始化参数
     */
    protected function initParams()
    {
        $this->params['appid']     = $this->appId;
        $this->params['mch_id']    = $this->mchId;
        $this->params['nonce_str'] = StringHelper::random(32);
        $this->params['sign_type'] = 'MD5';
        $this->params['sign']      = static::sign(static::temp($this->params, 'sign'), $this->payKey);
    }
    
    
    /**
     * 执行请求
     * @return array
     * @throws WeChatPayException
     */
    protected function request()
    {
        $this->initParams();
        
        $http = null;
        if (func_num_args() > 0) {
            $http = func_get_arg(0);
            if (!$http instanceof HttpHelper) {
                $http = null;
            }
        }
        
        try {
            $result = HttpHelper::postXML($this->apiUrl, static::arrayToXml($this->params), $http);
        } catch (Throwable $e) {
            throw new WeChatPayException("HTTP请求失败: {$e->getMessage()} [{$e->getCode()}]");
        }
        
        
        $result = static::xmlToArray($result);
        if ($result['return_code'] != 'SUCCESS') {
            throw new WeChatPayException($result['return_msg']);
        }
        
        
        if ($result['result_code'] != 'SUCCESS') {
            throw new WeChatPayException($result['err_code_des'], $result['err_code']);
        }
        
        
        return $result;
    }
    
    
    /**
     * 生成MD5密钥
     * @param string $temp 代签名字符串
     * @param string $secret 签名密钥
     * @return string
     */
    protected static function sign($temp, $secret)
    {
        return strtoupper(md5($temp . "&key={$secret}"));
    }
    
    
    /**
     * 将数组转换成XML格式的字符串
     * @param array $params 要转换的数组
     * @return string
     * @throws WeChatPayException
     */
    protected static function arrayToXml($params)
    {
        if (!is_array($params) || count($params) <= 0) {
            throw new WeChatPayException("数组数据异常！");
        }
        
        $xml = '';
        foreach ($params as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<{$key}>{$val}</{$key}>";
            } else {
                $xml .= "<{$key}><![CDATA[{$val}]]></{$key}>";
            }
        }
        
        return "<xml>{$xml}</xml>";
    }
    
    
    /**
     * 将xml转为array
     * @param string $xml 要转换的XML数据
     * @return array
     * @throws WeChatPayException
     */
    protected static function xmlToArray($xml)
    {
        if (!$xml) {
            throw new WeChatPayException("xml数据异常！");
        }
        
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }
    
    
    /**
     * 通用生成待参与运算的签名字符串
     * @param array        $params 待签名数据
     * @param string|array $filterKeys 要过滤的键名称，多个用逗号隔开
     * @return string 签名
     */
    protected static function temp($params, $filterKeys = '')
    {
        if (!is_array($filterKeys)) {
            $filterKeys = explode(',', $filterKeys);
        }
        $filter = array_map('trim', $filterKeys);
        $array  = [];
        foreach ($params as $key => $value) {
            if (in_array($key, $filter) || $value === '') {
                continue;
            }
            $array[$key] = $value;
        }
        
        ksort($array);
        reset($array);
        $query = [];
        foreach ($array as $key => $value) {
            $query[] = "{$key}={$value}";
        }
        
        return implode('&', $query);
    }
    
    
    /**
     * 获取微信公众号端接口配置
     * @param string $name 名称
     * @param string $alias 别名
     * @param int    $client 客户端类型
     * @return array
     */
    public static function js(?string $name = null, ?string $alias = null, ?int $client = null) : array
    {
        return [
            'name'          => $name ?? '微信公众号支付',
            'alias'         => $alias ?? '微信',
            'client'        => $client ?? PayType::CLIENT_WECHAT,
            'create'        => WeChatJSPayCreate::class,
            'notify'        => WeChatJSPayNotify::class,
            'refund'        => WeChatJSPayRefund::class,
            'refund_notify' => WeChatJSPayRefundNotify::class,
            'refund_query'  => WeChatJsPayRefundQuery::class,
        ];
    }
    
    
    /**
     * 获取微信H5端接口配置
     * @param string $name 名称
     * @param string $alias 别名
     * @param int    $client 客户端类型
     * @return array
     */
    public static function h5(?string $name = null, ?string $alias = null, ?int $client = null) : array
    {
        return [
            'name'          => $name ?? '微信H5支付',
            'alias'         => $alias ?? '微信',
            'client'        => $client ?? PayType::CLIENT_WECHAT,
            'create'        => WeChatH5PayCreate::class,
            'notify'        => WeChatH5PayNotify::class,
            'refund'        => WeChatH5PayRefund::class,
            'refund_notify' => WeChatH5PayRefundNotify::class,
            'refund_query'  => WeChatH5PayRefundQuery::class,
        ];
    }
    
    
    /**
     * 获取微信APP端接口配置
     * @param string $name 名称
     * @param string $alias 别名
     * @param int    $client 客户端类型
     * @return array
     */
    public static function app(?string $name = null, ?string $alias = null, ?int $client = null) : array
    {
        return [
            'name'          => $name ?? '微信APP支付',
            'alias'         => $alias ?? '微信',
            'client'        => $client ?? PayType::CLIENT_WECHAT,
            'create'        => WeChatAppPayCreate::class,
            'notify'        => WeChatAppPayNotify::class,
            'refund'        => WeChatAppPayRefund::class,
            'refund_notify' => WeChatAppPayRefundNotify::class,
            'refund_query'  => WeChatAppPayRefundQuery::class,
        ];
    }
    
    
    /**
     * 获取微信小程序端接口配置
     * @param string $name 名称
     * @param string $alias 别名
     * @param int    $client 客户端类型
     * @return array
     */
    public static function mini(?string $name = null, ?string $alias = null, ?int $client = null) : array
    {
        return [
            'name'          => $name ?? '微信小程序支付',
            'alias'         => $alias ?? '微信',
            'client'        => $client ?? PayType::CLIENT_WECHAT,
            'create'        => WeChatMiniPayCreate::class,
            'notify'        => WeChatMiniPayNotify::class,
            'refund'        => WeChatMiniPayRefund::class,
            'refund_notify' => WeChatMiniPayRefundNotify::class,
            'refund_query'  => WeChatMiniPayRefundQuery::class,
        ];
    }
    
    
    /**
     * 获取微信网页端接口配置
     * @param string $name 名称
     * @param string $alias 别名
     * @param int    $client 客户端类型
     * @return array
     */
    public static function native(?string $name = null, ?string $alias = null, ?int $client = null) : array
    {
        return [
            'name'          => $name ?? '微信网页支付',
            'alias'         => $alias ?? '微信',
            'client'        => $client ?? PayType::CLIENT_WECHAT,
            'create'        => WeChatNativePayCreate::class,
            'notify'        => WeChatNativePayNotify::class,
            'refund'        => WeChatNativePayRefund::class,
            'refund_notify' => WeChatNativePayRefundNotify::class,
            'refund_query'  => WeChatNativePayRefundQuery::class,
        ];
    }
}