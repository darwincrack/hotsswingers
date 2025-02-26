angular.module('matroshkiApp').factory('gamesService', [ '$http', '$q', 'commonHelper', 'appSettings', function ($http, $q, commonHelper, appSettings) {
  return{
    get: function (uid) {
      return $http.get(appSettings.BASE_URL + 'api/v1/games/' + uid);
    },

    getJuguetes: function (uid) {
      return $http.get(appSettings.BASE_URL + 'api/v1/juguetes/' + uid);
    },

     getAllGames: function (uid) {
      return $http.get(appSettings.BASE_URL + 'api/v1/allgames/' + uid);
    },
     getLastGame: function (uid) {
      return $http.get(appSettings.BASE_URL + 'api/v1/lastgames/' + uid);
    },


  };
}]);