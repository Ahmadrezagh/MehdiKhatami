
@extends('layouts.panel')
@section('admins')
    active
@endsection
@section('admins_list')
    active
@endsection
@section('title')
    Admins
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Admins</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Admins</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Website admins</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <a href="{{route('admin.create')}}" class="btn btn-primary" >Create admin</a>
                        <table id="table" class="table table-bordered table-striped text-center">
                            <thead>
                            <tr>
                                <th>Profile image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Registered</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody >
                            @foreach ($admins as $user)
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="{{URL::to('/').$user->profile()}}" alt="" width="50" height="50">
                                    </td>

                                    <td>
                                        {{$user->name}}
                                    </td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @foreach ($user->role as $r)
                                            {{$r->name}}
                                        @endforeach
                                    </td>
                                    <td >
                                        <button class="btn btn-default" data-toggle="tooltip" data-placement="top" title="{{$user->created_at}}">
                                            {{$user->created_at->diffForHumans()}}
                                        </button>
                                    </td>
                                    <td class="text-center">
                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-sliders-h"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                <button type="button" class="btn btn-success dropdown-item" data-toggle="modal" data-target="#modal-edit{{$user->id}}" ><i  class="fas fa-user-edit"></i> Edit</button>
                                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modal-delete{{$user->id}}" ><i style="color:red" class="fas fa-user-minus"></i> Delete</button>
                                            </div>
                                    </td>

                                </tr>
                                <!-- Delete Modal -->
                                <div class="modal fade" id="modal-delete{{$user->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete admin</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h5>Are you sure to delete `{{$user->name}}` ?</h5>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <form action="{{route('admin.destroy',$user->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>

                                            </form>

                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->

                                <!-- /.modal -->
                                <!-- Change Modal -->
                                <div class="modal fade" id="modal-edit{{$user->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit admin</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- form start -->
                                                <form  method="POST" action="{{route('admin.update',$user->id)}}"  enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="id" value="{{$user->id}}">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Name</label>
                                                            <input name="name" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter name" required value="{{$user->name}}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Email address</label>
                                                            <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" required value="{{$user->email}}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">New Password</label>
                                                            <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Retype password</label>
                                                            <input type="password" name="re_password" class="form-control" id="exampleInputPassword1" placeholder="Password" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1">Select Role</label>
                                                            <select class="form-control" name="role" id="exampleFormControlSelect1">
                                                                <option value="0"  selected disabled>Select role</option>
                                                                @foreach($roles as $role)
                                                                    <option value="{{$role->name}}"
                                                                        @if($user->role)
                                                                        {{-- {{dd($user->role->pluck('name')->first())}} --}}
                                                                        @if($role->name == $user->role->pluck('name')->first())
                                                                        selected
                                                                        @endif
                                                                        @endif
                                                                        >{{$role->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputFile">Profile</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" name="img" class="custom-file-input" id="exampleInputFile">
                                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-body -->

                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->


                            @endforeach

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
