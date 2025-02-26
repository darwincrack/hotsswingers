/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
'use strict';

angular.module('matroshkiApp').directive('commentLikeShare', ['appSettings', 'likesWidgetService', 'commentsWidgetService', function (appSettings, likesWidgetService, commentsWidgetService) {
    return {
      restrict: 'AE',
      templateUrl: appSettings.BASE_URL + 'app/views/partials/comment-like-share-widget.html',
      scope: {
        itemId: '@',
        item: '@'
      },
      controller: function ($scope) {

switch($('#idioma').val()) {
          case 'es':
            $scope.Marks = "Me gusta";
            $scope.comments = "comentario (s)";
            $scope.like = "like";
            $scope.Unlike = "Unlike";
            $scope.Comment = "Comentario";
            $scope.Share = "Compartir";

            break;
          case 'en':
            // code block
            $scope.Marks = "Marks 'Like'";
            $scope.comments = "comments(s)";
            $scope.like = "like";
            $scope.Unlike = "Unlike";
            $scope.Comment = "Comment";
            $scope.Share = "Share";
             
            break;

            case 'fr':
            // code block
            $scope.Marks = "J'aime";
            $scope.comments = "commentaire (s)";
            $scope.like = "like";
            $scope.Unlike = "Unlike";
            $scope.Comment = "Commentaire";
            $scope.Share = "Partager";

            break;
          default:
            $scope.Marks = "Marks 'Like'";
            $scope.comments = "comments(s)";
            $scope.like = "like";
            $scope.Unlike = "Unlike";
            $scope.Comment = "Comentario";
            $scope.Share = "Compartir";
        }

        
        likesWidgetService.count({itemId: $scope.itemId, item: $scope.item}).success(function (data, status, headers, config) {
          $scope.totalLikes = data;
        });
        //check like status
        likesWidgetService.checkMe({itemId: $scope.itemId, item: $scope.item}).success(function (data, status, headers, config) {
          $scope.liked = data;

        });

        //count comment
        commentsWidgetService.count({itemId: $scope.itemId, item: $scope.item}).success(function (data) {
          $scope.totalComments = data;
        });
        $scope.likeThis = function () {
          likesWidgetService.likeMe({itemId: $scope.itemId, status: $scope.liked, item: $scope.item}).then(function (data, status, headers, config) {
            if (data.data.status == 'error') {
              alertify.warning(data.data.message);
              return;
            }
            $scope.liked = (data.data.status == 'like') ? 1 : 0;
            likesWidgetService.count({itemId: $scope.itemId, item: $scope.item}).success(function (data, status, headers, config) {
              $scope.totalLikes = data;
            });
          });
        };
      }
    };
  }]);

