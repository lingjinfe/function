<?php
/**
 * 连接数据库
 * @param $host
 * @param $username
 * @param $password
 * @param $charset
 * @param $dbname
 * @return false|mysqli
 */
function connect1($host,$username,$password,$charset,$dbname){
    $link = mysqli_connect($host,$username,$password) or die('数据库连接失败<br/>ERROR'
        .mysqli_connect_error().':'.mysqli_connect_error());
    mysqli_set_charset($link,$charset);
    mysqli_select_db($link,$dbname) or die('指定打开数据库失败<br/>ERROR'
        .mysqli_errno($link).':'.mysqli_error($link));
    return $link;
}

/**
 * 连接数据库 需要传递数组
 * @param $config $config
 * @return false|mysqli
 */
function connect2($config){
    $link = mysqli_connect($config['host'],$config['username'],$config['password']) or die('数据库连接失败<br/>ERROR'
        .mysqli_connect_error().':'.mysqli_connect_error());
    mysqli_set_charset($link,$config['$charset']);
    mysqli_select_db($link,$config['dbName']) or die('指定打开数据库失败<br/>ERROR'
        .mysqli_errno($link).':'.mysqli_error($link));
    return $link;
}

/**
 * 使用常量连接数据库
 * @return false|mysqli
 */
function connect3(){
    $link = mysqli_connect(DB_HOST,DB_USER,DB_PWD) or  die('数据库连接失败<br/>ERROR'
        .mysqli_connect_errno().':'.mysqli_connect_error());
    mysqli_set_charset($link,DB_CHARSET);
    mysqli_select_db($link,DB_DBNAME) or die('指定打开数据库失败<br/>ERROR'
        .mysqli_errno($link).':'.mysqli_error($link));
    return $link;
}

/*
 array(
 'username'=>'king',
 'password'=>'king',
 'age'=>'12',
 'regTime'=>'123123123'
 );
 INSERT user(username,password,age,regTime) VALUES('king','king','12','123123123');
*/
/**
 * 插入操作
 * @param $link
 * @param $data
 * @param $table
 * @return bool|int|string
 */
function insert($link,$data,$table){
    $keys = join(',',array_keys($data));
    $vals = "'".join(',',array_values($data))."'";
    $query = "INSERT {$table}({$keys}) VALUES({$vals})";
    $res = mysqli_query($link,$query);
    if ($res){
        return mysqli_insert_id($link);
    }else{
        return false;
    }
}

/*
 array(
 		'username'=>'king123',
 		'password'=>'king123',
 		'age'=>'32',
 		'regTime'=>'123123123'
 );
 UPDATE user SET username='king123',password='king123',age='32',regTime='123123123' WHERE id=1
*/
/**
 * 更新操作
 * @param $link
 * @param $data
 * @param $table
 * @param null $where
 * @return bool|int
 */
function ($link,$data,$table,$where = null){
    foreach ($data as $key=>$val) {
        $set = "{$key}='({$val})',";
    }
    $set = $set;
    $where = $where == null ? '':'WHERE' .$where;
    $query = "UPDATE {$table} SET {$set} {$where}";
    $res = mysqli_query($link,$query);
    if ($res){
        return mysqli_affected_rows($res);
    }else{
        return false;
    }
}
//DELETE FROM user WHERE id=
