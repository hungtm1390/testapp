<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Demo Test App2</title>
    <!-- Load Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div>
    <h3>Manager Team Member</h3>
</div>
<div ng-app="MemberTeamManager" ng-controller="MemberTeamController">
    <!-- Table-to-load-the-data Part -->
    <table class="table">
        <thead>
        <tr>
            <th>STT</th>
            <th>Name</th>
            <th>Address</th>
            <th>Age</th>
            <th>Photo</th>
            <th>
                <button id="btn-add" class="btn btn-primary btn-xs">Add New User</button>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr ng-repeat="member in data">
            <td>{{member.id}}</td>
            <td>{{member.name}}</td>
            <td>{{member.address}}</td>
            <td>{{member.age}}</td>
            <td><img width="auto" height="100" src='/public/upload/img/member/{{member.photo}}'></td>
            <td>
                <button class="btn btn-default btn-xs btn-detail">Edit</button>
                <button class="btn btn-danger btn-xs btn-delete">Delete</button>
            </td>
        </tr>
        </tbody>
    </table>
    <!-- End of Table-to-load-the-data Part -->
    <!-- Modal (Pop up when detail button clicked) -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Function Name</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" enctype="multipart/form-data">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Fullname" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Email Address" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Age</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Age" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Photo</label>
                            <div class="col-sm-9">
                                <input type="file" name="img_member">
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-save">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Javascript Libraries (AngularJS, JQuery, Bootstrap) -->
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script src="public/app/controller/members.js"></script>
</body>
</html>