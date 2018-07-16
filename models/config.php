<?php
use ActiveRecord\Config;

Config::initialize(function ($cfg) {

    $cfg->set_model_directory('models'); 
    $cfg->set_connections(array('development' =>
        'mysql://root:root@localhost/user_archives')); 
});
