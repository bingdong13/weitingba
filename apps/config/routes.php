<?php

return array(
    
    '/' => array(
        'params' => array(
            'controller' => 'index',
            'action' => 'index'
        ),
        'name' => 'index-redirect',
    ),

    '/:controller/:action/:params' => array(
        'params' => array(
            'controller' => 1,
            'action' => 2,
            'params' => 3
        ),
        'name' => 'cap-redirect',
    ),
    
    '/:controller' => array(
        'params' => array(
            'controller' => 1,
            'action' => 'index'
        ),
        'name' => 'cap-index',
    ),
    
    '/jcrop_([0-9a-zA-z\.]+)_([0-9]+)_([0-9]+)' => array(
        'params' => array(
            'controller' => 'api',
            'action' => 'loadJcrop',
            'file' => 1,
            'width' => 2,
            'height' => 3
        ),
        'name' => 'api-jcrop',
    ),

    '/account' => array(
        'params' => array(
            'controller' => 'account',
            'action' => 'index'
        ),
        'name' => 'account-index',
    ),
    
    '/shared' => array(
        'params' => array(
            'controller' => 'shared',
            'action' => 'index'
        ),
        'name' => 'shared-index',
    ),
    '/shared_([0-9]+)' => array(
        'params' => array(
            'controller' => 'shared',
            'action' => 'index',
            'cid' => 1
        ),
        'name' => 'shared-category',
    ),

    '/notebook' => array(
        'params' => array(
            'controller' => 'notebook',
            'action' => 'index'
        ),
        'name' => 'notebook-index',
    ),
    '/notebook_([0-9]+)' => array(
        'params' => array(
            'controller' => 'notebook',
            'action' => 'index',
            'cid' => 1
        ),
        'name' => 'notebook-category',
    ),
    '/notebook@([0-9]+)' => array(
        'params' => array(
            'controller' => 'notebook',
            'action' => 'info',
            'nid' => 1
        ),
        'name' => 'notebook-info',
    ),

    '/magazine' => array(
        'params' => array(
            'controller' => 'magazine',
            'action' => 'index'
        ),
        'name' => 'magazine-index',
    ),
    '/magazine_([0-9]+)' => array(
        'params' => array(
            'controller' => 'magazine',
            'action' => 'index',
            'cid' => 1
        ),
        'name' => 'magazine-category',
    ),
    '/magazine@([0-9]+)' => array(
        'params' => array(
            'controller' => 'magazine',
            'action' => 'info',
            'nid' => 1
        ),
        'name' => 'magazine-info',
    ),

    '/tour' => array(
        'params' => array(
            'controller' => 'tour',
            'action' => 'index'
        ),
        'name' => 'tour-index',
    ),
    '/tour@([0-9]+)' => array(
        'params' => array(
            'controller' => 'tour',
            'action' => 'info',
            'tid' => 1
        ),
        'name' => 'tour-info',
    ),

    '/fm' => array(
        'params' => array(
            'controller' => 'index',
            'action' => 'fm'
        ),
        'name' => 'fm-index',
    )
);