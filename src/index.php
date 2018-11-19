<?php
/******************************************************************
* $Rev: 15 $
* $LastChangedDate: 2013-12-09 18:20:54 -0200 (seg, 09 dez 2013) $
* $LastChangedBy: root $
* $Author: root $
* Descrição:
* ----------------------------------------------------------------------
*/
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

//error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

$extra_options = array(
  'prepend_file_name' => time() .'_',
  //'upload_url' => LOCAL . 'documentos/' .$_SESSION['ven_predio_id'] .'/',
  //'upload_url' => LOCAL . 'documentos/',
  'upload_dir' => 'files/',
  );


$upload_handler = new UploadHandler($extra_options);

