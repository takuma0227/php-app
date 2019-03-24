<?php

namespace App\Controller;

/**
 * Users Controller
 * 
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * @inheritdoc
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add']);
    }

    /**
     * ユーザ登録画面/ユーザ登録処理
     * 
     * @return \Cake\Http\Response|null ユーザ登録後にログイン画面に遷移する
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if($this->request->is('post')){
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if($this->Users->save($user)){
                $this->Flash->success('ユーザの登録が完了しました');

                return $this->redirect(['controller' => 'Login', 'action' => 'index']);
            }
            $this->Flash->error('ユーザの登録に失敗しました');
        }
        $this->set(compact('user'));
    }

    /**
     * ユーザ編集画面/ユーザ情報更新処理
     * 
     * @return \Cake\Http\Response|null ユーザ情報更新後に質問一覧画面へ遷移する
     */
    public function edit()
    {
        $user = $this->Users->get($this->Auth->user('id'));
        if($this->request->is('put')){
            $user = $this->Users->patchEntity($uesr, $this->request->getData());
            if($this->Users->save($user)){
                $this->Auth->setUser($user->toArray());

                $this->Flash->success('ユーザ情報を更新しました');

                return $this->redirect(['controller' => 'Questions', 'action' => 'index']);
            }
            $this->Flash->error('ユーザ情報の更新に失敗しました');
        }
        $this->set(compact('user'));
    }

    /**
     * パスワード更新画面/パスワード更新処理
     * 
     * @return \Cake\Http\Response|null パスワード更新後にユーザ編集画面へ遷移する
     */
    public function password()
    {
        $user = $this->Users->newEntity();
        if($this->request->is('post')){
            $user = $this->Users->get($this->Auth->user('id'));

            $user = $this->Users->patchEntity($user, $this->request->getData());
            if($this->Users->save($user)){
                $this->Auth->setUser($user->toArray());

                $this->Flash->success('パスワードを更新しました');

                return $this->redirect(['action' => 'edit']);
            }
            $this->Flash->error('パスワードの更新に失敗しました');
        }
        $this->set(compact('user'));
    }
}