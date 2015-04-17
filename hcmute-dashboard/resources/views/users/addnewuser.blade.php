@extends('index')
@section('title')
    Thêm Người Dùng
@endsection
@section('content')
     <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Thêm Tài Khoản
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                        @if(isset($error))
                            <label >$error</label>
                        @endif
                        <div class="form">
                            <form class="cmxform form-horizontal " id="signupForm" method="POST" action="{{Asset('newuser')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group ">
                                    <label for="fullname" class="control-label col-lg-3">Họ Và Tên:</label>
                                    <div class="col-lg-6">
                                        <input class=" form-control" id="fullname" name="fullname" type="text" />
                                    </div>
                                </div>
                                
                                <div class="form-group ">
                                    <label for="username" class="control-label col-lg-3">Tên Tài Khoản:</label>
                                    <div class="col-lg-6">
                                        <input class="form-control " id="username" name="username" type="text" />
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="password" class="control-label col-lg-3">Mật Khẩu</label>
                                    <div class="col-lg-6">
                                        <input class="form-control " id="password" name="password" type="password" />
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="confirm_password" class="control-label col-lg-3">Nhập Lại Mật Khẩu</label>
                                    <div class="col-lg-6">
                                        <input class="form-control " id="confirm_password" name="confirm_password" type="password" />
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="email" class="control-label col-lg-3">Email</label>
                                    <div class="col-lg-6">
                                        <input class="form-control " id="email" name="email" type="email" />
                                    </div>
                                </div>


                                 <div class="form-group ">
                                    <label for="email" class="control-label col-lg-3">Nhóm</label>
                                    <div class="col-lg-6">
                                        <select class="form-control" name="group" style="color:#2c3e50">
                                            <option>Option 1</option>
                                            <option>Option 2</option>
                                            <option>Option 3</option>
                                        </select>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <div class="col-lg-offset-3 col-lg-6">
                                        <button class="btn btn-primary" type="submit">Lưu</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>

@endsection


