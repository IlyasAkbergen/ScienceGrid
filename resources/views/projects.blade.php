@extends('layouts.app')

@section('content')
<?php 
    //use App\library\MyFunctions;
    use App\User;
    use App\Allow;    
?>
    <div class="container">
        <div class="col-sm-offset-0 col-sm-12">
            You are logged in!
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Task
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Task Form -->
                    <form action="{{ url('project')}}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="task-name" class="col-sm-3 control-label">Project name</label>

                            <div class="col-sm-6">
                                <input type="text" name="title" id="task-name" class="form-control" value="{{ old('project') }}" required>
                            </div>
                            <br><br>
                            <label for="comment" class="col-sm-3 control-label">Content:</label>
                            
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

    <!-- Current Projects -->


            @if (count($projects) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Projects
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                                <th class="col-sm-1.5">Project</th>
                                <th class="col-sm-1">Admin</th>
                                <th class="col-sm-4">Allowed users</th>
                                <th class="col-sm-5">Tags</th>
                                <th></th> <!-- for delete button  -->
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td class="table-text">
                                            <a href="show/{{ $project->id }}">
                                                <div>{{ $project->title }}</div>
                                            </a>
                                        </td>
                                        
                                        <td class="table-text">
                                            <div class="col-sm-4 col-sm-offset-0">
                                                <?php 
                                                    echo User::getUsername($project->email);
                                                 ?>
                                            </div>
                                        </td>
                                        <td class="table-text col-sm-1">
                                            
                                            <table>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <ul style=" list-style-type: none; margin: 0; padding: 0;">
                                                                <?php  
                                                                  $emails = array(); 
                                                                  $emails = Allow::getEmail($project->id); 
                                                                foreach ($emails as $email) {
                                                                    ?><li> <?php echo $email;?> </li><?php
                                                                            
                                                                }
                                                                ?>
                                                            </ul> 
                                                        </div>
                                                    </td>

                                            <!-- Add user button -->
                                                    <td>
                                                        <form action="{{ url('allow') }}" method="POST">
                                                            {{ csrf_field() }}
                                                            
                                                            <input type="hidden" name="id" value="{{ $project->id }}">

                                                            <div class="col-sm-5">
                                                                <input type="text" name="email" class="form-control" value="add new" required>
                                                            </div>

                                                            <button type="submit" class="btn btn-primary btn-sm btn-link">
                                                                <i class="fa fa-btn fa-trash"></i>Add
                                                            </button>

                                                         
                                                        </form>
                                                        
                                                <!-- Remove user -->
                                                        
                                                        <br><form action="{{ url('allow/'.$project->id) }}" method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            
                                                            <div class="col-sm-5">
                                                                <input type="text" name="email" class="form-control" value="remove one" required>
                                                            </div>

                                                            <button type="submit" class="btn btn-primary btn-sm btn-link">
                                                                <i class="fa fa-btn fa-trash"></i>Remove
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>        
                                            </table>
                                        </td>
                                        
                                        <td>

                                            <!-- TAGS HERE -->

                                             <table>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <ul style=" list-style-type: none; margin: 0; padding: 0;">
                                                                
                                                            </ul> 
                                                        </div>
                                                    </td>

                                            <!-- Add tag button -->
                                                    <td>
                                                        <form action="{{ url('tag') }}" method="POST">
                                                            {{ csrf_field() }}
                                                            
                                                            <div class="col-sm-5">
                                                                <input type="text" name="name" class="form-control" value="add tag" required>
                                                            </div>

                                                            <button type="submit" class="btn btn-primary btn-sm btn-link">
                                                                <i class="fa fa-btn fa-trash"></i>Add
                                                            </button>

                                                         
                                                        </form>
                                                        
                                                <!-- Remove tag -->
                                                        
                                                        <br><form action="{{ url('tag/'.$project->id) }}" method="POST">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            
                                                            <div class="col-sm-5">
                                                                <input type="text" name="name" class="form-control" value="remove tag" required>
                                                            </div>

                                                            <button type="submit" class="btn btn-primary btn-sm btn-link">
                                                                <i class="fa fa-btn fa-trash"></i>Remove
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>        
                                            </table>

                                            <!-- TAGS END    -->


                                        </td>
                                        <!-- Task Delete Button -->
                                        <td>
                                            <form action="{{ url('project/'.$project->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif




        </div>
@include('allowedProjects')   
    </div>

@endsection

