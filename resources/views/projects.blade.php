@extends('layouts.app')

@section('content')
<?php 
    use App\User;
    use App\Project_and_contributors; 
    use App\Category;   
?>

    <div class="container">
        <h1 class="col-sm-7" style="margin: -4px 0 12px 100px">Dashboard</h1>
        <!-- <a href="addProject" class="btn btn-success col-sm-1.5" role="button" style="margin: 10px;">Create new project</a>
         -->
            
        
        <button type="button" class="btn btn-success btn-sm m-l-md" data-toggle="modal" data-target="#myModal" >
            <i class="fa fa-plus"></i>Create new project
        </button>
        
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Create new project</b></h4>
              </div>
              <!-- MODAL BODY MODAL BODY -->

              <div class="modal-body">

                <!-- Whom to add -->
                <div data-bind="if: page() == 'whom'">
                    <!-- Find contributors -->
                    <form class="form" action="{{url('project')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6">
                                
                                <div class="input-group m-b-lg">
                                    <label for="task-name" class="col-sm-2 control-label">Title:</label>
                                    <input class="form-control col-sm-2" name="title" id="task-name" required>
                                    <label for="description" class="col-sm-2 control-label">Description:</label>
                                    <input class="form-control col-sm-2" name="description" id="description" required>
                                    <label for="category[]" class="col-sm-4 control-label">Category:</label>
                                    
                                    <select name="category" class="form-control" id="category[]" required>
                                        
                                        <?php

                                            $options = Category::get();
                                            
                                            foreach ($options as $option){
                                                ?><option value="{{$option->id}}">
                                                   {{ $option->name }}
                                                </option><?php
                                            }
                                        
                                        ?>

                                    </select>

                                    <br><br><br> 
                                    <label for="fileToUpload" class="col-sm-5 control-label">Upload file:</label>
                                    
                                    <input id="fileToUpload" name="uploadFile" type="file">
                                    <input type="submit" value="Create" style="margin-top: 20px;" class="btn btn-success col-sm-4">
                                    
                                </div>

                            </div>
                        </div>
                      <hr>
                    </form>



                    <!-- Choose which to add -->
                   
                </div>
                <!-- Component selection page -->
                

                <!-- Invite user page -->
                <div data-bind="if:page() === &quot;invite&quot;"></div><!-- end invite user page -->

            </div>

            <!-- END MODAL BODY MODAL BODY  -->
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        

        @if (count($projects) > 0)
        <div class="panel panel-default" style="margin-top: 10px;">
            <div class="panel-body">
                <table class="table table-striped task-table" id="example">
                    <thead>
                        <th class="col-sm-3">Title</th>
                        <th class="col-sm-3">Contributors</th>
                        <th class ="col-sm-3">Modified</th> 
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
                                        ?><b style="color: blue;"><?php echo User::getUsername($project->user_id) . "\n"; ?></b><br><?php
                                        $emails = array(); 
                                        $emails = Project_and_contributors::getEmail($project->id); 
                                        
                                        foreach ($emails as $email) {
                                            echo $email . "\n";
                                            ?> <br> <?php
                                        }
                                    ?>
                                </div>
                            </td>

                            <td class="table-text">
                                
                                {{ $project->updated_at }}

                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    </div>
@endsection

