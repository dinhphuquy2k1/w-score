<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ApiUserController extends Controller
{
    /**
     * @return array|\Illuminate\Http\JsonResponse|object
     */
    public function get()
    {
        return $this->sendResponseSuccess(User::all()->toArray());
    }

    /**
     * @param Request $request
     * @return void
     */
    public function save(Request $request)
    {
        $attribute = $request->validate(
            [
                'email' => 'required|unique:users,email',
                'name' => 'required',
                'user_code' => 'required|unique:users,user_code',
                'level' => 'required',
                'note' => '',
            ],
            [
                'email.required' => 'Email không được để trống',
                'email.unique' => 'Email dã tồn tại',
                'name.required' => 'Họ và tên không được để trống',
                'user_code.unique' => 'Mã tài khoản đã tồn tại',
                'level.required' => 'Loại tài khoản không được để trống'
            ]
        );

        $attribute['password'] = bcrypt('123456');
        User::insert($attribute);
    }

    public function update(Request $request, $id)
    {
        $attribute = $request->validate(
            [
                'email' => "required|unique:users,email,{$id}",
                'name' => 'required',
                'user_code' => "required|unique:users,user_code,{$request->user_code},user_code",
                'level' => 'required',
                'note' => '',
            ],
            [
                'email.required' => 'Email không được để trống',
                'email.unique' => 'Email dã tồn tại',
                'name.required' => 'Họ và tên không được để trống',
                'user_code.unique' => 'Mã tài khoản đã tồn tại',
                'level.required' => 'Loại tài khoản không được để trống'
            ]
        );

        User::find($request->id)->update($attribute);
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();
    }
}
