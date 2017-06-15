<?php
const TYPE_SHOW = 0;
const TYPE_POST = 1;
/**
 * api测试用类
 *
 * Author: Chen Rongrong
 * Date: 2017/6/14
 */
class ApiTest
{

    /**
     * @return null
     */
    public function index()
    {
        echo "index";
    }

    /**
     * 测试用方法，调用api接口
     *
     *  @param $type post格式，0表示json
     *
     **/
    public function testPost($url)
    {
        //使用方法
        //测试数据

        $dataArray = $this->getDataArray();
        $post_data = [
            "data" => $dataArray,
        ];

        $post_data_json = json_encode($post_data);

        $result = $this->sendPost($url, $post_data_json, true);

        echo $result;
    }

    /**
     * 输出测试数据
     **/
    public function outputData()
    {
        $dataArray = $this->getDataArray();
        echo json_encode($dataArray);
    }

    /**
     * 发送post请求
     * @param string $url 请求地址
     * @param array $post_data post键值对数据
     * @return string
     */
    private function sendPost($url, $post_data, $is_json = true)
    {
        if (!$is_json) {
            $postdata = http_build_query($post_data); //将数组格式化为字符串
        } else {
            $postdata = $post_data;
        }
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60, // 超时时间（单位:s）
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }

    /**
     * 发送请求，curl方法
     **/
    private function curlrequest($url, $data, $method = 'POST')
    {
        $postdata = http_build_query($data); //将数组格式化为字符串

        $ch = curl_init(); //初始化CURL句柄
        curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); //设置请求方式

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-HTTP-Method-Override: $method")); //设置HTTP头信息
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata); //设置提交的字符串
        $document = curl_exec($ch); //执行预定义的CURL
        curl_close($ch);

        return json_decode($document);
        //return $document;
    }

    /**
     * 获取post的数组数据
     *
     * @return [type]
     */
    private function getDataArray()
    {
        $dataArray = [
            [
                "pname" => "咪咕阅读APPios",
                "device" => "IOS",
                "name" => "开机页ios",
                "price_cpm" => 0,
                "style" => "开机大图",
                "adspace_id" => "966E0EC5EC2D729D1923B71D144735E3",
                "web_sid" => "56c3c455",
                "width" => 750,
                "height" => 1030,
            ],
            [
                "pname" => "咪咕视频客户端android",
                "device" => "Android",
                "name" => "咪咕视讯-咪咕视频-点播播放页-前贴片-Android",
                "price_cpm" => 0,
                "style" => "视频点播前贴片",
                "adspace_id" => "625F77B58B9BC1D684F8650CF832342C",
                "web_sid" => "564984d9",
                "width" => 1280,
                "height" => 720,
            ],
        ];
        return $dataArray;
    }
}

$flag = $_GET['flag'] ?? 0;
$apiTest = new ApiTest();
if ($flag == TYPE_SHOW) {
    $url = "http://127.0.0.1:7077/api/adspace/index";
} elseif ($flag == TYPE_POST) {
    $url = "http://127.0.0.1:7077/api/adspace/import";
}
$apiTest->testPost($url);

//$apiTest->outputData();
