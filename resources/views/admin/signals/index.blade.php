
@extends('layouts.panel')
@section('Signals')
    active
@endsection
@section('Signal')
    active
@endsection
@section('title')
    Signals
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Signal</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Signals</li>
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
                        <h3 class="card-title">Signals</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-create">Create signal</button>

                        <!-- Create Modal -->
                        <div class="modal fade" id="modal-create">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Create signal</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- form start -->
                                        <form  method="POST" action="{{route('signals.store')}}"  enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="row col-md-12">
                                                    <div class="form-group col-12">
                                                        <label for="exampleFormControlSelect1">Exchange</label>
                                                        <select class="form-control" name="left" id="exampleFormControlSelect1">
                                                            <option value="0" selected>Choose Exchange</option>
                                                            @foreach($exchanges as $exchange)
                                                                <option value="{{$exchange->id}}" >{{$exchange->title()}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-12">
                                                        <label for="exampleFormControlSelect1">Duration</label>
                                                        <select class="form-control" name="left" id="exampleFormControlSelect1">
                                                            <option value="0" selected>Choose Exchange</option>
                                                            @foreach($exchanges as $exchange)
                                                                <option value="{{$exchange->id}}" >{{$exchange->title()}}</option>
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
                                <th>Signal</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody >
                            @foreach ($signals as $signal)
                                <tr>
                                    <td class="text-center row">
                                        <div class="col-auto">
                                            <img src="{{URL::to('/').$signal->exchange->left_flag->src}}" alt="" width="25px">{{$signal->exchange->left_flag->name}}
                                        </div>
                                        <div class="col-auto">
                                            <h5>/</h5>
                                        </div>
                                        <div class="col-auto">
                                            <img src="{{URL::to('/').$signal->exchange->right_flag->src}}" alt="" width="25px">{{$signal->exchange->right_flag->name}}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-sliders-h"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                            <button type="button" class="btn btn-success dropdown-item" data-toggle="modal" data-target="#modal-edit{{$signal->id}}" >Edit</button>
                                            <button type="button" class="dropdown-item" data-toggle="modal" data-target="#modal-delete{{$signal->id}}" >Delete</button>
                                        </div>
                                    </td>

                                </tr>
                                <!-- Delete Modal -->
                                <div class="modal fade" id="modal-delete{{$signal->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete signal</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h5>Are you sure to delete `{{$signal->name}}` ?</h5>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <form action="{{route('signals.destroy',$signal->id)}}" method="POST">
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
                                <div class="modal fade" id="modal-edit{{$signal->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit signal</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- form start -->
                                                <form  method="POST" action="{{route('signals.update',$signal->id)}}"  enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')


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
