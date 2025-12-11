<h1><?= h($tag->title) ?></h1>
<p><small>Created: <?= $tag->created ? $tag->created->format(DATE_RFC850) : '' ?></small></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $tag->id]) ?></p>
