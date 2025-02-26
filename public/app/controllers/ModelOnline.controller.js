'use strict';
var myApp =angular.module('matroshkiApp');
myApp.controller('modelOnlineCtrl', [
  '$scope', 'appSettings', '_', 'onlineService', 'socket',
  function ($scope, appSettings, _, onlineService, socket) {
    $scope.currentPage = 1;
    $scope.gPlace;
    $scope.textPlace="";
    $scope.lastPage = 1;
    $scope.perPage = appSettings.LIMIT_PER_PAGE;
    $scope.orderBy = 'isStreaming';
    $scope.sort = 'desc';
    $scope.totalPages = 0;
    $scope.online = 'true';
    $scope._ = _;
    $scope.modelOnlineNull = false;
    $scope.keyword = '';
    $scope.filter = 'week';
    $scope.styleModelItem = {};
    $scope.maps="";
    $scope.fecha ="";
    $scope.filtertravel ="todos";
    $scope.Desde = "";
    $scope.textLugar="";
    $scope.textDesde="";
    $scope.textHasta="";
    $scope.textDescription="";
    $scope.getData = function () {
        var widthScreen = $(window).width();
        if(widthScreen > 2000){
            var widthItems = Math.floor(100/Math.floor(widthScreen/280));
            $scope.styleModelItem = {
                "width": widthItems+'%'
            };
        }
      onlineService.get({page: $scope.lastPage, orderBy: $scope.orderBy, sort: $scope.sort, limit: $scope.perPage, keyword: $scope.keyword, filter: $scope.filter,online: $scope.online, category: $scope.categoryId}).success(function (data) {
        $scope.users = data.data;
        $scope.currentPage = data.current_page;
        $scope.totalPages = data.last_page;//Math.ceil(data.total / data.per_page);
        if (data.total == 0) {
          $scope.modelOnlineNull = true;
        } else {
          $scope.modelOnlineNull = false;
        }

      });
    };

    $scope.customSplitStringTags = function (item) {
        if (item.tags != null) {
            var arr = item.tags.split(',');
            return arr;
        }
    };

    $scope.getTopModels = function () {
      onlineService.getTopModels().success(function (data) {
        $scope.topModels = data;
      });
    };

    $scope.setPage = function (page) {
      if (page > 0 && page <= $scope.totalPages) {
        $scope.lastPage = page;
        $scope.getData();
      }
    };

    $scope.onlineInit = function (keyword, id) {
      $scope.keyword = keyword;
      $scope.categoryId = id || '';
      $scope.getData();
      $scope.getTopModels();
      // Run function every second
      setInterval($scope.getData, 30000);
    };

    $scope.setFilter = function (filter, online = 'false') {
      $scope.filter = filter;
      $scope.online = online;
       setInterval($scope.getData, 30000);
      //$scope.getData();
    };

    $scope.travel = function (filter = false) {

      if(filter){
        $scope.filtertravel = filter;
      }

       onlineService.getTravel($scope.filtertravel, $scope.textPlace, $scope.fecha).success(function (data) {
         $scope.users = data;
      });
     
    };


$scope.clear = function(){
 // $scope.maps = $scope.textPlace;
  $scope.travel();
}



    //load models in streaming page
    $scope.getModelsByCategory = function (model, category) {

      onlineService.getModelsByCategory(model, category).success(function (data)
      {
        $scope.users = data;
      });
    };

    $scope.setFavorite = function (index, id) {
      onlineService.setFavorite(id).then(function (data) {
        if (data.data.success) {
          $scope.users[index].favorite = (data.data.favorite === 'like') ? data.data.favorite : null;
        } else {
          alertify.error(data.data.message);
        }
      });
    };

    $scope.isRotate = false;

    $scope.modelRotates = function (thread) {

      onlineService.getModelRotateImages(thread.threadId).then(function (data) {

        if (data && angular.isArray(data.data)) {
          $scope.isRotate = true;

          var images = data.data;

          angular.forEach(images, function (item) {
            setTimeout(function () {
              thread.lastCaptureImage = item;
            }, 150);
          });
        }
      });

    };
  }
]);


//https://gist.github.com/victorb/6687484
myApp.directive('googleplace', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, model) {
            var options = {
                types: [],
                componentRestrictions: {}
            };
            scope.gPlace = new google.maps.places.Autocomplete(element[0], options);

            google.maps.event.addListener(scope.gPlace, 'place_changed', function() {
                scope.$apply(function() {
                    model.$setViewValue(element.val());

                    scope.maps= element.val();  
                     scope.travel();   

                });
            });
        }
    };
});


myApp.directive('googleplacetext', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, model) {
            var options = {
                types: [],
                componentRestrictions: {}
            };
            scope.gPlace = new google.maps.places.Autocomplete(element[0], options);

            google.maps.event.addListener(scope.gPlace, 'place_changed', function() {
                scope.$apply(function() {
                    model.$setViewValue(element.val());

                    scope.maps= element.val();  
                     

                });
            });
        }
    };
});








myApp.directive('jqdatepicker', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
         link: function (scope, element, attrs, ngModelCtrl) {
            element.datepicker({
                dateFormat: 'dd-mm-yy',
                onSelect: function (date) {   
                    var ar=date.split("-");
                    date=new Date(ar[2]+"-"+ar[1]+"-"+ar[0]);
                    ngModelCtrl.$setViewValue(date.getTime());
                //    scope.course.launchDate = date;
                      fecha = ar[2]+"-"+ar[1]+"-"+ar[0];
                var str = fecha;
                var fecha = str.replace("/", "-");

                scope.fecha=fecha; 
                 console.log("fecha");
                console.log(scope.fecha);
                console.log("fechaxx");   
                scope.travel(); 
                
                    scope.$apply();
                }
            });

        }
    };
});


myApp.directive('jqdatepickersimple', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
         link: function (scope, element, attrs, ngModelCtrl) {
            element.datepicker({
                dateFormat: 'dd-mm-yy',
                onSelect: function (date) {   
                    var ar=date.split("-");
                    date=new Date(ar[2]+"-"+ar[1]+"-"+ar[0]);
                    ngModelCtrl.$setViewValue(date.getTime());
                //    scope.course.launchDate = date;
                     
                
                    scope.$apply();
                }
            });

        }
    };
});