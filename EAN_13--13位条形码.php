<?php
		
	function EAN_13($code){
		$Guide = array(1=>'AAAAAA','AABABB','AABBAB','ABAABB','ABBAAB','ABBBAA','ABABAB','ABABBA','ABBABA');
		$Lstart ='101';
		$Lencode = array("A" =>array('0001101','0011001','0010011','0111101','0100011','0110001','0101111','0111011','0110111','0001011'),
		                   "B" => array('0100111','0110011','0011011','0100001','0011101','0111001','0000101','0010001','0001001','0010111'));
		$Rencode = array('1110010','1100110','1101100','1000010','1011100',
		                   '1001110','1010000','1000100','1001000','1110100');
		$center = '01010';
		$ends = '101';
		if( strlen($code) != 13 ){ die("UPC-A Must be 13 digits."); }
		$lsum =0;
		$rsum =0;
		for($i=0;$i<(strlen($code)-1);$i++)
		{
			if($i % 2)
		    {
		    // $odd += $ncode[$x]
		    $lsum +=(int)$code[$i];  //偶数为的和a
		    }else{
		    	$rsum +=(int)$code[$i];//奇数位的和b
		    }
		}
		$tsum = $lsum*3 + $rsum;	//偶数c = a*3 + b
		// 用大于或等于结果c 且为10的倍数的最小数减c，差值即为所求校验值
		$n_13 = (10-($tsum % 10));
		if($n_13 == 10){
			$n_13 = 0;
		}
		return substr($code,0,12).$n_13;
	}
	echo EAN_13();

	//barcodegen  多种php条形码生成 
?>