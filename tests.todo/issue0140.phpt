--TEST--
Issue #140: "bcgen.enable_file_override" doesn't respect "opcache.revalidate_freq"
--INI--
bcgen.enable=1
--SKIPIF--
<?php require_once('skipif.inc'); ?>
<?php if (php_sapi_name() != "cli") die("skip CLI only"); ?>
<?php if (getenv("SKIP_SLOW_TESTS")) die("skip slow tests excluded by request") ?>
--FILE--
<?php
define("FILENAME", dirname(__FILE__) . "/issuer0140.inc.php");
file_put_contents(FILENAME, "1\n");

var_dump(is_readable(FILENAME));
include(FILENAME);
var_dump(filemtime(FILENAME));

sleep(2);
file_put_contents(FILENAME, "2\n");

var_dump(is_readable(FILENAME));
include(FILENAME);
var_dump(filemtime(FILENAME));

sleep(2);
unlink(FILENAME);

var_dump(is_readable(FILENAME));
var_dump(@include(FILENAME));
var_dump(@filemtime(FILENAME));
?>
--EXPECTF--
bool(true)
1
int(%d)
bool(true)
2
int(%d)
bool(false)
bool(false)
bool(false)
