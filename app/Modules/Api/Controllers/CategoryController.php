<?php

namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Api\Models\CategoryModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Repositories\Categories;

class CategoryController extends Controller {
    /*
     * response  object
     * 
     *    */

    public function findAll(Categories $categories) {
        
        return $categories->all();
    }

    /**
     * @param string $name category name
     * @author Phong Le <pt.hongphong@gmail.com>
     * @return Response
     */
    public function checkName() {
        $validator = Validator::make(Input::all(), [
                    'name' => 'unique:categories|required',
        ]);
        if ($validator->fails()) {
            return Response()->json(array('success' => false, 'error' => $validator->errors()->first('name')));
        }
        return Response()->json(array('success' => true));
    }

    /**
     * @param string $name category name
     * @author Phong Le <pt.hongphong@gmail.com>
     * @return response new category
     */
    public function store(CategoryModel $category) {


        \App::setLocale(session('lang'));   

        $createCategorySuccessful = trans('messages.createCategorySuccessful');


        $validator = Validator::make(Input::all(), [
                    'name' => 'unique:categories|required',
        ]);
        if ($validator->fails()) {
            return Response()->json(array('success' => false, 'error' => $validator->errors()->first('name')));
        }


  $cat_data=$category->create(Input::only('name', 'name_en','name_fr'));

        return Response()->json(array('success' => true, 'message' => $createCategorySuccessful, 'category' =>   $cat_data));

    }

    /**
     * @param string $name category name
     * @author Phong Le <pt.hongphong@gmail.com>
     * @return response category
     */
    public function update(CategoryModel $category) {


        \App::setLocale(session('lang'));   

        $updateCategorySuccessful = trans('messages.updateCategorySuccessful');


        $validator = Validator::make(Input::all(), [
                    'name' => 'unique:categories,name,' . $category->id . '|required',
        ]);
        if ($validator->fails()) {
            return Response()->json(array('success' => false, 'error' => $validator->errors()->first('name')));
        }
        $category->update(Input::only('name'));
        $category->update(Input::only('name_en'));
        $category->update(Input::only('name_fr'));
        return Response()->json(array('success' => true, 'message' => $updateCategorySuccessful, 'category' => $category));

    }

    /**
     * @author Phong Le <pt.hongphong@gmail.com>
     * @param int $id category id
     * @return response
     */
    public function destroy(CategoryModel $category) {
        


        \App::setLocale(session('lang'));   

        $deleteCategorySuccessful = trans('messages.deleteCategorySuccessful');
        $deleteCategoryFailed = trans('messages.deleteCategoryFailed');


        if ($category->delete()) {
            return Response()->json(array('success' => true, 'message' => $deleteCategorySuccessful));
        } else {
            return Response()->json(array('success' => false, 'message' => $deleteCategoryFailed));
        }
    }

}
