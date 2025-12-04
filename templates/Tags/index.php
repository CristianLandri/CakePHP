<h1>Tags</h1>
<p><?= $this->Html->link('Add Tag', ['action' => 'add']) ?></p>
<table>
    <tr><th>Title</th><th>Action</th></tr>
    <?php foreach ($tags as $tag): ?>
    <tr>
        <td><?= h($tag->title) ?></td>
        <td>
            <?= $this->Html->link('View', ['action' => 'view', $tag->id]) ?>
            <?= $this->Html->link('Edit', ['action' => 'edit', $tag->id]) ?>
            <?= $this->Form->postLink('Delete', ['action' => 'delete', $tag->id], ['confirm' => 'Are you sure?']) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
