<?php
declare(strict_types=1);

namespace Bake\Test\App\Controller;

/**
 * BakeArticles Controller
 *
 * @property \Bake\Test\App\Model\Table\BakeArticlesTable $BakeArticles
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class BakeArticlesController extends AppController
{
    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authorization.Authorization');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->BakeArticles->find()
            ->contain(['BakeUsers']);
        $query = $this->Authorization->applyScope($query);
        $bakeArticles = $this->paginate($query);

        $this->set(compact('bakeArticles'));
    }

    /**
     * View method
     *
     * @param string|null $id Bake Article id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bakeArticle = $this->BakeArticles->get($id, contain: ['BakeUsers', 'BakeTags', 'BakeComments']);
        $this->Authorization->authorize($bakeArticle);
        $this->set(compact('bakeArticle'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bakeArticle = $this->BakeArticles->newEmptyEntity();
        $this->Authorization->authorize($bakeArticle);
        if ($this->request->is('post')) {
            $bakeArticle = $this->BakeArticles->patchEntity($bakeArticle, $this->request->getData());
            if ($this->BakeArticles->save($bakeArticle)) {
                $this->Flash->success(__('The bake article has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bake article could not be saved. Please, try again.'));
        }
        $bakeUsers = $this->BakeArticles->BakeUsers->find('list', limit: 200)->all();
        $bakeTags = $this->BakeArticles->BakeTags->find('list', limit: 200)->all();
        $this->set(compact('bakeArticle', 'bakeUsers', 'bakeTags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Bake Article id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bakeArticle = $this->BakeArticles->get($id, contain: ['BakeTags']);
        $this->Authorization->authorize($bakeArticle);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bakeArticle = $this->BakeArticles->patchEntity($bakeArticle, $this->request->getData());
            if ($this->BakeArticles->save($bakeArticle)) {
                $this->Flash->success(__('The bake article has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bake article could not be saved. Please, try again.'));
        }
        $bakeUsers = $this->BakeArticles->BakeUsers->find('list', limit: 200)->all();
        $bakeTags = $this->BakeArticles->BakeTags->find('list', limit: 200)->all();
        $this->set(compact('bakeArticle', 'bakeUsers', 'bakeTags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bake Article id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bakeArticle = $this->BakeArticles->get($id);
        $this->Authorization->authorize($bakeArticle);
        if ($this->BakeArticles->delete($bakeArticle)) {
            $this->Flash->success(__('The bake article has been deleted.'));
        } else {
            $this->Flash->error(__('The bake article could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}