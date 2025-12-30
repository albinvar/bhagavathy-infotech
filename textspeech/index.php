
<?php

// Debug
//print_r($_SESSION['response']);

$txt='Welcome to Artcl finance management systems';
  $txt=htmlspecialchars($txt);
  $txt=rawurlencode($txt);
  $audio=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl=en-IN');
  $speech="<audio controls='controls' autoplay><source src='data:audio/mpeg;base64,".base64_encode($audio)."'></audio>";
  echo $speech;
?>

