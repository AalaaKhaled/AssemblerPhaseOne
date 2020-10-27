<?php
$p=fopen('program.txt' ,'r');
$ps=fread($p,filesize('program.txt'));
fclose($p);
$a=explode(" ",$ps);
$b=array();
$c=array();
$d=array();

for($i=0;$i<=sizeof($a)/3-1;$i++){
array_push($b,$a[0+3*$i]);
array_push($c,$a[1+3*$i]);
array_push($d,$a[2+3*$i]);
}

$file = fopen('address.txt', 'w');
$file2 = fopen('objectcode.txt', 'w');


$zz=$d[0];//$zz is hex
//echo "zz=$d[0]";
//echo "<br>";
fwrite($file,$d[0]. "\r\n");
//array_push($addrs,$d[0]); 
$addrs=array();
array_push($addrs,$zz);
for($q=1;$q<sizeof($c);$q++){

if ($c[$q]=="RESW"){

		  $zch=hexdec($zz);// address 
		  $sumdec=$d[$q]*3+$zch;//sum in dec
		  $zz=dechex($sumdec);//
		  //echo "z=$zz";
		  fwrite($file,$zz. "\r\n");//file address 
		  array_push($addrs,$zz); //
		  echo "<br>";
	} 


    elseif($c[$q]=="RESB")
     {
	$zch=hexdec($zz);
	$sumdec=$d[$q]+$zch;
	$zz=dechex($sumdec);
	//echo"z=$zz";
	fwrite($file,$zz. "\r\n");
	array_push($addrs,$zz);
	echo "<br>";
	
     }
      elseif ($c[$q]=="BYTE"){

     
      $darr=explode("'",$d[$q]);
     unset($darr[2]);

     if($darr[0]=="c"){
        $zch=hexdec($zz);// address 
		$sumdec=strlen($darr[1])+$zch;//sum in dec
		$zz=dechex($sumdec);// 
		fwrite($file,$zz. "\r\n");
        array_push($addrs,$zz);
		//echo "z=$zz";
		//echo "<br>";
      
	}


	elseif($darr[0]=="x") {
	 if(strlen($darr[1])==1){
	 	 $zch=hexdec($zz);//address 
		 $sumdec=1+$zch;//
		 $zz=dechex($sumdec);//
		 //echo "z=$zz";
		//echo "<br>";
		fwrite($file,$zz. "\r\n");
         array_push($addrs,$zz);
		}elseif (strlen($darr[1])%2==0) {
          $zch=hexdec($zz);// address 
		  $sumdec=strlen($darr[1])/2+$zch;//
		  $zz=dechex($sumdec);//
         // echo "z=$zz";
		 // echo "<br>";
		  fwrite($file,$zz. "\r\n");
      array_push($addrs,$zz);
           
		}elseif (strlen($darr[1])%2!=0) {
		  $zch=hexdec($zz);//da el address 
		  $sumdec=ceil(strlen($darr[1])/2)+$zch; 
		  $zz=dechex($sumdec);//
		  //echo "z=$zz";
		 // echo "<br>";
		  fwrite($file,$zz. "\r\n");
      array_push($addrs,$zz);
        }
	}

      
     }
	
	

	
	
	else{//word +anything
		  $zch=hexdec($zz);//
		  $sumdec=3+$zch;//
		  $zz=dechex($sumdec);//
		  //echo "z=$zz";
		  fwrite($file,$zz. "\r\n");
		  array_push($addrs,$zz);
		 // echo "<br>";
		 
	}
}

$bb=array();
for($l=1;$l<sizeof($b);$l++)//to remove program's name copy 
{
 array_push($bb,$b[$l]);
}


$addrs2=array();
for($m=0;$m<sizeof($addrs)-1;$m++)// 
{
 array_push($addrs2,$addrs[$m]);
}

$mix=array_combine($bb,$addrs2);




foreach ($mix as $key => $value) {
	unset($mix[',']);
}






$appen=fopen('App.txt' ,'r');
$appr=fread($appen,filesize('App.txt'));
fclose($appen);
$apparr=explode(" ",$appr);
$e=array();
$f=array();
for($ii=0;$ii<sizeof($apparr)/2;$ii++){
array_push($e,$apparr[0+2*$ii]);
array_push($f,$apparr[1+2*$ii]);
}
$Q=array_combine($e,$f);


print_r($Q);




$obcode=array();
for($x=1;$x<sizeof($c);$x++){

if ($c[$x]=="RESW"){
     array_push($obcode,"------");
     fwrite($file2,"------". "\r\n");
		  
	} 


    elseif($c[$x]=="RESB")
     {
	array_push($obcode,"------");
	fwrite($file2,"------". "\r\n");
	
     }
     elseif ($c[$x]=="BYTE"){
      $darr=explode("'",$d[$x]);
     unset($darr[2]);
     if($darr[0]=="c"){
        $s=str_split($darr[1]);
       // print_r($s);
        for($ww=0;$ww<sizeof($s);$ww++){
	     //$aa=ord($s[0]);

	     $aa.=ord($s[$ww]);
          }
        //print_r($s);
      array_push($obcode,$aa);
      fwrite($file2,$aa. "\r\n");
	}


	elseif($darr[0]=="x") {
	 array_push($obcode,$darr[1]);
	 fwrite($file2,$darr[1]. "\r\n");
	}
   }
	elseif ($c[$x]=="WORD"){
      $ss=dechex($d[$x]);
      array_push($obcode,$ss); 
      fwrite($file2,$ss. "\r\n");
      
     }
	

	
	
	else{
		 $app=$Q[$c[$x]];
		 $app.=$mix[$d[$x]];
		 array_push($obcode,$app); 
		 fwrite($file2,$app. "\r\n");
		 
	}
}
//echo "obj<br>";
print_r($obcode);







?>