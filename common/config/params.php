<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'maxFileUploadSize' => ini_get('upload_max_filesize') ? (int) str_replace('M', '', ini_get('upload_max_filesize')) : 5,
];
