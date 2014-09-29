<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 9/29/14
 * Time: 3:58 PM
 */

class ParserForm
{
    public function selectDescription()
    {
        $row = Yii::app()->db->createCommand(array(
            'select' => array('id', 'st_name', 'song', 'author'),
            'from' => 'description',
            'order' => 'st_id'
        ))->queryAll();

        return $row;
    }
}