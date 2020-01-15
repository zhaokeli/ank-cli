<?php
//---------------------------------------------------------------
// Setup Global Error Levels
//
//--------------------------------------------------------------
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/func.php';
$workDir = getcwd();
$tplPath = __DIR__ . '/../tpl';
$action  = $argv[1] ?? '';
if (!file_exists($workDir . '/composer.json')) {
    $anw = getChar('Create Project ?  (y/n):');
    if ($anw == 'y') {
        while (true) {
            $anw = getChar('Project Name:');
            if (!preg_match('/[\w\d\-\_]{5,10}/', $anw, $mat)) {
                continue;
            }
            if (!is_dir($workDir . '/' . $anw)) {
                $workDir = $workDir . '/' . $anw;
                mkdir($workDir);
                chdir($anw);
                break;
            }
        }
        clilog('create project...');
        $name = $argv[2] ?? 'index';
        copy_dir($tplPath . '/project', $workDir);
        create_app($tplPath . '/app', $workDir . '/app', $name);
        exec('composer --working-dir=' . $workDir . ' install');
    }
    exit;
}

global $loader;
$autoloadFiles = [
    $workDir . '/vendor/autoload.php',
];
$autoloaderFound = false;

foreach ($autoloadFiles as $autoloadFile) {
    if (!file_exists($autoloadFile)) {
        continue;
    }
    $loader          = require_once $autoloadFile;
    $autoloaderFound = true;
}

$autoloaderFound or exit(
    'You must set up the project dependencies, run the following commands:' . PHP_EOL .
    'curl -s http://getcomposer.org/installer | php' . PHP_EOL .
    'php composer.phar install' . PHP_EOL
);

// echo $action, $name, PHP_EOL;
//设置argc argv进入对应控制器
$argc    = 2;
$isStart = false;
if ($action === 'greate') {
    $argv = [
        '-m=cli',
        '-c=index',
        '-a=greateTable',
    ];
    $isStart = true;
}
// elseif ($action === 'create') {
//     if (!file_exists($workDir . '/composer.json')) {
//         $name = $argv[2] ?? 'index';
//         copy_dir($tplPath . '/project', $workDir);
//         create_app($tplPath . '/app', $workDir . '/app', $name);
//         exec('composer --working-dir=' . $workDir . ' install');
//     } else {
//         echo 'composer.json exist', PHP_EOL;
//     }
// }
$isStart && \ank\App::start()->send();
