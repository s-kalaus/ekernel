<?php

if (count($this->data)) {
	$class_li = $this->class_li;
	$script = $this->script;
	$data = $this->data;
	$level = (int)$this->level;
	$class_ul = $this->class_ul ? $this->class_ul->to_array() : array('navigation');

?>
<ul<?php echo $level ? '' : ' class="'.implode(' ', $class_ul).'"' ?>>
<?php

	foreach ($data as $el) {
		$class = $class_li ? $class_li->to_array() : array();
		if ($el->is_active(true)) $class[] = 'active';

?>
	<li<?php echo $class ? ' class="'.implode(' ', $class).'"' : '' ?>>
		<a href="<?php echo $el->href ?>"><?php echo $el->title ?></a>
		<?php echo $this->xlist(array(
			'fetch' => array(
				'data' => $el->pages
			),
			'view' => array(
				'script' => $script,
				'param' => array(
					'level' => $level + 1,
					'script' => $script,
					'class_li' => $class_li
				)
			)
		)) ?>
	</li>
<?php

	}

?>
</ul>
<?php

}