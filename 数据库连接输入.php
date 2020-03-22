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
/**
 * 删除操作
 * @param $link
 * @param $table
 * @param null $where
 * @return bool|int
 */
function delete($link, $table, $where = null) {
    $where = $where ? ' WHERE ' . $where : '';
    $query = "DELETE FROM {$table} {$where}";
    $res = mysqli_query ( $link, $query );
    if ($res) {
        return mysqli_affected_rows ( $link );
    } else {
        return false;
    }
}

/**
 * 查询指定记录
 * @param $link
 * @param $query
 * @param int $result_type
 * @return array|bool|null
 */
function fetchOne($link, $query, $result_type = MYSQLI_ASSOC) {
    $result = mysqli_query ( $link, $query );
    if ($result && mysqli_num_rows ( $result ) > 0) {
        $row = mysqli_fetch_array ( $result, $result_type );
        return $row;
    } else {
        return false;
    }
}

/**
 * 查询所有记录
 * @param $link
 * @param $query
 * @param int $result_type
 * @return array|bool
 */
function fetchAll($link, $query, $result_type = MYSQLI_ASSOC) {
    $result = mysqli_query ( $link, $query );
    if ($result && mysqli_num_rows ( $result ) > 0) {
        while ( $row = mysqli_fetch_array ( $result, $result_type ) ) {
            $rows [] = $row;
        }
        return $rows;
    } else {
        return false;
    }
}
/**
 * 得到表中的记录数
 * @param object $link
 * @param string $table
 * @return number|boolean
 */
function getTotalRows($link, $table) {
    $query = "SELECT COUNT(*) AS totalRows FROM {$table}";
    $result = mysqli_query ( $link, $query );
    if ($result && mysqli_num_rows ( $result ) == 1) {
        $row = mysqli_fetch_assoc ( $result );
        return $row ['totalRows'];
    } else {
        return false;
    }
}

/**
 * 得到结果集的记录条数
 * @param object $link
 * @param string $query
 * @return boolean
 */
function getResultRows($link, $query) {
    $result = mysqli_query ( $link, $query );
    if ($result) {
        return mysqli_num_rows ( $result );
    } else {
        return false;
    }
}



/**
 * @param object $link
 */
function getServerInfo($link) {
    return mysqli_get_server_info ( $link );
}
/**
 * @param object $link
 */
function getClientInfo($link) {
    return mysqli_get_client_info ( $link );
}

/**
 * @param object $link
 */
function getHostInfo($link){
    return mysqli_get_host_info($link);
}

/**
 * @param object $link
 */
function getProtoInfo($link) {
    return mysqli_get_proto_info ( $link );
}
