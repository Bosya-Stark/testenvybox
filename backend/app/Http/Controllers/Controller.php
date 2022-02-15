<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedBackRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    protected function getFormFields() {
        return response([
            [
                'name' => 'name',
                'type' => 'input',
                'value' => '',
            ],
            [
                'name' => 'phone',
                'type' => 'input',
                'value' => '',
            ],
            [
                'name' => 'description',
                'type' => 'textarea',
                'value' => '',
            ],
        ], 200);
    }
    protected function formSave(FeedBackRequest $request) {
        $result = array_merge([
            "name: $request->name; ",
            "phone: $request->phone; ",
            "description: $request->description; ",
        ], [ PHP_EOL . file_get_contents(public_path() . '/data.txt')]);
        file_put_contents(public_path() . '/data.txt', $result);
        DB::table('feedback')->insert($request->all());
        try {
            DB::table('feedback')->insert($request->all());
        } catch (\Exception $e) {
            return response(['error' => ['Ошибка при добавлении отзыва']], 400);
        }
        return response([
            "name: $request->name; ",
            "phone: $request->phone; ",
            "description: $request->description; ",
        ], 200);
    }
}
