<?php

namespace app\models\forms;

class SystemNameForm extends \yii\base\Model
{
    public $sysName;

    public function rules(): array
    {
        return [
            ['sysName', 'required'],
            ['sysName', 'string', 'length' => [2]]
        ];
    }

    public function attributeLabels()
    {
        return ['sysName' => 'Field',];
    }
}
