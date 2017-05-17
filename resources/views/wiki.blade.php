<?php
   use App\User;
   use App\Project_and_contributors;
   use App\Category;
   use App\Project;
   ?>
@extends('layouts.app')
@section('settings_contributors')
<nav class="navbar">
   <div class="container">
      <ul class="nav navbar-nav">
         <li><a href="{{url('show'). '/' . $id}}" style="padding: 7px;">{{Project::where('id', $id)->first()->title}}</a></li>
         <li><a href="{{url('show/settings'). '/' . $id}}" style="padding: 7px;">Settings</a></li>
         <li><a href="{{url('show/contributors'). '/' . $id}}" style="padding: 7px;">Contributors</a></li>
         <li><a href="#" class="nav-link active" style="background: #337ab7; color: white; padding: 7px;">Wiki</a></li>
      </ul>
   </div>
</nav>
@endsection
@section('content')
<div class="container container-xxl">
   <div class="row" style="margin-bottom: 5px;">
      <div class="col-sm-6">
         <h3 id="wikiName" class="wiki-title wiki-title-xs">
            <i class="fa fa-home"></i> 
            <span id="pageName">{{ $wiki->title }}</span>
         </h3>
      </div>
   </div>
   <div class="row wiki-wrapper">
      <div class="panel-toggle col-sm-3">
         <div class="osf-panel panel panel-default reset-height ">
            <div class="panel-heading wiki-panel-header clearfix">
               <div class="wiki-toolbar-icon text-success">
                  <button type="button" class="btn btn-success btn-sm m-l-md" data-toggle="modal" data-target="#newWiki">
                     <span class="glyphicon glyphicon-plus"></span>New
                  </button>
               </div>

               <div id="toggleIcon" class="pull-right hidden-xs">
                  <div class="panel-collapse pointer"><i class="fa fa-angle-left"></i></div>
               </div>
            </div>
            <div id="grid">
               <div class="gridWrapper" style="overflow-x: auto;">
                  <div class="tb-table" style="width: 500px;">
                     <div id="tb-tbody">
                        <div class="tb-tbody-inner" style="height: 116.676px;">
                           <div style="margin-top: 0px;">
                              <div data-id="1" data-level="1" data-index="0" data-rindex="0" class="tb-row  tb-even" style="height: 34px;">
                                 <div data-id="1" class="tb-td td-title tb-col-0" style="padding-left: 0px; width: 100%;">
                                    <span class="tb-td-first">
                                    <span class="tb-toggle-icon"><i class="fa fa-minus"></i></span>
                                    <span class="tb-expand-icon-holder"><i class="glyphicon glyphicon-folder-open"></i></span></span>
                                    <span class="title-text"><b> Project Wiki Pages</b></span>
                                 </div>
                              </div>
                              <div data-id="2" data-level="2" data-index="1" data-rindex="1" class="tb-row  tb-odd" style="height: 34px;">
                                 <div data-id="2" class="tb-td td-title tb-col-0" style="padding-left: 20px; width: 100%;">
                                    <span class="tb-td-first">
                                    <span class="tb-toggle-icon"></span>
                                    <span class="tb-expand-icon-holder"><i class="fa fa-file-o"></i></span>
                                    </span>


                                    <!-- ТУТ БУДЕТ FOREACH -->
                                    @foreach ($wikislist as $w)
                                       <span class="title-text glyphicon glyphicon-file">
                                          <a href="{{url('/show/wiki') . '/' . $id . '/' . $w->title }}" class="fg-file-links"> {{$w->title}}</a>
                                       </span>
                                       <br>
                                    @endforeach

                                    
                                    <!-- ТУТ БУДЕТ FOREACH -->

                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="osf-panel panel panel-default panel-collapsed hidden-xs text-center hidden">
            <div class="panel-heading pointer"><i class="fa fa-list"></i> <i class="fa fa-angle-right"></i></div>
            <div>
               <nav class="wiki-nav">
                  <div class="navbar-collapse text-center">
                     <ul class="superlist nav navbar-nav" style="float: none;">
                        <li data-toggle="tooltip" title="" data-placement="right" data-container="body" data-original-title="New"><a id="openNewWiki" href="#" data-toggle="modal" data-target="#newWiki"><span class="wiki-nav-closed"><i class="fa fa-plus-circle text-success"></i></span></a></li>
                     </ul>
                  </div>
               </nav>
            </div>
         </div>
      </div>
      <div id="wikiPageContext" class="wiki">
         <div class="panel-expand col-sm-9">
            <div class="row">
               <div data-osf-panel="View" data-osf-toggle="on" data-initial-state="on" data-css-cache="col-sm-12" class="col-lg-6">
                  <div data-bind="css: { 'no-border reset-height': $root.singleVis() === 'view', 'osf-panel-flex': $root.singleVis() !== 'view' }" class="osf-panel panel panel-default osf-panel-flex">
                     <div data-bind="css: { 'osf-panel-heading-flex': $root.singleVis() !== 'view', 'wiki-single-heading': $root.singleVis() === 'view' }" class="panel-heading wiki-panel-header osf-panel-heading-flex">
                        <div class="row wiki-view-icon-container">
                           <div class="col-lg-4">
                              <div class="panel-title"><i class="fa fa-eye"></i>View</div>
                           </div>
                           <div class="col-sm-8"></div>
                        </div>
                     </div>
                     <div id="wikiViewPanel" data-bind="css: { 'osf-panel-body-flex': $root.singleVis() !== 'view' }" class="panel-body osf-panel-body-flex">
                        <div id="wikiViewRender" class="markdown-it-view scripted" style="display: block;">
                          


                           <pre id="wiki_view">{{$wiki->text}}</pre>
                        


                        </div>
                     </div>
                  </div>
               </div>
               <div data-bind="with: $root.editVM.wikiEditor.viewModel" data-osf-panel="Edit" data-osf-toggle="on" data-initial-state="on" data-css-cache="col-sm-12" class="col-lg-6">
                  
                  <form id="wiki-form" action="{{url('editWiki')}}" method="POST">
                     {{ csrf_field() }}
                     <div data-bind="css: { 'no-border': $root.singleVis() === 'edit' }" class="osf-panel panel panel-default osf-panel-edit">
                        <div data-bind="css : { 'wiki-single-heading': $root.singleVis() === 'edit' }" class="panel-heading wiki-panel-header clearfix">
                           <div class="row">
                              <div class="col-md-6">
                                 <h3 class="panel-title"><i class="fa fa-pencil-square-o"></i>   Edit </h3>
                              </div>
                              <div class="col-md-6">
                                 <div class="pull-right">
                                    <div data-toggle="modal" data-bind="attr: {'data-target': modalTarget}" data-target="#connectedModal" class="progress no-margin pointer ">
                                       <div role="progressbar" data-bind="attr: progressBar" class="progress-bar progress-bar-success" style="width: 100%;"><span class="progress-bar-content p-h-sm"><span data-bind="text: statusDisplay">Live editing mode</span> <span class="sharejs-info-btn"><i class="fa fa-question-circle fa-large"></i></span></span></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="panel-body">
                           <div class="row">
                            <div class="col-xs-12">
                               <div class="form-group wmd-panel">
                                  <div id="wmd-button-bar"></div>
                                  <div id="editor">


                                    <textarea rows="12" cols="55" name="wiki_content" id="wiki_content">{{$wiki->text}}</textarea>
                                    <input type="hidden" name="wiki_id" value="{{$wiki->id}}"></input>


                                  </div>
                               </div>
                            </div>
                           </div>
                        </div>
                        <script type="text/javascript">
                           $(document).ready(function() {
                              $('#wiki_content').change(function(){
                                 var x = document.getElementById("wiki_content").innerHTML;
                                 document.getElementById("wiki_view").innerHTML = x;
                                 return 0;
                              });
                           });
                        </script>

                        <div class="panel-footer">
                           <div class="row">
                              <div class="col-xs-12">
                                 <div class="pull-right"><button id="revert-button" data-bind="click: revertChanges" class="btn btn-danger">Revert</button> <input value="Save" class="btn btn-success" type="submit"></div>
                              </div>
                           </div>
                          
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div id="newWiki" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
            <form class="form" action="{{url('addWiki')}}" method="post">
               {{ csrf_field() }}
               <div class="modal-header">
                  <button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button> 
                  <h3 class="modal-title">Add new wiki page</h3>
               </div>
               <div class="modal-body">
                  <div class="form-group">
                     <input id="data" name="newWiki" placeholder="New Wiki Name" class="form-control" type="text">
                     <input type="hidden" name="project_id" value="{{$id}}">
                  </div>
                  <p id="alert" class="text-danger"></p>
               </div>
               <div class="modal-footer"><a id="close" href="#" data-dismiss="modal" class="btn btn-default">Cancel</a> <button id="add-wiki-submit" type="submit" class="btn btn-success">Add</button></div>
            </form>
         </div>
      </div>
   </div>
  
</div>
@endsection

