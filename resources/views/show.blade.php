<?php
use App\User;
use App\Project_and_contributors;
use App\Category;
use Auth\Article as BA;
use App\Http\Controllers\ContributorsController;
?>
@extends('layouts.app')

@if( Auth::user()->role !== 'investor' )
    @if( $project->user_id === Auth::user()->id || Auth::user()->role === 'admin' || ContributorsController::canWrite($project->id, Auth::user()->id) )
        @section('settings_contributors')
            <nav class="navbar">
                <div class="container">
                    <ul class="nav navbar-nav">
                        <li><a href="#" class="nav-link active" style="background: #337ab7; color: white; padding: 7px;">{{$project->title}}</a></li>
                        <li><a href="settings/{{ $project->id }}" style="padding: 7px;">Settings</a></li>
                        <li><a href="contributors/{{ $project->id }}" style="padding: 7px;">Contributors</a></li>
                        <li><a href="wiki/{{$project->id}}/firstWiki" style="padding: 7px;">Wiki</a></li>
                    </ul>
                </div>
            </nav>
        @endsection
    @endif
@endif

@section('content')
    <div class="container">
        <div class="col-sm-offset-0 col-sm-12">
            <h3>{{ $project->title }}</h3>
           
                @include('common.errors')
            
            <div class="col-sm-1">Contributors:</div>
            <div class="col-sm-11">
                
                 <ul style=" list-style-type: none; margin: 0; padding: 0;">
                    <li>
                        <b style="color: #337AB7;"><?php echo User::getUsername($project->user_id) . "\n"; ?></b><br>
                    </li>
                    <?php  
                        $names = array(); 
                        $names = Project_and_contributors::getContributor($project->id); 
                        
                        foreach ($names as $names) {
                            ?><li> <?php echo $names;?> </li><?php
                                    
                        }

                    ?>
                </ul> 
            </div>

            <div class="col-sm-12">Date created: {{ $project->created_at . " | "}} Last updated: {{ $project->updated_at }} </div>
            <div class="col-sm-12">Category: {{ Category::where('id', $project->category)->first()->name }}</div>
            <div class="col-sm-12">Description: {{ $project->description }}</div>
            <div class="col-sm-12">Privacy level: {{ $project->privacyLevel }}</div>
            
            @if(count($investments)>0)
            <div class="col-sm-12">Investments: </div>
                <div class="col-sm-12">
                <div class="col-sm-5 col-sm-offset-1">
                    <table class="table table-striped">
                        <thead>
                            <th>Investor</th>
                            <th>Sum</th>
                            <th>Date</th>
                        </thead>
                        <tbody>
                            @foreach($investments as $investment)
            
                            <tr>
                                <td><a href="">{{ User::where('id', $investment->user_id)->first()->fullName}}</a></td>
                                <td>{{$investment->sum}}</td>
                                <td>{{$investment->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            @endif    
                
            <div class="col-sm-6">
               <div id="addonWikiWidget" class="" >
                  <div class="panel panel-default" name="wiki">
                     <div class="panel-heading clearfix">
                        <h3 class="panel-title">Wiki</h3>
                        <div class="pull-right">
                           <a href="/f3fyd/wiki/">  <i class="fa fa-external-link"></i> </a>
                        </div>
                     </div>
                     <div class="panel-body">
                        @if(count($wikis) === 0)
                            <div id="markdownRender" class="break-word scripted preview" style="display: block;">
                               <p><em>Add important information, links, or images here to describe your project.</em></p>
                            </div>
                        @else
                            @foreach($wikis as $wiki)
                            <div id="markdownRender" class="break-word scripted preview" style="display: block;">
                               <b>
                                    @if($project->user_id === Auth::user()->id || Auth::user()->role === 'admin' || ContributorsController::canWrite($project->id, Auth::user()->id))
                                    <a href="{{url('/show/wiki') . '/' . $project->id . '/' . $wiki->title }}">{{$wiki->title}}</a>
                                    @else
                                    {{$wiki->title}}
                                    @endif
                                </b>
                               <p><em>{{$wiki->text}}</em></p>
                            </div>

                            <!-- <a href="{{url('/show/wiki') . '/' . $project->id . '/' . $wiki->title }}">Read more</a> -->
                            <hr>
                            @endforeach
                        @endif
                        <style>
                           .preview {
                           max-height: 300px;
                           overflow-y: auto;
                           padding-right: 10px;
                           }
                        </style>
                     </div>
                  </div>
               </div>
               <!-- Files -->
            </div>
            <div class="col-sm-6">
               <div class="panel panel-default">
                  <div class="panel-heading clearfix">
                     <h3 class="panel-title">Files</h3>
                     <div class="pull-right">
                        <a href="/f3fyd/files/"> <i class="fa fa-external-link"></i> </a>
                     </div>
                  </div>
                 
                  <div class="panel-body panel-body-with-instructions">
                    <div id="treeGrid" class="dz-clickable">
                        @if(!empty($files))
                                                       
                            <table class="table table-striped">
                                <thead>
                                    <th>File</th>
                                    <th>Size</th>
                                    <th>Date</th>
                                </thead>
                                <tbody>
                                    @foreach($files as $file)
                                    <tr>
                                        <td><a href="{{ url('download/' . $file->file) }}"><span class="glyphicon glyphicon-paperclip"> </span>{{' '.$file->file}}</a></td>
                                        <td>{{$file->size}} byte</td>
                                        <td>{{$file->created_at}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>


                                <div class="col-sm-12"></div>
                            
                        @endif
                        
                        @if( $project->user_id === Auth::user()->id || Auth::user()->role === 'admin' || ( ContributorsController::canWrite($project->id, Auth::user()->id)) )
                        <div class="col-sm-12">
                            <br><br>
                            <form action="{{ url('uploadFile') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                <label for="fileToUpload" class="control-label">Upload file:</label>
                                <input id="fileToUpload" name="uploadFile" type="file" required>
                                <input type="submit" value="Upload" style="margin-top: 20px;" class="btn btn-success col-sm-2">
                            </form>
                        </div>
                        @endif
                     </div>
                    </div>
                  <!-- end .panel-body -->
               </div>
               </div>



            
            @if( $project->needInvest && Auth::user()->role === 'investor' )
               
                <div class="col-sm-12">
                    <br><br><br> <button type="button" class="btn btn-success col-sm-1" data-toggle="modal" data-target="#myModal" >
                        <i class="fa fa-plus"></i>Invest
                    </button>
                </div>

                <div id="myModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><b>Invest this project</b></h4>
                      </div>
                      <!-- MODAL BODY MODAL BODY -->

                      <div class="modal-body">

                        <!-- Whom to add -->
                        <div data-bind="if: page() == 'whom'">
                            <!-- Find contributors -->
                            <form class="form" action="{{url('invest')}}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-md-6">
                                        
                                        <div class="input-group m-b-lg">
                                            <label for="task-name" class="col-sm-2 control-label">Sum:</label>
                                            <input class="form-control col-sm-2" name="sum" id="sum-name" required>
                                            <label for="notes" class="col-sm-2 control-label">Comments:</label>
                                            <input class="form-control col-sm-2" name="notes" id="notes" required>
                                            <input type="hidden" name="project_id" value="{{$project->id}}">
                                            <input type="submit" value="Invest" style="margin-top: 20px;" class="btn btn-success col-sm-4">
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
            @endif
        </div>
    </div>
@endsection
