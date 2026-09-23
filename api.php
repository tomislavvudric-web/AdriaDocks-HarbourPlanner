<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
$file=__DIR__.'/data.json';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $raw=file_get_contents('php://input'); $j=json_decode($raw,true);
  if(!is_array($j)||!isset($j['projects'])||!is_array($j['projects'])){http_response_code(400);echo json_encode(['error'=>'bad data']);exit;}
  $out=['updatedAt'=>gmdate('c'),'projects'=>$j['projects']];
  $tmp=$file.'.tmp'; file_put_contents($tmp,json_encode($out,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT),LOCK_EX); rename($tmp,$file);
  echo json_encode(['ok'=>true,'updatedAt'=>$out['updatedAt']]); exit;
}
if(!file_exists($file)){echo json_encode(['updatedAt'=>'','projects'=>[]]);exit;}
readfile($file);
?>