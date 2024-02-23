<?php
error_reporting(0);
include("config.php");
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
function sendmessage($chat_id,$msg,$key = null){
  return bot('sendMessage',[

    'chat_id'=> $chat_id,
    'text' => $msg,
    'parse_mode' => "html",
    'reply_markup' => $key,
    'disable_web_page_preview' => true
]);
}
function deletemessage($chat_id,$msgid){
  return bot('deleteMessage',[
  'chat_id' => $chat_id,
  'message_id' => $msgid
  ]);
}
function sendphoto($chat_id,$ph,$ch){
  return bot('sendPhoto',[
  'chat_id' => $chat_id,
  'photo' => $ph,
  'caption' => $ch
  ]);
}
function copymessage($chid,$fchid,$msid,$rm,$re){
  bot("copyMessage",[
    'chat_id'=> $chid,
    'from_chat_id'=> $fchid,
    'message_id'=> $msid,
    'reply_markup'=> $rm,
    'reply_to_message_id' => $re
    ]);
}
function getchat($chat_id){
  return bot("getChat",["chat_id"=>$chat_id]);
}
function answerquery($callid,$msg,$al){
  return bot('AnswerCallbackQuery',[
    'callback_query_id' => $callid,
    'text' => $msg,
    'show_alert' => $al
    ]);
}
function editmessagereplymarkup($chid,$msid,$rem){
  return bot("editMessageReplyMarkup",["chat_id"=> $chid, "message_id"=>$msid,"reply_markup"=>$rem]);
}
function editmessage($chat_id,$msgid,$text,$key = null){
  return bot('EditMessageText',[
    'chat_id' => $chat_id,
    'message_id' => $msgid,
    'text' => $text,
    'reply_markup' => $key
    ]);
}
function sendpoll($chat_id,$msg,$op){
  return bot('sendPoll',[
    'chat_id' => $chat_id,
    'question' => $msg,
    'options' => $op
]);
}
function check($chat_id,$userid){
  $check = bot("getChatMember",["chat_id"=> $chat_id,"user_id"=> $userid])->result->status;
  if($check != "left"){
    return true;
  }else{
    return false;
  }
}
if($member['step'] == 'blocked'){ exit();}
if($type == "private"){
if($text == "/koos"){
$polltext = array("g","m");
 $response =   sendpoll("217317471","Who is Gharib’s love?",json_encode($polltext));

$poll_id = $response->result->poll->id;
sendmessage($from_id,"res $poll_id",$key);
}
if($text == $mtn7){
  if(preg_match("/conn_(.*)/",$member['step'],$m)){
    mysqli_query($con,"update member set step = 'none' where id = $m[1]");
  $check = mysqli_fetch_assoc(mysqli_query($con,"select userid from member where id = $m[1]"));
    $mtn = "☹️مخاطب مکالمه رو قطع کرد\nچه کاری برات انجام بدم؟".$tabligh;
    sendmessage($check['userid'],$mtn,$keys); 
  }
  $mem = $member['id'];
$chack = mysqli_query($con,"select * from connect where id = $mem"); 
   if(mysqli_num_rows($chack) != 0){
     mysqli_query($con,"delete from connect where id = $mem");
   }
  mysqli_query($con,"update member set step = 'none' where userid = $from_id");
  $member = mysqli_fetch_assoc(mysqli_query($con,"select * from member where userid = $chat_id"));
  $mtn = "حله!

چه کاری برات انجام بدم؟
".$tabligh;
sendmessage($from_id,$mtn,$keys);
}
if(preg_match('/\/start (.*)/',$text,$m)){
if(preg_match('/\/start ac-(.*)/',$text,$me)){
  $check = mysqli_query($con,"select * from member where id = $me[1]");
  if($member['id'] == $me[1]){
    $mtn = "اینکه آدم گاهی با خودش حرف بزنه خوبه ، ولی اینجا نمیتونی به خودت پیام ناشناس بفرستی ! :)

چه کاری برات انجام بدم؟";
    sendmessage($from_id,$mtn,$keys);
  }elseif(mysqli_num_rows($check) == 0){
    $mtn = "متاسفانه مخاطبت الان عضو ربات نیست !

چطوره یه جوری لینک ربات رو بهش برسونی تا بیاد و عضو بشه؟ مثلا لینک خودت رو بهش بفرستی یا اگه جزء دنبال کننده‌های اینستاگرامته لینکت رو در اینستاگرامت بذاری.

برای دریافت لینک 👈 /link";
    sendmessage($from_id,$mtn,$keys);
  }else{
    $check = mysqli_fetch_assoc($check);
    $id = $check['userid'];
 $checkh = mysqli_query($con,"select * from block where fromid = $id and toid = $chat_id");
 if(mysqli_num_rows($checkh) == 0){
    $checkme = mysqli_query($con,"select * from member where userid = '$from_id'");
    if(mysqli_num_rows($checkme) == 0){
       mysqli_query($con,"insert into member(name,username,userid,score,step) values('$first_name','$username',$from_id,0,'none')");
    }
    mysqli_query($con,"update member set step = 'send_$m[1]' where userid = $from_id");
    $name = $check['name'];
    $mtn = "در حال ارسال پیام ناشناس به $name هستی.
میتونی پیامت رو ارسال کنی 😉
می‌تونی هر حرف یا انتقادی که تو دلت هست رو بگی چون پیامت به صورت کاملا ناشناس ارسال می‌شه!";
    sendmessage($from_id,$mtn,$backmember);
 }else{
   $mtn = "شما توسط کاربر بلاک شده اید";
   sendmessage($from_id,$mtn,$keys);
 }
  }
  exit;
}else{
  $check = mysqli_num_rows(mysqli_query($con,"select * from member where userid = $from_id"));
  if($from_id == $m[1]){
    $mtn = "با لینک خودت که نمیتونی بیای☹️\nربات رو به دوستات معرفی کن اول";
    sendmessage($from_id,$mtn,$keys);
  }elseif($check != 0){
    $mtn = "شما قبلا وارد ربات شدی داداش🤦🏽‍♂️\n بجا این کارا لینک ناشناستو بگیر و به دوستات بده تا بفهمی چجور آدمین";
    sendmessage($from_id,$mtn,$keys);
  }else{
    $score = mysqli_fetch_assoc(mysqli_query($con,"select * from member where userid = $m[1]"));
    $score = $score['score'] + 10;
    mysqli_query($con,"update member set score = $score where userid = $m[1]");
    $mtn = "😍یک نفر با لینک تو وارد ربات شد\n10 گپ جدید بهت اضافه شد";
    sendmessage($m[1],$mtn,$keys);
  }
}
}
if(preg_match("/\/[Ss][Tt][Aa][Rr][Tt]/",$text)){
  $check = mysqli_query($con,"select * from member where userid = '$from_id'");
  if(mysqli_num_rows($check) == 0){
    $mtn = "🙂سلام $first_name عزیز به ربات حرف ناشناس خوش اومدی\nبا این ربات میتونی به صورت ناشناس با دوستات به روش های مختلف ارتباط برقرار کنی";
    mysqli_query($con,"insert into member(name,username,userid,score,step) values('$first_name','$username',$from_id,0,'none')");
  }else{
    $check = mysqli_fetch_assoc($check);
    if($check['username'] != $username){
      $edit = "username = $username ";
    }elseif($check['name'] != $first_name){
      $edit = $edit." name = $name";
    }
    if($edit != null){
    $edit = str_replace("  "," and ",$edit);
    mysqli_query($con,"update member set $edit where userid = $from_id");
    }
    
    $mtn = "حله!

چه کاری برات انجام بدم؟
".$tabligh;
  }
  sendmessage($from_id,$mtn,$keys);
}
if($text == $mtn6){
  $score = $member['score'];
  $mtns = "دریافت اعتبار رایگان";
  $keys = json_encode(['inline_keyboard'=>[
    [['text'=> $mtns , 'callback_data'=> 'banner']]
    ]]);
  $mtn = "اعتبار فعلی مکالمه شما : $score گپ جدید


❓ چطور اعتبار مکالمه خودمو افزایش بدم ؟


برای افزایش اعتبار، بنر مخصوص خودت رو به دوستات فوروارد کن. به ازای هر کاربری که از طرف تو وارد ربات بشه 10 گپ جدید می‌گیری !😀
برای دریافت بنر 👈 /banner 👉 رو لمس کن";
sendmessage($from_id,$mtn,$keys);
}
if($text == $mtn5){
  $mtn = '
این ربات چطور کار میکنه ؟ کاراییش چیه؟
‌‌•• ••  •• •• •• •• •• •• •• •• •• •• •• •• •• •• •• •• 
• شما با کمک این ربات میتونید به صورت رایگان به دوستاتون اجازه بدین هر حرف یا انتقادی که تو دلشون مونده رو بصورت ناشناس بهت بگن!
‌‌•• ••  •• •• •• •• •• •• •• •• •• •• •• •• •• •• •• •• 
• میتونی به گروه‌ هایی که توشون عضو  هستی پیام ناشناس بفرستی!
‌‌•• ••  •• •• •• •• •• •• •• •• •• •• •• •• •• •• •• •• 
•  یکی دیگر از قابلیت های جذاب رباتمون اینه که میتونی هر موقع حوصلت سر رفت بیای به رباتمون و با مخاطب تصادفی دختر/پسر (به انتخاب خودتون) وصل شید به صورت ناشناس چت کنید.
‌‌•• ••  •• •• •• •• •• •• •• •• •• •• •• •• •• •• •• •• 
• و همچنین میتونید با استفاده از آیدی به مخاطب خاصت بصورت ناشناس پیام بفرستی.';
sendmessage($from_id,$mtn,$keys);
}
if($text == "/banner" || $data == "banner"){
  $userid = $chat_id;
  $mtn = "حوصلت سر رفته؟ 😀

با این برنامه می‌تونی هر وقت بخوای به صورت تصادفی به یک نفر وصل بشی و کاملا ناشناس گپ بزنی 

شروع کن 👇

t.me/$userbot?start=$userid";
sendmessage($chat_id,$mtn,$key);
$score = $member['score'];
$mtn = "اعتبار مکالمه شما : $score گپ جدید


برای افزایش اعتبار، بنر بالا رو به دوستات فوروارد کن. به ازای هر کاربری که از طرف تو وارد برنامه بشه 👈 10 👉 گپ جدید می‌گیری!😀";
sendmessage($chat_id,$mtn,$key);
}
if( $text == $mtn4 || $text == "/link" ){
  $id = $member['id'];
  $userbot = "GsChatRobot";
  $mtn = "سلام $first_name هستم ✋️

لینک زیر رو لمس کن و هر حرفی که تو دلت هست یا هر انتقادی که نسبت به من داری رو با خیال راحت بنویس و بفرست. بدون اینکه از اسمت باخبر بشم پیامت به من می‌رسه. خودتم می‌تونی امتحان کنی و از بقیه بخوای راحت و ناشناس بهت پیام بفرستن، حرفای خیلی جالبی می‌شنوی! 😉

👇👇
https://t.me/$userbot?start=ac-$id";
  sendmessage($from_id,$mtn,$keys);
  $mtn = "☝️ پیام بالا رو به دوستات و گروه‌هایی که می‌شناسی فـوروارد کن یا لـینک داخلش رو تو شبکه‌های اجتماعی بذار و توئیت کن، تا بقیه بتونن بهت پیام ناشناس بفرستن. پیام‌ها از طریق همین برنامه بهت می‌رسه.

اینستاگرام داری و میخوای دنبال کننده های اینستاگرامت برات پیام ناشناس بفرستن؟
پس روی دستور 👈🏻 /Instagram کلیک کن!";
  sendmessage($from_id,$mtn,$keys);
}
if(preg_match("/ac-(.*)/",$member['step'],$m) ){
  $check = mysqli_fetch_assoc(mysqli_query($con,"select * from member where id = $m[1]"))['userid'];
  $keysend = json_encode(["inline_keyboard"=>[
    [["text"=>$mtn8,'callback_data'=>"pas $message_id $from_id"],["text"=>$mtn9 , 'callback_data'=> "block_$from_id"]]
    ]]);
  copymessage($check,$from_id,$message_id,$keysend,null);
  $mtn = "پیام شما ارسال شد 😊

چه کاری برات انجام بدم؟".$tabligh;
  sendmessage($from_id,$mtn,$keys);
 mysqli_query($con,"update member set step = 'none' where userid = $from_id");
}
if(preg_match("/pas (.*) (.*)/",$data,$m)){
 $check = mysqli_query($con,"select * from block where fromid = $m[2] and toid = $chat_id");
 if(mysqli_num_rows($check) == 0){
  $mtn = "پاسخ خود را بفرستید:";
  sendmessage($chat_id,$mtn,$backmember);
  mysqli_query($con,"update member set step = 'replace $m[1] $m[2]' where userid = $chat_id");
 }else{
   $mtn = "شما توسط کاربر بلاک شده اید";
   answerquery($callbackid,$mtn,true);
 }
}
if(preg_match("/replace (.*) (.*)/",$member['step'],$m)){
$keysend = json_encode(["inline_keyboard"=>[
    [["text"=>$mtn8,'callback_data'=>"pas $message_id $from_id"],["text"=>$mtn9 , 'callback_data'=> "block_$from_id"]]
    ]]);
  copymessage($m[2],$from_id,$message_id,$keysend,$m[1]);
   mysqli_query($con,"update member set step = 'none' where userid = $from_id");
  $mtn = "پیام شما ارسال شد 😊

چه کاری برات انجام بدم؟".$tabligh;
  sendmessage($from_id,$mtn,$keys);
}
if( preg_match("/block_(.*)/",$data,$m) ){
  $check = mysqli_query($con,"select * from block where fromid = $chat_id and toid = $m[1]");
  if(mysqli_num_rows($check) == 0){
  mysqli_query($con,"insert into block values($chat_id,$m[1])");
  $mtn = "کاربر با موفقیت بلاک شد\nبرای ازاد سازی کاربر به لیست بلاک بروید و کاربر را آزاد کنید";
  answerquery($callbackid,$mtn,true);
  }else{
  $mtn = "شما قبلا کاربر را بلاک کرده اید";
  answerquery($callbackid,$mtn,true);
  }
}
if($text == $mtn5){
  $mtn = "💡 راهنما ربات << GsChatRobot >>

این• شما با کمک اl ناشناس پیام بفرستی.";
sendmessage($from_id,$mtn,$keys);
}
if($text == $mtn10){
  $check = mysqli_query($con,"select * from block where fromid = $from_id");
  if(mysqli_num_rows($check) == 0){
    $mtn = "❌شما تا به حال کسی را بلاک نکرده اید";
  }else{
    $arb = [];
    while( $row = mysqli_fetch_assoc($check) ){
      $arb[] = $row['toid'];
    }
    $keyb = [];
    for($i = 0;$i <= count($arb) - 1 ; $i++){
      $check = mysqli_fetch_assoc(mysqli_query($con,"select * from member where userid = $arb[$i]"));
      $toid = $arb[$i];
      $id = $check['id'];
      $keyb[] = [['text'=> "کاربر با ایدی ناشناس $id",'callback_data'=> "nu"],['text'=>'آزاد کردن کاربر','callback_data'=>"unlo_$toid"]];
    }
    $mtn = "💎لیست کاربران بلاک شده را میتوانید در زیر مشاهده کنید\nبرای آزاد کردن کاربر باید ایدی ناشناس کاربر را بدانید تا بتوانید تشخیص دهید";
    $keys = json_encode(["inline_keyboard"=>
      $keyb
      ]);
  }
  sendmessage($from_id,$mtn,$keys);
}
if( preg_match('/unlo_(.*)/',$data,$m) ){
 mysqli_query($con,"delete from block where fromid = $chat_id and toid = $m[1]");
$check = mysqli_query($con,"select * from block where fromid = $chat_id");
  if(mysqli_num_rows($check) != 0){
 $arb = [];
    while( $row = mysqli_fetch_assoc($check) ){
      $arb[] = $row['toid'];
    }
    $keyb = [];
    for($i = 0;$i <= count($arb) - 1 ; $i++){
      $check = mysqli_fetch_assoc(mysqli_query($con,"select * from member where userid = $arb[$i]"));
      $toid = $arb[$i];
      $id = $check['id'];
      $keyb[] = [['text'=> "کاربر با ایدی ناشناس $id",'callback_data'=> "nu"],['text'=>'آزاد کردن کاربر','callback_data'=>"unblock_$toid"]];
    }
    $keyse = json_encode(["inline_keyboard"=>
      $keyb
      ]);
  }
  $mtn = "✔️با موفقیت انجام شد\nاگر فرد دیگری میخواهید بلاک کنید میتوانید روی کاربر کلیک کتید";
  editmessage($chat_id,$message_id,$mtn,$keyse);
}
if($text == $mtn1){
  if($member['sex'] == "none"){
   $keys = json_encode(["inline_keyboard"=>[
      [["text"=>$mtn11,"callback_data"=>"woman"],["text"=>$mtn12,"callback_data"=>"man"]]
      ]]);
    $mtn = "جنسیتت چیه ؟";
    sendmessage($from_id,$mtn,$keys);
  }else{
   $chack = mysqli_query($con,"select * from connect LIMIT 1");
   if(mysqli_num_rows($chack) == 0){
     $sex = $member['sex'];
     $id = $member['id'];
     mysqli_query($con,"INSERT INTO connect (id, sex) VALUES ('$id', '$sex')");
     $mtn = "در صف چت قرار گرفتید....";
      sendmessage($from_id,$mtn,$backmember);
      exit();
   }if(mysqli_num_rows($chack) <= 1){
     $chack = mysqli_fetch_assoc($chack);
    $cid = $chack['id'];
    $mem = $member['id'];
    if($cid == $mem){
     $mtn = "در صف چت قرار گرفتید....";
      sendmessage($from_id,$mtn,$backmember);
      exit();
    }
     mysqli_query($con,"update member set step = 'conn_$mem' where id = $cid");
     mysqli_query($con,"update member set step = 'conn_$cid' where id = $mem");
    $check = mysqli_fetch_assoc(mysqli_query($con,"select userid from member where id = $cid"));
     $mtn = "یکیو برات پیدا کردم🙂\nباهاش صحبت کن";
     sendmessage($from_id,$mtn,$backmember);
     sendmessage($check['userid'],$mtn,$backmember);
     mysqli_query($con,"delete from connect where id = $cid");
   }
  }
}
if(preg_match('/conn_(.*)/',$member['step'],$m )){
  $check = mysqli_fetch_assoc(mysqli_query($con,"select userid from member where id = $m[1]"));
    copymessage($check['userid'],$from_id,$message_id,$backmember,null);
}
if($text == $mtn2){
  $mtn  = 'برای اینکه بتونم به مخاطب خاصت بطور ناشناس وصلت کنم، Username@ یا همون آی‌دی تلگرام اون شخص رو الان وارد ربات کن!';
  mysqli_query($con,"update member set step = 'etesal' where userid = $from_id");
  sendmessage($from_id,$mtn,$backmember);
}
if($member['step'] == 'etesal'){
  if(preg_match('/@(.*)/',$text,$m) ){
    $check = mysqli_query($con,"select * from member where username = '$m[1]'");
    if(mysqli_num_rows($check) == 0){
      $mtn = "متاسفانه مخاطبت الان عضو ربات نیست!

چطوره یه جوری لینک ربات رو بهش برسونی تا بیاد و عضو بشه؟ مثلا لینک خودت رو بهش بفرستی یا اگه جزء دنبال کننده‌های اینستاگرامته لینکت رو در اینستاگرامت بذاری.

برای دریافت لینک 👈 /link";
   sendmessage($from_id,$mtn,$keys);
  mysqli_query($con,"update member set step = 'none' where userid = $from_id");
    }else{
      $check = mysqli_fetch_assoc($check);
      $name = $check['name'];
      $ids = $check['id'];
      $mtn = "در حال ارسال پیام ناشناس به $name هستی!
میتونی پیامت رو ارسال کنی 😉
با خیال راحت هر حرف یا انتقادی که تو دلت هست بنویس ، این پیام بصورت کاملا ناشناس ارسال میشه :)";
    mysqli_query($con,"update member set step = 'send_ac-$ids' where userid = $from_id");
    sendmessage($from_id,$mtn,$backmember);
    }
  }elseif(is_numeric($text) ){
    $check = mysqli_query($con,"select * from member where userid = $text");
    if(mysqli_num_rows($check) == 0){
      $mtn = "متاسفانه مخاطبت الان عضو ربات نیست!

چطوره یه جوری لینک ربات رو بهش برسونی تا بیاد و عضو بشه؟ مثلا لینک خودت رو بهش بفرستی یا اگه جزء دنبال کننده‌های اینستاگرامته لینکت رو در اینستاگرامت بذاری.

برای دریافت لینک 👈 /link";
   sendmessage($from_id,$mtn,$keys);
  mysqli_query($con,"update member set step = 'none' where userid = $from_id");
    }else{
      $check = mysqli_fetch_assoc($check);
      $name = $check['name'];
      $ids = $check['id'];
      $mtn = "در حال ارسال پیام ناشناس به $name هستی!
میتونی پیامت رو ارسال کنی 😉
با خیال راحت هر حرف یا انتقادی که تو دلت هست بنویس ، این پیام بصورت کاملا ناشناس ارسال میشه :)";
    mysqli_query($con,"update member set step = 'send_ac-$ids' where userid = $from_id");
    sendmessage($from_id,$mtn,$backmember);
    }
  }
}
if($data == "man"){
  mysqli_query($con,"update member set sex = 'man' where userid = $chat_id");
  $mtn = "✔️با موفقیت ثبت شد";
   editmessage($chat_id,$message_id,$mtn,$key);
}
if($data == "woman"){
    mysqli_query($con,"update member set sex = 'woman' where userid = $chat_id");
  $mtn = "✔️با موفقیت ثبت شد";
   editmessage($chat_id,$message_id,$mtn,$key);
}
if($text==$mtn3){
$check = mysqli_query($con,"select * from `group` where type = 'group'");
if(mysqli_num_rows($check) == 0){
  $mtn = "هنوز گروهی نیست";
}else{
  $mtn = "گروهی که میخوای این پیام به صورت ناشناس بهش ارسال بشه رو انتخاب کن !

اگه اسم گروهت توی صفحه شیشه‌ای زیر نیست، گزینه اضافه کردن رو لمس کن ، ربات رو توی گروهی که میخوای پیام ناشناس بفرستی عضو کن و بعد آپدیت لیست گروه ها رو لمس کن 👇";
  $kbd = [];
  while($row =mysqli_fetch_assoc($check)){
    $checkbot = bot("getChatMember",["chat_id"=> $row["groupid"],"user_id"=> $idbot]);
    if($checkbot->ok){
    $checkad = check($row['groupid'],$from_id);
     if($checkad){
      $getchatname = getchat($row['groupid'])->result->title;
    
      $kbd[] = [['text'=> "$getchatname",'callback_data'=>"sendgap_".$row['groupid']]];
      }
    }else{
      if($checkbot->error_code == 403){
      $groupid = $row['groupid'];
      mysqli_query($con,"delete from `group` where groupid = '$groupid'");
      }
    }
  }
  $kbd[] = [['text'=>'افزودن به گروهم','url'=>'https://t.me/'.$userbot.'?startgroup=new']];
  $kbd[] = [['text'=>'آپدیت لیست گروه ها','callback_data'=>'update']];
  $kbd = json_encode(['inline_keyboard'=>$kbd]);
}
sendmessage($from_id,$mtn,$kbd);
}
if($data == "update"){
$check = mysqli_query($con,"select * from `group` where type = 'group'");
if(mysqli_num_rows($check) == 0){
  $mtn = "هنوز گروهی نیست";
}else{
  $mtn = "گروهی که میخوای این پیام به صورت ناشناس بهش ارسال بشه رو انتخاب کن !

اگه اسم گروهت توی صفحه شیشه‌ای زیر نیست، گزینه اضافه کردن رو لمس کن ، ربات رو توی گروهی که میخوای پیام ناشناس بفرستی عضو کن و بعد آپدیت لیست گروه ها رو لمس کن 👇";
  $kbd = [];
  while($row =mysqli_fetch_assoc($check)){
    $checkbot = bot("getChatMember",["chat_id"=> $row["groupid"],"user_id"=> $idbot]);
    if($checkbot->ok){
    $checkad = check($row['groupid'],$chat_id);
     if($checkad){
      $getchatname = getchat($row['groupid'])->result->title;
    
      $kbd[] = [['text'=> "$getchatname",'callback_data'=>"sendgap_".$row['groupid']]];
      }
    }else{
      if($checkbot->error_code == 403){
      $groupid = $row['groupid'];
      mysqli_query($con,"delete from `group` where groupid = '$groupid'");
      }
    }
  }
  $kbd[] = [['text'=>'افزودن به گروهم','url'=>'https://t.me/'.$userbot.'?startgroup=new']];
  $kbd[] = [['text'=>'آپدیت لیست گروه ها','callback_data'=>'update']];
  $kbd = json_encode(['inline_keyboard'=>$kbd]);
}
  editmessagereplymarkup($chat_id,$message_id,$kbd);
}
if(preg_match("/sendgap_(.*)/",$data,$m)){
  $check = mysqli_query($con,"select * from `group` where groupid = '$m[1]'");
  if(mysqli_num_rows($check) != 0){
    $check = mysqli_fetch_assoc($check);
    $mtn = "پیام خود را بفرستید";
    sendmessage($chat_id,$mtn,$key);
    mysqli_query($con,"update member set step = 'gap_$m[1]' where userid = $chat_id");
  }else{
    sendmessage($chat_id,"no",$key);
  }
}
if(preg_match("/gap_(.*)/",$member['step'],$m)){
  $check = mysqli_query($con,"select * from `group` where groupid = '$m[1]'");
  if(mysqli_num_rows($check) != 0){
  $check = mysqli_fetch_assoc($check);
    if($check['permission'] == "yes"){
      $mtnnew= "✔️ارسال به گروه";
      $mtnnew2 = "❌لغو ارسال";
      $keyz = json_encode(['inline_keyboard'=>[
        [['text'=>$mtnnew,'callback_data'=>'sg_'.$m[1]],['text'=>$mtnnew2,'callback_data'=>'cg_'.$m[1]]]
        ]]);
      sendmessage($check['admincheck'],$text,$keyz);
      $mtn = "پیام شما برای ادمین تایید پیام ارسال شد و در صورت تایید به گروه ارسال میشود";
    }else{
      sendmessage($check['groupid'],$text,$key);
      $mtn = "پیام شما با موفقیت ارسال شد";
    }
    sendmessage($from_id,$mtn,$keys);
  }
  mysqli_query($con,"update member set step = 'none' where userid = $from_id");
}
  if(preg_match("/sg_(.*)/",$data,$m)){
    $text = $update->callback_query->message->text;
    $check = mysqli_query($con,"select * from `group` where groupid = '$m[1]'");
   if(mysqli_num_rows($check) != 0){
     $check = mysqli_fetch_assoc($check);
     sendmessage($check['groupid'],$text,$key);
     deletemessage($chat_id,$message_id);
   }
}
  if(preg_match("/cg_(.*)/",$data,$m)){
     deletemessage($chat_id,$message_id);
}
if(preg_match("/permission_(.*)/",$data,$m)){
  $check = mysqli_fetch_assoc(mysqli_query($con,"select * from `group` where groupid = '$m[1]'"));
  if($check['permission'] == 'yes'){
    mysqli_query($con,"update `group` set permission = 'no' where groupid = '$m[1]'");
  }else{
   mysqli_query($con,"update `group` set permission = 'yes' where groupid = '$m[1]'");
  }
  $check = mysqli_fetch_assoc(mysqli_query($con,"select * from `group` where groupid = '$m[1]'"));
        $mtnnew = "تایید ادمین برای ارسال ناشناس";
        $mtnnew2 = "تنظیم ادمین تایید پیام ها";
        if($check['permission']=="yes") $ke = "✔️";
        if($check['permission']=="no") $ke = "❌";
        $keys = json_encode(["inline_keyboard"=>[
          [["text"=> $mtnnew.$ke,"callback_data"=>"permission_".$check['groupid']]],
          [["text"=>$mtnnew2,'callback_data'=>"admingap_".$check['groupid']]]
          ]]);
          $mtn = "پنل مدیریت گروه";
          sendmessage($from_id,$mtn,$keys);
}
if(in_array($from_id,$admin) ){
  if($text == $mtn13){
    $amar = mysqli_num_rows(mysqli_query($con,"select * from member"));
    sendmessage($from_id,"$amar member joined bot",$key);
  }
  if($text == $mtn15){
    $mtn = "لطفا برای مسدود کردن کاربر ایدی عددی ان را ارسال کنید";
    sendmessage($from_id,$mtn,$backmember);
    mysqli_query($con,"update member set step = 'blockuser' where userid = $from_id");
  }
  if($member['step'] == 'blockuser'){
    $check = mysqli_query($con,"update member set step = 'blocked' where userid = $text");
    if($check){
      $mtn = 'با موفقیت انجام شد';
    }else{
      $mtn = 'ارور همگام انجام عملیات';
    }
    sendmessage($from_id,$mtn,$keyadmin);  
    mysqli_query($con,"update member set step = 'none' where userid = $from_id");
  }
  if($text == $mtn16){
    $mtn = "لطفا پیام خود را برای ارسال وارد نمائید";
    mysqli_query($con,"update member set step = 'forward' where userid = $from_id");
    sendmessage($from_id,$mtn,$backmember);
  }
  if ($member['step'] == 'forward') {
    $mtn = "در حال انجام عملیات \nلطفا تا پایان عملیات صبر کنید....";
    sendmessage($from_id,$mtn,$keyadmin);
    $check = mysqli_query($con,"select * from member");
    while ($row = mysqli_fetch_assoc($check)) {
      sendmessage($row['userid'],$text,$key);
    }
    $mtn = "ارسال پیام به تمامی کاربران با موفقیت انجام شد";
    sendmessage($from_id,$mtn,$keyadmin);
    
  }
}
}
if($type == "group" || $type == "supergroup"){
  $check = mysqli_query($con,"select * from `group` where groupid = '$chat_id'");
  if(mysqli_num_rows($check) == 0){
   mysqli_query($con,"insert into group(groupid,type,permission,admincheck) values('$chat_id','group','yes',");
    $data = bot("getChatAdministrators",["chat_id"=>$chat_id]);
    if ($data->ok) {
    $admins = $data->result;
    foreach ($admins as $admin) {
      if( $admin->status == "creator"){
        $admin_id = $admin->user->id;
        $admi_username ="@".$admin->user->username;
      }
    }
   mysqli_query($con,"insert into `group`(`groupid`,`type`,`permission`,`admincheck`) values('$chat_id','group','yes','$admin_id')");
   $mtn = "💎گروه شما با موفقیت ثبت شد\nادمین تایید پیام های ناشناس:$admi_username\nدر صورت برداشتن تایید پیام برای گروهتان یا تعویض ادمین تایید پیام های گروه سازنده گروه میتواند با ارسال دستور /tanzim آن را تنظیم کند";
   sendmessage($chat_id,$mtn,$key);
  }
}
if($text == "/tanzim"){
      $checkuser = bot("getChatMember",["chat_id"=> $chat_id,"user_id"=> $from_id])->result->status;
      if($checkuser == "creator"){
        $check = mysqli_fetch_assoc(mysqli_query($con,"select * from `group` where groupid = '$chat_id' "));
        $mtnnew = "تایید ادمین برای ارسال ناشناس";
        $mtnnew2 = "تنظیم ادمین تایید پیام ها";
        if($check['permission']=="yes") $ke = "✔️";
        if($check['permission']=="no") $ke = "❌";
        $keys = json_encode(["inline_keyboard"=>[
          [["text"=> $mtnnew.$ke,"callback_data"=>"permission_$chat_id"]],
          [["text"=>$mtnnew2,'callback_data'=>"admingap_$chat_id"]]
          ]]);
          $mtn = "پنل مدیریت گروه";
          sendmessage($from_id,$mtn,$keys);
      }elseif($checkuser == "Administrator"){
        $mtn = "تنها مالک توانایی دسترسی به اینبخش را دارد";
        sendmessage($chat_id,$mtn,$key);
      }
}
}
?>