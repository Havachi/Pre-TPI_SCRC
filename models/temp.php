<?php

function randomImage($currentLevel){
  if ($currentLevel === 1) {
    //reset exclusionList, no check needed
    $randomImage = rand(1,$GLOBALS['COUNT_IMAGE']);
    $_SESSION['Settings']['Concours']['exclusionList'] = array(0=>$randomImage);
    return $randomImage;
  }else {
    do {
      $randomImage = rand(1,$GLOBALS['COUNT_IMAGE']);
    } while (checkExclusion($_SESSION['Settings']['Concours']['exclusionList'], $randomImage) !== true);
    $_SESSION['Settings']['Concours']['exclusionList'][] = $randomImage;
    return $randomImage;
  }
}
