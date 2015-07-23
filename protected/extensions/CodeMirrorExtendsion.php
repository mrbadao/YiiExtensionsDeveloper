<?php
class CodeMirrorExtendsion extends CApplicationComponent
{
    private $basePath;

    function init()
    {
        $this->basePath = sprintf("%s/plugin/codemirror/", Yii::app()->request->getBaseUrl(true));
    }

    public function import()
    {

    }
}
