angular.module("MemberTeamManager", ['ui.bootstrap'])
    .controller('MemberTeamController', function ($scope, $http) {
        $scope.data = [];
        $scope.totalPages = 0;
        $scope.currentPage = 1;
        $scope.range = [];
        $scope.getMembersList = function (pageNumber) {
            if (pageNumber === undefined) {
                pageNumber = '1';
            }
            $http.get('http://testapp2.local:400/list-members' + '?page=' + pageNumber).success(function(response) {
                $scope.data        = response.data;
                $scope.totalPages   = response.last_page;
                $scope.currentPage  = response.current_page;
                // Pagination Range
                var pages = [];

                for (var i = 1; i <= response.last_page; i++) {
                    pages.push(i);
                }
                $scope.range = pages;
            });
        };
        /*$http.get(url).success(function (response) {
            $scope.data = response.data;
        });*/

        //show modal form
        //states: add||edit; id = 0: add; id != 0 edit
        $scope.membermanager = function (states, id) {
            $scope.states = states;
            $scope.formData = {};
            switch (states) {
                case 'add':
                    document.getElementById("upload").value = "";
                    document.getElementById("imgThumbnail").src = "";
                    $scope.state = "Add New Member";
                    $scope.formData.id = "0";
                    $scope.formData.name = '';
                    $scope.formData.age = '';
                    $scope.formData.address = '';
                    $scope.formData.photo = '';
                    break;
                case 'edit':
                    $scope.state = "Edit Member";
                    $scope.id = id;
                    $http.get("http://testapp2.local:400/details-member/" + id)
                        .success(function (response) {
                            console.log(response);
                            $scope.formData = response;
                        });
                    break;
                default:
                    break;
            }
            $('#myModal').modal('show');
        }

        //get file when choose file and validate file
        $scope.imageUpload = function(event){
            var files = event.target.files;
            var file = files[files.length-1];
            $scope.file = file;
            var reader = new FileReader();
            if(file['type'] !== 'image/jpg' && file['type'] !== 'image/jpeg' && file['type'] !== 'image/png'&& file['type'] !== 'image/gif' ){
                $('#err_upload').html('Please choose a valid image( jpg, gif, png, jpeg)');
                document.getElementById("upload").value = "";
                document.getElementById("imgThumbnail").src = "";
            }else{
                if(file['size'] > 10*1024*1024){
                    $('#err_upload').html('Image is too large!');
                    document.getElementById("upload").value = "";
                    document.getElementById("imgThumbnail").src = "";
                }
                else
                {
                    reader.onload = $scope.imageIsLoaded;
                    reader.readAsDataURL(file);
                }
            }
        }

        //show file have choose
        $scope.imageIsLoaded = function(e){
            $scope.$apply(function(){
                $scope.step = e.target.result;
            })
        }

        //buttom cancel
        $scope.cancel = function () {
            $('#err_upload').html('');
            document.getElementById("upload").value = "";
            document.getElementById("imgThumbnail").src = "";
        }
        //save memmber then add or edit
        $scope.save = function (states, id) {
            var file= $scope.file;

            if((file.type === 'image/jpeg' || file.type === 'image/jpg' || file.type === 'image/png' || file.type === 'image/tif') && file.size <= 10*1024*1024){
                $scope.memberData={
                    //_token : $scope._token,
                    name: $scope.formData.name,
                    age: $scope.formData.age,
                    address: $scope.formData.address,
                    photo:$scope.file
                };
            }else {
                $scope.memberData={
                    //_token : $scope._token,
                    name: $scope.formData.name,
                    age: $scope.formData.age,
                    address: $scope.formData.address,
                };

                document.getElementById("upload").value = "";
                document.getElementById("imgThumbnail").src = "";
            }

            switch (states) {
                case 'add':
                    var url = "http://testapp2.local:400/add-member";
                    break;
                case 'edit':
                    var url = "http://testapp2.local:400/edit-member/"+id;
                    break;
                default:
                    break;
            }
            $http({
                method: 'POST',
                url: url,
                data:$scope.memberData,
                transformRequest: function (data, headersGetter) {
                    var fd = new FormData();
                    angular.forEach(data, function (value, key) {
                        fd.append(key, value);
                    });
                    var headers = headersGetter();
                    delete headers['Content-Type'];
                    return fd;
                }
            }).success(function (response) {
                $http.get('http://testapp2.local:400/list-members').success(function(response) {
                    $scope.data = response.data;
                });
                $('#myModal').modal('hide');
            }).error(function (response) {
                if(response.address){
                    $('#inputAddress').focus().css('background-color','red');

                }
                if(response.age){
                    $('#inputAge').focus().css('background-color','red');
                }
                if(response.name){
                    //$('#msgName').html(response.name[0]).addClass('error message');
                    $('#inputName').focus().css('background-color','red');
                }


            })
        }

        //delete member
        $scope.deleteMember = function (memberId) {
            $http.post('http://testapp2.local:400/delete-member', {id: memberId}).success(function (data) {
                $http.get('http://testapp2.local:400/list-members').success(function(response) {
                    $scope.data = response.data;
                });
            }).error(function (data) {
                console.log(data);
            });
        }
    })


    //Custom confirm Delete members
    .directive('confirmClick', ['$q', 'dialogModal', function($q, dialogModal) {
        return {
            link: function (scope, element, attrs) {
                var ngClick = attrs.ngClick.replace('confirmClick()', 'true')
                    .replace('confirmClick(', 'confirmClick(true,');

                scope.confirmClick = function(memberId,msg) {
                    msg = 'Are you sure?';
                    dialogModal(msg).result.then(function() {
                        scope.$eval(ngClick);
                    });
                    return false;
                };
            }
        }
    }])
    .service('dialogModal', ['$modal', function($modal) {
        return function (message, title, okButton, cancelButton) {
            okButton = okButton===false ? false : (okButton || 'Delete');
            cancelButton = cancelButton===false ? false : (cancelButton || 'Cancel');

            var ModalInstanceCtrl = function ($scope, $modalInstance, settings) {
                angular.extend($scope, settings);
                $scope.ok = function () {
                    $modalInstance.close(true);
                };
                $scope.cancel = function () {
                    $modalInstance.dismiss('cancel');
                };
            };
            var modalInstance = $modal.open({
                template: '<div class="dialog-modal"> \
                  <div class="modal-header" ng-show="modalTitle"> \
                      <h3 class="modal-title">{{modalTitle}}</h3> \
                  </div> \
                  <div class="modal-body">{{modalBody}}</div> \
                  <div class="modal-footer"> \
                      <button class="btn btn-primary" ng-click="ok()" ng-show="okButton">{{okButton}}</button> \
                      <button class="btn btn-warning" ng-click="cancel()" ng-show="cancelButton">{{cancelButton}}</button> \
                  </div> \
              </div>',
                controller: ModalInstanceCtrl,
                resolve: {
                    settings: function() {
                        return {
                            modalTitle: title,
                            modalBody: message,
                            okButton: okButton,
                            cancelButton: cancelButton
                        };
                    }
                }
            });
            return modalInstance;
        }
    }])
// define directive pagination
    .directive('postsPagination', function(){
    return {
        restrict: 'E',
        template: '<ul class="pagination">'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getCourse(1)">«</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getCourse(currentPage-1)">‹ Prev</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getMembersList(i)">{{ i }}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getCourse(currentPage+1)">Next ›</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getCourse(totalPages)">»</a></li>'+
        '</ul>'
    };
});
