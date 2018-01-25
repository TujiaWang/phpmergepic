<?php  
function thumb($file){
  $info = getimagesize($file);

  $type = image_type_to_extension($info[2], false);

  if($type=='png'){
    $src_im = @imagecreatefrompng($file);
  }else if($type=='jpeg'){
    $src_im = @imagecreatefromjpeg($file);
  }

  $dst_im = imagecreatetruecolor(86, 86);
    
  // 调整大小
  imagecopyresized($dst_im, $src_im, 0, 0, 0, 0, 86, 86, $info[0], $info[1]);

  return $dst_im;
}

function genImg($arr,$imgname){
  $dst_im = imagecreatetruecolor(300, 300);

  $red = imagecolorallocate($dst_im, 239, 239, 239);
  $white=imagecolorallocate($dst_im,255,255,255);

  imagefill($dst_im, 0, 0, $red);
  $x = 9;
  $y = 9;
  for($i = 0;$i < count($arr) ;$i++){
    $src_im = thumb($arr[$i]);
    if($i < 3){
      $x = 9 + (98 * $i);
      $y = 9;

      $lbx = 8 + (98 * $i);
      $lby = 8;
      $rbx = 8 + 88 + (98 * $i);
      $rby = 96;
    }else if($i < 6 && $i > 2){
      $x = 9 + (98 * ($i - 3));
      $y = 107;

      $lbx = 8 + (98 * ($i - 3));
      $lby = 106;
      $rbx = 8 + 88 + (98 * ($i - 3));
      $rby = 194;
    }else{
      $x = 9 + (98 * ($i - 6));
      $y = 205;

      $lbx = 8 + (98 * ($i - 6));
      $lby = 204;
      $rbx = 8 + 88 + (98 * ($i - 6));
      $rby = 292;
    }
    // echo 'i = '.$i.'x = '.$x.'y = '.$y.'<br>';
    // echo '(x1,y1)= ('.$lbx.','.$lby.') (x2,y2)= ('.$rbx.','.$rby.')<br>';
    imagefilledrectangle($dst_im,$lbx,$lby,$rbx,$rby, $white);
    imagecopy( $dst_im, $src_im, $x, $y, 0, 0, 86, 86 );
  }


  //输出拷贝后图像
  if(imagejpeg($dst_im,'./dist/'.$imgname.'.png')){
    echo 'dist/'.$imgname.'.png 已生成<br>';
  }

  imagedestroy($dst_im);
  imagedestroy($src_im);
}


$total = array();
$list = scandir('./imgs');
for($i = 2;$i < count($list);$i++){
  // echo 'imgs/'.$list[$i].'-----$i = '.$i.'<br>';
  array_push($total,'imgs/'.$list[$i]);
}


$totalarr = array_chunk($total,9);

for($i = 0;$i < count($totalarr);$i++){
  genImg($totalarr[$i],'test'.$i);
}