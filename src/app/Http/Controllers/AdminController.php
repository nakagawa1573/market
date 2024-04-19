<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\SendEmailRequest;
use App\Mail\NotificationEmail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class AdminController extends Controller
{
    public function index()
    {
        $this->authorize('admin', Auth::user());
        $users = User::with('profile')->get();
        return view('admin', compact('users'));
    }

    public function destroy(DeleteUserRequest $request)
    {
        $this->authorize('admin', Auth::user());
        User::destroy($request->id);
        return back()->with('message', 'ユーザーの削除に成功しました');
    }

    public function send(SendEmailRequest $request)
    {
        $this->authorize('admin', Auth::user());
        $subject = $request->subject;
        $text = $request->text;
        $userIds = $request->id;
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            Mail::to($user)->send(new NotificationEmail($subject, $text));
        }
        return back()->with('message', 'メールの送信に成功しました');
    }
}
