<?php
function unescape($source='') {  
    $decodedStr = "";  
    $pos = 0;  
    $len = strlen ($source);  
    while ($pos < $len) {  
        $charAt = substr ($source, $pos, 1);  
        if ($charAt=='%') {  
            $pos++;  
            $charAt = substr ($source, $pos, 1);  
            if($charAt=='u'){  
                // we got a unicode character  
                $pos++;  
                $unicodeHexVal = substr ($source, $pos, 4);  
                $unicode = hexdec ($unicodeHexVal);  
                $entity = "&#". $unicode . ';';  
                $decodedStr .= utf8_encode ($entity);  
                $pos += 4;  
            }else {  
                // we have an escaped ascii character  
                $hexVal = substr ($source, $pos, 2);  
                $decodedStr .= chr (hexdec ($hexVal));  
                $pos += 2;  
            }  
        } else {  
            $decodedStr .= $charAt;  
            $pos++;  
        }  
    }  
    return $decodedStr;  
}
$fopen=fopen('proxy.txt',"w");
for($i2=0;$i2<30;$i2++){
$files_get=file_get_contents('http://seprox.ru/ru/proxy_filter/0_1_0_on_on_on_on_0_0_'.$i2.'.html');
preg_match_all('#<script type="text/javascript">eval\(unescape\(\'(.*)\'\)\)\;#Uis',$files_get,$qwer);

foreach($qwer[1] as $gert){

$ggg=unescape($gert);
preg_match_all('#var (.*)=\'(.*)\'\;#Uis',$ggg,$arr);
preg_match_all('#document.write\((.*)\)\;#Uis',$ggg,$docum);
//var_dump($docum);
$i=0;
foreach ($arr[1] as $var){
$data=$arr[2][$i];
$ggg=str_replace($var,$arr[2][$i],$ggg);
$i++;
}
preg_match('#document.write\((.*)\)\;#Uis',$ggg,$docum2);
$docum2[1]=str_replace('+','',$docum2[1]);
//echo $docum2[1]."<br/>";
fwrite($fopen,$docum2[1]."\r\n");
}
}
fclose($fopen);
?>
