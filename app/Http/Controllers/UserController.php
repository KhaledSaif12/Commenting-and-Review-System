<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Validator;
use Dotenv\Password;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    // عرض الملف الشخصي للمستخدم الحالي
    public function showProfile()
    {
        $user = Auth::user(); // الحصول على المستخدم الحالي
        return view('Users.profile', compact('user'));
    }

    // عرض نموذج تحرير الملف الشخصي للمستخدم الحالي
    public function editProfile($id)
    {
        $user = User::findOrFail($id); // Get the user by ID
        return view('Users.edit-profile', compact('user'));
    }

    // تحديث الملف الشخصي للمستخدم الحالي
    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $user = User::findOrFail($id);

        $user->full_name = $request->input('full_name');
        $user->address = $request->input('address', ''); // تعيين قيمة افتراضية إذا كانت العنوان فارغاً

        $user->save();

        return redirect()->route('profile')->with('status', 'تم تحديث الملف الشخصي بنجاح!');
    }

    // تحديث بيانات مستخدم معين
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);

        $user->full_name = $request->input('full_name');
        $user->address = $request->input('address', ''); // تعيين قيمة افتراضية إذا كانت العنوان فارغاً

        if ($user->email !== $request->input('email')) {
            $user->email = $request->input('email');
        }

        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('list_user')->with('success', 'User updated successfully.');
    }
}
