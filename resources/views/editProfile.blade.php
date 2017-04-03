@extends('layouts.app')

@section('content')
<?php 
    use App\User;
    use App\Project_and_contributors; 
    use App\Category;   
    use App\Project;
?>
<body data-spy="scroll" data-target=".scrollspy">
    <div class="osf-nav-wrapper">
        <div class="osf-search" data-bind="fadeVisible: showSearch" style="display: none">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form class="input-group" data-bind="submit: submit">
                            <input id="searchPageFullBar" name="search-placeholder" type="text" class="osf-search-input form-control" placeholder="Search" data-bind="value: query, hasFocus: true">
                            <label id="searchBarLabel" class="search-label-placeholder" for="search-placeholder">Search</label>
                            <span class="input-group-btn">
                                <button type="button" class="btn osf-search-btn" data-bind="click: submit"><i class="fa fa-circle-arrow-right fa-lg"></i></button>
                                <button type="button" class="btn osf-search-btn" data-toggle="modal" data-target="#search-help-modal"><i class="fa fa-question fa-lg"></i></button>
                                <button type="button" class="btn osf-search-btn" data-bind="visible: showClose, click : toggleSearch"><i class="fa fa-times fa-lg"></i></button>
                            </span>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="search-help-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span>×</button>
                        <h3 class="modal-title">Search help</h3>
                    </div>
                    <div class="modal-body">
                        <h4>Queries</h4>
                        <p>Search uses the <a href="http://extensions.xwiki.org/xwiki/bin/view/Extension/Search+Application+Query+Syntax">Lucene search syntax</a>.This gives you many options, but can be very simple as well. Examples of valid searches include:</p>
                        <ul>
                            <li><a href="/search/?q=repro*">repro*</a></li>
                            <li><a href="/search/?q=brian+AND+title%3Amany">brian AND title:many</a></li>
                            <li><a href="/search/?q=tags%3A%28psychology%29">tags:(psychology)</a></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="watermarked">
        <div class="container">
            <h2 class="page-header">Settings
            <div class="pull-right">
                <a href="{{url('profile' . '/' . Auth::user()->id) }}" class="btn btn-link"><i class="fa fa-user m-r-sm"></i>View your profile </a>
            </div>
            </h2>


            <div id="profileSettings" class="row">

            <div class="col-sm-3 affix-parent">
                <div class="osf-affix profile-affix panel panel-default affix-top" data-spy="affix" data-offset-top="70" data-offset-bottom="268" style="width: 263px; display: block;">
                  <ul class="nav nav-stacked nav-pills">
                      <li class="active">
                        <a href="#">Profile information</a></li>

                      <li class="">
                        <a href="/settings/account/">Account settings</a></li>

                      <li class="">
                        <a href="/settings/addons/">Configure add-on accounts</a></li>

                      <li class="">
                        <a href="/settings/notifications/">Notifications</a></li>

                      <li class="">
                        <a href="/settings/applications/">Developer apps</a></li>

                      <li class="">
                        <a href="/settings/tokens/">Personal access tokens</a></li>
                  </ul>
                </div>
             </div>

    <div class="col-sm-9 col-md-7">

        <div id="userProfile">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#names" data-toggle="tab" aria-expanded="true">Name</a></li>
                <li class=""><a href="#jobs" data-toggle="tab" aria-expanded="false">Employment</a></li>
                <li class=""><a href="#schools" data-toggle="tab" aria-expanded="false">Education</a></li>
            </ul>

            <div class="tab-content" id="containDrag">
                <div class="m-t-md tab-pane active" id="names">
                    <div data-bind="template: {name: 'profileName'}">

                        <form role="form" method="post" action="{{url('updateProfile')}}"> 
                            {{ csrf_field() }}
                            <div class="form-group">
                                <br>
                                <label>Full name</label>
                                <input class="form-control" name="fullName"><span class="validationMessage" style="display: none;"></span>
                                <div data-bind="visible: showMessages, css:'text-danger'" class="text-danger" style="display: none;">
                                    <p data-bind="validationMessage: full" style="display: none;"></p>
                                </div>
                            </div>

                            <hr>

                            <div class="p-t-lg p-b-lg">
                                <button data-bind="disable: saving(), text: saving() ? 'Saving' : 'Save'" type="submit" class="btn btn-success">Save</button>
                            </div>

                             <!-- Flashed Messages -->
                            <div class="help-block">
                                <p data-bind="html: message, attr: {class: messageClass}"></p>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="m-t-md tab-pane" id="jobs">
                    <div data-bind="template: {name: 'profileJobs'}">

                    <div data-bind="if: mode() === 'edit'">

                        <form role="form" data-bind="submit: submit, validationOptions: {insertMessages: false, messagesOnModified: false}">

                        <div data-bind="sortable: {
                                data: contents,
                                options: {
                                    handle: '.sort-handle',
                                    containment: '#containDrag',
                                    tolerance: 'pointer'
                                }
                            }" class="ko_container ui-sortable">
                                <div>

                                <div class="well well-sm sort-handle">
                                    <span>Position <span data-bind="text: $index() + 1">1</span></span>
                                    <span data-bind="visible: $parent.contentsLength() > 1" style="display: none;">
                                        [ drag to reorder ]
                                    </span>
                                    <a class="text-danger pull-right" data-bind="click: $parent.removeContent.bind($parent)">Remove</a>
                                </div>

                                <div class="form-group">
                                    <label>Institution / Employer</label>
                                    <input class="form-control" data-bind="value: institution" placeholder="Required">
                                    <div data-bind="visible: $parent.showMessages, css:'text-danger'" class="text-danger" style="display: none;">
                                        <p data-bind="validationMessage: institution" style="display: none;"></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Department / Institute</label>
                                    <input class="form-control" data-bind="value: department">
                                </div>

                                <div class="form-group">
                                    <label>Job title</label>
                                    <input class="form-control" data-bind="value: title">
                                </div>

                                <div class="form-group">
                                    <label>Start date</label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select class="form-control" data-bind="options: months,
                                                     optionsCaption: '-- Month --',
                                                     value: startMonth"><option value="">-- Month --</option><option value="January">January</option><option value="February">February</option><option value="March">March</option><option value="April">April</option><option value="May">May</option><option value="June">June</option><option value="July">July</option><option value="August">August</option><option value="September">September</option><option value="October">October</option><option value="November">November</option><option value="December">December</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control" placeholder="Year" data-bind="value: startYear">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" data-bind="ifnot: ongoing">
                                    <label>End date</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <select class="form-control" data-bind="options: months,
                                                     optionsCaption: '-- Month --',
                                                     value: endMonth"><option value="">-- Month --</option><option value="January">January</option><option value="February">February</option><option value="March">March</option><option value="April">April</option><option value="May">May</option><option value="June">June</option><option value="July">July</option><option value="August">August</option><option value="September">September</option><option value="October">October</option><option value="November">November</option><option value="December">December</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" placeholder="Year" data-bind="value: endYear">
                                            </div>
                                        </div>
                                </div>


                                <div class="form-group">
                                    <label>Ongoing</label>
                                    <input type="checkbox" data-bind="checked: ongoing, click: clearEnd">
                                </div>

                                <div data-bind="visible: $parent.showMessages, css:'text-danger'" class="text-danger" style="display: none;">
                                    <p data-bind="validationMessage: start" style="display: none;"></p>
                                    <p data-bind="validationMessage: end" style="display: none;"></p>
                                    <p data-bind="validationMessage: startYear" style="display: none;"></p>
                                    <p data-bind="validationMessage: endYear" style="display: none;"></p>
                                </div>

                            <hr data-bind="visible: $index() != ($parent.contents().length - 1)" style="display: none;">

                             </div>
                        </div>

                        <div>
                            <a class="btn btn-default" data-bind="click: addContent">
                                Add another
                            </a>
                        </div>

                        <div class="p-t-lg p-b-lg">

                            <button type="button" class="btn btn-default" data-bind="click: cancel">Discard changes</button>

                            <button data-bind="disable: saving(), text: saving() ? 'Saving' : 'Save'" type="submit" class="btn btn-success">Save</button>

                        </div>

                        <!-- Flashed Messages -->
                        <div class="help-block">
                            <p data-bind="html: message, attr: {class: messageClass}"></p>
                        </div>

                        </form>

                    </div>

                    <div data-bind="if: mode() === 'view'"></div>

                    </div>
                </div>

                <div class="m-t-md tab-pane" id="schools">
                    <div data-bind="template: {name: 'profileSchools'}">

            <div data-bind="if: mode() === 'edit'">

                <form role="form" data-bind="submit: submit, validationOptions: {insertMessages: false, messagesOnModified: false}">

                    <div data-bind="sortable: {
                            data: contents,
                            options: {
                                handle: '.sort-handle',
                                containment: '#containDrag',
                                tolerance: 'pointer'
                            }
                        }" class="ko_container ui-sortable"><div>

                            <div class="well well-sm sort-handle">
                                <span>Position <span data-bind="text: $index() + 1">1</span></span>
                                <span data-bind="visible: $parent.contentsLength() > 1" style="display: none;">
                                    [ drag to reorder ]
                                </span>
                                <a class="text-danger pull-right" data-bind="click: $parent.removeContent.bind($parent)">Remove</a>
                            </div>

                            <div class="form-group">
                                <label>Institution</label>
                                <input class="form-control" data-bind="value: institution" placeholder="Required">
                                <div data-bind="visible: $parent.showMessages, css:'text-danger'" class="text-danger" style="display: none;">
                                    <p data-bind="validationMessage: institution" style="display: none;"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Department</label>
                                <input class="form-control" data-bind="value: department">
                            </div>

                            <div class="form-group">
                                <label>Degree</label>
                                <input class="form-control" data-bind="value: degree">
                            </div>

                            <div class="form-group">
                                <label>Start date</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control" data-bind="options: months,
                                                 optionsCaption: '-- Month --',
                                                 value: startMonth"><option value="">-- Month --</option><option value="January">January</option><option value="February">February</option><option value="March">March</option><option value="April">April</option><option value="May">May</option><option value="June">June</option><option value="July">July</option><option value="August">August</option><option value="September">September</option><option value="October">October</option><option value="November">November</option><option value="December">December</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" placeholder="Year" data-bind="value: startYear">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" data-bind="ifnot: ongoing"></div>


                            <div class="form-group">
                                <label>Ongoing</label>
                                <input type="checkbox" data-bind="checked: ongoing, click: clearEnd">
                            </div>

                            <div data-bind="visible: $parent.showMessages, css:'text-danger'" class="text-danger" style="display: none;">
                                <p data-bind="validationMessage: start" style="display: none;"></p>
                                <p data-bind="validationMessage: end" style="display: none;"></p>
                                <p data-bind="validationMessage: startYear" style="display: none;"></p>
                                <p data-bind="validationMessage: endYear" style="display: none;"></p>
                            </div>

                            <hr data-bind="visible: $index() != ($parent.contents().length - 1)" style="display: none;">

                        </div></div>

                    <div>
                        <a class="btn btn-default" data-bind="click: addContent">
                            Add another
                        </a>
                    </div>

                    <div class="p-t-lg p-b-lg">

                        <button type="button" class="btn btn-default" data-bind="click: cancel">Discard changes</button>

                        <button data-bind="disable: saving(), text: saving() ? 'Saving' : 'Save'" type="submit" class="btn btn-success">Save</button>

                    </div>

                    <!-- Flashed Messages -->
                    <div class="help-block">
                        <p data-bind="html: message, attr: {class: messageClass}"></p>
                    </div>

                </form>

            </div>

            <div data-bind="if: mode() === 'view'"></div>

        </div>
        </div>
    </div>

</div>

</div>

</div>


<script id="profileName" type="text/html">

    <form role="form" data-bind="submit: submit">

        <div class="form-group">
            <label>Full name (e.g. Rosalind Elsie Franklin)</label>
            <input class="form-control" data-bind="value: full" />
            <div data-bind="visible: showMessages, css:'text-danger'">
                <p data-bind="validationMessage: full"></p>
            </div>
        </div>

        <span class="help-block">
            Your full name, above, is the name that will be displayed in your profile.
            To control the way your name will appear in citations, you can use the
            "Auto-fill" button to automatically infer your first name, last
            name, etc., or edit the fields directly below.
        </span>

        <div style="margin-bottom: 10px;">
            <a class="btn btn-primary" data-bind="enabled: hasFirst(), click: impute">Auto-fill</a>
        </div>

        <div class="form-group">
            <label>Given name (e.g. Rosalind)</label>
            <input class="form-control" data-bind="value: given" />
        </div>

        <div class="form-group">
            <label>Middle name(s) (e.g. Elsie)</label>
            <input class="form-control" data-bind="value: middle" />
        </div>

        <div class="form-group">
            <label>Family name (e.g. Franklin)</label>
            <input class="form-control" data-bind="value: family" />
        </div>

        <div class="form-group">
            <label>Suffix</label>
            <input class="form-control" data-bind="value: suffix" />
        </div>

        <hr />

        <h4>Citation preview</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Style</th>
                    <th class="overflow-block" width="30%">Citation format</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>APA</td>
                    <td class="overflow-block" width="30%"><span data-bind="text: citeApa"></span></td>
                </tr>
                <tr>
                    <td>MLA</td>
                    <td class="overflow-block" width="30%"><span data-bind="text: citeMla"></span></td>
                </tr>
            </tbody>
        </table>

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

</script>

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


        </div><!-- end container -->
    </div><!-- end watermarked -->




    


    
</div><!-- end container copyright -->

            <script>
            var _prum = [['id', "526076f6abe53d9e35000000"],
                            ['mark', 'firstbyte', (new Date()).getTime()]];
            (function() {
                var s = document.getElementsByTagName('script')[0]
                    , p = document.createElement('script');
                p.async = 'async';
                p.src = '//rum-static.pingdom.net/prum.min.js';
                s.parentNode.insertBefore(p, s);
            })();
            </script>

        

        

            <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', "UA-26813616-1", 'auto', {'allowLinker': true});
            ga('require', 'linker');
            ga('linker:autoLink', ['centerforopenscience.org', 'cos.io'] );
            ga('set', 'dimension1', "99c65e61b37df5b8df5b742ce8b0676d");
            ga('set', 'dimension2', "2017-04-03 14:57:33.612807");
            ga('send', 'pageview');
            </script>


        <script>
            // Mako variables accessible globally
            window.contextVars = $.extend(true, {}, window.contextVars, {
                waterbutlerURL: "https://files.osf.io/",
                // Whether or not this page is loaded under osf.io or another domain IE: institutions
                isOnRootDomain: "https://osf.io/" === window.location.origin + '/',
                cookieName: "osf",
                apiV2Prefix: "https://api.osf.io/v2/",
                registerUrl: "/api/v1/register/",
                currentUser: {
                    id: "83akk",
                    locale: "ru",
                    timezone: "Asia/Almaty",
                    entryPoint: "osf",
                    institutions: [],
                    emailsToAdd: [],
                    anon: {"country": "SE", "continent": "EU"},
                },
                popular: "57tnq",
                newAndNoteworthy: "z3sg2",
                maintenance: null,
                analyticsMeta: {},
            });
        </script>

            <script>
                window.contextVars = $.extend(true, {}, window.contextVars, {
                    keen: {
                        public: {
                            projectId: "5797b58fbcb79c2c0fa1a705",
                            writeKey: "40b0559c81c37757442b7fdeec4d384c0b2878ca9758ce561c1daa7b4c5cb77b0c9f80c562f313aa23ebef2c97cd70b2cf2af41716dc8fdb682ffaa52ff23441598432e81995e4899df55b6caa32edd3d208a05fd6367f0ac9fdcd2c4023c290",
                        },
                        private: {
                            projectId: "5797b5a3709a395e9e29c11d",
                            writeKey: "73357414691a69448b9b967b7c56a16602e02ebe3d21f348acd7e717cef40275536f302143758330dfabea49355753dd05ab3865aa675ef2d803c2baa9b591b825689d96e4492c181be6a6631c0328ee9eeb24704ee7beb6c90f9bd5f06cfcb2",
                        },
                    },
                });
            </script>


        
<script type="text/javascript">
    window.contextVars = window.contextVars || {};
    window.contextVars.nameUrls = {
        crud: "/api/v1/settings/names/",
        impute: "/api/v1/settings/names/impute/"
    };
    window.contextVars.socialUrls = {
        crud: "/api/v1/settings/social/"
    };
    window.contextVars.jobsUrls = {
        crud: "/api/v1/settings/jobs/"
    };
    window.contextVars.schoolsUrls = {
        crud: "/api/v1/settings/schools/"
    };
</script>
<script src="/static/public/js/profile-settings-page.d7f528fa6cf525529377.js"></script>

</body>
@endsection