<?php

return [
    'notices' => [
        'created' => '新预设 :name 已成功创建。',
        'deleted' => '已成功从面板中删除所请求的预设。',
        'updated' => '已成功更新预设配置选项。',
    ],
    'eggs' => [
        'notices' => [
            'imported' => '已成功导入此模板及其关联变量。',
            'updated_via_import' => '已使用提供的文件更新此模板。',
            'deleted' => '已成功从面板中删除所请求的模板。',
            'updated' => '模板配置已成功更新。',
            'script_updated' => '模板安装脚本已更新，将在服务器安装时运行。',
            'egg_created' => '新模板已成功创建。您需要重启所有正在运行的守护进程以应用此新模板。',
        ],
    ],
    'variables' => [
        'notices' => [
            'variable_deleted' => '变量 ":variable" 已删除，重建后服务器将不再可用。',
            'variable_updated' => '变量 ":variable" 已更新。您需要重建使用此变量的服务器以应用更改。',
            'variable_created' => '新变量已成功创建并分配给此模板。',
        ],
    ],
];
