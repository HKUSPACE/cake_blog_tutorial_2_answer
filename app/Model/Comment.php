<?php
class Comment extends AppModel{
	public $belongsTo = array('Post');
	public $actsAs = array('containable');
    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty'
        ),
		'email' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter your email.'
			),
			'email' => array(
				'rule' => array('email', true),
				'message' => 'Please enter a valid email address.'
			)
		),
        'body' => array(
            'rule' => 'notEmpty'
        )
    );}
?>