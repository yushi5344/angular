<?php
/*********************************************************************\
 *  Copyright (c) 1998-2013, TH. All Rights Reserved.
 *  Author :guomin
 *  FName  :2.php
 *  Time   :2017/10/20  22:40
 *  Remark :
 * \*********************************************************************/

//第一种方式
//$content=file_get_contents('php://input');
//print_r(json_decode($content,true));

//第二种方式
print_r($_POST);