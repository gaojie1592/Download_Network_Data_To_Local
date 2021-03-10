<?php

namespace gaojie1592;

/**
 * 下载网络数据识别文件后缀后保存到本地并返回本地地址
 * Download the network data identification file suffix, save it to the local and return to the local address
 * @author  gaojie11@163.com
 */
class Download_Network_Data_To_Local
{
    /**
     * @var string 访问网络需要的URL地址
     * URL address required to access the network
     */
    private $http_url           = '';
    /**
     * @var string 网络数据保存到本地的地址
     * Save network data to a local address
     */
    private $local_path         = '';
    /**
     * @var string 保存到本地的文件名称,不包含后缀
     * The name of the file saved locally, excluding the suffix
     */
    private $filename           = '';
    /**
     * @var string||false 访问网络返回的数据
     * Visit the data returned by the network
     */
    private $http_ret_data_res  = false;
    /**
     * @var string||false 访问网络返回的信息
     * Information returned by visiting the network
     */
    private $http_ret_info_res  = false;
    /**
     * @var int 最大网络下载时间/秒
     * Maximum network download time/sec
     */
    private $http_timeout       = 30;
    /**
     * @var int 最大网络初始化时间/秒
     * Maximum network initialization time/sec
     */
    private $http_sertimeout    = 40;
    /**
     * @var string 设置代理地址与端口,格式:192.168.1.1:8080
     * Set the proxy address and port, format: 192.168.1.1:8080
     */
    private $http_proxy         = '';
    /**
     * @var string 设置访问代理需要用到的账号与密码,格式:usr:pwd
     * Set the account and password needed to access the proxy, format: usr:pwd
     */
    private $http_proxyusrpwd   = '';
    /**
     * @var string 文件后缀名
     * File extension
     */
    private $filetype           = 'unknown';
    /** 
     * @var array 文件后缀名池
     * File suffix pool
     */
    private $filetypes          = array(
        4742     => 'js',
        5666     => 'psd',
        6033     => 'htm_or_html',
        6063     => 'xml',
        6677     => 'bmp',
        7173     => 'gif',
        7790     => 'exe',
        7784     => 'midi',
        8075     => 'zip',
        8297     => 'rar',
        10056    => 'bt',
        13780    => 'png',
        64101    => 'bat',
        208207   => 'xls_or_doc_or_ppt',
        239187   => 'txt_or_aspx_or_asp_or_sql',
        255216   => 'jpg',
        255254   => 'rdp',
    );
    /**
     * 初始化
     * initialization
     */
    public function __construct($http_url = '', $local_path = '', $filename = '')
    {
        $this->http_url   = $http_url;
        $this->local_path = $local_path;
        $this->filename   = $filename;
    }
    /**
     * 开始执行
     * start execution
     */
    public function start()
    {
        if (empty($this->http_url) || empty($this->local_path)) {
            return false;
        }
        \clearstatcache();
        if (!is_dir($this->local_path)) {
            if (!mkdir($this->local_path, 0777, true)) {
                return false;
            }
        }
        $this->http();
        if (isset($this->http_ret_info_res['http_code']) && $this->http_ret_info_res['http_code'] != 200) {
            return false;
        }
        $this->get_hz($this->http_ret_data_res);
        $this->filename = empty($this->filename) ? substr(md5(uniqid(microtime(true), true)), 0, 10) : $this->filename;
        $tmp_filename = $this->local_path . $this->filename . '.' . $this->fileType;
        if (\is_readable($tmp_filename)) {
            return false;
        }
        if (\file_put_contents($tmp_filename, $this->http_ret_data_res)) {
            return $tmp_filename;
        }
        return false;
    }
    /**
     * 设置本地保存文件名称
     * Set the name of the locally saved file
     * @param   string  $str
     * @return  this
     */
    public function set_filename($str)
    {
        $this->filename = $str;
        return $this;
    }
    /**
     * 设置本地保存目录
     * Set local save directory
     * @param   string  $str
     * @return  this
     */
    public function set_local_path($str)
    {
        $this->local_path = $str;
        return $this;
    }
    /**
     * 设置需要下载的网络地址
     * Set the network address to be downloaded.
     * @param   string  $str
     * @return  this
     */
    public function set_http_url($str)
    {
        $this->http_url = $str;
        return $this;
    }
    /**
     * 设置最大网络下载时间
     * Set the maximum network download time
     * @param   int  $int   time
     * @return  this
     */
    public function set_http_timeout($int)
    {
        $this->http_timeout = $int;
        return $this;
    }
    /**
     * 设置最大网络初始化时间
     * Set the maximum network initialization time
     * @param   int  $int   time
     * @return  this
     */
    public function set_http_sertimeout($int)
    {
        $this->http_sertimeout = $int;
        return $this;
    }
    /**
     * 设置代理地址与端口,格式:192.168.1.1:8080
     * Set the proxy address and port, format: 192.168.1.1:8080
     * @param   string  $str
     * @return  this
     */
    public function set_http_proxy($str)
    {
        $this->http_proxy = $str;
        return $this;
    }
    /**
     * 设置访问代理需要用到的账号与密码,格式:usr:pwd
     * Set the account and password needed to access the proxy, format: usr:pwd
     * @param   string  $str
     * @return  this
     */
    public function set_http_proxyusrpwd($str)
    {
        $this->http_proxyusrpwd = $str;
        return $this;
    }
    /**
     * 访问网络并返回数据
     * @return  this
     */
    private function http()
    {
        $ch = \curl_init();
        \curl_setopt($ch, CURLOPT_URL, $this->http_url);
        \curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        \curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        \curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        \curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        \curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->http_sertimeout);
        \curl_setopt($ch, CURLOPT_TIMEOUT, $this->http_timeout);
        if ($this->http_proxy) {
            \curl_setopt($ch, CURLOPT_PROXY, $this->http_proxy);
        }
        if ($this->http_proxyusrpwd) {
            \curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->http_proxyusrpwd);
        }
        $this->http_ret_data_res = \curl_exec($ch);
        $this->http_ret_info_res = \curl_getinfo($ch);
        \curl_close($ch);
        return $this;
    }
    /**
     * 根据二进制内容判断文件后缀名
     * Judge the file suffix based on the binary content
     * @param   string  $data   二进制内容
     * @return  this
     */
    private function get_hz($data)
    {
        $strInfo = @unpack("C2chars", \substr($data, 0, 2));
        if (empty($strInfo)) {
            $this->fileType = 'unknown';
            return $this;
        }
        $typeCode = \intval($strInfo['chars1'] . $strInfo['chars2']);
        $this->fileType = isset($this->filetypes[$typeCode]) ? $this->filetypes[$typeCode] : 'unknown';
        return $this;
    }
}
