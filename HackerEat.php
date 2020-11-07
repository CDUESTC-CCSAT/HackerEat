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
?>
<title>HackerEat Demo</title>
<a href="/"><h1>HackerEat Demo</h1></a><hr>
Please select some properties of the restaurant you want to go:
<p><form action="" method="get">x | Cuisine: <input type="text" value="Mexican"><br>
x | Payment: <select name="payment">
  <option value="VISA">VISA</option>
  <option value="cash">cash</option>
  <option value="bank_debit_cards">Debit Cards</option>
  <option value="American_Express">American Express</option>
</select><br>
x | Price: <select name="budget">
  <option value="high">high</option>
  <option value="medium">medium</option>
  <option value="low">low</option>
</select><br>
<a href="#">+ Add more</a></p>
<input type="submit"></form><hr><?php
if(isset($_GET['payment'])){
    $data = '{
    "from": "ratings",
    "where": {
        "userID": {
            "cuisine": "Mexican", 
            "payment": "'.$_GET['payment'].'",
            "budget": "'.$_GET['budget'].'"
        }
    },
    "recommend": "placeID",
    "goal": {"rating": 2},
    "limit": 3
}';
    $getit=curl_post_https($data)['hits'];
    echo "Here is some information that may you want:<br>";
    echo "Best Restaurant Name:".$getit[0]["name"]."<br>";
    echo "Address:".$getit[0]["country"]." ".$getit[0]["city"]." ".$getit[0]["address"].'<br><br>';
    echo "Second Restaurant Name:".$getit[1]["name"]."<br>";
    echo "Address:".$getit[1]["country"]." ".$getit[1]["city"]." ".$getit[1]["address"].'<br><br>';
    echo "Third Restaurant Name:".$getit[2]["name"]."<br>";
    echo "Address:".$getit[2]["country"]." ".$getit[2]["city"]." ".$getit[2]["address"].'<br><br>';
    echo 'Origin Data:<br><pre>';
    print_r($getit);
    echo "</pre>";
    
}
?><hr>Copyright &copy; 2020 by CCSAT
