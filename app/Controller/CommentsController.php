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
}
?>