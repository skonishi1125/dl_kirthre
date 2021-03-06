<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;


class HelloController extends Controller
{
    //
    public function index() {
      return 'DockerでLaravel環境ができた！';
    }

    public function view() {
      // 任意の列でデータ検索する first(最初の1行だけ)
      // 複数の条件で指定する場合は、getを使う 速習Laravelブクマ済
      $php = Member::where('email','php@gmail.com')->first();

      $data = [
        'msg' => 'こんにちは、世界!',
        'number' => 100,
        'string' => 'うおお！',
        'members' => Member::all(),
        // 主キーで検索する find()
        'myadmin_email' => Member::find(1)->email,
        'php' => $php,
      ];
      // hello/view.blade.phpを探しにいく
      return view('hello.view',$data);
    }

    // Requestクラスができていて、その中にform内容が入っている
    public function check(Request $req) {

      $this->validate($req, Member::$rules);

      // if (!$req->hasfile('picture')) {
      //   return redirect('hello/view')
      //   ->withInput()->with('e_msg','入力に不備があります。');
      // }

      $file = $req->picture;
      if (isset($file)) {
        $date = date('YmdHis');
        $picName = $date . $file->getClientOriginalName();
        // storage.app.filesに保存される
        // $file->storeAs('files',$picName);
        
        // storage/appから、勝手に /public/images/画像が生成される
        // $file->storeAs('./public/images',$picName);
  
        // 正しくpublic.imagesに保存されている
        $file->storeAs('images',$picName,'public_uploads');
      } else {
        $picName = 'sample.png';
      }
      $userData = [
        'name' => $req->name,
        'email' => $req->email,
        'password' => hash("sha256",$req->password),
        'picture' => $picName,
      ];

      return view('hello/check',$userData);
      
    }
    
    public function register(Request $req) {
      $m = new Member();
      // csrfのトークンで送られているinputは除去する
      $m -> fill( $req->except('_token') )->save();
      return view('hello/register');
    }

    public function login() {
      return view('hello/login');
    }


}
