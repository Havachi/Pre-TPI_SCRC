  <?php

/**
 * This function is used for controlling cache and send 304 Not Modified HTTP code if the file hasn't change
 *
 *
 * @param type $file The file to check
 * @param type $timestamp The current timestamp
 * @return return type
 */
function cacheControl ($file, $timestamp) {
  if (!isset($_SESSION['isLogged'])) {
    if (!headers_sent()) {
      $gmt_mtime = gmdate('r', $timestamp);
      header('ETag: "'.md5($timestamp.$file).'"');
      header('Last-Modified: '.$gmt_mtime);
      header('Cache-Control: public');

      if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) || isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
          if ($_SERVER['HTTP_IF_MODIFIED_SINCE'] == $gmt_mtime || str_replace('"', '', stripslashes($_SERVER['HTTP_IF_NONE_MATCH'])) == md5($timestamp.$file)) {
              header('HTTP/1.1 304 Not Modified');
          }
      }
    }
  }
}
