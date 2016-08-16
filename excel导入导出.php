<?php
//上传 读取excel
	include_once "Excel/PHPExcel.php";
	include_once "UploadFile.php";
	function importNumber(){
		if(!empty($_FILES)){
            $upload = new UploadFile();
            $upload->allowExts = array('xlsx','xls');
			$upload->savePath = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads')||!is_dir($_SERVER['DOCUMENT_ROOT'].'/uploads')){
				mkdir($_SERVER['DOCUMENT_ROOT'].'/uploads',0777);
			}
            if (!$upload->upload()) {
                echo ($upload->getErrorMsg());
            } else {
                $info = $upload->getUploadFileInfo();
            }
            $file_name=$info[0]['savepath'].$info[0]['savename'];
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
			if($highestRow>1){
				$item = array();
				for($i=2;$i<=$highestRow;$i++){
					$item[]=$objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
				}
				$_old_data = //查询数据库已存在的数据;
				$old_data =  array();
				if($_old_data){
					foreach($_old_data as $k=>$value){
						$old_data[] = $value['number'];
					}
				}
				$new_data = array();
				$success = 0;
				$repeat = 0;
				foreach($item as $k=>$v){
					if(in_array($v,$old_data)){
						$repeat++;
					}else{
						$new_data[] = array('number'=>$v);
						$success++;
					}
				}
				$create_model->addAll($new_data);
				echo '导入完成，导入'.$success.'条，重复'.$repeat.'条';exit;
			}else{
				echo  "没有用于导入的数据";exit;
			}
		}else{
			echo  "请选择上传的文件";
		}

	}
	
//导出
	function exportNumber(){

		$list = array(0=>array('number'=>'03938389'));
		header("Content-Type: text/html; charset=utf-8");
		header("Content-type:application/vnd.ms-execl");
		header("Content-Disposition:filename=number.xls");
		$row = array('A');
		$title=array(
			array('en'=>'number','cn'=>'卡号'),//中英文字段名成
		);
		$i=0;
		$fieldCount=count($title);
		$s=0;
/*		foreach($title as $f){
			if ($s<$fieldCount-1){
				echo iconv('utf-8','gbk',$f['cn'])."\t";
			}else {
				echo iconv('utf-8','gbk',$f['cn'])."\n";
			}
			$s++;
		}*/

		foreach ($list as $value){
			$i = 1;
			foreach ($title as $t){
				switch ($t['en']){
					default :
						$field = $value[$t['en']];
				}
				echo iconv('utf-8','gbk',$field);
				if($i < count($title)){
					echo "\t";
				}else{
					echo "\n";
				}
				$i ++;
			}
		}
		exit;

	}
	
	exportNumber();
?>