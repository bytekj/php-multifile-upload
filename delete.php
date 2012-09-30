<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require 'upload.inc.php';

unlink(UPLOAD_DIR."/".$_GET['filename']);
?>
