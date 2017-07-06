<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    const SEX_UN = 10;
    const SEX_BOY = 20;
    const SEX_GIRL = 30;

    protected $table = 'student';
    public $timestamps = true;
    protected $fillable = ['name','age','sex'];

    protected function getDateFormat()
    {
        return time();
    }

    protected function asDateTime($val)
    {
        return $val;
    }

    public function sex($ind = null)
    {
        $arr =[
          self::SEX_UN=>'未知',
          self::SEX_BOY=>'男孩',
          self::SEX_GIRL=>'女孩'
        ];

        if($ind != null){
            return array_key_exists($ind,$arr)?$arr[$ind]:$arr[self::SEX_UN];
        }

        return $arr;
    }
}