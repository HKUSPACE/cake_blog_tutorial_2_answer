<?php
class CommentsController extends AppController{
	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');
	public $uses = array('Comment', 'Post');
	
	public function index($postId = null){
		if (!$postId) {
			throw new NotFoundException(__('Invalid post id'));
		}
		
		// 找出所有 posts 表格內 post_id 的值為輸入的函數
		$comments = $this->Comment->find('all', array(
			// 同時找出關聯的 post
			'contain' => array('Post'),
			'conditions' => array('Comment.post_id' => $postId)
		));
		
		$this->set('comments', $comments);
		$this->set('postId', $postId);
	}
	
	public function add($postId = null){
		if (!$postId) {
			throw new NotFoundException(__('Invalid post id'));
		}
		
        if ($this->request->is('post')) {
            $this->Comment->create();
            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash(__('Your comment has been saved.'));
                return $this->redirect('/posts/view/'.$postId);
            }
            $this->Session->setFlash(__('Unable to add your comment.'));
        }
		
		$post = $this->Post->findById($postId);
		$this->set('post', $post);
	}
	
	// edit 功能可由 /comments/edit/{comment-id} 運行 
	public function edit($id = null){
		// 先確定在 URL 拿到 $id
		if (!$id) {
			throw new NotFoundException(__('Invalid comment'));
		}
		
		// 從數據庫中找出需要更改的 comment
		$comment = $this->Comment->findById($id);
		if (!$comment) {
			throw new NotFoundException(__('Invalid comment'));
		}

		// 若果應用收到的 request 為 post 或 put
		if ($this->request->is(array('post', 'put'))) {
			// 設定 Comment model 的 id 為 URL 收到的 $id
			$this->Comment->id = $id;
			// 利用 Comment model 更新跟 id 為 $id 那一筆數據，CakePHP 自動將 $this->request->data 更新到數據庫
			if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash(__('Your comment has been updated.'));
				// 重新導向到 /comments/index/{post-id}
				return $this->redirect(array('action' => 'index', $comment['Comment']['post_id']));
			}
			$this->Session->setFlash(__('Unable to update your comment.'));
		}

		// 若果這一頁並沒有收到 request data，把 Comment model 讀到的數據存入 $this->request->data，FormHelper 會自動將數據放到 View 的 form 中。
		if (!$this->request->data) {
			$this->request->data = $comment;
		}
	}
	
	// delete 功能可由 /comments/delete 運行
	public function delete($id) {
		//	delete 功能需要收到 comment 的 $id，但為保持不會被亂啓動，確定應用收到的 request 不是從 URL 收到 (不是 GET)
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}

		// 因我們需要利用到 post_id，所以要先把需要刪除的 comment 數據拿出來
		$comment = $this->Comment->findById($id);
		if (!$comment) {
			throw new NotFoundException(__('Invalid comment'));
		}
		
		// 若 Comment model 能刪除所要求的 comment，重新導向到 /comments/index/{post-id}
		if ($this->Comment->delete($id)) {
			$this->Session->setFlash(
				__('The comment with id: %s has been deleted.', h($id))
			);
			return $this->redirect(array('action' => 'index', $comment['Comment']['post_id']));
		}
	}
}
?>