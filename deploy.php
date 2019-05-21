<?php

namespace Deployer;

require 'recipe/symfony4.php';
require 'recipe/cachetool.php';
require __DIR__ . '/vendor/tijsverkoyen/deployer-sumo/sumo.php';

// Define some variables
set('client', 'xxx');
set('project', 'yyy');
set('repository', 'git@git.sumocoders.be:xxx/yyy.git');
set('production_url', 'https://xxx.yyy.php72.sumocoders.eu');

// Define staging
host('dev02.sumocoders.eu')
    ->user('sites')
    ->stage('staging')
    ->set('deploy_path', '~/apps/{{client}}/{{project}}')
    ->set('branch', 'master')
    ->set('bin/php', 'php7.2')
    ->set('cachetool', '/var/run/php_71_fpm_sites.sock')
    ->set('document_root', '~/php72/{{client}}/{{project}}');

/*************************
 * No need to edit below *
 *************************/

set('use_relative_symlink', false);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);

// Disallow stats
set('allow_anonymous_stats', false);

/*****************
 * Task sections *
 *****************/
// Build tasks
task(
    'build:assets:npm',
    function () {
        run('npm run build');
    }
)
    ->desc('Run the build script which will build our needed assets.')
    ->local();

// Upload tasks
task(
    'upload:assets',
    function () {
        upload(__DIR__ . '/public/build', '{{release_path}}/public');
    }
)
    ->desc('Uploads the assets')
    ->addBefore('build:assets:npm');
after('deploy:update_code', 'upload:assets');

/**********************
 * Flow configuration *
 **********************/
// Clear the Opcache
after('deploy:symlink', 'cachetool:clear:opcache');
// Unlock the deploy when it failed
after('deploy:failed', 'deploy:unlock');
