<?php

namespace App\Http\Controllers;

use App\Models\{
    Student,
    ProfilePicture
};
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unilogin_user' => 'required|string|max:255|unique:students',
            'password' => 'required|string|min:8',
        ]);

        Student::create([
            'name' => $request->name,
            'unilogin_user' => $request->unilogin_user,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'User registered successfully!');
    }

    public function downloadVisibility(Request $request)
    {
        $request->validate([
            'visibility' => 'required|boolean',
        ]);
        config(['admin.downloadVisible' => $request->visibility]);

        $admin = config('admin');

        $admin['downloadVisible'] = $request->visibility;

        $configContent = '<?php return ' . var_export($admin, true) . ';';

        file_put_contents(config_path('admin.php'), $configContent);

        return new JsonResponse(['message' => 'Download visibility updated successfully!']);
    }

    public function downloadComments()
    {
        $student = Student::with('comments')->find(Auth::id());
        dd($student);
        return response()->streamDownload(function () use ($comments) {
            echo $comments->toJson();
        }, 'comments.json');
    }

    public function login(Request $request)
    {
        $request->validate([
            'unilogin_user' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $student = Student::where('unilogin_user', $request->unilogin_user)->with('comments')->with('commentedOn')->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            return redirect()->back()->with('error', 'Invalid credentials!');
        }

        Auth::login($student);

        return redirect('/');
    }

    public function studentImage(Request $request)
    {
        $student = Auth::user();
        ProfilePicture::updateOrCreate(
            ['unilogin' => $student->unilogin_user],
            ['picture' => $request->image]
        );


        return redirect()->back()->with('success', 'Profile picture uploaded successfully!');
    }
}
