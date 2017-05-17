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
            <li><a href="#" class="nav-link active" style="background: #337ab7; color: white; padding: 7px;">Contributors</a></li>
            <li><a href="{{url('show/wiki'). '/' . $id . '/firstWiki'}}" style="padding: 7px;">Wiki</a></li>
        </ul>
    </div>
</nav>
@endsection
@section('content')

    <div class="col-sm-9 col-sm-offset-2">
    <div id="manageContributors" class="scripted" style="display: block;">
        <h3>{{ Project::where('id', $id)->first()->title }}</h3>
        <h3> Contributors
            <button type="button" class="btn btn-success btn-sm m-l-md" data-toggle="modal" data-target="#myModal">
                <span class="glyphicon glyphicon-plus"></span> Add
            </button>
        </h3>
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Add Contributors</b></h4>
              </div>

              <div class="modal-body">
                <div data-bind="if: page() == 'whom'">
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <div class="navbar-form" role="search" id="target">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by name" name="search_name" id="search_name">
                                <span class="input-group-btn">
                                    <div class="btn btn-default" id="submitContactBtn">
                                        <span class="glyphicon glyphicon-search">
                                            <span class="sr-only">Search</span>
                                        </span>
                                    </div>
                                </span>
                            </div>
                        </div>        
                        
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#submitContactBtn').click(function(){ 
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    //$.post('http://localhost:8081/project/public/AjaxPage', {

                                    $.post('http://localhost/project/public/AjaxPage', {

                                        search_name: $('#search_name').val()
                                    },  function(response){  
                                            var output = "";
                                            for (var i = 0; i < response.length; i+=3) {    
                                                output = output + '<tr><td><button onClick="AddRightCol(' + response[i] +  ');" type="button" id="addRightCol" class="btn btn-success btn-sm m-l-md col-sm-3" value="' + response[i] + '"><span class="glyphicon glyphicon-plus" id="add"></span></button><div class="col-sm-9"><a target="blank" href="../../profile/' + response[i] + '">' + response[i+1] + '</a><p>' + response[i+2] + '</p></div></td></tr>';
                                            }
                                            $('.showResult').html(output);
                                        }
                                    );
                                });  
                            });
                        </script>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <span class="modal-subheader">Results</span>
                                <table class="table-condensed">
                                    <thead></thead>
                                    <tbody id="showResult" class="showResult">
                                        {{ csrf_field() }}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <span class="modal-subheader">Adding</span>
                            </div>

                            <table class="table-condensed">
                                <thead>
                                   
                                </thead>
                                <tbody id="showAdding">
                                    <p id="cString" style="display: none;"></p>
                                    <p id="myphp" style="display: none;"></p>
                                    <p id="pers" style="display: none;"></p>
                                </tbody>
                            </table>
                            <br>  
                                <button id="addAll" onClick="sendContributors({{$id}})" class="btn btn-success btn-sm m-l-md" style="visibility: hidden;">
                                    Add all
                                </button>  
                            <script type="text/javascript">                                 
                                function AddRightCol(id) {
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });


                                    //$.post('http://localhost:8081/project/public/addRightCol', {

                                    $.post('http://localhost/project/public/addRightCol', {
                                        id: id
                                    },  function(response){  
                                            var output = "";
                                            var tbody = document.getElementById('showAdding');
                                            output = '<tr id="row' + response[0] + '"><td><button onClick="removeRightCol(' + response[0] + ')" type="button" id="addRightCol" class="btn btn-danger btn-sm m-l-md col-sm-3" value="' + response[0] + '"><span class="glyphicon glyphicon-minus"></span></button><div class="col-sm-9"><a target="blank" href="../../profile/' + response[0] + '">' + response[1] + '</a><p>' + response[2] + '</p></td><td><select class="permission' + response[0] + '" id="permission' + response[0] + '" onchange="changeSelect(' + response[0] + ')"><option value="1">Read</option><option value="2">Read + Write</option></select>  </div></td></tr>';
                                            
                                            if(!tbody.innerHTML.match(response[1])){
                                                tbody.innerHTML = tbody.innerHTML + output;
                                            }

                                            document.getElementById("addAll").style.visibility = "visible";
                                            var par = document.getElementById("cString");
                                            if(!par.innerHTML.match(response[0])){
                                                par.innerHTML = par.innerHTML + " " + response[0]; 
                                            }
                                            var sel = document.getElementById('permission'+id);
                                            var pers = document.getElementById('pers');
                                            var select = sel.options[sel.selectedIndex].value;

                                            if( pers.innerHTML == "" ){
                                                pers.innerHTML += 'id'+id + ':' + select + '  '; 
                                            }else{
                                                var str = pers.innerHTML;
                                                if(str.match('id'+id+':1')){
                                                    var res = str.replace('id'+id+':2', 'id'+id+':1');  
                                                    pers.innerHTML = res;
                                                }else if(str.match('id'+id+':2')){
                                                    var res = str.replace('id'+id+':1', 'id'+id+':2');  
                                                    pers.innerHTML = res;
                                                }else{
                                                    pers.innerHTML += 'id'+id + ':' + select + '  '; 
                                                }
                                            }
                                        }
                                    );
                                }

                                function changeSelect(id){
                                    var sel = document.getElementById('permission'+id);
                                    var pers = document.getElementById('pers');
                                    var select = sel.options[sel.selectedIndex].value;

                                    if( pers.innerHTML == "" ){
                                        pers.innerHTML += 'id'+id + ':' + select + '  '; 
                                    }else{
                                        // pers.innerHTML = pers.innerHTML + 'id'+id + ':' + select + '/n';
                                        var str = pers.innerHTML;
                                        if(str.match('id'+id+':1')){
                                            var res = str.replace('id'+id+':1', 'id'+id+':2');  
                                            pers.innerHTML = res;
                                        }else if(str.match('id'+id+':2')){
                                            var res = str.replace('id'+id+':2', 'id'+id+':1');  
                                            pers.innerHTML = res;
                                        }else{
                                            pers.innerHTML += 'id'+id + ':' + select + '  '; 
                                        }
                                    }

                                    return 0;
                                }
                                    
                                function removeRightCol(id) {
                                    var elem = document.getElementById('row'+id);
                                    elem.parentNode.removeChild(elem);

                                    var str = document.getElementById("cString").innerHTML; 
                                    var res1 = str.replace(id, "");
                                    document.getElementById("cString").innerHTML = res1;

                                    var str2 = document.getElementById("pers").innerHTML;
                                    
                                    if(str2.match('id'+id+':1')){
                                        str2 = str2.replace('id'+id+':1', '');  
                                    }else if(str2.match('id'+id+':2')){
                                        str2 = str2.replace('id'+id+':2', '');  
                                    }
                                    
                                    document.getElementById('pers').innerHTML = str2;

                                    return false;
                                }

                                function sendContributors(id){
                                    var par = document.getElementById("cString");
                                    var sel = document.getElementById('pers');
                                    cString =  par.innerHTML;
                                    pers = sel.innerHTML;
                                
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    // $.post('http://localhost:8081/project/public/allow', {

                                    $.post('http://localhost/project/public/allow', {
                                        pID: id,
                                        cString: cString,
                                        pers: pers
                                    },  function(){  
                                            // window.location.replace("http://localhost:8081/project/public/");

                                            window.location.replace("http://localhost/project/public/");
                                        }
                                    );
                                }
                            </script>
                        </div>
                    </div>
                </div>
                <div data-bind="visible:page()=='which'" style="display: none;">
                    <div>
                        Adding contributor(s)
                        <span data-bind="text:addingSummary()"></span>
                        to <span data-bind="text:title">Test project</span>.
                    </div>
                    <hr>
                    <div style="margin-bottom:10px;">
                        You can also add the contributor(s) to any components on which you are an admin.
                    </div>
                    <div>
                        Select:&nbsp;
                        <a class="text-bigger" data-bind="click:selectAllNodes">Select all</a>
                        &nbsp;|&nbsp;
                        <a class="text-bigger" data-bind="click:selectNoNodes">Select none</a>
                    </div>
                    <div class="tb-row-titles">
                        <div style="width: 100%" data-tb-th-col="0" class="tb-th">
                            <span class="m-r-sm"></span>
                        </div>
                    </div>
                    <div class="osf-treebeard">
                        <div id="addContributorsTreebeard"><div style="overflow-x: auto" class="gridWrapper"><div style="width:auto;" class="tb-table"><div id="tb-tbody"><div style="height: 84.25714285714287px;" class="tb-tbody-inner"><div style="margin-top:0px;"><div class="tb-row  tb-even" data-id="1" data-level="1" data-index="0" data-rindex="0" style="height: 35px;"><div class="tb-td tb-col-0" style="width:4%"><input type="checkbox"></div><div data-id="1" class="tb-td td-title tb-col-1" style="padding-left: 0px; width:96%"><span class="tb-td-first"><span class="tb-toggle-icon"></span><span class="tb-expand-icon-holder"><span class="fa fa-bar-chart po-icon"></span></span></span><span class="title-text"><span>Test project</span></span></div></div></div></div></div></div></div></div>
                    </div>
                </div>
                <div data-bind="if:page() === &quot;invite&quot;"></div>
            </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
    
    <div>
        <table id="manageContributorsTable" class="table responsive-table responsive-table-xxs">
            <thead>
                <tr>
                    <th class="responsive-table-hide sortable" data-bind="css: {sortable: ($data === 'contrib' &amp;&amp; $root.isSortable())}">
                        Name
                    </th>
                    <th>Permission</th>
                    <th class="remove"></th>
                </tr>
            </thead>
            <tbody id="contributors"  class="ko_container ui-sortable">
                <tr class="contrib">
                    <td >
                        <span class="fa fa-bars sortable-bars"></span>
                        <span class="fa toggle-icon fa-angle-down"></span>
                        <div class="card-header">
                            <span data-bind="ifnot: profileUrl"></span>
                            <span data-bind="if: profileUrl">
                                <?php
                                    $user_id = Project::where('id', $id)->first()->user_id;
                                ?>
                                <i><b><a class="name-search" href="{{ url('profile/' . User::where('id', $user_id)->first()->id) }}">{{ User::where('id', $user_id)->first()->fullName }}
                                </a></b></i>
                            </span>
                        </div>
                    </td>
                </tr>
               
                @foreach ($contributors as $contributor) 
                <tr class="contrib">
                <td >
                    <span class="fa fa-bars sortable-bars"></span>  
                    <span class="fa toggle-icon fa-angle-down"></span>
                    <div class="card-header">
                        <?php  
                            $uID = User::where('fullName', $contributor)->first()->id;
                        ?>
                        <span data-bind="ifnot: profileUrl"></span>
                        <span data-bind="if: profileUrl">
                            <a class="name-search" href="{{ url('profile/' . $uID) }}">{{ $contributor }}</a>
                        </span>
                    </div>
                </td>
            
                <td>
                    <div class="td-content" data-bind="visible: !$root.collapsed() || contributor.expanded()">
                            <form action="{{url('allow'). '/' . $id}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <?php 
                                    $email = User::where('fullName', $contributor)->first()->email;
                                ?>
                                
                                <input type="hidden" value="{{$email}}" name="email">                                    
                                <div class="col col-sm-3">
                                   <?php 
                                        $perm = Project_and_contributors::where('project_id', $id)->where('user_id', $uID)->first()->permission;
                                        
                                        if($perm == 'Read'){
                                            $perm2 = 'Read+Write';        
                                        }else if($perm == 'Read+Write'){
                                            $perm2 = 'Read';
                                        }
                                    ?>
                                    <select class="form-control" id="changePermission{{ User::where('fullName', $contributor)->first()->id }}" onchange="changePermission({{ User::where('fullName', $contributor)->first()->id }},{{ $id }})">
                                        <option value="{{$perm}}">
                                            {{$perm}}
                                        </option>
                                        <option value="{{$perm2}}">
                                            {{$perm2}}
                                        </option>
                                    </select>
                                </div>                                

                                <button type="submit" class="btn btn-danger btn-sm m l-md" data-toggle="modal">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button> Remove
                            </form>
                    </div>
                </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <script type="text/javascript"> 
            function changePermission(uID, pID){
                var sel = document.getElementById('changePermission'+uID);
                var permission = sel.options[sel.selectedIndex].value;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.post('http://localhost:8081/project/public/changePermission', {

                    pID: pID,
                    uID: uID,
                    permission: permission

                },  function(response){  
                    
                    }
                );
            }
        </script>
    </div>
@endsection
