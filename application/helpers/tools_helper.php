<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function encrypt_password($password)
{
	return md5(md5($password));
}

function get_datetime()
{
	return date("Y-m-d H:i:s",time());
}

function get_paging_indexs_array($page_index, $page_num)
{
	if($page_index < 3)
	{
		$pre = 1;
		$min = 1;
		
		if($page_num == 1)
		{
			$max = 1;
		}
		else if($page_num < 5)
		{
			$max = $page_num;
		}
		else
		{
			$max = 5;
		}
		
		if(($page_index + 1) < $page_num)
		{
			$next = $page_index + 1;
		}
		else 
		{
			$next = $page_num;
		}
	}
	else if(($page_index + 2) <= $page_num)
	{
		$pre = $page_index - 1;
		$min = $page_index - 2;
		$max = $page_index + 2;
		$next = $page_index + 1;
	}
	else
	{
		$pre = $page_index - 1;
		if($page_num > 5)
		{
			$min = $page_num - 4;
		}
		else
		{
			$min = 1;
		}
		$max = $page_num;
		if(($page_index + 1) < $page_num)
		{
			$next = $page_index + 1;
		}
		else
		{
			$next = $page_num;
		}
	}
	
	return array(
			'pre' => $pre,
			'min' => $min,
			'max' => $max,
			'next' => $next,
	);
}

function get_rand_char($length)
{
	$str = null;
	$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	$max = strlen($strPol)-1;

	for($i=0; $i < $length; $i++)
	{
		$str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
	}

	return $str;
}

function remove_dir($dirName)
{
	if(! is_dir($dirName))
	{
		return false;
	}
	$handle = @opendir($dirName);
	while(($file = @readdir($handle)) !== false)
	{
		if($file != '.' && $file != '..')
		{
			$dir = $dirName . '/' . $file;
			is_dir($dir) ? removeDir($dir) : @unlink($dir);
		}
	}
	closedir($handle);

	return rmdir($dirName) ;
}