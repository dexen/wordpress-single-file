<?php

function H($v) { return htmlspecialchars($v); }

function td(...$a) {
	foreach ($a as $v)
		fprintf(STDERR, "%s\n", H(var_export($v, true)));
	fprintf(STDERR, "--\ntd()\n");
	die(2);
}

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

echo <<<'EOS'
<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

function H($v) { return htmlspecialchars($v); }

define('VALIDITY_PERIOD_SECONDS', 24 * 3600); # one day

if (filemtime(__FILE__) + VALIDITY_PERIOD_SECONDS < time()) {
	unlink(__FILE__);
	die('package aged out'); }

function TRACE(string $pn)
{
	echo H($pn), "\n";
	if (ob_get_level())
		ob_flush();
	flush();
}

function create_file(string $pn, string $content)
{
	if (!is_dir(dirname($pn)))
		mkdir(dirname($pn), 0777, $recursive = true);
	TRACE($pn);
	file_put_contents($pn, $content);
}

header('Content-Type: text/plain');

$h = fopen(__FILE__, 'r');
fseek($h,  __COMPILER_HALT_OFFSET__);
while (($line = fgets($h)) !== false) {
	$str = hex2bin(rtrim($line, "\n"));
	unset($line);
	$rcd = unserialize($str);
	unset($str);
	create_file($rcd[0], gzinflate($rcd[1])); }

echo "ALL DONE.\n";

unlink(__FILE__);

__halt_compiler();
EOS;

while (($line = readline()) !== false) {
	$pn = $line;
	$str = serialize([$pn, gzdeflate(file_get_contents($pn), 9)]);
	echo bin2hex($str), "\n";
}
