
@extends('layouts.panel')
@section('Exchanges')
    active
@endsection
@section('Exchange')
    active
@endsection
@section('title')
    Exchanges
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Exchange</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Exchanges</li>
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
                        <h3 class="card-title">Exchanges</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-create">Create exchange</button>

                        <!-- Create Modal -->
                        <div class="modal fade" id="modal-create">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Create exchange</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- form start -->
                                        <form  method="POST" action="{{route('exchanges.store')}}"  enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="row col-md-12">
                                                    <div class="form-group col-6">
                                                        <label for="exampleFormControlSelect1">Left Currency</label>
                                                        <select class="form-control" name="left" id="exampleFormControlSelect1">
                                                            <option value="0" selected>Choose exchange</option>
                                                            @foreach($flags as $flag)
                                                                <option value="{{$flag->id}}" style="background-image:url({{URL::to('/').$flag->src}});">{{$flag->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label for="exampleFormControlSelect1">Right Currency</label>
                                                        <select class="form-control" name="right" id="exampleFormControlSelect1">
                                                            <option value="0" selected>Choose exchange</option>
                                                            @foreach($flags as $flag)
                                                                <option value="{{$flag->id}}">{{$flag->name}}</option>
                                                            @endforeach
                                                        </select>
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

                        <table id="table" class="table table-bordered table-striped text-center">
                            <thead>
                            <tr>
                                <th>Exchange</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody >
                            @foreach ($exchanges as $exchange)
                                <tr>
                                    <td class="text-center row">
                                        <div class="col-auto">
                                            <img src="{{URL::to('/').$exchange->left_flag->src}}" alt="" width="25px">{{$exchange->left_flag->name}}
                                        </div>
                                        <div class="col-auto">
                                            <h5>/</h5>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{URL::to('/').$exchange->right_flag->src}}" alt="" width="25px">{{$exchange->right_flag->name}}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-sliders-h"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                            <button type="button" class="btn btn-success dropdown-item" data-toggle="modal" data-target="#modal-edit{{$exchange->id}}" >Edit</button>
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modal-delete{{$exchange->id}}" >Delete</button>
                                        </div>
                                    </td>

                                </tr>
                                <!-- Delete Modal -->
                                <div class="modal fade" id="modal-delete{{$exchange->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete exchange</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h5>Are you sure to delete `{{$exchange->left_flag->name}}/{{$exchange->right_flag->name}}` ?</h5>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <form action="{{route('exchanges.destroy',$exchange->id)}}" method="POST">
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
                                <div class="modal fade" id="modal-edit{{$exchange->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit exchange</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- form start -->
                                                <form  method="POST" action="{{route('exchanges.update',$exchange->id)}}"  enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')

                                                        <div class="card-body">
                                                            <div class="row col-md-12">
                                                                <div class="form-group col-6">
                                                                    <label for="exampleFormControlSelect1">Left Currency</label>
                                                                    <select class="form-control" name="left" id="exampleFormControlSelect1">
                                                                        <option value="0" selected>Choose exchange</option>
                                                                        @foreach($flags as $flag)
                                                                            <option value="{{$flag->id}}" style="background-image:url({{URL::to('/').$flag->src}});" @if($flag->id == $exchange->left_flag->id) selected @endif >{{$flag->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-6">
                                                                    <label for="exampleFormControlSelect1">Right Currency</label>
                                                                    <select class="form-control" name="right" id="exampleFormControlSelect1">
                                                                        <option value="0" selected>Choose exchange</option>
                                                                        @foreach($flags as $flag)
                                                                            <option value="{{$flag->id}}" @if($flag->id == $exchange->right_flag->id) selected @endif>{{$flag->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->

                                                        <div class="card-footer">
                                                            <button type="submit" class="btn btn-primary">Edit</button>
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
