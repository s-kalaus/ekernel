<input<?php echo $this->onclick ? ' onclick="'.$this->onclick.'"' : '' ?><?php echo $this->class ? ' class="'.$this->class.'"' : '' ?> type="<?php echo $this->type ?>"<?php echo $this->name ? ' name="'.$this->escape($this->name).'"' : '' ?> value="<?php echo $this->escape($this->value) ?>" />