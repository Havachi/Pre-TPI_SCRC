<?php

function displayErrorPage($error)
{
  switch ($error) {
    case '400':
      header("HTTP/1.1 400 Bad Request");
      require "views/errorpages/400.php";
      exit();
      break;

    case '403':
      header("HTTP/1.1 403 Forbidden");
      require "views/errorpages/403.php";
      exit();
      break;

    case '404':
      header("HTTP/1.1 404 Not Found");
      require "views/errorpages/404.php";
      exit();
      break;

    case '500':
      header("HTTP/1.1 500 Internal Server Error");
      require "views/errorpages/500.php";
      exit();
      break;


}
}
