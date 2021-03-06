@extends('layouts.base')
@section('title','topページ')
@section('main')

  <section class="container my-3">
    <div class="row">
      <div class="col-md-12">
        <h6>
          登録済みの方は
          <a href="{{url('/hello/login')}}">ログイン画面</a> 
          へ移遷してください
        </h4>
      </div>
    </div>
  </section>

  <section class="container my-3 border">
    <div class="row">
      <div class="col-md-12 my-2">
        <h4><b>登録しよう</b></h4>
      </div>
    </div>

    <form method="POST" action="/hello/check" enctype="multipart/form-data" class="my-3 pb-4">
      @csrf

      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="inputName">なまえ</label>
          <input type="text" class="form-control" id="inputName" name="name" placeholder="タロー" value="{{ old('name') }}">
        </div>
  
        <div class="form-group col-md-4">
          <label for="inputEmail">メールアドレス</label>
          <input type="email" class="form-control" id="inputEmail" name="email" placeholder="taro@gmail.com" value="{{ old('email') }}">
        </div>
  
        <div class="form-group col-md-4">
          <label for="inputPassword">パスワード<span style="font-size: 12px;" class="text-muted">(4文字以上)</span></label>
          <input type="password" class="form-control" id="inputPassword" name="password" placeholder="****">

        </div>

        <div class="form-group col-md-12">
          <label for="inputPicture">画像ファイル</label>
          <input type="file" class="form-control-file" id="inputPicture" name="picture">
        </div>

      </div>

      <button type="submit" class="btn btn-sm btn-success float-right">登録</button>

    </form>

    @if (count($errors) > 0)
      <ul>
        @foreach ($errors->all() as $err)
          <li class="text-danger">{{ $err }}</li>
        @endforeach
      </ul>
        
    @endif

    @if (Session::has('e_msg'))
      <p style="color: red">{{session('e_msg')}}</p> 
    @endif

  </section>

  <section class="container">
    <div class="row">
      <div class="col-md-12">
        <h5>現在登録中のユーザ</h5>

        <table class="table">
          <tr>
            <th>id</th>
            <th>name</th>
            <th>email</th>
            <th>password</th>
            <th>picture</th>
            <th>created</th>
            <th>modified</th>
          </tr>
          @foreach($members as $member)
            <tr>
              <td>{{ $member->id }}</td>
              <td>{{ $member->name }}</td>
              <td>{{ $member->email }}</td>
              <td>
                @php
                  echo mb_substr($member->password,0,10). '...';
                @endphp
              </td>
              <td>{{ $member->picture }}</td>
              <td>{{ $member->created }}</td>
              <td>{{ $member->modified }}</td>
            </tr>
          @endforeach

        </table>

      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <p>
          Member::find(1)->email <br> 
          つまり主キーid=1のemailは, {{$myadmin_email}}
        </p>

        <p>
          Member::where('email','php@gmail.com')->first() <br>
          つまりemailがphp@gmail.comに該当する最初の１件を表示する<br>
          id:{{$php->id}} / name:{{$php->name}} / picture:{{$php->picture}}
        </p>


      </div>
    </div>
  </section>

@endsection

{{-- 

  【inputの値を受け取る】
  ・name=""で、コントローラの方で扱うタグをつける
  ・コントローラでRequest $reqとすると、フォームの値が$reqに入る
    （input name="color"としたら、$req->colorで取り出せる）
  ・return view('遷移したいページ',変数);でOK

--}}

