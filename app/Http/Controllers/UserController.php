<?php

namespace App\Http\Controllers;

use App\Mail\AccountActivation;
use App\Models\File;
use App\Models\Investment;
use App\Models\Log;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function investorComplete()
    {
        $user = Auth::user();

        $info = $this->getUserInfo();

        switch ($user->investor_type) {
            case 'self':
                $investorName = 'Self-certified sophisticated investor';
                break;
            case 'certified':
                $investorName = 'Certified sophisticated investor';
                break;
            case 'high':
                $investorName = 'High Net Worth investor';
                break;
            default:
                $investorName = '';
                break;
        }

        $test = true;
        if ('Passed' === $user->test) {
            $test = false;
        }

        return view('user.investor-success', [
            'title' => 'My investor type',
            'user' => $user,
            'details' => $info['details'],
            'documents' => $info['documents'],
            'test' => $test,
            'investorName' => $investorName,
        ]);
    }

    public function investments()
    {
        $invested = false;
        $summ = 0;
        $feet = 0;
        $profit = 0;

        $investments = Investment::where('user_id', Auth::user()->id)->where('completed', 'Return')->where('deleted', false)->orderBy('created_at', 'desc')->get();
        $countProjects = 0;
        if ($investments) {
            $invested = true;
            foreach ($investments as $k => $investment) {
                $investments[$k]->project = Project::where('id', $investment->project_id)->firstOrFail();
                $investments[$k]->files = File::where('entity_id', $investment->project_id)->where('entity', 'project')->where('deleted', false)->get();
                if ('Return' === $investment->completed) {
                    $percentProfit = $investments[$k]->project->profit / 100;
                    $summ += $investment->invested;
                    $feet += $investment->fts;
                    $profit += round($investment->invested * $percentProfit, 2);
                    $countProjects++;
                }
                $timeStart = strtotime($investment->project->start_at);
                $timeEnd = strtotime($investment->project->deadline);
                $timeNow = time();
                $allDays = ($timeEnd - $timeStart)/(60*60*24);
                $pastDays = ($timeNow - $timeStart)/(60*60*24);
                $investments[$k]->interval = 0;
                if ($allDays) {
                    $investments[$k]->interval = round($pastDays * 100 / $allDays);
                }
                $days = round((strtotime($investment->project->deadline) - time())/(60*60*24));
                $investments[$k]->days = (0 < $days) ? $days : 0;
            }
        }

        return view('user.investments', [
            'title' => 'My investments',
            'invested' => $invested,
            'summ' => $summ,
            'feet' => $feet,
            'profit' => $profit,
            'countProjects' => $countProjects,
            'investments' => $investments,
        ]);
    }

    public function details()
    {
        $info = $this->getUserInfo();

        return view('user.details', [
            'title' => 'My profile details',
            'user' => Auth::user(),
            'details' => $info['details'],
            'documents' => $info['documents'],
            'test' => $info['test'],
        ]);
    }

    public function detailsStore(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            // 'firstName' => ['required', 'max:255'],
            // 'lastName' => ['required', 'max:255'],
            // 'phone' => ['required', 'string', 'max:255'],
            // 'birth' => ['required', 'max:255'],
            // 'nationality' => ['required', 'max:255'],
            // 'house' => ['required', 'max:255'],
            // 'address1' => ['required', 'max:255'],
            // 'address2' => ['nullable', 'max:255'],
            // 'city' => ['required', 'max:255'],
            // 'zip' => ['required', 'max:255'],
            // 'country' => ['required', 'max:255'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->first_name = $input['firstName'];
        $user->last_name = $input['lastName'];
        $user->phone = $input['phone'];
        $user->birth = $input['birth'];
        $user->nationality = $input['nationality'];
        $user->house = $input['house'];
        $user->address1 = $input['address1'];
        $user->address2 = $input['address2'];
        $user->city = $input['city'];
        $user->zip = $input['zip'];
        $user->country = $input['country'];
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = $user->id;
        $log->user_type = $user->role;
        $log->user_name = $user->first_name.' '.$user->last_name;
        $log->action = 'Profile update';
        $log->save();

        $info = $this->getUserInfo();

        return view('user.details-success', [
            'title' => 'My profile details',
            'user' => $user,
            'details' => $info['details'],
            'documents' => $info['documents'],
            'test' => $info['test'],
        ]);
    }

    public function identity()
    {
        $info = $this->getUserInfo();
        $template = 'user.identity';
        if (1 != $info['documents']) {
            $template = 'user.identity-wait';
        }

        return view($template, [
            'title' => 'Identity verification',
            'user' => Auth::user(),
            'details' => $info['details'],
            'documents' => $info['documents'],
            'test' => $info['test'],
        ]);
    }

    public function identityChange()
    {
        $info = $this->getUserInfo();

        return view('user.identity', [
            'title' => 'Identity verification',
            'user' => Auth::user(),
            'details' => $info['details'],
            'documents' => $info['documents'],
            'test' => $info['test'],
        ]);
    }

    public function identityStore(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();

        if (isset($input['copyId'])) {
            $file = File::where('user_id', $user->id)->where('deleted', false)->where('entity', 'copy_id')->orderBy('id', 'DESC')->first();
            if ($file) {
                $file->deleted = true;
                $file->save();
            }

            $fileName = time().'_'.Str::random(5).'.'.$request->file('copyId')->getClientOriginalExtension();
            $filePath = $request->file('copyId')->storeAs('uploads', $fileName, 'public');

            $file = new File();
            $file->user_id = $user->id;
            $file->name = $fileName;
            $file->entity = 'copy_id';
            $file->entity_id = $user->id;
            $file->original_name = $request->file('copyId')->getClientOriginalName();
            $file->file_path = $filePath;
            $file->save();

            $log = new Log();
            $log->user_id = $user->id;
            $log->action_user_id = $user->id;
            $log->user_type = $user->role;
            $log->user_name = $user->first_name.' '.$user->last_name;
            $log->action = 'Upload copy ID file';
            $log->save();

            $user->attention = true;
            $user->save();

            $request->session()->flash('success', 'File uploaded');
        }
        if (isset($input['address'])) {
            $file = File::where('user_id', $user->id)->where('deleted', false)->where('entity', 'address')->orderBy('id', 'DESC')->first();
            if ($file) {
                $file->deleted = true;
                $file->save();
            }

            $fileName = time().'_'.Str::random(5).'.'.$request->file('address')->getClientOriginalExtension();
            $filePath = $request->file('address')->storeAs('uploads', $fileName, 'public');

            $file = new File();
            $file->user_id = $user->id;
            $file->name = $fileName;
            $file->entity = 'address';
            $file->entity_id = $user->id;
            $file->original_name = $request->file('address')->getClientOriginalName();
            $file->file_path = $filePath;
            $file->save();

            $log = new Log();
            $log->user_id = $user->id;
            $log->action_user_id = $user->id;
            $log->user_type = $user->role;
            $log->user_name = $user->first_name.' '.$user->last_name;
            $log->action = 'Upload address file';
            $log->save();

            $user->attention = true;
            $user->save();

            $request->session()->flash('success', 'File uploaded');
        }

        return redirect()->route('identity.wait');
    }

    public function identityWait()
    {
        $info = $this->getUserInfo();

        return view('user.identity-wait', [
            'title' => 'Identity verification',
            'user' => Auth::user(),
            'details' => $info['details'],
            'documents' => $info['documents'],
            'test' => $info['test'],
        ]);
    }

    public function test()
    {
        $user = Auth::user();

        $info = $this->getUserInfo();

        $test = true;
        $template = 'user.test';
        if ('Passed' === $user->test) {
            $test = false;
            $template = 'user.test-success';
        }

        $message = '';
        if (session('message')) {
            $message = session('message');
        }

        return view($template, [
            'title' => 'Investor appropriateness test',
            'user' => $user,
            'details' => $info['details'],
            'documents' => $info['documents'],
            'test' => $test,
            'message' => $message,
        ]);
    }

    public function testProcess()
    {
        $info = $this->getUserInfo();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'User start test';
        $log->save();

        return view('user.test-process', [
            'title' => 'Investor appropriateness test',
            'user' => Auth::user(),
            'details' => $info['details'],
            'documents' => $info['documents'],
            'test' => $info['test'],
        ]);
    }

    public function testStore(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();

        $error = false;
        if (isset($input['question1']) && 'Yes' !== $input['question1'][0]) {
            $error = true;
        }
        if (isset($input['question2']) && 'Yes' !== $input['question2'][0]) {
            $error = true;
        }
        if (isset($input['question3']) && 'Yes' !== $input['question3'][0]) {
            $error = true;
        }
        if (isset($input['question4']) && 'Yes' !== $input['question4'][0]) {
            $error = true;
        }
        if (isset($input['question5']) && 'Yes' !== $input['question5'][0]) {
            $error = true;
        }
        if (isset($input['question6']) && 'No, returns may be less than originally projected.' !== $input['question6'][0]) {
            $error = true;
        }
        if (isset($input['question7']) && 'No, it could be difficult to sell my investment in a timely fashion, or indeed at all.' !== $input['question7'][0]) {
            $error = true;
        }
        if (isset($input['question8']) && 'No, if the investment fails any losses will not be covered by the FSCS.' !== $input['question8'][0]) {
            $error = true;
        }

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;

        if ($error) {
            $test = true;
            $user->test = 'Tried';
            $user->save();

            $log->action = 'User fail test';
            $log->save();

            $request->session()->flash('message', 'Something went wrong with submitting the test. Please try again.');
            return redirect()->route('test');
        }
        else {
            $test = false;
            $user->test = 'Passed';
            $user->save();

            $log->action = 'User complete test';
            $log->save();
        }

        $info = $this->getUserInfo();

        return view('user.test-success', [
            'title' => 'Investor appropriateness test',
            'user' => $user,
            'details' => $info['details'],
            'documents' => $info['documents'],
            'test' => $test,
        ]);
    }

    public function changePassword()
    {
        $info = $this->getUserInfo();

        return view('user.password', [
            'title' => 'My profile details',
            'user' => Auth::user(),
            'details' => $info['details'],
            'documents' => $info['documents'],
            'test' => $info['test'],
        ]);
    }

    public function changePasswordStore(Request $request)
    {
        $user = Auth::user();

        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                'string',
                'min:8',
                // 'regex:/[a-z]/',
                // 'regex:/[A-Z]/',
                'regex:/[0-9]/',
                // 'regex:/[@$!%*#?&]/',
            ],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->password = Hash::make($input['password']);
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = $user->id;
        $log->user_type = $user->role;
        $log->user_name = $user->first_name.' '.$user->last_name;
        $log->action = 'Password changed';
        $log->save();

        $info = $this->getUserInfo();

        return view('user.password-success', [
            'title' => 'My profile details',
            'user' => $user,
            'details' => $info['details'],
            'documents' => $info['documents'],
            'test' => $info['test'],
        ]);
    }

    public function deleteProfile()
    {
        $info = $this->getUserInfo();

        return view('user.delete', [
            'title' => 'My profile details',
            'user' => Auth::user(),
            'details' => $info['details'],
            'documents' => $info['documents'],
            'test' => $info['test'],
        ]);
    }

    public function deleteProfileStore()
    {
        $user = Auth::user();
        $user->deleted = true;
        $user->attention = true;

        $deleted = User::where('email', $user->email.'_deleted')->first();
        if ($deleted) {
            $i = 1;
            while(User::where('email', $user->email.'_deleted_'.$i)->first()) {
                $i++;
            }
            $user->email = $user->email.'_deleted_'.$i;
        }
        else {
            $user->email = $user->email.'_deleted';
        }

        $user->save();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'User delete profile';
        $log->save();

        return redirect()->route('logout');
    }

    public function downloadFile(Request $request, int $id)
    {
        $user = Auth::user();
        $file = File::where('id', $id)->where('deleted', false)->orderBy('id', 'DESC')->firstOrFail();

        switch ($file->entity) {
            case 'project':
                $path = storage_path('app/private/'.$file->file_path);
                $info = pathinfo($file->original_name);
                if (mb_strpos($file->name, $info['extension'])) {
                    $fileName = $file->name;
                }
                else {
                    $fileName = $file->name.'.'.$info['extension'];
                }
                return response()->download($path, $fileName);
            case 'copy_id':
            case 'address':
                if ('Admin' === $user->role || $user->id == $file->user_id) {
                    $path = storage_path('app/private/'.$file->file_path);
                    $info = pathinfo($file->original_name);
                    if (mb_strpos($file->name, $info['extension'])) {
                        $fileName = $file->name;
                    }
                    else {
                        $fileName = $file->name.'.'.$info['extension'];
                    }
                    return response()->download($path, $fileName);
                }
                break;
            default:
                $request->session()->flash('error', 'An error occurred while downloading file');
                break;
        }

        $request->session()->flash('error', 'You dont nave access to this action');

        return back();
    }

    public function uploadFile(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:pdf,jpg,png|max:5000',
            'entity' => 'required',
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->withErrors($validator);
        }
        $entity = $input['entity'];
        $id = $input['id'];
        switch ($entity) {
            case 'project':
                if ('Admin' !== $user->role) {
                    $request->session()->flash('error', "You don't nave access to this action");
                    break;
                }
                $fileName = $input['fileName'] ?? time().'_'.Str::random(5).'.'.$request->file('file')->getClientOriginalExtension();
                $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');

                $file = new File();
                $file->user_id = $user->id;
                $file->name = $fileName;
                $file->entity = 'project';
                $file->entity_id = $id;
                $file->original_name = $request->file('file')->getClientOriginalName();
                $file->file_path = $filePath;
                $file->save();

                $log = new Log();
                $log->user_id = $user->id;
                $log->action_user_id = $user->id;
                $log->user_type = $user->role;
                $log->user_name = $user->first_name.' '.$user->last_name;
                $log->action = 'Upload file for project #'.$id;
                $log->save();

                $request->session()->flash('success', 'File uploaded');
                break;
            case 'address':
            case 'copy_id':
                if ('Admin' !== $user->role) {
                    $request->session()->flash('error', "You don't nave access to this action");
                    break;
                }
                $fileName = time().'_'.Str::random(5).'.'.$request->file('file')->getClientOriginalExtension();
                $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');

                $file = new File();
                $file->user_id = $user->id;
                $file->name = $fileName;
                $file->entity = $entity;
                $file->entity_id = $id;
                $file->original_name = $request->file('file')->getClientOriginalName();
                $file->file_path = $filePath;
                $file->save();

                $log = new Log();
                $log->user_id = $user->id;
                $log->action_user_id = $user->id;
                $log->user_type = $user->role;
                $log->user_name = $user->first_name.' '.$user->last_name;
                $log->action = 'Upload file for user #'.$id;
                $log->save();

                if ('address' === $entity) {
                    $file = File::where('user_id', $user->id)->where('deleted', false)->where('entity', 'copy_id')->orderBy('id', 'DESC')->first();
                    if ($file) {
                        $user->attention = true;
                        $user->save();
                    }
                } elseif ('copy_id' === $entity) {
                    $file = File::where('user_id', $user->id)->where('deleted', false)->where('entity', 'address')->orderBy('id', 'DESC')->first();
                    if ($file) {
                        $user->attention = true;
                        $user->save();
                    }
                }

                $request->session()->flash('success', 'File uploaded');
                break;
            default:
                $request->session()->flash('error', 'An error occurred while uploading file');
                break;
        }

        return back();
    }

    public function deleteFile(Request $request, int $id)
    {
        $user = Auth::user();
        $file = File::where('id', $id)->where('deleted', false)->firstOrFail();

        if ('Admin' === $user->role || $user->id == $file->user_id) {
            $file->deleted = true;
            $file->save();

            $log = new Log();
            $log->user_id = $user->id;
            $log->action_user_id = $user->id;
            $log->user_type = $user->role;
            $log->user_name = $user->first_name.' '.$user->last_name;
            $log->action = 'Delete file #'.$id;
            $log->save();

            $request->session()->flash('success', 'File successfully deleted');
        } else {
            $request->session()->flash('error', "You don't nave access to this action");
        }

        return back();
    }

    private function getUserInfo(): array
    {
        $user = Auth::user();

        $details = true;
        if (
            $user->first_name &&
            $user->last_name &&
            $user->phone &&
            $user->birth &&
            $user->nationality &&
            $user->zip &&
            $user->country &&
            $user->city &&
            $user->address1 &&
            $user->house
        ) {
            $details = false;
        }

        $files = [];
        $documents = 1;
        if ($user->identity) {
            $documents = 3;
        } else {
            $copyId = File::where('entity_id', $user->id)->where('deleted', false)->where('entity', 'copy_id')->orderBy('id', 'DESC')->first();
            $address = File::where('entity_id', $user->id)->where('deleted', false)->where('entity', 'address')->orderBy('id', 'DESC')->first();
            $files = [
                'copyId' => $copyId,
                'address' => $address,
            ];
            if ($copyId && $address) {
                $documents = 2;
            }
        }

        $test = true;
        if ('Passed' === $user->test) {
            $test = false;
        }

        return [
            'details' => $details,
            'documents' => $documents,
            'test' => $test,
            'files' => $files,
        ];
    }

    public function kilobyte(Request $request)
    {
$to      = 'a@ripkilobyte.ru';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: noreply@squarico.com' . "\r\n" .
    'Reply-To: noreply@squarico.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();


        //phpinfo();
        $user = User::where('id', 5)->firstOrFail();
        //$user->email = 'ripkilobyte@gmail.com';
        $user->email = 'a@ripkilobyte.ru';
        //$user->sendEmailVerificationNotification();

            event(new Registered($user));
            //Mail::to($user->email)->send(new AccountActivation($user->first_name.' '.$user->last_name, 123123));
            //mail($to, $subject, $message, $headers);
    }
}
