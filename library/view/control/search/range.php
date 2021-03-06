<?php

$val = explode(',', $this->control()->config->param->{'search_'.$this->name});
if ($this->range_type == 'date') {
	$this->messify	->append('js', '/'.DIR_KERNEL.'/ctl/ui/ui/jquery.ui.core.js')
					->append('js', '/'.DIR_KERNEL.'/ctl/ui/ui/jquery.ui.datepicker.js')
					->append('js', '/'.DIR_KERNEL.'/ctl/ui/ui/i18n/jquery.ui.datepicker-'.$this->control()->config->ui->lang.'.js')
					->append_inline('js', '$(function() { $("#c-table-filter-'.$this->name.'-1").datepicker('.Zend\Json\Json::encode($this->range_ui_param->to_array(), false, array(
						'enableJsonExprFinder' => true
					)).');$("#c-table-filter-'.$this->name.'-2").datepicker('.Zend\Json\Json::encode($this->range_ui_param->to_array(), false, array(
						'enableJsonExprFinder' => true
					)).'); });')
					->append('css', '/'.DIR_KERNEL.'/ctl/ui/themes/'.$this->control()->config->ui->theme.'/jquery.ui.core.css')
					->append('css', '/'.DIR_KERNEL.'/ctl/ui/themes/'.$this->control()->config->ui->theme.'/jquery.ui.theme.css')
					->append('css', '/'.DIR_KERNEL.'/ctl/ui/themes/'.$this->control()->config->ui->theme.'/jquery.ui.datepicker.css');
}

?>
<div class="c-table-filter-range"><input id="c-table-filter-<?php echo $this->name ?>-1" data-field="<?php echo $this->escape($this->name) ?>" data-default="<?php echo @$this->default[0] ?>" onkeydown="c.filter_change(this, event);" class="span5" type="text" value="<?php echo $this->escape(@$val[0] ? $val[0] : @$this->default[0]) ?>" /><span class="span2">-</span><input id="c-table-filter-<?php echo $this->name ?>-2" data-field="<?php echo $this->escape($this->name) ?>" data-default="<?php echo @$this->default[1] ?>" onkeydown="c.filter_change(this, event);" class="span5" type="text" value="<?php echo $this->escape(@$val[1] ? $val[1] : @$this->default[1]) ?>" /></div>
