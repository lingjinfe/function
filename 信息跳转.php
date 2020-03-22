<?php
/**
 * 弹出提示信息并且跳转
 * @param $mes
 * @param $url
 */
function alertMes($mes,$url)
{
    echo "<script>
        alert('{$mes}');
        location.href='{$url}';
</script>";
    die;
}
$res = alertMes('你好','http://www.baidu.com');
echo $res;