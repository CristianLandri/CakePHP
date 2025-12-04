<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;

class TagsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    public function index()
    {
        $tags = $this->paginate($this->Tags->find());
        $this->set(compact('tags'));
    }

    public function view($id = null)
    {
        $tag = $this->Tags->get($id, ['contain' => ['Articles']]);
        $this->set(compact('tag'));
    }

    public function add()
    {
        $tag = $this->Tags->newEmptyEntity();
        if ($this->request->is('post')) {
            $tag = $this->Tags->patchEntity($tag, $this->request->getData());
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add the tag.'));
        }
        $this->set(compact('tag'));
    }

    public function edit($id = null)
    {
        $tag = $this->Tags->get($id);
        if ($this->request->is(['post', 'put'])) {
            $this->Tags->patchEntity($tag, $this->request->getData());
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('The tag has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update the tag.'));
        }
        $this->set(compact('tag'));
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tag = $this->Tags->get($id);
        if ($this->Tags->delete($tag)) {
            $this->Flash->success(__('The tag has been deleted.'));
        } else {
            $this->Flash->error(__('Unable to delete the tag.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
