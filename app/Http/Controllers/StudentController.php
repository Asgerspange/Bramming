<?php

namespace App\Http\Controllers;

use App\Models\{
    Student,
    ProfilePicture,
    Comment
};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Dompdf\Dompdf;

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

    public function deleteStudents()
    {
        Student::where('is_teacher', false)->delete();
        Comment::query()->delete();

        return new JsonResponse(['message' => 'All students deleted successfully!']);
    }

    public function downloadComments()
    {
        $student = Student::with(['comments', 'profilePicture'])->find(Auth::id());

        $dompdf = new Dompdf();
        $comments = $student->comments->pluck('comment')->toArray();

        $logo = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('bramming_logo.png')));
        $html = view('comments_pdf', [
            'comments' => $comments,
            'logo' => $logo,
            'name' => $student->name,
            'profilePicture' => $student->profilePicture->picture
        ])->render();

        // return view('comments_pdf', [
        //     'comments' => $comments,
        //     'logo' => $logo,
        //     'profilePicture' => $student->profilePicture->picture
        // ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('Bramming Efterskole - Kommentarer til ' . $student->name . '.pdf');
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

    public function makeTeacher(Request $request)
    {
        Student::where('id', $request->id)->update(['is_teacher' => true]);

        return new JsonResponse(['message' => 'Teacher status updated successfully!']);
    }

    public function removeTeacher(Request $request)
    {
        Student::where('id', $request->id)->update(['is_teacher' => false]);

        return new JsonResponse(['message' => 'Teacher status updated successfully!']);
    }
}
