<?php
namespace StickFramework\StickClass;

/**
 * [StickQueryBuilder description]
 */
class StickQueryBuilder
{
    public function __construct(){
    }

    /**
     * [where description]
     * @param  array  $datas [description]
     * @return [type]        [description]
     */
    public function where($datas=array()){
        $where = 'WHERE ';
        foreach ($datas as $value) {
            $where .= 'AND'.$value;
        }
        var_dump($where);
        die();
        return $where;
    }

}

?>
