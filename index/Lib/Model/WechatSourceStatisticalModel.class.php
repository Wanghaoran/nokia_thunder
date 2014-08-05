<?php
class WechatSourceStatisticaModel extends Model {


    public function addnum($type){
        $date = date('Y-m-d');
        $where = array();
        $where['date'] = $date;
        //查找到数据更新
        if($id_arr = $this -> field('id') -> where($where) -> find()){
            if($type == 1){
                $result = $this -> where(array('id' => $id_arr['id'])) -> setInc('key1');
            }else{
                $result = $this -> where(array('id' => $id_arr['id'])) -> setInc('key2');
            }
        //没找到数据新增
        }else{
            $data = array();
            $data['date'] = $date;
            if($type == 1){
                $data['key1'] = 1;
                $data['key2'] = 0;
            }else{
                $data['key1'] = 0;
                $data['key2'] = 1;
            }
            $result = $this -> add($data);
        }
        return $result;
    }
}