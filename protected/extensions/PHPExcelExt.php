<?php

/**
 * Class ImgurUploader
 */
class PHPExcelExt extends CApplicationComponent
{
    const PHPExcel_ALIAS_PASTH = "application.vendors.phpExcel";
    private $PHPExcel;

    function init()
    {
        $extRootPath = Yii::getPathOfAlias(self::PHPExcel_ALIAS_PASTH);
        //Include PHPExcel.php
//        spl_autoload_unregister(array('YiiBase','autoload'));
        include_once ('C:\wamp\www\YiiExtensionsDeveloper\protected\vendors\PHPExcel\PHPExcel.php');

        //Include PHPExcel_Writer_Excel2007
        include_once($extRootPath.DIRECTORY_SEPARATOR."PHPExcel/Writer/Excel2007.php");

        $this->PHPExcel = new PHPExcel();
//        spl_autoload_register(array('YiiBase','autoload'));
    }

    public function exportSample(){
        $extRootPath = Yii::getPathOfAlias(self::PHPExcel_ALIAS_PASTH).DIRECTORY_SEPARATOR.'abc';
        // Set properties
        echo date('H:i:s') . " Set properties<br/>";
        $this->PHPExcel->getProperties()->setCreator("Maarten Balliauw");
        $this->PHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
        $this->PHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $this->PHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $this->PHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

        // Add some data
        echo date('H:i:s') . " Add some data<br/>";
        $this->PHPExcel->setActiveSheetIndex(0);
        $this->PHPExcel->getActiveSheet()->SetCellValue('A1', 'Hello');
        $this->PHPExcel->getActiveSheet()->SetCellValue('B2', 'world!');
        $this->PHPExcel->getActiveSheet()->SetCellValue('C1', 'Hello');
        $this->PHPExcel->getActiveSheet()->SetCellValue('D2', 'world!');

// Rename sheet
        echo date('H:i:s') . " Rename sheet<br/>";
        $this->PHPExcel->getActiveSheet()->setTitle('Simple');


// Save Excel 2007 file
        echo date('H:i:s') . " Write to Excel2007 format<br/>";
        $objWriter = new PHPExcel_Writer_Excel2007($this->PHPExcel);
        $objWriter->save(str_replace('.php', '.xlsx', $extRootPath));

//// Echo done
//        echo date('H:i:s') . " Done writing file.\r\n";
    }


}