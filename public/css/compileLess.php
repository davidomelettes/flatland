<?php

require "../../vendor/leafo/lessphp/lessc.inc.php";

$less = new lessc();
echo $less->compileFile('../less/flatland.less');