<h1>Comments for Post ID: <?php echo $postId; ?></h1>
<?php echo $this->Html->link(
    'Add Comment',
    array('controller' => 'comments', 'action' => 'add', $postId)
); ?>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
		<th>Action</th>
        <th>Created</th>
    </tr>

    <?php foreach ($comments as $comment): ?>
    <tr>
        <td><?php echo $comment['Comment']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($comment['Comment']['body'],
array('controller' => 'comments', 'action' => 'view', $comment['Comment']['id'])); ?>
        </td>
		<td>
			<?php
                echo $this->Form->postLink(
                    'Delete',
                    array('action' => 'delete', $comment['Comment']['id']),
                    array('confirm' => 'Are you sure?')
                );
            ?>
            <?php
                echo $this->Html->link(
                    'Edit',
                    array('action' => 'edit', $comment['Comment']['id'])
                );
            ?>
        </td>
        <td><?php echo $comment['Comment']['created']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($comment); ?>
</table>
<?php echo $this->Html->link(
	'Back to post',
	'/posts/view/'.$postId
); ?>