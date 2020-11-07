<?php
function curl_post_https($data){ // 模拟提交数据函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, "https://kalinote.aito.app/api/v1/_recommend"); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'x-api-key: jh7y40WzpZ7nFsph7Lkpy49DkBoO5Ivh41UpjObG',
          'content-type: application/json'
      ));
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
    $backdata = $tmpInfo;
    return json_decode($backdata,true); // 返回数据，json格式
}
$data = '{
    "from": "ratings",
    "where": {
        "userID": {
            "cuisine": "Mexican", 
            "payment": "VISA"
        }
    },
    "recommend": "placeID",
    "goal": {"rating": 2}
}';
?>
<title>HackerEat Demo</title>
<h1>HackerEat Demo</h1><hr>
Please select some properties of the restaurant you want to go:
<p>Cuisine:<input type="text" value="Mexican" disabled><br>
payment:<input type="text" value="VISA" disabled><br>
<a href="#">+ Add more</a></p>
<input type="button" value="Submit" onclick="location.href='?show=1'"><br><?php
if(isset($_GET['show'])){
    $getit=curl_post_https($data)['hits'][0];
    echo "This is you want information:<br>";
    echo "Restaurant Name:".$getit["name"]."<br>";
    echo "Address:".$getit["country"]." ".$getit["city"]." ".$getit["address"];
    
}
?><hr>
