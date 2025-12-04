<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ArticlesTagsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('articles_tags');
        $this->setPrimaryKey(['article_id', 'tag_id']);

        $this->belongsTo('Articles', [
            'foreignKey' => 'article_id',
        ]);
        $this->belongsTo('Tags', [
            'foreignKey' => 'tag_id',
        ]);
    }
}
