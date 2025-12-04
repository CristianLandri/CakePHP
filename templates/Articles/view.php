<h1><?= h($article->title) ?></h1>
<p><?= h($article->body) ?></p>
<p><small>Created: <?= $article->created->format(DATE_RFC850) ?></small></p>
<?php if (!empty($article->tags)): ?>
<p>Tags:
	<?php foreach ($article->tags as $tag): ?>
		<?= $this->Html->link(h($tag->title), ['controller' => 'Tags', 'action' => 'view', $tag->id]) ?>
	<?php endforeach; ?>
</p>
<?php endif; ?>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $article->slug]) ?></p>
