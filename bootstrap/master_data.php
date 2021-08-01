<?php
/**
 * MLM Admin Page : Master data
 * 2020/05/16 Created by RedSpider
 *
 * @author RedSpider
 */

define('USER_NOT_LOGINNED', 0);
define('USER_LOGINNED', 1);

define('API_RESULT_SUCCESS', 0);
define('API_RESULT_FAILURE', 1);

define('API_ERROR_NONE', 0);
define('API_ERROR_RUNTIME', 1);
define('API_ERROR_NO_DATA', 2);
define('API_ERROR_INVALID_USER', 11);
define('API_ERROR_INVALID_PASSWORD', 12);
define('API_ERROR_BANNED_USER', 13);
define('API_ERROR_ALREADY_LOGINNED', 14);
define('API_ERROR_INVALID_LICENSE', 15);

define('ACCESS_INTERVAL', 5 * 60);

# Role Data
define('USER_ROLE_ADMIN', 'admin');
define('USER_ROLE_SUBSCRIBER', 'writer');
$UserRoleData = array(
    USER_ROLE_ADMIN             => ['管理者', 'danger'],
    USER_ROLE_SUBSCRIBER        => ['投稿者', 'info'],

);

# User Gender
define('USER_GENDER_MALE', 0);
define('USER_GENDER_FEMALE', 1);
$UserGenderData = array(
    USER_GENDER_MALE     =>  ['男', 'primary'],
    USER_GENDER_FEMALE   =>  ['女', 'info'],
);


# Status
define('STATUS_BANNED', 0);
define('STATUS_ACTIVE', 1);
$StatusData = array(
    STATUS_BANNED       =>  ['無効', 'danger'],
    STATUS_ACTIVE       =>  ['有効', 'success'],
);

$g_masterData = array(
    'UserRoleData'          => $UserRoleData,
    'UserGenderData'        => $UserGenderData,
    'StatusData'            => $StatusData,
);

