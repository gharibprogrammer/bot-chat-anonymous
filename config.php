<?php
define('API_KEY','TOKEN');//insert token your bot 
$getinfobot = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getMe"));
$userbot = $getinfobot->result->username;
$idbot = $getinfobot->result->id;
$update = json_decode(file_get_contents("php://input"));
$message = $update->message;
$callback = $update->callback_query;
if(isset($message)){
  $message_id =$message->message_id;
  $from_id = $message->from->id;
  $chat_id = $message->chat->id;
  $text = $message->text;
  $type = $message->chat->type;
  $first_name = $message->from->first_name;
  $username  = $message->from->username;
}elseif(isset($callback)){
  $from_id = $callback->message->from->id;
  $chat_id = $callback->message->chat->id;
  $message_id = $callback->message->message_id;
  $data = $callback->data;
  $type = $callback->message->chat->type;
  $callbackid = $callback->id;
}
$mtn1 = "🔗 به یه ناشناس وصلم کن!";
$mtn2 = "💌 به مخاطب خاصم وصلم کن!";
$mtn3 = "👥 پیام ناشناس به گروه";
$mtn4 = "لینک ناشناس من 📬";
$mtn5 = "💎 راهنما";
$mtn6 = "🏆 افزایش امتیاز";
$mtn7 = "انصراف";
$mtn8 = "✍ پاسخ";
$mtn9 = "⛔️ بلاک";
$mtn10 = "♨️ لیست بلاک";
$mtn11 = "🧍🏻‍♀️ دخترم";
$mtn12 = "🧍🏻‍♂️ پسرم";
$mtn13 = "آمار";
$mtn14 = "قطع مکالمه";
$mtn15 = "مسدود کردن کاربر";
$mtn16 = "پیام همگانی";
$con =mysqli_connect('localhost','databaseName','password','userName');//mention information database mysql
$member = mysqli_fetch_assoc(mysqli_query($con,"select * from member where userid = $chat_id"));

$keys  = json_encode(["keyboard"=>[
  [['text' => $mtn1]],
  [['text'=> $mtn2]],
  [['text'=> $mtn4],['text'=> $mtn3]],
  [['text'=> $mtn5],['text'=> $mtn6]],
  [['text'=> $mtn10]]
  ],"resize_keyboard"=> true]);
$backmember  = json_encode(['keyboard'=>[
  [["text"=>$mtn7]]
  ],"resize_keyboard"=>true]);
  $keyadmin = json_encode(["keyboard"=>[
    [['text'=> $mtn15]],
    [['text'=> $mtn13]],
    [['text'=> $mtn16]]
  ],"resize_keyboard"=> true]);
$admin = [217317471,262928678];// insert id admin 
?>