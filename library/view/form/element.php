<?php

$error = $this->error;

?><div class="e-form-el<?php echo $this->item->required ? ' e-form-el-required' : '' ?><?php echo $this->item->class_frame ? ' '.$this->item->class_frame : '' ?><?php echo $error && $this->item->class_error ? ' '.$this->item->class_error : '' ?><?php echo $this->item->name ? ' e-form-el-'.$this->item->name : '' ?>">
	<?php echo $this->item->label ? '<label'.($this->item->class_label ? ' class="'.$this->item->class_label.'"' : '').'>'.$this->item->label.($this->item->required ? ' <span class="e-form-el-star">*</span>' : '').($this->item->description ? ' <span class="e-form-el-description">'.(string)$this->item->description.'</span>' : '').'</label>' : '' ?>
	<div class="e-form-el-control<?php echo $this->item->class_control ? ' '.$this->item->class_control : '' ?>"><?php echo (string)$this->item ?></div>
	<div class="fix"></div>
	<?php echo $error ?>
</div>
