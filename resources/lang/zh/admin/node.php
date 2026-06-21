<?php

return [
    'validation' => [
        'fqdn_not_resolvable' => '提供的 FQDN 或 IP 地址无法解析为有效的 IP 地址。',
        'fqdn_required_for_ssl' => '要为此节点使用 SSL，需要解析到公网 IP 的完整域名。',
    ],
    'notices' => [
        'allocations_added' => '端口分配已成功添加到此节点。',
        'node_deleted' => '节点已成功从面板中移除。',
        'location_required' => '在向此面板添加节点之前，必须至少配置一个区域。',
        'node_created' => '新节点创建成功。您可以访问"配置"选项卡自动配置此机器上的守护进程。在添加任何服务器之前，必须首先分配至少一个 IP 地址和端口。',
        'node_updated' => '节点信息已更新。如果更改了任何守护进程设置，您需要重启守护进程以使其生效。',
        'unallocated_deleted' => '已删除 <code>:ip</code> 的所有未分配端口。',
    ],
];
