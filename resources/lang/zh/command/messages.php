<?php

return [
    'location' => [
        'no_location_found' => '找不到与提供的短代码匹配的记录。',
        'ask_short' => '区域短代码',
        'ask_long' => '区域描述',
        'created' => '成功创建了新区域 (:name)，ID 为 :id。',
        'deleted' => '成功删除了请求的区域。',
    ],
    'user' => [
        'search_users' => '输入用户名、用户 ID 或邮箱地址',
        'select_search_user' => '要删除的用户 ID（输入 \'0\' 重新搜索）',
        'deleted' => '用户已成功从面板中删除。',
        'confirm_delete' => '确定要从此面板中删除该用户吗？',
        'no_users_found' => '未找到与搜索词匹配的用户。',
        'multiple_found' => '找到多个匹配的账户，由于 --no-interaction 标志，无法删除用户。',
        'ask_admin' => '该用户是否为管理员？',
        'ask_email' => '邮箱地址',
        'ask_username' => '用户名',
        'ask_name_first' => '名字',
        'ask_name_last' => '姓氏',
        'ask_password' => '密码',
        'ask_password_tip' => '如果要创建带有随机密码的账户并通过电子邮件发送给用户，请重新运行此命令（CTRL+C）并传递 `--no-password` 标志。',
        'ask_password_help' => '密码长度必须至少为8个字符，并包含至少一个大写字母和数字。',
        '2fa_help_text' => [
            '此命令将禁用用户账户的双因素验证（如果已启用）。仅应在用户被锁定无法访问其账户时用作账户恢复命令。',
            '如果不是此目的，请按 CTRL+C 退出此流程。',
        ],
        '2fa_disabled' => '已为 :email 禁用双因素验证。',
    ],
    'schedule' => [
        'output_line' => '正在调度 `:schedule` (:hash) 中第一个任务的作业。',
    ],
    'maintenance' => [
        'deleting_service_backup' => '正在删除服务备份文件 :file。',
    ],
    'server' => [
        'rebuild_failed' => '节点 ":node" 上 ":name" (#:id) 的重建请求失败，错误：:message',
        'reinstall' => [
            'failed' => '节点 ":node" 上 ":name" (#:id) 的重装请求失败，错误：:message',
            'confirm' => '您即将对一组服务器执行重装操作。是否继续？',
        ],
        'power' => [
            'confirm' => '您即将对 :count 台服务器执行 :action 操作。是否继续？',
            'action_failed' => '节点 ":node" 上 ":name" (#:id) 的电源操作请求失败，错误：:message',
        ],
    ],
    'environment' => [
        'mail' => [
            'ask_smtp_host' => 'SMTP 主机 (例如 smtp.gmail.com)',
            'ask_smtp_port' => 'SMTP 端口',
            'ask_smtp_username' => 'SMTP 用户名',
            'ask_smtp_password' => 'SMTP 密码',
            'ask_mailgun_domain' => 'Mailgun 域名',
            'ask_mailgun_endpoint' => 'Mailgun 端点',
            'ask_mailgun_secret' => 'Mailgun 密钥',
            'ask_mandrill_secret' => 'Mandrill 密钥',
            'ask_postmark_username' => 'Postmark API 密钥',
            'ask_driver' => '应使用哪个驱动发送邮件？',
            'ask_mail_from' => '发件邮箱地址',
            'ask_mail_name' => '发件人显示名称',
            'ask_encryption' => '加密方式',
        ],
    ],
];
