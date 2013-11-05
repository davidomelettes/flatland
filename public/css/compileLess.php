<?php

require "../../vendor/leafo/lessphp/lessc.inc.php";

$less = new lessc();
header("Content-Type: text/css");
echo $less->compileFile('../less/flatland.less');
