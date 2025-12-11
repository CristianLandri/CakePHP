<h1>Users</h1>
<p><?= $this->Html->link('Add User', ['action' => 'add']) ?></p>
<table>
    <tr>
        <th>Email</th>
        <th>Created</th>
        <th>Action</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= h($user->email) ?></td>
        <td><?= $user->created ? $user->created->format(DATE_RFC850) : '' ?></td>
        <td>
            <?= $this->Html->link('View', ['action' => 'view', $user->id]) ?>
            <?= $this->Html->link('Edit', ['action' => 'edit', $user->id]) ?>
            <?= $this->Form->postLink('Delete', ['action' => 'delete', $user->id], ['confirm' => 'Are you sure?']) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
