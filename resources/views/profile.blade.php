@extends('layouts.app')

@section('content')
<?php 
    use App\User;
    use App\Project_and_contributors; 
    use App\Category;   
    use App\Project;
?>
<div class="watermarked">
        <div class="container">

<div class="page-header">
    <div class="profile-fullname">
        
        <span id="profileFullname" class="h1 overflow m-l-sm">
            Ilyas
        </span>
        <span class="edit-profile-settings">
                <a href="{{url('editProfilePage')}}"><span class="glyphicon glyphicon-pencil"></span> Edit your profile</a>
        </span>
    </div>
</div><!-- end-page-header -->


<div class="row">

    <div class="col-sm-6">

        <table class="table table-plain">
            <tbody>
                <tr>
                    <td>Member&nbsp;Since</td>
                    <td>{{ User::where('id', $id)->first()->created_at }}</td>
                </tr>
                <tr>
                   <td>Address:</td>
                   <td>{{ User::where('id', $id)->first()->address }}</td>
               </tr>       
            </tbody>
        </table>
        <h2>
           {{ count(Project::where('user_id', $id)->get()) }}  @if(count(Project::where('user_id', $id)->get()) !== 1)
                                                                    {{ 'projects' }}
                                                                @else
                                                                    {{ 'project' }}
                                                                @endif
           <br>     
           
        </h2>
    </div>

    <div class="col-sm-6">


        <ul class="nav nav-tabs">
            <li class="active"><a href="#social" data-toggle="tab">Social</a></li>
            <li><a href="#jobs" data-toggle="tab">Employment</a></li>
            <li><a href="#schools" data-toggle="tab">Education</a></li>
        </ul>

        <div class="tab-content" id="containDrag">

            <div class="m-t-md tab-pane active" id="social">
                <div data-bind="template: {name: 'profileSocial'}">

                    <link rel="stylesheet" href="/static/css/pages/profile-page.css">
                    <link rel="stylesheet" href="/static/vendor/bower_components/academicons/css/academicons.css">

                    <div data-bind="if: mode() === 'edit'"></div>

                    <div data-bind="if: mode() === 'view'">

                        <table class="table" data-bind="if: hasValues()"></table>

                        <div >
                            <div class="well well-sm">Not provided</div>
                        </div>

                        <div data-bind="if: editAllowed"></div>

                    </div>

                </div>
            </div>

            <div class="m-t-md tab-pane" id="jobs">
                <div data-bind="template: {name: 'profileJobs'}">

                    <div data-bind="if: mode() === 'edit'"></div>

              
                    <div data-bind="ifnot: contents().length" class="dropdown">
                    @if(empty($employments))
                        <div class="well well-sm">Not provided</div>
                    @else
                        <?php $i = 0; ?>
                        @foreach($employments as $emp)
                        <div class="well well-sm">
                            {{ $emp->employer}}
                            <?php 
                                if($emp->ongoing === 1){
                                    $endDate = 'ongoing'; 
                                }else{
                                    $endDate = $emp->endDate;
                                } 
                            ?>
                            <p><i><small>{{ $emp->startDate  . ' - ' . $endDate}}</small></i></p>
                           
                            <button class="button" onclick="$('#target{{$i}}').toggle();">
                                <span class="caret"></span>
                            </button>
                            <div id="target{{$i}}" style="display: none">
                                @if(!empty($emp->department))
                                    <b>Department: </b>{{ $emp->department }}
                                    {{ "\n" }}
                                @endif
                                <p></p>
                                @if(!empty($emp->jobTitle))
                                    <b>Job title: </b>{{ "\n" . $emp->jobTitle }}
                                @endif
                             
                            </div>     
                        </div>
                        <?php $i++; ?>
                        @endforeach
                    @endif
                    </div>
                      
                    <div class="row" data-bind="if: contents().length"></div>

                    <div data-bind="if: editable"></div>

                </div>

            </div>
        

            <div class="m-t-md tab-pane" id="schools">
                <div data-bind="template: {name: 'profileSchools'}">

                    <div data-bind="if: mode() === 'edit'"></div>

                    <div data-bind="if: mode() === 'view'">

                        <div data-bind="ifnot: contents().length" class="dropdown">
                            @if(empty($educations))
                                <div class="well well-sm">Not provided</div>
                            @else
                                <?php $j=0; ?>
                                @foreach($educations as $edu)
                                <div class="well well-sm">
                                    {{ $edu->universityName}}
                                    <?php 
                                        if($edu->ongoing === 1){
                                            $endDate = 'ongoing'; 
                                        }else{
                                            $endDate = $edu->endDate;
                                        } 
                                    ?>
                                    <p><i><small>{{ $edu->startDate  . ' - ' . $endDate}}</small></i></p>
                                    
                                    <button class="button" onclick="$('#{{$j}}target').toggle();">
                                        <span class="caret"></span>
                                    </button>
                                    <div id="{{$j}}target" style="display: none">
                                        @if(!empty($edu->department))
                                            <b>Department: </b>{{ $edu->department }}
                                        @endif
                                        
                                        <p></p>
                                        @if(!empty($edu->degree))
                                            <b>Degree: </b>{{ $edu->degree }}
                                        @endif
                                     
                                    </div>
                                </div>
                                <?php $j++; ?>
                                @endforeach
                            @endif
                        </div>

                        <div class="row" data-bind="if: contents().length"></div>


                        <div data-bind="if: editable"></div>

                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

<hr>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
              <h3 class="panel-title">Public projects</h3>
            </div>
            <div class="panel-body">
              

            <div class="help-block">
                
                <?php $projects = Project::where('user_id', $id)->get(); ?>

                <table class="table table-striped task-table" id="example">
                    <thead>
                        <th class="col-sm-3">Title</th>
                        <th class ="col-sm-3">Modified</th> 
                        <th class ="col-sm-3">Category</th> 
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                        <tr>
                            <td class="table-text">
                                <a href="{{url('show') . '/' . $project->id }}">
                                    <div>{{ $project->title }}</div>
                                </a>
                            </td>
                            
                            <td class="table-text">
                                
                                {{ $project->updated_at }}

                            </td>

                            <td class="table-text">
                                
                                {{ Category::where('id', $project->category)->first()->name }}

                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>

            </div>


            </div>
        </div>
    </div>
    
</div><!-- end row -->

<script id="profileSocial" type="text/html">

    <link rel="stylesheet" href='/static/css/pages/profile-page.css'>
    <link rel="stylesheet" href="/static/vendor/bower_components/academicons/css/academicons.css"/>

    <div data-bind="if: mode() === 'edit'">

        <form role="form" data-bind="submit: submit">

            <label>Your websites</label>
            <div data-bind="sortable: {
                        data: profileWebsites,
                        options: {
                            handle: '.sort-handle',
                            containment: '#containDrag'
                        }
                    }">

                <div>
                    <div class="sort-handle">
                        <i title="Click to remove" class="btn text-danger pull-right  fa fa-times fa" data-bind="click: $parent.removeWebsite"></i>
                        <div class="input-group" >
                            <span class="input-group-addon"><i title="Drag to reorder"  class="fa fa-bars"></i></span>
                            <input type="url" class="form-control" data-bind="value: $parent.profileWebsites()[$index()]" placeholder="http://yourwebsite.com"/>
                        </div>
                    </div>
                    <div class="form-group" data-bind="visible: $index() != ($parent.profileWebsites().length - 1)">
                    </div>
                </div>
            </div>
            <div data-bind="ifnot: hasValidWebsites" class="text-danger">Please enter a valid website</div>
            <div class="p-t-sm p-b-sm">
                <a class="btn btn-default" data-bind="click: addWebsiteInput">
                    Add website
                </a>
            </div>

            <div class="form-group">
                <label>ORCID</label>
                <div class="input-group">
                <span class="input-group-addon">http://orcid.org/</span>
                <input class="form-control" data-bind="value: orcid" placeholder="xxxx-xxxx-xxxx-xxxx"/>
                </div>
            </div>

            <div class="form-group">
                <label>ResearcherID</label>
                <div class="input-group">
                <span class="input-group-addon">http://researcherid.com/rid/</span>
                <input class="form-control" data-bind="value: researcherId" placeholder="x-xxxx-xxxx" />
                </div>
            </div>

            <div class="form-group">
                <label>Twitter</label>
                <div class="input-group">
                <span class="input-group-addon">@</span>
                <input class="form-control" data-bind="value: twitter" placeholder="twitterhandle"/>
                </div>
            </div>

            <div class="form-group">
                <label>GitHub</label>
                <div class="input-group">
                    <span class="input-group-addon">https://github.com/</span>
                    <input class="form-control" data-bind="value: github" placeholder="username"/>
                    <span class="input-group-btn" data-bind="if: github.hasAddon()">
                        <button
                                class="btn btn-primary"
                                data-bind="click: github.importAddon"
                                >Import</button>
                     </span>
                </div>
            </div>

            <div class="form-group">
                <label>LinkedIn</label>
                <div class="input-group">
                <span class="input-group-addon">https://www.linkedin.com/</span>
                <input class="form-control" data-bind="value: linkedIn" placeholder="in/userID, profile/view?id=profileID, or pub/pubID"/>
                </div>
            </div>

            <div class="form-group">
                <label>ImpactStory</label>
                <div class="input-group">
                <span class="input-group-addon">https://impactstory.org/</span>
                <input class="form-control" data-bind="value: impactStory" placeholder="profileID"/>
                </div>
            </div>

            <div class="form-group">
                <label>Google Scholar</label>
                <div class="input-group">
                <span class="input-group-addon">http://scholar.google.com/citations?user=</span>
                <input class="form-control" data-bind="value: scholar" placeholder="profileID"/>
                </div>
            </div>

            <div class="form-group">
                <label>ResearchGate</label>
                <div class="input-group">
                <span class="input-group-addon">https://researchgate.net/profile/</span>
                <input class="form-control" data-bind="value: researchGate" placeholder="profileID"/>
                </div>
            </div>

            <div class="form-group">
                <label>Academia</label>
                <div class="input-group">
                <span class="input-group-addon">https://</span>
                <input class="form-control" data-bind="value: academiaInstitution" placeholder="institution" size="5"/>
                <span class="input-group-addon">.academia.edu/</span>
                <input class="form-control" data-bind="value: academiaProfileID" placeholder="profileID"/>
                </div>
            </div>

            <div class="form-group">
                <label>Baidu Scholar</label>
                <div class="input-group">
                <span class="input-group-addon">http://xueshu.baidu.com/scholarID/</span>
                <input class="form-control" data-bind="value: baiduScholar" placeholder="profileID"/>
                </div>
            </div>

            <div class="form-group">
                <label>SSRN</label>
                <div class="input-group">
                <span class="input-group-addon">http://papers.ssrn.com/sol3/cf_dev/AbsByAuth.cfm?per_id=</span>
                <input class="form-control" data-bind="value: ssrn" placeholder="profileID"/>
                </div>
            </div>

            <div class="p-t-lg p-b-lg">

                <button
                        type="button"
                        class="btn btn-default"
                        data-bind="click: cancel"
                    >Discard changes</button>

                <button
                        data-bind="disable: saving(), text: saving() ? 'Saving' : 'Save'"
                        type="submit"
                        class="btn btn-success"
                    >Save</button>
            </div>

            <!-- Flashed Messages -->
            <div class="help-block flashed-message">
                <p data-bind="html: message, attr: {class: messageClass}"></p>
            </div>


        </form>

    </div>

    <div data-bind="if: mode() === 'view'">

        <table class="table" data-bind="if: hasValues()">
            <tbody>
                <tr data-bind="if: hasProfileWebsites()">
                    <td data-bind="visible: profileWebsites().length > 1">Personal websites</td>
                    <td data-bind="visible: profileWebsites().length === 1">Personal website</td>
                    <td data-bind="foreach: profileWebsites"><a data-bind="attr: {href: $data}, text: $data"></a><br></td>
                </tr>
            </tbody>

            <tbody data-bind="foreach: values">
                <tr data-bind="if: value">
                    <td><a target="_blank" data-bind="attr: {href: value}"><span data-bind="html: iconName(label)"></span></a></td>
                    <td><span data-bind="text: label"></span></td>
                    <td><a target="_blank" data-bind="attr: {href: value}, text: text"></a></td>
                </tr>
            </tbody>
        </table>

        <div data-bind="ifnot: hasValues()">
            <div class="well well-sm">Not provided</div>
        </div>

        <div data-bind="if: editAllowed">
            <a class="btn btn-primary" data-bind="click: edit">Edit</a>
        </div>

    </div>

</script>
<script>
iconName = function(name) {
    var nameToHtml = {
        "ORCID": "<i class='ai ai-orcid-square ai-2x' />",
        "ResearcherID": "<img src='http://tguillerme.github.io/images/logo-RID.png' class='icon-image'>",
        "Twitter": "<i class='fa fa-twitter-square fa-2x' />",
        "GitHub": "<i class='fa fa-github-square fa-2x' />",
        "LinkedIn": "<i class='fa fa-linkedin-square fa-2x' />",
        "ImpactStory": "<i class='ai ai-impactstory-square ai-2x' />",
        "Google Scholar": "<i class='ai ai-google-scholar-square ai-2x' />",
        "ResearchGate": "<i class='ai ai-researchgate-square ai-2x' />",
        "Academia": "<i class='ai ai-academia-square ai-2x' />",
        "Baidu Scholar": "<img src='http://www.baidu.com/favicon.ico' class='icon-image'>",
        "SSRN": "<img src='https://www.google.com/s2/favicons?domain=http://www.ssrn.com/' class='icon-image'>"
    };
    return nameToHtml[name];
}
</script>

<script id="profileJobs" type="text/html">

    <div data-bind="if: mode() === 'edit'">

        <form role="form" data-bind="submit: submit, validationOptions: {insertMessages: false, messagesOnModified: false}">

            <div data-bind="sortable: {
                    data: contents,
                    options: {
                        handle: '.sort-handle',
                        containment: '#containDrag',
                        tolerance: 'pointer'
                    }
                }">

                <div>

                    <div class="well well-sm sort-handle">
                        <span>Position <span data-bind="text: $index() + 1"></span></span>
                        <span data-bind="visible: $parent.contentsLength() > 1">
                            [ drag to reorder ]
                        </span>
                        <a
                                class="text-danger pull-right"
                                data-bind="click: $parent.removeContent.bind($parent)"
                                >Remove</a>
                    </div>

                    <div class="form-group">
                        <label>Institution / Employer</label>
                        <input class="form-control" data-bind="value: institution"
                            placeholder="Required"/>
                        <div data-bind="visible: $parent.showMessages, css:'text-danger'">
                            <p data-bind="validationMessage: institution"></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Department / Institute</label>
                        <input class="form-control" data-bind="value: department" />
                    </div>

                    <div class="form-group">
                        <label>Job title</label>
                        <input class="form-control" data-bind="value: title" />
                    </div>

                    <div class="form-group">
                        <label>Start date</label>
                        <div class="row">
                            <div class ="col-md-3">
                                <select class="form-control" data-bind="options: months,
                                         optionsCaption: '-- Month --',
                                         value: startMonth">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" placeholder="Year" data-bind="value: startYear" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group" data-bind="ifnot: ongoing">
                        <label>End date</label>
                            <div class="row">
                                <div class ="col-md-3">
                                    <select class="form-control" data-bind="options: months,
                                         optionsCaption: '-- Month --',
                                         value: endMonth">
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" placeholder="Year" data-bind="value: endYear" />
                                </div>
                            </div>
                    </div>


                    <div class="form-group">
                        <label>Ongoing</label>
                        <input type="checkbox" data-bind="checked: ongoing, click: clearEnd"/>
                    </div>

                    <div data-bind="visible: $parent.showMessages, css:'text-danger'">
                        <p data-bind="validationMessage: start"></p>
                        <p data-bind="validationMessage: end"></p>
                        <p data-bind="validationMessage: startYear"></p>
                        <p data-bind="validationMessage: endYear"></p>
                    </div>

                    <hr data-bind="visible: $index() != ($parent.contents().length - 1)" />

                </div>

            </div>

            <div>
                <a class="btn btn-default" data-bind="click: addContent">
                    Add another
                </a>
            </div>

            <div class="p-t-lg p-b-lg">

                <button
                        type="button"
                        class="btn btn-default"
                        data-bind="click: cancel"
                    >Discard changes</button>

                <button
                        data-bind="disable: saving(), text: saving() ? 'Saving' : 'Save'"
                        type="submit"
                        class="btn btn-success"
                    >Save</button>

            </div>

            <!-- Flashed Messages -->
            <div class="help-block">
                <p data-bind="html: message, attr: {class: messageClass}"></p>
            </div>

        </form>

    </div>

    <div data-bind="if: mode() === 'view'">

        <div data-bind="ifnot: contents().length">
            <div class="well well-sm">Not provided</div>
        </div>

        <div class="row" data-bind="if: contents().length">

            <div data-bind="foreach: contents">
                <div class="col-xs-12">
                    <!-- ko if: expandable() -->
                        <div class="panel panel-default">
                            <div class="panel-heading card-heading" data-bind="click: toggle(), attr: {id: 'jobHeading' + $index(), href: '#jobCard' + $index()}" role="button" data-toggle="collapse" aria-controls="card" aria-expanded="false">
                                <div class="header-content">
                                    <h5 class="institution" data-bind="text: institution"></h5>
                                    <span data-bind="if: startYear()" class="subheading">
                                        <span data-bind="text: startMonth"></span> <span data-bind="text: startYear"></span> - <span data-bind="text: endView"></span>
                                    </span>
                                </div>
                                <span data-bind="attr: {class: expanded() ? 'fa toggle-icon fa-angle-down' : 'fa toggle-icon fa-angle-up'}"></span>
                            </div>
                            <div data-bind="attr: {id: 'jobCard' + $index(), 'aria-labelledby': 'jobHeading' + $index()}" class="panel-collapse collapse">
                                <div class="panel-body card-body">
                                    <span data-bind="if: department().length"><h5>Department / Institute:</h5> <span data-bind="text: department"></span></span>
                                    <span data-bind="if: title().length"><h5>Title:</h5> <span data-bind="text: title"></span></span>
                                    <span data-bind="if: startYear()"><h5>Dates:</h5>
                                        <span data-bind="text: startMonth"></span> <span data-bind="text: startYear"></span> - <span data-bind="text: endView"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <!-- /ko -->
                    <!-- ko ifnot: expandable() -->
                        <div class="panel panel-default">
                            <div class="panel-heading no-bottom-border">
                                <div>
                                    <h5 data-bind="text: institution"></h5>
                                </div>
                            </div>
                        </div>
                    <!-- /ko -->
                </div>
            </div>
        </div>

        <div data-bind="if: editable">
            <a class="btn btn-default" data-bind="click: edit">Edit</a>
        </div>

    </div>

</script>

<script id="profileSchools" type="text/html">

    <div data-bind="if: mode() === 'edit'">

        <form role="form" data-bind="submit: submit, validationOptions: {insertMessages: false, messagesOnModified: false}">

            <div data-bind="sortable: {
                    data: contents,
                    options: {
                        handle: '.sort-handle',
                        containment: '#containDrag',
                        tolerance: 'pointer'
                    }
                }">

                <div>

                    <div class="well well-sm sort-handle">
                        <span>Position <span data-bind="text: $index() + 1"></span></span>
                        <span data-bind="visible: $parent.contentsLength() > 1">
                            [ drag to reorder ]
                        </span>
                        <a
                                class="text-danger pull-right"
                                data-bind="click: $parent.removeContent.bind($parent)"
                                >Remove</a>
                    </div>

                    <div class="form-group">
                        <label>Institution</label>
                        <input class="form-control" data-bind="value: institution" 
                            placeholder="Required" />
                        <div data-bind="visible: $parent.showMessages, css:'text-danger'">
                            <p data-bind="validationMessage: institution"></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Department</label>
                        <input class="form-control" data-bind="value: department" />
                    </div>

                    <div class="form-group">
                        <label>Degree</label>
                        <input class="form-control" data-bind="value: degree" />
                    </div>

                    <div class="form-group">
                        <label>Start date</label>
                        <div class="row">
                            <div class ="col-md-3">
                                <select class="form-control" data-bind="options: months,
                                         optionsCaption: '-- Month --',
                                         value: startMonth">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" placeholder="Year" data-bind="value: startYear" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group" data-bind="ifnot: ongoing">
                        <label>End date</label>
                            <div class="row">
                                <div class ="col-md-3">
                                    <select class="form-control" data-bind="options: months,
                                         optionsCaption: '-- Month --',
                                         value: endMonth">
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" placeholder="Year" data-bind="value: endYear" />
                                </div>
                            </div>
                    </div>


                    <div class="form-group">
                        <label>Ongoing</label>
                        <input type="checkbox" data-bind="checked: ongoing, click: clearEnd"/>
                    </div>

                    <div data-bind="visible: $parent.showMessages, css:'text-danger'">
                        <p data-bind="validationMessage: start"></p>
                        <p data-bind="validationMessage: end"></p>
                        <p data-bind="validationMessage: startYear"></p>
                        <p data-bind="validationMessage: endYear"></p>
                    </div>

                    <hr data-bind="visible: $index() != ($parent.contents().length - 1)" />

                </div>

            </div>

            <div>
                <a class="btn btn-default" data-bind="click: addContent">
                    Add another
                </a>
            </div>

            <div class="p-t-lg p-b-lg">

                <button
                        type="button"
                        class="btn btn-default"
                        data-bind="click: cancel"
                    >Discard changes</button>

                <button
                        data-bind="disable: saving(), text: saving() ? 'Saving' : 'Save'"
                        type="submit"
                        class="btn btn-success"
                    >Save</button>

            </div>

            <!-- Flashed Messages -->
            <div class="help-block">
                <p data-bind="html: message, attr: {class: messageClass}"></p>
            </div>

        </form>

    </div>

    <div data-bind="if: mode() === 'view'">

        <div data-bind="ifnot: contents().length">
            <div class="well well-sm">Not provided</div>
        </div>

        <div class="row" data-bind="if: contents().length">
            <div data-bind="foreach: contents">
                <div class="col-xs-12">
                    <!-- ko if: expandable() -->
                        <div class="panel panel-default">
                            <div class="panel-heading card-heading" data-bind="click: toggle(), attr: {id: 'schoolHeading' + $index(), href: '#schoolCard' + $index()}" role="button" data-toggle="collapse" aria-controls="card" aria-expanded="false">
                                <div class="header-content">
                                    <h5 class="institution" data-bind="text: institution"></h5>
                                    <span data-bind="if: startYear()" class="subheading">
                                        <span data-bind="text: startMonth"></span> <span data-bind="text: startYear"></span> - <span data-bind="text: endView"></span>
                                    </span>
                                </div>
                                <span data-bind="attr: {class: expanded() ? 'fa toggle-icon fa-angle-down' : 'fa toggle-icon fa-angle-up'}"></span>
                            </div>
                            <div data-bind="attr: {id: 'schoolCard' + $index(), 'aria-labelledby': 'schoolHeading' + $index()}" class="panel-collapse collapse">
                                <div class="panel-body card-body">
                                    <span data-bind="if: department().length"><h5>Department:</h5> <span data-bind="text: department"></span></span>
                                    <span data-bind="if: degree().length"><h5>Degree:</h5> <span data-bind="text: degree"></span></span>
                                    <span data-bind="if: startYear()"><h5>Dates:</h5>
                                        <span data-bind="text: startMonth"></span> <span data-bind="text: startYear"></span> - <span data-bind="text: endView"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <!-- /ko -->
                    <!-- ko ifnot: expandable() -->
                        <div class="panel panel-default">
                            <div class="panel-heading no-bottom-border">
                                <div>
                                    <h5 data-bind="text: institution"></h5>
                                </div>
                            </div>
                        </div>
                    <!-- /ko -->
                </div>
            </div>

        </div>


        <div data-bind="if: editable">
            <a class="btn btn-default" data-bind="click: edit">Edit</a>
        </div>

    </div>

</script>

<script type="text/javascript">
  (function() {
      var socialUrls = {
          crud: "/api/v1/settings/social/83akk/"
      };
      var jobsUrls = {
          crud: "/api/v1/settings/jobs/83akk/"
      };
      var schoolsUrls = {
          crud: "/api/v1/settings/schools/83akk/"
      };

      window.contextVars = $.extend(true, {}, window.contextVars, {
          socialUrls: socialUrls,
          jobsUrls: jobsUrls,
          schoolsUrls: schoolsUrls
      });
  })();
</script>


        </div><!-- end container -->
    </div>
@endsection