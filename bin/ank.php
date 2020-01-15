<?php
//---------------------------------------------------------------
// Setup Global Error Levels
//
//--------------------------------------------------------------
// error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/func.php';
$workDir    = getcwd();
$tplPath    = __DIR__ . '/../src/tpl';
$controller = trim($argv[1] ?? '');
$action     = $argv[2] ?? '';
if (!file_exists($workDir . '/composer.json')) {
    $anw = getChar('Creating Project ?  (y/n):');
    if ($anw == 'y') {
        $projectName = getRequireName('Project Name:');
        $dirName     = getRequireName('Project Dir Name (default is Project Name):', false);
        $moduleName  = getRequireName('Default Module Name:');
        $dirName || ($dirName = $projectName);
        if (!is_dir($workDir . '/' . $dirName)) {
            $workDir = $workDir . '/' . $dirName;
            mkdir($workDir);
            chdir($workDir);
        }

        clilog('create project...');
        $name  = $argv[2] ?? 'index';
        $rearr = [
            'MODULE_NAME'  => $moduleName,
            'MODULE_NAME.' => $moduleName . '/',
            'PROJECT_NAME' => $projectName,

        ];
        copy_dir($tplPath . '/project', $workDir, $rearr);
        copy_dir($tplPath . '/app', $workDir . '/app', $rearr);
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

switch ($controller) {
    case 'install':
        $args = implode(' ', $argv);
        $str  = substr(strpos($args, 'install '), $args);
        exec('composer --working-dir=' . $workDir . ' install' . $str);
        break;

    default:
        $obj = loadlib($controller);
        if ($obj) {
            if ($action && method_exists($obj, $action)) {
                $obj->$action();
            } else {
                $obj->run();
            }

        }
        break;
}
