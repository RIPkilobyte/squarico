<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Investment;
use App\Models\Log;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function project(Request $request, int $id = 0)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        $project = new Project();
        $title = 'Create project';
        if ($id) {
            $project = Project::where('id', $id)->where('deleted', 'false')->firstOrFail();
            $title = 'Project '.$project->name;
            $timeStart = strtotime($project->start_at);
            $timeEnd = strtotime($project->deadline);
            $timeNow = time();
            $allDays = ($timeEnd - $timeStart)/(60*60*24);
            $pastDays = ($timeNow - $timeStart)/(60*60*24);
            $project->interval = 0;
            if ($allDays) {
                $project->interval = round($pastDays * 100 / $allDays);
            }
        }
        $files = File::where('entity_id', $id)->where('entity', 'project')->where('deleted', false)->get();

        return view('admin.project', [
            'title' => $title,
            'id' => $id,
            'project' => $project,
            'files' => $files,
        ]);
    }

    public function projectStore(Request $request, int $id)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        $user = Auth::user();

        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:255'],
            'updateLink' => ['nullable', 'string', 'max:255'],
            'expectationsDescription' => ['nullable', 'string', 'max:255'],
            'profitDescription' => ['nullable', 'string', 'max:255'],
            'startAt' => ['nullable', 'string', 'max:255'],
            'deadline' => ['nullable', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($id) {
            $project = Project::where('id', $id)->where('deleted', 'false')->firstOrFail();
        } else {
            $project = new Project();
        }
        if (!$project) {
            $request->session()->flash('error', 'An error was occurred. Please contact to Admin');
            return back();
        }
        $project->name = $input['name'];
        $project->description = $input['description'];
        $project->link = $input['link'];
        $project->update_link = $input['updateLink'];
        $project->expectations_description = $input['expectationsDescription'];
        $project->profit_description = $input['profitDescription'];
        $project->start_at = $input['startAt'] ? date('Y-m-d', strtotime($input['startAt'])) : date('Y-m-d');
        $project->deadline = $input['deadline'] ? date('Y-m-d', strtotime($input['deadline'])) : date('Y-m-d');
        $project->fts = (int) $input['fts'];
        $project->price = (int) $input['price'];
        $project->profit = (int) $input['profit'];
        $project->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = $user->id;
        $log->user_type = $user->role;
        $log->user_name = $user->first_name.' '.$user->last_name;

        if ($id) {
            $log->action = 'Project update';
            $request->session()->flash('success', 'Project successfully updated');
        }
        else {
            $log->action = 'Project create';
            $request->session()->flash('success', 'Project successfully created');
        }
        $log->save();

        return redirect()->route('project', $project->id);
    }

    public function projectDelete(Request $request, int $id)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        $user = Auth::user();

        $project = [];
        if ($id) {
            $project = Project::where('id', $id)->where('deleted', 'false')->firstOrFail();
        }
        if (!$project) {
            $request->session()->flash('error', 'An error was occurred. Please contact to Admin');
            return back();
        }
        $project->deleted = true;
        $project->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = $user->id;
        $log->user_type = $user->role;
        $log->user_name = $user->first_name.' '.$user->last_name;
        $log->action = 'Project delete';
        $log->save();

        return redirect()->route('projects');
    }

    public function projects(Request $request)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        return view('admin.projects', [
            'title' => 'Users list',
        ]);
    }

    public function projectsDatatable(Request $request)
    {
        if (!User::isadmin()) {
            return '';
        }
        $input = $request->all();
        $column = $input['order'][0]['column'];
        $dir = $input['order'][0]['dir'];
        $order_column = 'id';

        $projects = Project::where('deleted', 'false')->get();

        return datatables()->of($projects)
            ->addColumn('verif', function ($row) {
                return '<i class="fas fa-exclamation-circle fa-lg text-red"></i>';
            })
            ->toJson();
    }

    public function user(Request $request, int $id)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        $user = [];
        $title = 'Create user';
        if ($id) {
            $user = User::where('id', $id)->firstOrFail();
            $title = 'User #'.$user->id;
        }
        $files = File::where('entity_id', $id)->where('deleted', 'false')->orderBy('id', 'DESC')->get();
        $projects = Project::where('deleted', false)->orderBy('name', 'DESC')->get();
        $investments = Investment::where('user_id', $id)->where('deleted', false)->orderBy('created_at', 'desc')->get();

        $logs = Log::where('action_user_id', $id)->orderBy('created_at', 'desc')->get();
        foreach($logs as $k=>$v) {
            $logs[$k]->user = User::where('id', $v->action_user_id)->first();
            $logs[$k]->date = date('d-m-Y', strtotime($v->created_at));
        }

        $notCompleted = 0;
        $completed = 0;
        foreach ($investments as $k => $investment) {
            if ('Completed' === $investment->completed) {
                $completed += $investment->invested;
            }
            else {
                $notCompleted += $investment->invested;
            }
            foreach ($projects as $project) {
                if ($investment->project_id == $project->id) {
                    $investments[$k]['project'] = $project;
                }
            }
        }
        if ($id) {
            $template = 'admin.user';
        } else {
            $template = 'admin.user-create';
        }

        return view($template, [
            'title' => $title,
            'id' => $id,
            'user' => $user,
            'files' => $files,
            'projects' => $projects,
            'logs' => $logs,
            'investments' => $investments,
            'notCompleted' => $notCompleted,
            'completed' => $completed,
        ]);
    }

    public function userStore(Request $request, int $id)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'firstName' => ['nullable', 'max:255'],
            'lastName' => ['nullable', 'max:255'],
            'email' => ['required',
                Rule::unique('users')->where(function ($query) use($input) {
                    return $query
                        ->where('email', $input['email'])
                        ->where('id', '!=', $input['id'])
                        ->where('deleted', 'false')
                        ;
                })
            ],
            'phone' => ['nullable', 'string', 'max:255'],
            'birth' => ['nullable', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'house' => ['nullable', 'string', 'max:255'],
            'address1' => ['nullable', 'string', 'max:255'],
            'address2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'zip' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'password' => [
                'nullable',
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

        if ($id) {
            $user = User::where('id', $id)->firstOrFail();
        } else {
            $user = new User();
        }
        if (!$user) {
            $request->session()->flash('error', 'An error was occurred. Please contact to Admin');
            return back();
        }

        if ($input['password']) {
            $user->password = Hash::make($input['password']);
        }
        $user->first_name = $input['firstName'];
        $user->last_name = $input['lastName'];
        $user->email = $input['email'];
        $user->phone = $input['phone'];
        $user->birth = $input['birth'];
        $user->nationality = $input['nationality'];
        $user->house = $input['house'];
        $user->address1 = $input['address1'];
        $user->address2 = $input['address2'];
        $user->city = $input['city'];
        $user->zip = $input['zip'];
        $user->country = $input['country'];
        $user->role = 'User';
        $user->password = Hash::make($input['password']);
        $user->save();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_user_id = $user->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'User create';
        $log->save();

        //Mail::to($user->email)->send(new AccountActivation($user->first_name.' '.$user->last_name, $input['password']));

        if ($id) {
            $request->session()->flash('detailsStatus', 'User successfully updated');
        } else {
            $request->session()->flash('detailsStatus', 'User successfully created');
        }

        return redirect()->route('user', ['id'=>$user->id, '#detail']);
    }

    public function userDelete(Request $request, int $id)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        User::find($id)->delete();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_user_id = $id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'Admin delete profile';
        $log->save();

        $request->session()->flash('success', 'User notes successfully deleted');

        return redirect()->route('users');
    }

    public function userNotes(Request $request, int $id)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'notes' => ['nullable', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('id', $id)->where('deleted', false)->firstOrFail();

        $user->notes = $input['notes'];
        $user->save();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_user_id = $user->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'User notes update';
        $log->save();

        $request->session()->flash('notesSuccess', 'User notes successfully updated');

        return redirect()->route('user', ['id'=>$user->id, '#notes']);
    }

    public function userProject(Request $request)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'projectId' => ['required', 'not_in:0', 'int'],
            'userId' => ['required', 'not_in:0', 'int'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $investment = new Investment();
        $investment->user_id = $input['userId'];
        $investment->project_id = $input['projectId'];
        $investment->save();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_user_id = $input['userId'];
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'User investment create';
        $log->save();

        $request->session()->flash('projectsStatus', 'Investment successfully added');

        return redirect()->route('user', ['id'=>$input['userId'], '#projects']);
    }

    public function userProjectStore(Request $request)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'int'],
            'userId' => ['required', 'int'],
            'invested' => ['required', 'int'],
            'fts' => ['required', 'int'],
            'notes' => ['nullable', 'string'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $investment = Investment::where('id', $input['id'])->where('user_id', $input['userId'])->firstOrFail();
        $investment->invested = $input['invested'];
        $investment->fts = $input['fts'];
        $investment->notes = $input['notes'];
        $investment->save();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_user_id = $input['userId'];
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'User investment update';
        $log->save();
        $request->session()->flash('projectsStatus', 'Investment successfully updated');

        return redirect()->route('user', ['id'=>$input['userId'], '#projects']);
    }

    public function usersInvestmentComplete(Request $request, int $id)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        $investment = Investment::where('id', $id)->where('deleted', false)->firstOrFail();
        if ('Completed' === $investment->completed) {
            $investment->completed = 'Return';
            $action = 'User investment return';
            $success = 'Investment successfully completed';
        }
        else {
            $investment->completed = 'Completed';
            $action = 'User investment complete';
            $success = 'Investment successfully returned';
        }

        $investment->save();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_user_id = $investment->user_id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = $action;
        $log->save();
        $request->session()->flash('projectsStatus', $success);

        return redirect()->route('user', ['id'=>$investment->user_id, '#projects']);
    }

    public function usersInvestmentDelete(Request $request, int $id)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        $investment = Investment::where('id', $id)->where('deleted', false)->firstOrFail();
        $investment->deleted = true;
        $investment->save();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_user_id = $investment->user_id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'User investment delete';
        $log->save();
        $request->session()->flash('projectsStatus', 'Investment successfully deleted');

        return redirect()->route('user', ['id'=>$investment->user_id, '#projects']);
    }

    public function userApprove(Request $request, int $id)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        $user = User::where('id', $id)->where('deleted', false)->firstOrFail();
        if ($user->approved) {
            $user->approved = false;
            $action = 'User disapproved';
            $success = 'User successfully disapproved';
        }
        else {
            $user->approved = true;
            $action = 'User approved';
            $success = 'User successfully approved';
        }
        $user->save();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_user_id = $id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = $action;
        $log->save();
        $request->session()->flash('success', $success);

        return redirect()->route('user', $id);
    }

    public function userAttention(Request $request, int $id)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        $user = User::where('id', $id)->where('deleted', false)->firstOrFail();
        if ($user->attention) {
            $user->attention = false;
            $action = 'User dis activated attention';
            $success = 'User successfully dis activated attention';
        }
        else {
            $user->attention = true;
            $action = 'User activated attention';
            $success = 'User successfully activated attention';
        }
        $user->save();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_user_id = $id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = $action;
        $log->save();
        $request->session()->flash('success', $success);

        return redirect()->route('user', $id);
    }

    public function userVerify(Request $request, int $id)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        $user = User::where('id', $id)->where('deleted', false)->firstOrFail();
        if ($user->identity) {
            $user->identity = false;
            $action = 'User non-verify';
            $success = 'User successfully non-verify';
        }
        else {
            $user->identity = true;
            $action = 'User verify';
            $success = 'User successfully verify';
        }
        $user->save();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_user_id = $id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = $action;
        $log->save();
        $request->session()->flash('verificationStatus', $success);

        return redirect()->route('user', ['id'=>$id, '#verification']);
    }

    public function users(Request $request)
    {
        if (!User::isadmin()) {
            $request->session()->flash('error', "You don't nave access to this action");
            return redirect()->route('home');
        }

        return view('admin.users', [
            'title' => 'Users list',
        ]);
    }

    public function usersDatatable(Request $request)
    {
        if (!User::isadmin()) {
            return '';
        }
        $input = $request->all();
        $column = $input['order'][0]['column'];
        $dir = $input['order'][0]['dir'];
        $order_column = 'id';

        switch ($input['filter']) {
            case 'attention':
                $users = User::where('attention', true)->get();
                break;
            case 'investment':
                $users = User::select('users.*')
                    ->leftJoin('investments', 'users.id', '=', 'investments.user_id')
                    ->where('investments.invested', '>', '0')
                    ->get();
                break;
            case 'approved':
                $users = User::where('approved', true)->get();
                break;
            case 'deleted':
                $users = User::where('deleted', true)->get();
                break;
            default:
                $users = User::get();
                break;
        }


        return datatables()->of($users)
            ->addColumn('attention', function ($row) {
                $html = '';
                if ($row->attention) {
                    $html = '<i class="fa-solid fa-circle-exclamation text-danger"></i>';
                }
                return $html;
            })
            ->addColumn('verif', function ($row) {
                $html = '';
                if ($row->identity) {
                    $html = '<i class="fa-sharp fa-solid fa-circle-check text-success"></i>';
                }
                return $html;
            })
            ->addColumn('name', function ($row) {
                return $row->last_name.' '.$row->first_name;
            })
            ->addColumn('projects', function ($row) {
                $projects = [];
                $investments = Investment::where('user_id', $row->id)->where('deleted', false)->orderBy('created_at', 'desc')->get();
                foreach ($investments as $investment) {
                    $project = Project::where('id', $investment->project_id)->firstOrFail();
                    $projects[] = $project->name;
                }
                return implode(", ", $projects);
            })
            ->addColumn('test', function ($row) {
                $html = '';
                if ('Passed' === $row->test) {
                    $html = '<i class="fa-sharp fa-solid fa-circle-check text-success"></i>';
                } elseif ('Tried' === $row->test) {
                    $html = '<i class="fa-solid fa-clock text-warning"></i>';
                }
                return $html;
            })
            ->addColumn('status', function ($row) {
                $html = '';
                if ($row->approved) {
                    $html = '<i class="fa-sharp fa-solid fa-circle-check text-success"></i>';
                } elseif ($row->deleted) {
                    $html = '<i class="fa-solid fa-circle-xmark text-danger"></i>';
                }
                return $html;
            })
            ->rawColumns(['attention', 'verif', 'test', 'status'])
            ->toJson();
    }
}
