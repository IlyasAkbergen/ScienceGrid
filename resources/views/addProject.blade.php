<?php
    use App\Category;
?>
@extends('layouts.app')
@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        New Project
    </div>
    <div class="panel-body">
        @include('common.errors')
        <form action="{{ url('project')}}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="task-name" class="col-sm-3 control-label">Title:</label>
                <div class="col-sm-6">
                    <input type="text" name="title" id="task-name" class="form-control" value="{{ old('project') }}" required>
                </div>
                <br><br>
                <label for="description" class="col-sm-3 control-label">Description:</label>
                <div class="col-sm-6">
                     <textarea class="form-control" rows="5" id="description" name="description"></textarea>
                </div>
                <br><br><br><br><br><br>
                <label for="category" class="col-sm-3 control-label">Category:</label>
                <div class="col-sm-2">
                    <select name="category" class="form-control" id="category[]">
                        <?php
                            $options = Category::get();
                            foreach ($options as $option){
                                ?><option value="{{$option->id}}">
                                   {{ $option->name }}
                                </option><?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-btn fa-plus"></i>Add Project
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>           
@endsection