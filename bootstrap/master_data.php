<?php
/**
 * MLM Admin Page : Master data
 * 2020/05/16 Created by RedSpider
 *
 * @author RedSpider
 */

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

