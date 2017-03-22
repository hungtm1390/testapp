<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Demo Test App2</title>
    <!-- Load Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">

    <link href="public/css/members.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet'
          type='text/css'>
    <style>
        .error {color: red;}
        .valid {color: blue;    padding: 0px 16px; line-height: 2.5em;}
        .form-horizontal .control-label{text-align: left;}
        .message{margin-left: 86px;line-height: 2.5em;}
        .col-sm-10{padding-right: 0px;padding-left: 35px;}
        .col-sm-6{padding-left: 35px;}
        .reqPhoto{padding-top:0px  !important;     font-size: 13px;
            text-decoration: none;
            font-weight: normal;
            font-style: italic;}
        .messagePhoto{    margin-left: 71px;
            position: fixed;
            bottom: 145px;}
        .sort{
            float: right; line-height: 1.5em;
        }
    </style>
</head>
<body>
<div class="container flex-center position-ref full-height">
    <header>
        <div class="row">
            <div class="col-md-6 col-ms-6 col-xs-6" id="logo-topo">
                <a href="/"><h2>Scuti</h2></a>
            </div>
        </div>
    </header>

    <div class="row" ng-app="MemberTeamManager" ng-controller="MemberTeamController" ng-init="getMembersList()">
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">Member Team Manager</h3>
                        </div>
                        <div class="col col-xs-6 text-right">
                            <button type="button" class="btn btn-sm btn-primary btn-create"
                                    ng-click="membermanager('add',0)">Create New
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th width="100px" cclass="hidden-xs" ng-click="sortBy('id')"><i class="sort fa fa-sort" aria-hidden="true"></i>ID</th>
                            <th width="200px" ng-click="sortBy('name')"><i class="sort fa fa-sort" aria-hidden="true"></i>Name</th>
                            <th width="100px" ng-click="sortBy('age')"><i class="sort fa fa-sort" aria-hidden="true"></i>Age</th>
                            <th ng-click="sortBy('address')"><i class="sort fa fa-sort" aria-hidden="true"></i>Address</th>
                            <th width="200px">Photo</th>
                            <th width="100px"><em class="fa fa-cog"></em></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="members in data | orderBy:sortField:reverseOrder">
                            <td width="50px" class="hidden-xs">{{members.id}}</td>
                            <td width="200px">{{members.name}}</td>
                            <td width="50px">{{members.age}}</td>
                            <td>{{members.address}}</td>
                            <td width="200px"><img ng-if="members.photo" class="img-circle" height="100" width="auto"
                                     src="/upload/img/member/{{members.photo}}"/>
                            <img ng-if="!members.photo" class="img-circle" height="100" width="auto"
                                 src="/upload/img/member/1490070194.images.png"/></td>
                            <td width="100px" align="center">
                                <a class="btn btn-default" ng-click="membermanager('edit',members.id)"><em
                                            class="fa fa-pencil"></em></a>
                                <a class="btn btn-danger" ng-click="confirmClick() && deleteMember(members.id)"
                                   confirm-click><em class="fa fa-trash"></em></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col col-xs-8">
                            <posts-pagination class="text-center"></posts-pagination>
                        </div>
                    </div>
                </div>

                <!-- Modal (Pop up when detail button clicked) -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true" ng-click="cancel()">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" ng-click="cancel()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">{{state}}</h4>
                            </div>
                            <div class="modal-body">
                                <form name="memberform" class="form-horizontal"  novalidate>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="inputName" name="txtname" class="form-control" placeholder="Full Name" value="{{name}}"
                                                   ng-model="formData.name" ng-required=true ng-maxlength="100">
                                        </div>
                                        <label class="col-sm-1 error control-label" ng-show="memberform.txtname.$error.required">(*)</label>
                                        <span id="msgName"></span>
                                        <span id="msgName" class="error message" ng-show="memberform.txtname.$error.maxlength">The name must be less than 100</span>
                                        <span class="valid" ng-show="memberform.txtname.$valid"><i class="fa fa-check-circle"></i></span>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Age</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="inputAge" name="numberage" class="form-control" placeholder="Age"
                                                   value="{{age}}" ng-model="formData.age" ng-required="true" ng-maxlength="2" >
                                        </div>
                                        <label class="col-sm-1 error control-label" ng-show="memberform.numberage.$error.required">(*)</label>
                                        <span class="error message" ng-show="!memberform.numberage.$error.required && memberform.numberage.$invalid">Age must be numeric less than 3</span>
                                        <span class="valid" ng-show="memberform.numberage.$valid"><i class="fa fa-check-circle"></i></span>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Address</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="inputAddress" name="txtaddress" class="form-control" placeholder="Address" value="{{address}}"
                                                   ng-model="formData.address" ng-required="true" ng-maxlength="300">
                                        </div>
                                        <label class="col-sm-1 error control-label" ng-show="memberform.txtaddress.$error.required">(*)</label>
                                        <span class="error message" ng-show="memberform.txtaddress.$error.maxlength">The Address must be less than 300</span>
                                        <span class="valid" ng-show="memberform.txtaddress.$valid"><i class="fa fa-check-circle"></i></span>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label">Photo</label>
                                        <div class="col-sm-6">
                                            <input type="file" name="file" file-model="files" id="upload"
                                                   onchange="angular.element(this).scope().imageUpload(event)"
                                            />
                                        </div>
                                        <label class="col-sm-5 control-label reqPhoto">(jpg|png|gif)(Max:10MB)</label>
                                    </div>
                                    <span id="err_upload" class="error message messagePhoto"></span>
                                    <div class="form-group" style="margin-left: 70px;    padding-top: 30px;">
                                        <img class="img-thumbnail" id="imgThumbnail"
                                             src="/upload/img/member/{{formData.photo}}"
                                             style="width:100px;height:auto;" ng-src="{{step}}"/>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="cancel()">
                                    Close
                                </button>
                                <button type="button" class="btn btn-primary" id="btn-save" ng-disabled="memberform.$invalid" ng-click="save(states,id)">
                                    Summit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Javascript Libraries (AngularJS, JQuery, Bootstrap) -->
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.10.0.js"></script>
<script src="public/app/controller/members.js"></script>


</body>
</html>