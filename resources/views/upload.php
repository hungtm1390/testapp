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
        .thumb {
            width: 24px;
            height: 24px;
            float: none;
            position: relative;
            top: 7px;
        }

        form .progress {
            line-height: 15px;
        }
        }

        .progress {
            display: inline-block;
            width: 100px;
            border: 3px groove #CCC;
        }

        .progress div {
            font-size: smaller;
            background: orange;
            width: 0;
        }
    </style>
</head>
<body ng-app="fileUpload" ng-controller="MyCtrl">
<form name="myForm">
    <fieldset>
        <legend>Upload on form submit</legend>
        Username:
        <input type="text" name="userName" ng-model="username" size="31" required>
        <i ng-show="myForm.userName.$error.required">*required</i>
        <br>Photo:
        <input type="file" ngf-select ng-model="picFile" name="file"
               accept="image/*" ngf-max-size="2MB" required
               ngf-model-invalid="errorFile">
        <i ng-show="myForm.file.$error.required">*required</i><br>
        <i ng-show="myForm.file.$error.maxSize">File too large
            {{errorFile.size / 1000000|number:1}}MB: max 2M</i>
        <img ng-show="myForm.file.$valid" ngf-thumbnail="picFile" class="thumb">
        <button ng-click="picFile = null" ng-show="picFile">Remove</button>
        <br>
        <button ng-disabled="!myForm.$valid"
                ng-click="uploadPic(picFile)">Submit</button>
        <span class="progress" ng-show="picFile.progress >= 0">
        <div style="width:{{picFile.progress}}%"
             ng-bind="picFile.progress + '%'"></div>
      </span>
        <span ng-show="picFile.result">Upload Successful</span>
        <span class="err" ng-show="errorMsg">{{errorMsg}}</span>
    </fieldset>
    <br>
</form>

<!-- Load Javascript Libraries (AngularJS, JQuery, Bootstrap) -->
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
<script>
    //inject angular file upload directives and services.
    var app = angular.module('fileUpload', ['ngFileUpload']);

    app.controller('MyCtrl', ['$scope', 'Upload', '$timeout', function ($scope, Upload, $timeout) {
        $scope.uploadPic = function(file) {
            file.upload = Upload.upload({
                url: 'https://angular-file-upload-cors-srv.appspot.com/upload',
                data: {username: $scope.username, file: file},
            });

            file.upload.then(function (response) {
                $timeout(function () {
                    file.result = response.data;
                });
            }, function (response) {
                if (response.status > 0)
                    $scope.errorMsg = response.status + ': ' + response.data;
            }, function (evt) {
                // Math.min is to fix IE which reports 200% sometimes
                file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        }
    }]);
</script>
</html>