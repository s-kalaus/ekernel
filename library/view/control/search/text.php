<input data-field="<?php echo $this->escape($this->name) ?>" onkeydown="c.filter_change(this, event);" class="col-12" type="text" value="<?php echo $this->escape($this->control()->config->param->{'search_'.$this->name}) ?>" />