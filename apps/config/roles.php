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
            'tour' => array('index', 'info'),
            'guestbook' => array('index', 'loadList', 'loadReply')
        )
    ),
    
    'Member' => array(
        'resources' => array(
            'account' => array('*'),
            'guestbook' => array('add', 'delete')
        ), 
        'inherit' => 'Guests'
    ),
    
    'Admin' => array('resources' => '*')
);