<h1>Add Comment for Post: <?php echo $post['Post']['title']; ?></h1>
<?php
echo $this->Form->create('Comment');
echo $this->Form->hidden('post_id', array('value'=>$post['Post']['id']));
echo $this->Form->input('name');
echo $this->Form->input('email');
echo $this->Form->input('body', array('rows' => '3'));
echo $this->Form->end('Save Comment');
?>