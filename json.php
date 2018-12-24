<?php

$json = '{"foo-bar": 12345}';


$obj = json_decode($json);
print $obj->{'foo-bar'}; // 12345

?>



Ub3ea97c513612d6e3401302f051f81dc