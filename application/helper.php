<?php
/**
 * Wejoy CMF [ WE CAN DO IT JUST ENJOY ]
 * 扩展系统函数
 * @since   2016-12-08
 * @author  TechLee <767049337@qq.com>
 */

/**
 * 字节转换
 */
function get_byte_size($size)
{
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size > 1024; $i++) {
        $size /= 1024;
    }
    return round($size, 2) . $units[$i];
}

/**
 * textarea转换为html
 * @author TechLee
 */
function text_to_html($content, $type = '1')
{
    $str = '';
    switch ($type) {
        case '2':
            $str = '<p>' . str_replace(PHP_EOL, '</p><p>', $content) . '</p>';
            break;
        case '1':
        default:
            $str = str_replace(PHP_EOL, '<br>', $content);
            break;
    }
    return $str;
}
/**
 * xml对象转换为数组
 * @author TechLee
 */
function xml_to_array($xmlStr)
{    
    $xmlObj = simplexml_load_string($xmlStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    return json_decode(json_encode($xmlObj), true);
}

/**
 * 清除html标签
 * @author TechLee
 */
function clear_tags($str)
{
    $str = strip_tags($str);
    //首先去掉头尾空格
    $str = trim($str);
    $str = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", strip_tags($str));
    //接着去掉两个空格以上的
    $str = preg_replace('/\s(?=\s)/', '', $str);
    //最后将非空格替换为一个空格
    $str = preg_replace('/[\n\r\t]/', ' ', $str);
    return $str;
}

/**
 * 清除html标签，字符串截取
 * 支持中文
 * @author TechLee
 */
function substr_cn($str, $length = 0, $start = 0, $charset = "utf-8", $suffix = true)
{
    $str = clear_tags($str);
    if (function_exists("mb_substr")) {
        if ($length > 0 && mb_strlen($str, $charset) <= $length) {
            return $str;
        }
        $slice = $length > 0 ? mb_substr($str, $start, $length, $charset) : $str;
    } else {
        $re['utf-8']  = "/[\x01-]|[�-�][�-�]|[�-�][�-�]{2}|[�-�][�-�]{3}/";
        $re['gb2312'] = "/[\x01-]|[�-�][�-�]/";
        $re['gbk']    = "/[\x01-]|[�-�][@-�]/";
        $re['big5']   = "/[\x01-]|[�-�]([@-~]|�-�])/";
        preg_match_all($re[$charset], $str, $match);
        if ($length > 0 && count($match[0]) <= $length) {
            return $str;
        }
        $slice = join("", $length > 0 ? array_slice($match[0], $start, $length) : $match[0]);
    }
    if ($suffix) {
        return $slice . "…";
    }
    return $slice;
}
/**
 * des加密
 * 该解密替换了特殊符号，例如：/ + = .
 */
function do_mencrypt($input, $key = '2DS56FA5-F52AS4F24SF2365SD14GUIO')
{
    $key   = md5($key);
    $input = str_replace("\n", "", $input);
    $input = str_replace("\t", "", $input);
    $input = str_replace("\r", "", $input);
    $key   = substr(md5($key), 0, 24);
    $td    = mcrypt_module_open('tripledes', '', 'ecb', '');
    $iv    = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $key, $iv);
    $encrypted_data = mcrypt_generic($td, $input);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    $src  = array("/", "+", "=");
    $dist = array("_a", "_b", "_");
    return trim(chop(str_replace($src, $dist, base64_encode($encrypted_data))));
}
/**
 * des解密
 * 该解密替换了特殊符号，例如：/ + = .
 */
function do_mdecrypt($input, $key = '2DS56FA5-F52AS4F24SF2365SD14GUIO')
{
    $dist  = array("/", "+", "=");
    $src   = array("_a", "_b", "_");
    $input = str_replace($src, $dist, $input);
    $key   = md5($key);
    $input = str_replace("\n", "", $input);
    $input = str_replace("\t", "", $input);
    $input = str_replace("\r", "", $input);
    $input = trim(chop(base64_decode($input)));
    $td    = mcrypt_module_open('tripledes', '', 'ecb', '');
    $key   = substr(md5($key), 0, 24);
    $iv    = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $key, $iv);
    $decrypted_data = mdecrypt_generic($td, $input);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    return trim(chop($decrypted_data));
}
/**
 * 无限极分类
 * 将数组转换为树形结构
 * @author TechLee
 */
function list_to_tree($dataList, $parent_id = 0, $depth = 0, $prefix = '|--')
{
    $resTree = [];
    foreach ($dataList as $key => $val) {
        if ($val['parent_id'] == $parent_id) {
            $val['depth']  = $depth;
            $val['prefix'] = str_repeat($prefix, $depth);
            unset($dataList[$key]);
            $resTree[] = $val;
            $resTree   = array_merge($resTree, list_to_tree($dataList, $val['id'], $depth + 1));
        }
    }
    return $resTree;
}

/**
 * 把返回的数据集转换成子父类
 * @param $list
 * @param string $pk
 * @param string $pid
 * @param string $child
 * @param string $root
 * @return array
 */
function list_to_child($dataList, $root = '0', $pid = 'parent_id', $pk = 'id', $child = '_child')
{
    $tree = [];
    if (is_array($dataList)) {
        $refer = [];
        foreach ($dataList as $key => $data) {
            method_exists($data, 'toArray') and $dataList[$key] = $data->toArray();
        }
        foreach ($dataList as $key => $data) {
            $refer[$data[$pk]]         = &$dataList[$key];
            $refer[$data[$pk]][$child] = [];
        }
        foreach ($dataList as $key => $data) {
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] = &$dataList[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent           = &$refer[$parentId];
                    $parent[$child][] = &$dataList[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * Curl请求，支持https，get，post，及非80,443端口。
 */
function url_request($data, $url = '', $method = 'post', $port = '80', $charset = 'utf-8')
{
    if (strstr($url, 'https://')) {
        $port = '443';
    }
    $form_data = "";
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            if ($form_data == "") {
                $form_data = $key . "=" . rawurlencode($value);
            } else {
                $t         = "&" . $key . '=' . rawurlencode($value);
                $form_data = $form_data . $t;
            }
        }
    } else {
        $form_data = $data;
    }

    $ch = curl_init();
    if (strtolower($charset) == 'gbk') {
        // header("Content-type:text/html;charset=gbk");
        $this_header = array("content-type: application/x-www-form-urlencoded;charset=gbk");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
    }
    curl_setopt($ch, CURLOPT_PORT, $port);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false); //设定是否输出页面内容
    if ($port == '443') {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    }
    if (strtolower($method) == 'post') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $form_data);
    } else {
        $url .= strstr($url, '?') ? '&' . $form_data : "?" . $form_data;
    }
    // echo $url;die;
    curl_setopt($ch, CURLOPT_URL, $url);
    // curl_setopt_array($ch, $option);
    $result = curl_exec($ch);
    // dump($result);
    return $result;
}
