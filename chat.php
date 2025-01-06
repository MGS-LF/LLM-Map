<?php
header('Content-Type: text/event-stream'); // 设置内容类型为流式传输
header('Cache-Control: no-cache'); // 禁用缓存

$data = json_decode(file_get_contents('php://input'), true);
$messages = $data['messages'];
$stream = $data['stream'];

$openaiApiKey = '*********************************'; // 替换为你的OpenAI API密钥

$url = '***********************************'; //opeai格式的api接口
$headers = [
    'Authorization: Bearer ' . $openaiApiKey,
    'Content-Type: application/json',
];

$payload = [
    'model' => '*****', // 或者你想使用的其他模型
    'messages' => $messages,
    'stream' => $stream,
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $str) {
    echo $str; // 直接将响应流式传输到客户端
    flush(); // 刷新输出缓冲区
    return strlen($str); // 返回字符串的长度
});
curl_exec($ch);
curl_close($ch);
?>
