<?php
return [
    //главная
    '' => 'galery/index',
    //Вход для админа в админ панель
    'admin' => 'admin/login',
    //Изменить логин или пароль для админа
    'admin/edit' => 'admin/edit',
    //Выход из админ панели
    'admin/output' => 'admin/logout',
    //Управление фотографиями
    'admin/index' => 'admin/index',
    'admin/create' => 'admin/create',
    'admin/delete/([0-9]+)' => 'admin/delete/$1',
    'admin/update/([0-9]+)' => 'admin/update/$1',
];