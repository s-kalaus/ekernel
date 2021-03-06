<?php
/**
 * ekernel
 *
 * Copyright (c) 2012 Magwai Ltd. <info@magwai.ru>, http://magwai.ru
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 */

class k_view_helper_meta_collector extends view_helper_meta {
	public $description = array();
	public $keywords = array();

	function url($url = '') {
		$url = $url ? $url : application::get_instance()->request->url;
		if (application::get_instance()->config->resource->lang) {
			$m = new model_lang;
			$langs = $m->fetch_col('stitle', array(
				'show_it' => 1
			));
			$url = preg_replace('/^\/('.implode('|', $langs).')\//si', '/', $url);
		}
		$m = new model_meta;
		$data = $m->fetch_by_url($url);
		if ($data) $this->auto($data, false);
	}

	function controller($name, $id) {
		$m = new model_meta;
		$data = $m->fetch_by_controller($name, $id);
		if ($data) $this->auto($data, false);
	}

	function auto($data, $correct = true) {
		if (!$data) return;
		if (!is_array($data)) $data = array(
			'title' => $data
		);

		$title_a = $this->analize($data['title']);
		if ($title_a['sign'] == '+') $this->view->title()->append($title_a['value']);
		else if ($title_a['sign'] == '-') $this->view->title()->prepend($title_a['value']);
		else $this->view->title()->clear()->append($title_a['value']);
		$this->view->title()->append_site_title = $title_a['site_title'];

		$keywords = @$data['keywords'] ? $data['keywords'] : $data['title'];
		if ($keywords) {
			$words = $correct ? preg_replace('/(\,|\-|\;|\_|\.)/si', ' ', $keywords) : $keywords;
			do $words = str_replace('  ', ' ', $words, $count);
			while($count);
			$keywords_a = $this->analize($correct ? str_replace(' ', ', ', $words) : $words);
			if ($keywords_a['sign'] == '+') array_push($this->keywords, $keywords_a['value']);
			else if ($keywords_a['sign'] == '-') array_unshift($this->keywords, $keywords_a['value']);
			else $this->keywords = array($keywords_a['value']);
			$this->view->meta()->set('name', 'keywords', implode(', ', $this->keywords));
		}

		$description = @$data['description'] ? $data['description'] : $data['title'];
		if ($description) {
			$description_a = $this->analize($description);
			if ($description_a['sign'] == '+') array_push($this->description, $description_a['value']);
			else if ($description_a['sign'] == '-') array_unshift($this->description, $description_a['value']);
			else $this->description = array($description_a['value']);
			$this->view->meta()->set('name', 'description', implode('. ', $this->description));
		}
	}

	function analize($str) {
		$is_site_title = false;
		$is_sign = '';
		if (substr($str, 0, 1) == '@') {
			$is_site_title = true;
			$str = substr($str, 1);
		}
		$first = substr($str, 0, 1);
		if ($first == '+' || $first == '-') {
			$is_sign = $first;
			$str = substr($str, 1);
		}
		return array(
			'site_title' => $is_site_title,
			'sign' => $is_sign,
			'value' => $str
		);
	}
}