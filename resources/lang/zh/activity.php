<?php

return [
    'auth' => [
        'fail' => '登录失败',
        'success' => '已登录',
        'password-reset' => '密码已重置',
        'reset-password' => '请求密码重置',
        'checkpoint' => '请求双因素验证',
        'recovery-token' => '使用双因素恢复令牌',
        'token' => '完成双因素验证',
        'ip-blocked' => '阻止了来自未列出 IP 地址的 :identifier 请求',
        'sftp' => [
            'fail' => 'SFTP 登录失败',
        ],
    ],
    'user' => [
        'user' => [
            'create' => '创建了新用户 :email',
        ],
        'account' => [
            'email-changed' => '邮箱从 :old 更改为 :new',
            'password-changed' => '密码已更改',
        ],
        'api-key' => [
            'create' => '创建了新的 API 密钥 :identifier',
            'delete' => '删除了 API 密钥 :identifier',
        ],
        'ssh-key' => [
            'create' => '向账户添加了 SSH 密钥 :fingerprint',
            'delete' => '从账户移除了 SSH 密钥 :fingerprint',
        ],
        'two-factor' => [
            'create' => '启用了双因素验证',
            'delete' => '禁用了双因素验证',
        ],
    ],
    'server' => [
        'reinstall' => '重装了服务器',
        'console' => [
            'command' => '在服务器上执行了 ":command"',
        ],
        'power' => [
            'start' => '启动了服务器',
            'stop' => '停止了服务器',
            'restart' => '重启了服务器',
            'kill' => '强制终止了服务器进程',
        ],
        'backup' => [
            'download' => '下载了 :name 备份',
            'delete' => '删除了 :name 备份',
            'restore' => '恢复了 :name 备份 (已删除文件: :truncate)',
            'restore-complete' => '完成了 :name 备份的恢复',
            'restore-failed' => '未能完成 :name 备份的恢复',
            'start' => '开始了新的 :name 备份',
            'complete' => '将 :name 备份标记为完成',
            'fail' => '将 :name 备份标记为失败',
            'lock' => '锁定了 :name 备份',
            'unlock' => '解锁了 :name 备份',
        ],
        'database' => [
            'create' => '创建了新数据库 :name',
            'rotate-password' => '为数据库 :name 更换了密码',
            'delete' => '删除了数据库 :name',
        ],
        'file' => [
            'compress_one' => '压缩了 :directory:files.0',
            'compress_other' => '在 :directory 中压缩了 :count 个文件',
            'read' => '查看了 :file 的内容',
            'copy' => '创建了 :file 的副本',
            'create-directory' => '创建了目录 :directory:name',
            'decompress' => '在 :directory 中解压了 :files',
            'delete_one' => '删除了 :directory:files.0',
            'delete_other' => '在 :directory 中删除了 :count 个文件',
            'download' => '下载了 :file',
            'pull' => '从 :url 下载了远程文件至 :directory',
            'rename_one' => '将 :directory:files.0.from 重命名为 :directory:files.0.to',
            'rename_other' => '在 :directory 中重命名了 :count 个文件',
            'write' => '向 :file 写入了新内容',
            'upload' => '开始上传文件',
            'uploaded' => '上传了 :directory:file',
        ],
        'sftp' => [
            'denied' => '因权限不足阻止了 SFTP 访问',
            'create_one' => '创建了 :files.0',
            'create_other' => '创建了 :count 个新文件',
            'write_one' => '修改了 :files.0 的内容',
            'write_other' => '修改了 :count 个文件的内容',
            'delete_one' => '删除了 :files.0',
            'delete_other' => '删除了 :count 个文件',
            'create-directory_one' => '创建了 :files.0 目录',
            'create-directory_other' => '创建了 :count 个目录',
            'rename_one' => '将 :files.0.from 重命名为 :files.0.to',
            'rename_other' => '重命名或移动了 :count 个文件',
        ],
        'allocation' => [
            'create' => '向服务器添加了 :allocation',
            'notes' => '将 :allocation 的备注从 ":old" 更新为 ":new"',
            'primary' => '将 :allocation 设置为主服务器端口',
            'delete' => '删除了 :allocation 端口分配',
        ],
        'schedule' => [
            'create' => '创建了 :name 计划任务',
            'update' => '更新了 :name 计划任务',
            'execute' => '手动执行了 :name 计划任务',
            'delete' => '删除了 :name 计划任务',
        ],
        'task' => [
            'create' => '为 :name 计划创建了新的 ":action" 任务',
            'update' => '更新了 :name 计划的 ":action" 任务',
            'delete' => '删除了 :name 计划的一个任务',
        ],
        'settings' => [
            'rename' => '将服务器名称从 :old 改为 :new',
            'description' => '将服务器描述从 :old 改为 :new',
        ],
        'startup' => [
            'edit' => '将 :variable 变量从 ":old" 改为 ":new"',
            'image' => '将服务器的 Docker 镜像从 :old 更新为 :new',
        ],
        'subuser' => [
            'create' => '添加 :email 为子用户',
            'update' => '更新了 :email 的子用户权限',
            'delete' => '移除 :email 作为子用户',
        ],
    ],
];
