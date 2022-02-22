<?php

require_once __DIR__ . '/vendor/autoload.php';
include 'config/messages.php';

if (is_callable('fastcgi_finish_request ')){
    session_write_close();
    fastcgi_finish_request ();
}

set_time_limit(0);
date_default_timezone_set("Iran/Tehran");

$development_mode = true;
