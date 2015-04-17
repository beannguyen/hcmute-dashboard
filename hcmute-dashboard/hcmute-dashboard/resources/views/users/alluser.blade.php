
@extends('index')
@section('title')
    Tất Cả Người Dùng
@endsection
@section('content')
<!-- page start-->

<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                Tất Cả Tài Khoản
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-cog"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                 </span>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="btn-group">
                           <a href="{{Asset('newuser')}}">
                                <button id="editable-sample_new" class="btn btn-primary">
                                    Add New <i class="fa fa-plus"></i>
                                </button>
                            </a> 
                        </div>
                        <div class="btn-group pull-right">
                            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="#">Print</a></li>
                                <li><a href="#">Save as PDF</a></li>
                                <li><a href="#">Export to Excel</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                        <tr>
                            <th>Tên Tài Khoản</th>
                            <th>Họ Và Tên</th>
                            <th>Email</th>
                            <th>Nhóm</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="" value="{{$user->id}}">
                                    <td><a href="{{URL::route('profileuser', $user->id)}}">{{$user->username}}</a></td>
                                    <td>{{$user->name}} </td>
                                    <td>{{$user->email}}</td>
                                    <td class="center">{{$user->group_id}}</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>    
                            @endforeach
                       
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- page end-->
@endsection




