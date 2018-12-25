<?php
require_once('./line_class.php');

$channelAccessToken = 'WsEg0h0hvWL6AH/5vRTp/VoKgHexRMQ+FOgbI9xrJ19q07jk59Z4X9p6laKD7BR6s8F8E3rZ0pvht4n4NOAtNkA726d4quuAYJW/P0rqABDermZI5505WTp5ix0BjLn6WVb67TpH/sIl6Bwv7m+yagdB04t89/1O/w1cDnyilFU='; //sesuaikan 
$channelSecret = '88556d8dd777dea8d4508b361332a939';
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
$userId     = $client->parseEvents()[0]['source']['userId'];
$groupId    = $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp  = $client->parseEvents()[0]['timestamp'];
$type       = $client->parseEvents()[0]['type'];
$message    = $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$messageid  = $client->parseEvents()[0]['message']['id'];
$pesan_datang = explode(" ", $message['text']);
$msg_type = $message['type'];
$command = $pesan_datang[0];
$options = $pesan_datang[1];
if (count($pesan_datang) > 2) {
    for ($i = 2; $i < count($pesan_datang); $i++) {
        $options .= '+';
        $options .= $pesan_datang[$i];
    }
}

#-------------------------[Main Function]-------------------------#
#-------------------------[Open]-------------------------#
function yandex($keyword) {
    $uri = "https://translate.yandex.net/api/v1.5/tr.json/translate?lang=en-th&key=trnsl.1.1.20181219T062414Z.5b564dfddd592ba6.b745ec8bc8abce2a600d3fc10eb4a37fc77d1b20&text=" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
	$result = $json['text'][0];
    return $result;
}
#-------------------------[Close]-------------------------#
#-------------------------[Open]-------------------------#
function longdo($keyword) { 
    $uri = "https://dict.longdo.com/mobile.php?search=" . $keyword; 
    $response = Unirest\Request::get("$uri"); 
    $result = $uri; 
    return $result; 
}
#-------------------------[Close]-------------------------#
#-------------------------[Open]-------------------------#
function urb_dict($keyword) {
    $uri = "http://api.urbandictionary.com/v0/define?term=" . $keyword;
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $result = $json['list'][0]['definition'];
    $result .= "\n\nExamples : \n";
    $result .= $json['list'][0]['example'];
    return $result;
}
#-------------------------[Close]-------------------------#





#-------------------------[Optional Function]-------------------------#
#-------------------------[Open]-------------------------#
function film_syn($keyword) {
    $uri = "http://www.omdbapi.com/?t=" . $keyword . '&plot=full&apikey=d5010ffe';

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "Judul : \n";
	$result .= $json['Title'];
	$result .= "\n\nSinopsis : \n";
	$result .= $json['Plot'];
    return $result;
}
#-------------------------[Close]-------------------------#
#-------------------------[Open]-------------------------#
function film($keyword) {
    $uri = "http://www.omdbapi.com/?t=" . $keyword . '&plot=full&apikey=d5010ffe';

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "「Informasi Film」";
    $result .= "\nJudul :";
	$result .= $json['Title'];
	$result .= "\nRilis : ";
	$result .= $json['Released'];
	$result .= "\nTipe : ";
	$result .= $json['Genre'];
	$result .= "\nActors : ";
	$result .= $json['Actors'];
	$result .= "\nBahasa : ";
	$result .= $json['Language'];
	$result .= "\nNegara : ";
	$result .= $json['Country'];
	$result .= "\n「Done~」";
    return $result;
}
#-------------------------[Close]-------------------------#
#-------------------------[Open]-------------------------#
function instagram($keyword) {
    $uri = "https://rest.farzain.com/api/ig_profile.php?id=" . $keyword . "&apikey=fDh6y7ZwXJ24eiArhGEJ55HgA";
  
    $response = Unirest\Request::get("$uri");
  
    $json = json_decode($response->raw_body, true);
    $parsed = array();
    $parsed['a1'] = $json['info']['username'];
    $parsed['a2'] = $json['info']['bio'];
    $parsed['a3'] = $json['count']['followers'];
    $parsed['a4'] = $json['count']['following'];
    $parsed['a5'] = $json['count']['post'];
    $parsed['a6'] = $json['info']['full_name'];
    $parsed['a7'] = $json['info']['profile_pict'];
    $parsed['a8'] = "https://www.instagram.com/" . $keyword;
    return $parsed;
}




//show menu, saat join dan command,menu
if ($command == 'Help') {
    $text .= "「Keyword RpdBot~」\n\n";
    $text .= "- Help\n";
    $text .= "- /jam \n";
    $text .= "- /quotes \n";
    $text .= "- /say [teks] \n";
    $text .= "- /definition [teks] \n";
    $text .= "- /coolteks [teks] \n";
    $text .= "- /shalat [lokasi] \n";
    $text .= "- /qiblat [teks] \n";
    $text .= "- /film [teks] \n";
    $text .= "- /film-syn [teks] \n";
    $text .= "- /zodiak [tanggal lahir] \n";
		$text .= "- /instagram [unsername] \n";
    $text .= "- /creator \n";
	$text .= "\n「Done~」";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
}
if ($type == 'join') {
    $text = "";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
}
//show menu, saat join dan command,menu


#-------------------------[Open]-------------------------#
if($message['type']=='text') {
    if ($command == '/instagram') { 
        
        $result = instagram($options);
        $altText2 = "Followers : " . $result['a3'];
        $altText2 .= "\nFollowing :" . $result['a4'];
        $altText2 .= "\nPost :" . $result['a5'];
        $balas = array( 
            'replyToken' => $replyToken, 
            'messages' => array( 
                array ( 
                        'type' => 'template', 
                          'altText' => 'Instagram' . $options, 
                          'template' =>  
                          array ( 
                            'type' => 'buttons', 
                            'thumbnailImageUrl' => $result['a7'], 
                            'imageAspectRatio' => 'rectangle', 
                            'imageSize' => 'cover', 
                            'imageBackgroundColor' => '#FFFFFF', 
                            'title' => $result['a6'], 
                            'text' => $altText2, 
                            'actions' =>  
                            array ( 
                              0 =>  
                              array ( 
                                'type' => 'uri', 
                                'label' => 'Check', 
                                'uri' => $result['a8'],
                              ), 
                            ), 
                          ), 
                        ) 
            ) 
        ); 
    }
}
#-------------------------[Close]-------------------------#
#-------------------------[Open]-------------------------#
if ($message['type'] == 'text') {
    if ($command == '/definition') {
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'Definition : ' . urb_dict($options)
                )
            )
        );
    }
}
#-------------------------[Close]-------------------------#
#-------------------------[Open]-------------------------#
if ($message['type'] == 'text') {
    if ($command == 'ดิก') {
        $result = longdo($options);
        $balas = array( 
            'replyToken' => $replyToken, 
            'messages' => array( 
                array ( 
                        'type' => 'template', 
                          'altText' => 'Result ' . $options, 
                          'template' =>  
                          array ( 
                            'type' => 'buttons', 
                            'text' => 'Longdo Dictionary', 
                            'actions' =>  
                            array ( 
                              0 =>  
                              array ( 
                'type' =>  'uri',
              'label' =>  'ดูผลลัพธ์',
              'uri' => longdo($options)
                              )
                            )
                          )
                        ) 
            ) 
        ); 
    }
} 

#-------------------------[Close]-------------------------#
#-------------------------[Open]-------------------------#
if ($message['type'] == 'text') {
    if ($command == 'ตารางสอบ') {
	$result = 'https://foodguidebot.herokuapp.com/grade2.php';
        $balas = array( 
            'replyToken' => $replyToken, 
            'messages' => array( 
                array ( 
                        'type' => 'template', 
                          'altText' => 'Grade', 
                          'template' =>  
                          array ( 
                            'type' => 'buttons', 
                            'text' => 'ดูตารางสอบล่าสุด', 
                            'actions' =>  
                            array ( 
                              0 =>  
                              array ( 
                'type' =>  'uri',
              'label' =>  'ดูตารางสอบ',
              'uri' => $result 
                              )
                            )
                          )
                        ) 
            ) 
        );
    }
} 
#-------------------------[Close]-------------------------#
#-------------------------[Open]-------------------------#
if ($message['type'] == 'text') {
    if ($command == 'ผลสอบ') {
	$result = 'https://foodguidebot.herokuapp.com/grade.php';
        $balas = array( 
            'replyToken' => $replyToken, 
            'messages' => array( 
                array ( 
                        'type' => 'template', 
                          'altText' => 'Grade', 
                          'template' =>  
                          array ( 
                            'type' => 'buttons', 
                            'text' => 'ดูผลสอบล่าสุด', 
                            'actions' =>  
                            array ( 
                              0 =>  
                              array ( 
                'type' =>  'uri',
              'label' =>  'ดูผลสอบ',
              'uri' => $result 
                              )
                            )
                          )
                        ) 
            ) 
        );
    }
} 
#-------------------------[Close]-------------------------#
#-------------------------[Open]-------------------------#
if($message['type']=='text') {
        if ($command == 'แปล') {

        $result = yandex($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array( 
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
#-------------------------[Close]-------------------------#
if($message['type']=='text') {
        if ($command == 'myid') {
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $userId
                )
            )
        );
    }
}
#-------------------------[Open]-------------------------#
if($message['type']=='text') {
        if ($command == '/film') {

        $result = film($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
#-------------------------[Close]-------------------------#	
if (isset($balas)) {
    $result = json_encode($balas);
    file_put_contents('./balasan.json', $result);
    $client->replyMessage($balas);
} 
?>
