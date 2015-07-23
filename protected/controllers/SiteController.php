<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$imgUrUploader = Yii::app()->imgUrUploader;
//		$res = $imgUrUploader->getImages();
		$res = $imgUrUploader->getImage("8zYqI9h");
		var_dump($res);

//		var_dump($imgUrUploader->getAlbums());
//		var_dump($res->getAttributes());
//		$this->render('index');
	}

}