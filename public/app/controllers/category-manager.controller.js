/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


'use strict';
angular.module('matroshkiApp').controller('categoryManagerCtrl', ['$scope', 'categoryService', function ($scope, categoryService) {

    $scope.categories = [];
    $scope.category = {};
    $scope.category.idioma="es";

    categoryService.all().then(function (data) {
      $scope.categories = data.data;

    });

    $scope.addCategory = function (categoryName,Name_en, Name_fr) {


      if (typeof categoryName == 'undefined' || categoryName == '' || Name_en == '' || Name_fr == '') {
        return alertify.error('Nombre de categoría es requerido.');

      }
      categoryService.checkName(categoryName).then(function (data) {
        if (!data.data.success) {
          return alertify.error(data.data.error);
        }
        categoryService.addNew(categoryName,Name_en,Name_fr).then(function (data) {
          if (!data.data.success) {
            return alertify.error(data.data.error);
          }
          $scope.categories.push(data.data.category);
          alertify.success(data.data.message);

          $scope.category.name = null;
          $scope.category.idioma = null;
        });
      });
    };

    $scope.deleteCategory = function (index, category) {
      alertify.confirm("Estas seguro de que quieres borrar esta categoría?",
              function () {
                categoryService.delete(category.id).then(function (data) {
                  if (!data.data.success) {
                    return alertify.error(data.data.error);
                  }
                  $scope.categories.splice(index, 1);
                  alertify.success(data.data.message);
                });
              }).set('title', 'Confirm');
    };

    $scope.updateCategory = function (index, category) {

 
      if (typeof category == 'undefined' || category.name == '' || category.name_en == '' || category.name_fr == '') {
        return alertify.error('Nombre de categoria es requerido');

      }
      categoryService.update(category).then(function (data) {
        if (!data.data.success) {
          return alertify.error(data.data.error);
        }
        alertify.success(data.data.message);
      });

    };

  }]);