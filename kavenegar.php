<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: ماژول پیامک کاوه نگار
Description: ارسال پیامک‌های سیستم از طریق سامانه پیامکی کاوه نگار
Author: میلاد مالدار
Version: 1.0.0
Requires at least: 2.9.*
Author URI: https://miladworkshop.ir
*/

define('KAVENEGAR_MODULE_NAME', 'kavenegar');

hooks()->add_filter('module_'.KAVENEGAR_MODULE_NAME.'_action_links', 'module_kavenegar_action_links');

function module_kavenegar_action_links($actions)
{
	$actions[] = '<a href="' . admin_url('settings?group=sms') . '">' . _l('settings') . '</a>';

	return $actions;
}

register_activation_hook(KAVENEGAR_MODULE_NAME, 'kavenegar_activation_hook');

function kavenegar_activation_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
}

$CI  =&get_instance();
$CI->load->library(KAVENEGAR_MODULE_NAME . '/sms_kavenegar');