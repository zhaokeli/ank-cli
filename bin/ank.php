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
if (!$controller) {
    $cmdstr = <<<eot
\033[32mANK Cli 1.0.0\033[0m

\033[33mAvailable commands:\033[0m
  \033[32mcreate project                    \033[0mcreate project
  \033[32mcreate all                        \033[0mcreate validate and model,skip if exist
  \033[32mcreate validate                   \033[0mcreate validate,skip if exist
  \033[32mcreate model                      \033[0mcreate model,skip if exist
  \033[32mcreate app                        \033[0mcreate example application
  \033[32mpreload                           \033[0mcreate preload script

\033[33mDatabase Migration:               \033[0m
  \033[32mdb migrations:generate            \033[0m生成迁移脚本
  \033[32mdb migrations:migrate             \033[0m迁移到最新版本
  \033[32mdb migrations:migrate [version]   \033[0m迁移到指定版本
  \033[32mdb status                         \033[0m查看详细信息
  \033[32mdb ......                         \033[0mdoc: https://www.doctrine-project.org/projects/doctrine-migrations/en/2.2/index.html


eot;
    echo $cmdstr;
    exit;
}
if ($controller == 'create' && $action == 'project') {
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
            system('composer --working-dir=' . $workDir . ' install');
        }
    } else {
        clilog('project is exist');
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
if (strpos($controller, 'db') !== false) {
    $obj = loadlib('migration');
    $obj->run();
    exit;
}
switch ($controller) {
    case 'install':
        $args = implode(' ', $argv);
        $str  = substr(strpos($args, 'install '), $args);
        system('composer --working-dir=' . $workDir . ' install' . $str);
        break;

    default:
        $obj = loadlib($controller);
        if ($obj) {
            $action .= 'Command';
            if ($action !== 'Command' && method_exists($obj, $action)) {
                $obj->$action();
            } else {
                $obj->run();
            }

        } else {
            echo 'not command execed !' . PHP_EOL;
        }
        break;
}
