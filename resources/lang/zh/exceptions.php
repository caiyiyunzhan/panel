<?php

return [
    'daemon_connection_failed' => '尝试与守护进程通信时出现异常，返回 HTTP/:code 响应码。此异常已记录。',
    'node' => [
        'servers_attached' => '节点必须没有关联的服务器才能被删除。',
        'daemon_off_config_updated' => '守护进程配置已更新，但在尝试自动更新守护进程上的配置文件时遇到错误。您需要手动更新配置文件(config.yml)以使守护进程应用这些更改。',
    ],
    'allocations' => [
        'server_using' => '当前有服务器分配到此端口。只有在没有服务器分配时才能删除端口。',
        'too_many_ports' => '单次不支持添加超过 1000 个端口。',
        'invalid_mapping' => '为 :port 提供的映射无效，无法处理。',
        'cidr_out_of_range' => 'CIDR 表示法只允许 /25 到 /32 之间的掩码。',
        'port_out_of_range' => '端口分配中的端口必须大于 1024 且小于等于 65535。',
    ],
    'nest' => [
        'delete_has_servers' => '无法从面板中删除包含活跃服务器的预设。',
        'egg' => [
            'delete_has_servers' => '无法从面板中删除包含活跃服务器的模板。',
            'invalid_copy_id' => '选择用于复制脚本的模板不存在，或正在复制自身脚本。',
            'must_be_child' => '此模板的"复制设置来源"指令必须是所选预设的子选项。',
            'has_children' => '此模板是一个或多个其他模板的父模板。请先删除这些模板后再删除此模板。',
        ],
        'variables' => [
            'env_not_unique' => '环境变量 :name 必须在此模板中唯一。',
            'reserved_name' => '环境变量 :name 受保护，无法分配给变量。',
            'bad_validation_rule' => '验证规则 ":rule" 不是此应用的有效规则。',
        ],
        'importer' => [
            'json_error' => '尝试解析 JSON 文件时出错：:error。',
            'file_error' => '提供的 JSON 文件无效。',
            'invalid_json_provided' => '提供的 JSON 文件格式无法识别。',
        ],
    ],
    'subusers' => [
        'editing_self' => '不允许编辑自己的子用户账户。',
        'user_is_owner' => '不能将服务器所有者添加为该服务器的子用户。',
        'subuser_exists' => '该邮箱地址的用户已被指定为此服务器的子用户。',
    ],
    'databases' => [
        'delete_has_databases' => '无法删除包含活跃数据库的数据库主机。',
    ],
    'tasks' => [
        'chain_interval_too_long' => '链式任务的最大间隔时间为 15 分钟。',
    ],
    'locations' => [
        'has_nodes' => '无法删除包含活跃节点的区域。',
    ],
    'users' => [
        'node_revocation_failed' => '撤销 <a href=":link">节点 #:node</a> 上的密钥失败。:error',
    ],
    'deployment' => [
        'no_viable_nodes' => '找不到满足自动部署所需规格的节点。',
        'no_viable_allocations' => '找不到满足自动部署要求的端口分配。',
    ],
    'api' => [
        'resource_not_found' => '请求的资源在此服务器上不存在。',
    ],
];
