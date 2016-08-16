<?php
/**
 * 递归无限级分类【先序遍历算】，获取任意节点下所有子孩子
 * @param array $arrCate 待排序的数组
 * @param int $parent_id 父级节点
 * @param int $level 层级数
 * @return array $arrTree 排序后的数组
 */
function getMenuTree($arrCat, $parent_id = 0, $level = 0)
{
    static  $arrTree = array(); //使用static代替global
    if( empty($arrCat)) return FALSE;
    $level++;
    foreach($arrCat as $key => $value)
    {
        if($value['parent_id' ] == $parent_id)
        {
            $value[ 'level'] = $level;
            $arrTree[] = $value;
            unset($arrCat[$key]); //注销当前节点数据，减少已无用的遍历
            getMenuTree($arrCat, $value[ 'id'], $level);
        }
    }
   
    return $arrTree;
}


/**
 * 测试数据
 */
$arrCate = array(  //待排序数组
  array( 'id'=>1, 'name' =>'顶级栏目一', 'parent_id'=>0),
  array( 'id'=>2, 'name' =>'顶级栏目二', 'parent_id'=>0),
  array( 'id'=>3, 'name' =>'栏目三', 'parent_id'=>1),
  array( 'id'=>4, 'name' =>'栏目四', 'parent_id'=>3),
  array( 'id'=>5, 'name' =>'栏目五', 'parent_id'=>4),
  array( 'id'=>6, 'name' =>'栏目六', 'parent_id'=>2),
  array( 'id'=>7, 'name' =>'栏目七', 'parent_id'=>6),
  array( 'id'=>8, 'name' =>'栏目八', 'parent_id'=>6),
  array( 'id'=>9, 'name' =>'栏目九', 'parent_id'=>7),
);

header('Content-type:text/html; charset=utf-8'); //设置utf-8编码
echo '<pre>';
print_r(getMenuTree($arrCate, 1, 0));
echo '</pre>';
?>
