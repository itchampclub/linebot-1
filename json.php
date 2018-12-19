<?php

$json = '{"foo-bar": สวัสดี}';


$obj = json_decode($json);
print $obj->{'foo-bar'}; // 12345

?>