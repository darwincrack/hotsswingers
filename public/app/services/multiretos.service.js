angular.module('matroshkiApp').factory('multiretosService', [ '$http', '$q', 'commonHelper', 'appSettings', function ($http, $q, commonHelper, appSettings) {
  return{
    get: function (uid) {
      return $http.get(appSettings.BASE_URL + 'api/v1/multiretos/user/' + uid);
    },

    getFirst: function (uid) {
      return $http.get(appSettings.BASE_URL + 'api/v1/multiretos/user/first/' + uid);
    },

     getNext: function (uid) {
      return $http.get(appSettings.BASE_URL + 'api/v1/multiretos/user/next/' + uid);
    },


      ganancias: function (uid, tokens) {
      return  $http({
        method: 'post',
        url: appSettings.BASE_URL + 'api/v1/multiretos/ganancias/' + uid,
        data: {
          tokens: tokens
        }
      }).then(function successCallback(response) {
        // this callback will be called asynchronously
        // when the response is available
        return response;
      }, function errorCallback(err) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
        return err;
      });
    },


  };
}]);