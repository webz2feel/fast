<?php

return [
    [
        'name' => 'Software',
        'flag' => 'plugins.software',
    ],
    [
        'name'        => 'Softwares',
        'flag'        => 'softwares.index',
        'parent_flag' => 'plugins.software',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'softwares.create',
        'parent_flag' => 'softwares.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'softwares.edit',
        'parent_flag' => 'softwares.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'softwares.destroy',
        'parent_flag' => 'softwares.index',
    ],

    [
        'name'        => 'Categories',
        'flag'        => 'software-categories.index',
        'parent_flag' => 'plugins.software',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'software-categories.create',
        'parent_flag' => 'software-categories.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'software-categories.edit',
        'parent_flag' => 'software-categories.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'software-categories.destroy',
        'parent_flag' => 'software-categories.index',
    ],

    [
        'name'        => 'Tags',
        'flag'        => 'software-tags.index',
        'parent_flag' => 'plugins.software',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'software-tags.create',
        'parent_flag' => 'software-tags.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'software-tags.edit',
        'parent_flag' => 'software-tags.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'software-tags.destroy',
        'parent_flag' => 'software-tags.index',
    ],
];
