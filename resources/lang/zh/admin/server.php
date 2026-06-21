<?php

return [
    'exceptions' => [
        'no_new_default_allocation' => '您正在尝试删除此服务器的默认端口分配，但没有可用的备用端口。',
        'marked_as_failed' => '此服务器被标记为上次安装失败。在此状态下无法切换当前状态。',
        'bad_variable' => ':name 变量存在验证错误。',
        'daemon_exception' => '尝试与守护进程通信时出现异常，返回 HTTP/:code 响应码。此异常已记录。(请求 ID: :request_id)',
        'default_allocation_not_found' => '在此服务器的端口分配中未找到请求的默认端口。',
    ],
    'alerts' => [
        'startup_changed' => '此服务器的启动配置已更新。如果更改了此服务器的预设或模板，将立即进行重装。',
        'server_deleted' => '服务器已成功从系统中删除。',
        'server_created' => '服务器已成功在面板上创建。请等待守护进程几分钟以完成此服务器的安装。',
        'build_updated' => '此服务器的构建详情已更新。某些更改可能需要重启才能生效。',
        'suspension_toggled' => '服务器暂停状态已更改为 :status。',
        'rebuild_on_boot' => '此服务器已被标记为需要重建 Docker 容器。这将在下次服务器启动时发生。',
        'install_toggled' => '此服务器的安装状态已切换。',
        'server_reinstalled' => '此服务器已加入重装队列，现在开始。',
        'details_updated' => '服务器详情已成功更新。',
        'docker_image_updated' => '已成功更改此服务器的默认 Docker 镜像。需要重启才能应用此更改。',
        'node_required' => '在向此面板添加服务器之前，必须至少配置一个节点。',
        'transfer_nodes_required' => '在迁移服务器之前，必须至少配置两个节点。',
        'transfer_started' => '服务器迁移已开始。',
        'transfer_not_viable' => '您选择的节点没有足够的磁盘空间或内存来承载此服务器。',
    ],
];
