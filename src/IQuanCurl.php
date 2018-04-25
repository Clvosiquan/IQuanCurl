<?php
/**
 *-----------------------------------------
 * Class IQuanCurl
 * Author  ClovisiQuan
 * Date: 2018/04/25
 * Time: 11:19
 *-----------------------------------------
 *
 *-----------------------------------------
 */
namespace IQuanCurl;

class IQuanCurl
{
    private $_ch = Null;
    private $method = 'get';
    private $param = array();

    public function __construct($app)
    {
        $this->app = $app;
    }

    private function _init() {
        $this->_ch = curl_init();
        curl_setopt($this->_ch, CURLOPT_HEADER, true);
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
    }


    public function param($value){
        $this->param = $value;
        return $this;
    }

    public function method($value){
        $this->param = $value;
        return $this;
    }

    public function Call($queryUrl='',$method='get',$isJson=true,$isUrlcode=true) {
        if (empty($queryUrl)) {
            return false;
        }else{
            $ret = '';
            $param = $this->param;
            $this->_init();
            switch ($method){
                case 'post':
                    $ret = $this->post($queryUrl, $param, $isUrlcode);
                    break;
                case 'put':
                    $ret = $this->put($queryUrl, $param);
                    break;
                case 'delete':
                    $ret = $this->delete($queryUrl, $param);
                    break;
                case 'head':
                    $ret = $this->head($queryUrl, $param);
                    break;
                default:
                    $ret = $this->get($queryUrl, $param);
                    break;
            }
            if(!empty($ret)){
                if($isJson){
                    return json_decode($ret, true);
                }else{
                    return $ret;
                }
            }
            return true;
        }

    }

    private function get($url = '',$array = array()){
        if (!empty($query)) {
            $url .= (strpos($url, '?') === false) ? '?' : '&';
            $url .= is_array($query) ? http_build_query($query) : $query;
        }
        curl_setopt($this->_ch, CURLOPT_URL, $url);
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->_ch, CURLOPT_HEADER, 0);
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($this->_ch, CURLOPT_SSLVERSION, 1);

        $ret =$this->execute();
        $this->close();
        return $ret;
    }

    private function post($url, $query=array(), $isUrlcode=true) {
        if (is_array($query)) {
            foreach ($query as $key => $val) {
                if($isUrlcode){
                    $encode_key = urlencode($key);
                }else{
                    $encode_key = $key;
                }
                if ($encode_key != $key) {
                    unset($query[$key]);
                }
                if($is_urlcode){
                    $query[$encode_key] = urlencode($val);
                }else{
                    $query[$encode_key] = $val;
                }

            }
        }
        curl_setopt($this->_ch, CURLOPT_URL, $url);
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->_ch, CURLOPT_HEADER, 0);
        curl_setopt($this->_ch, CURLOPT_POST, true );
        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($this->_ch, CURLOPT_SSLVERSION, 1);


        $ret = $this->execute();
        $this->_close();
        return $ret;
    }

    private function put($url, $query = array()) {
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, 'PUT');

        return $this->post($url, $query);
    }

    private function delete($url, $query = array()) {
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        return $this->post($url, $query);
    }

    private function head($url, $query = array()) {
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, 'HEAD');

        return $this->post($url, $query);
    }

    private function execute() {
        $response = curl_exec($this->_ch);
        $errno = curl_errno($this->_ch);
        if ($errno > 0) {
            exception(curl_error($this->_ch), $errno);
        }
        return  $response;
    }

    private function close() {
        if (is_resource($this->_ch)) {
            curl_close($this->_ch);
        }
        return true;
    }
}