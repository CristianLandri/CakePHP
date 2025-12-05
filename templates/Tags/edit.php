<h1>Edit Tag</h1>
<?php
    echo $this->Form->create($tag);
    echo $this->Form->control('title');
    echo $this->Form->button(__('Save Tag'));
    echo $this->Form->end();
?>
