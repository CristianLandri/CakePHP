<?php
// src/Controller/TagsController.php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\Paging\NumericPaginator;

class TagsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    public function index()
    {
        $paginator = new NumericPaginator();
        $tags = $paginator->paginate($this->Tags->find(), ['limit' => 10]);
        $this->set(compact('tags'));
    }

    public function view($id)
    {
        $tag = $this->Tags->get($id);
        $this->set(compact('tag'));
    }

    public function add()
    {
        $tag = $this->Tags->newEmptyEntity();
        if ($this->request->is('post')) {
            $tag = $this->Tags->patchEntity($tag, $this->request->getData());
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('Your tag has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your tag.'));
        }
        $this->set('tag', $tag);
    }

    public function edit($id)
    {
        $tag = $this->Tags->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->Tags->patchEntity($tag, $this->request->getData());
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('Your tag has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your tag.'));
        }
        $this->set('tag', $tag);
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tag = $this->Tags->get($id);
        if ($this->Tags->delete($tag)) {
            $this->Flash->success(__('The tag has been deleted.'));
            return $this->redirect(['action' => 'index']);
        }
    }
}
