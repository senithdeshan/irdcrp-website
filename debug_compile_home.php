<?php

require __DIR__.'/vendor/autoload.php';

$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$compiler = app('blade.compiler');
$src = file_get_contents(__DIR__.'/resources/views/home.blade.php');
$out = $compiler->compileString($src);

$target = __DIR__.'/storage/framework/views/_debug_home_compiled.php';
file_put_contents($target, $out);

echo $target.PHP_EOL;
