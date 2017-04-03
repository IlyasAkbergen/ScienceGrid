<?php
    use App\Category;
    use App\Project;
    use App\Allow;
    use App\User;
?>
@extends('layouts.app')

@section('settings_contributors')
	<nav class="navbar">
            <div class="container">
                <ul class="nav navbar-nav">
    				<li><a href="#" class="nav-link active" style="background: #337ab7; color: white; padding: 7px;">Settings</a></li>             
                	<li><a href="{{url('show/contributors'). '/' . $project->id}}" style="padding: 7px;">Contributors</a></li>
                </ul>
            </div>
        </nav>
@endsection

@section('content')
	<div class="col-sm-8 col-sm-offset-2">
		<div class="panel panel-default">
		    <span id="configureNodeAnchor" class="anchor"></span>
		    <div class="panel-heading clearfix">
		        <h3 id="configureNode" class="panel-title">Project</h3>
		    </div>

		    <div id="projectSettings" class="panel-body">
		        <form action="{{ url('edit') }}" method="post">
			        {{ csrf_field() }}
			        <div class="form-group">
			            <label>Category:</label>
			           <select name="category" id="category[]">
	                        
	                        <?php

	                            $options = Category::get();
	                            
	                            foreach ($options as $option){
	                                ?><option value="{{$option->id}}">
	                                   {{ $option->name }}
	                                </option><?php
	                            }
	                        
	                        ?>

	                    </select>
			            <i>(For descriptive purposes)</i>
			        </div>
		        
		     	    <input type="hidden" name="id" value="{{ $project->id }}">
				    <div class="form-group">
			            <label for="title">Title:</label>
			            <input class="form-control" type="text" maxlength="200" placeholder="{{ $project->title }} -Required" name="title"><span class="validationMessage" style="display: none;"></span>
			            <span class="text-danger" style="display: none;"></span>
		        	</div>
		       
			        <div class="form-group">
			            <label for="description">Description:</label>
			            <textarea placeholder="{{ $project->body }} -Optional" name="description" class="form-control resize-vertical" style="max-width: 100%"></textarea>
			        </div>
		           
		            <button type="submit" data-bind="click: updateAll" class="btn btn-success">Save changes</button>

		     	</form>
		       
		        <div class="help-block">
		            <span data-bind="css: messageClass, html: message" class="text-info"></span>
		        </div>
		       
		        <hr>
		             <form action="{{ url('project/'.$project->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button id="deleteNode" class="btn btn-danger btn-delete-node">Delete project</button>
                    </form>
		            
		    </div>
		</div>
	</div>
	@endsection