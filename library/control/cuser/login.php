<?php
/**
 * ekernel
 *
 * Copyright (c) 2012 Magwai Ltd. <info@magwai.ru>, http://magwai.ru
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 */

$this->config_include('cuser');

$this->control(array(
	'use_db' => false,
	'type' => 'add',
	'oac' => array(
		'cancel' => false,
		'apply' => false,
		'ok' => array(
			'value' => 'Войти',
		)
	),
	'place' => 'Авторизация',
	'field' => array(
		'login' => array(
			'title' => 'Логин',
			'required' => true,
			'order' => 1
		),
		'password' => array(
			'type' => 'password',
			'required' => true,
			'title' => 'Пароль',
			'order' => 2
		),
		'remember' => array(
			'type' => 'checkbox',
			'title' => 'Запомнить меня',
			'value' => 1,
			'order' => 3
		),
		'role' => array(
			'active' => false
		),
		'date' => array(
			'active' => false
		),
		'active' => array(
			'active' => false
		),
		'pic' => array(
			'active' => false
		)
	),
	'callback' => array(
		'success' => function($control) {
			$ok = $control->view->user()->login($control->config->data->login, $control->config->data->password, $control->config->data->remember);
			unset($control->config->notify);
			$control->config->notify = array(array(
				'title' => $ok ? 'Добро пожаловать, '.$control->config->data->login : 'Логин/пароль неверны',
				'style' => $ok ? 'success' : 'warning'
			));
			if ($ok) $control->config->request->current = array(
				'controller' => 'cindex',
				'action' => 'index'
			);
		}
	)
));