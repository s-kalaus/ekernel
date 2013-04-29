<?php

class k_router {
	public $route = array();

	public function __construct($routes) {
		// Добавляем маршрут по-умолчанию
		if ($routes) {
			foreach ($routes as $k => $v) $this->add_route($k, $v['type'], @$v['param']);
		}
	}

	public function add_route($key, $name, $param = array()) {
		// Добавление маршрута - просто инициализация его класса и сохранение его в хранилище
		$class = 'route_'.$name;
		$this->route[$key] = new $class($param);
	}

	public function run($request) {
		if ($this->route) {
			// Роутинг состоит в поочередном запуске каждого роута. Первый совпадающий с адресом заполняем request своими данными и роутинг прекращается
			$route = array_reverse($this->route);
			foreach ($route as $el) if ($el->route($request)) break;
		}
	}
}