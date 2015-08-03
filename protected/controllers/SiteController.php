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
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
//        $imgUrUploader = Yii::app()->imgUrUploader;
//        $res = '';
//
//        $album = $imgUrUploader->getImages();
//        var_dump($album[4]->_id);

//        if (isset($_FILES['file'])) {
//
//            $file = file_get_contents($_FILES["file"]["tmp_name"]);
//            $pVars = array(
//                'image' => base64_encode($file),
//                'title' => "Date A Live SS1 Thumbnail",
//                'description' => "Date A Live Seasion 1",
//                "type" => "base64",
//                "album" => "a3TbU",
//                "name" => "Thumbnail",
//            );
//
//            $res = $imgUrUploader->uploadImage($pVars);
//        }
//        $imgUrUploader->UpdateImageInfo("D7RzY0p",array("title" => "kurumi", "description" => "Kurumi_Tokisaki"));
//        $imgUrUploader->updateAlbumInfo("a3TbU",
//            array(
//                "cover" => "dzxiECE"
//            ));

        $phpExcelExt = Yii::app()->PHPExcelExt;
        $phpExcelExt->exportSample();

//        $this->render('index', compact('res'));
    }

}