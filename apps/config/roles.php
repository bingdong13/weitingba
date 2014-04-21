<?php

return array(
    'Guests' => array(
        'resources' => array(
            'error' => array('*'),
            'api' => array('loadJcrop','uploadFile','crupImage', 'verify'),
            'passport' => array('*'),
            'index' => array('*'),
            'shared' => array('index', 'loadList'),
            'notebook' => array('index', 'loadList', 'info'),
            'magazine' => array('index', 'loadList', 'info'),
            'tour' => array('index', 'page')
        )
    ),
    
    'Admin' => array('resources' => '*')
);