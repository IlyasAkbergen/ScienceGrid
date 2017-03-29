@extends('layouts.app')

@section('content')


     <div class="panel-heading">
                New Project
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Task Form -->
                    <form action="{{ url('project')}}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Title:</label>

                            <div class="col-sm-6">
                                <input type="text" name="title" id="task-name" class="form-control" value="{{ old('project') }}" required>
                            </div>
                            <br><br>
                            <label for="comment" class="col-sm-3 control-label">Description:</label>
                            
                            <div class="col-sm-6">
                                 <textarea class="form-control" rows="5" id="comment" name="body"></textarea>
                            </div>

                           <!--  <br><br><label for="task-name" class="col-sm-3 control-label">Admin's email</label>

                            <div class="col-sm-6">
                                <input type="text" name="email" class="form-control">
                            </div> -->

                            

                        </div>

                        <!-- Add Task Button -->
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