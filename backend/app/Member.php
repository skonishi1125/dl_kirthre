<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
  // Laravelデフォルトのupdated_at,created_atを無効にする
  public $timestamps = false;
  // fillableで、fillによる割り当てを許可する
  protected $fillable = ['name','email','password','picture'];

  // 検証ルール
  public static $rules = [
    'name' => 'required',
    'email' => 'required',
    'password' => 'required|min:4',
    'picture' => 'image',
  ];
}
