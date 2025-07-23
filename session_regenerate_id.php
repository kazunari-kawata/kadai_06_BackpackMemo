<?php
session_start();

$session_id = session_id();

var_dump($session_id);

session_regenerate_id(true);
$new_session_id = session_id();

var_dump($new_session_id);
exit();
