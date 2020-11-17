function gas($voc){
date_default_timezone_set('Asia/Jakarta');
$url="https://gql.tokopedia.com";
echo "[!] Test VOC: {$voc}\n";
$data='[
  {
    "variables": {
      "data": {
        "product_id": 747,
        "price": 40000,
        "code": "'.$voc.'",
        "client_number": "no isi pulsa"
      }
    },
    "operationName": null,
    "md5": "isi md5",
    "query": "query rechargeCheckVoucher($data: RechargeInputVoucher!) {\n    status\n    rechargeCheckVoucher(voucher: $data) {\n        data {\n          success\n          code\n          discount_amount\n          cashback_amount\n          promo_code_id\n          is_coupon\n          message {\n            state\n            color\n            text\n          }\n          title_description\n        }\n        errors{\n          status\n          title\n        }\n    }\n}\n"
  }
]';
$h=array();
$h[]='{"content-type: application/json"}';
$h[]="x-tkpd-clc: isi value hash";
$h[]="x-method: POST";
$h[]="user-agent: TkpdConsumer/3.99 (Android 7.1.2;)";
$h[]="x-user-id: isi id tokped";
$h[]="request-method: POST";
$h[]="authorization: isi value";
$h[]="x-tkpd-app-version: android-3.99";
$h[]="x-tkpd-app-name: com.tokopedia.customerappp";
$h[]="date: Fri, ".date('d')." Nov 2020 ".date('h:i:s')." +0700";
$h[]="os_version: 25";
$h[]="content-md5: isi value";
$h[]="x-release-track: production";
$h[]="x-app-version: 320309904";
$h[]="x-device: android-3.99";
$h[]="tkpd-sessionid: isi value";
$h[]="tkpd-userid: isi value";
$h[]="fingerprint-hash: isi value";
$h[]="accounts-authorization: isi value";
$h[]="fingerprint-data: isi value";
$h[]="x-ga-id: isi value";
$h[]="content-type: application/json; charset=UTF-8";
$h[]="content-length: ".strlen($data);
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_HTTPHEADER,$h);
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_ENCODING,"gzip");
$res=json_decode(curl_exec($ch),true);
curl_close($ch);
$dat=$res[0]['data']['rechargeCheckVoucher']['data'];
$status=(int) $dat['success'];
$diskon=$dat['discount_amount'];
$pesan=$dat['message']['text'];
echo "[•] Voc: {$voc}\n[•] Status: {$status}\n[•] Diskon: {$diskon}\n[•] Pesan: {$pesan}\n";
if($diskon !=0 || $status==1){
$save=fopen('voc.txt','a');
fwrite($save,$voc."\n");
fclose($save);
}
}
error_reporting(0);
require_once 'voc.php';
$i=0;
while($i < 1000){
$voc="TKPD30".coupon::generate(4, ””, ””, true, true);
gas($voc);
sleep(5);
$i++;
}
   
