<?php
namespace common\models\base;
//基础公共模型

use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord{

	//分页方法

	public static function getPages($query, $curPage = 1, $pageSize = 5, $search = null){

		if($search) $query = $query->andFilerWhere($search);

		$data['count'] = $query->count();

		if(!$data['count']){

			return ['count' => 0, 'curPage' => $curPage, 'pageSize' => $pageSize, 'start' => 0, 'end' => 0, 'data' => []];
		}


		$carPage = (ceil($data['count']/$pageSize) < $curPage ) ? ceil($data['count']/$pageSize) : $curPage;

		//当前页

		$data['curPage'] = $curPage;

		$data['pageSize'] = $pageSize;

		$data['start'] = ($curPage-1)*$pageSize+1;

		$data['end'] = (ceil($data['count']/$pageSize) == $curPage) ? $data['count'] : ($curPage-1)*$pageSize+$pageSize;

		$data['data'] = $query->offset(($curPage-1)*$pageSize)->limit($pageSize)->asArray()->all();

		return $data;


	}
}
?>