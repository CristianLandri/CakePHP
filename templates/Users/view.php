<h1><?= h($user->email) ?></h1>
<p><small>Created: <?= $user->created ? $user->created->format(DATE_RFC850) : '' ?></small></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $user->id]) ?></p>
