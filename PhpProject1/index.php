<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$ch = curl_init("http://192.168.1.2:8000/api01rv2/patientgetv2?id=1");

curl_setopt($ch,CURLOPT_USERPWD,'ormaster:ormaster123');
curl_setopt($ch,CURLOPT_HTTPGET,TRUE);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);

$c = curl_exec($ch);

$xml = new DOMDocument("1.0");

$xml->loadXML($c);

$xpath = new DOMXPath($xml);

$name = $xpath->query("/xmlio2/patientinfores/Patient_Information/WholeName")->item(0);
echo "名前:".$name->nodeValue."\n";
$address1 = $xpath->query("/xmlio2/patientinfores/Patient_Information/Home_Address_Information/WholeAddress1")->item(0);
$address2 = $xpath->query("/xmlio2/patientinfores/Patient_Information/Home_Address_Information/WholeAddress2")->item(0);
echo "住所:".$address1->nodeValue.$address2->nodeValue."\n";
$phone = $xpath->query("/xmlio2/patientinfores/Patient_Information/Home_Address_Information/PhoneNumber1")->item(0);
echo "電話番号:".$phone->nodeValue."\n";
$sex = $xpath->query("/xmlio2/patientinfores/Patient_Information/Sex")->item(0);
echo "性別:".toSexString($sex->nodeValue)."\n";
$birthdate = $xpath->query("/xmlio2/patientinfores/Patient_Information/BirthDate")->item(0);
echo "年齢:".toYear($birthdate->nodeValue)."\n";
curl_close($ch);

function toSexString($type){
	$ret = '';
	switch ($type){
		case 1:
			$ret = '男';
			break;
		case 2:
			$ret = '女';
			break;
	}
	return $ret;
}
function toYear($birthdate){
	$date = date('Ymd',strtotime($birthdate));
	return (int)((date('Ymd')-$date)/10000);
}