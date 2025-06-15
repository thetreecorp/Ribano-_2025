<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Gateway;
use App\Models\Project;
use App\Models\Language;
use App\Models\Template;
use App\Models\ManagePlan;
use App\Models\Subscriber;
use App\Http\Traits\Notify;
use Illuminate\Http\Request;
use App\Models\ContentDetails;
use App\Models\PayMoney;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use App\Console\Commands\UpdateBadgeCron;
use App\Http\Traits\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Controller;
use App\Http\Traits\Common;
use App\Models\UserXeedwallet;
class ProjectController extends Controller
{
    use Upload, Notify, Common;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();


    }

    public function index()
    {
        $manageWallets = UserXeedwallet::get();

        // $projectHaveXeedwallet = Project::pluck('user_xeedwallet_id')->all();

        // $manageWallet = UserXeedwallet::whereNotIn('id', $projectHaveXeedwallet)->get();



        if($request->type == 'pending')
            $projects = Project::where(['status' => 2, 'user_id' => $this->user->id])->orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        else
            $projects = Project::where('user_id', $this->user->id)->orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        return view('project.index', compact('projects', 'manageWallets'));
    }

    public function pendingUserProject(Request $request)
    {
        $projects = Project::where([['status','!=', 1], ['user_id', "=", $this->user->id]])->orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        return view('project.index', compact('projects'));
    }

    public function adminProject(Request $request)
    {
        $manageWallets = UserXeedwallet::get();
        if($request->type == 'pending')
            $projects = Project::where('status', 2)->orderBy('id', 'DESC')->get();
        else
            $projects = Project::orderBy('id', 'DESC')->get();


        return view('project.admin-project', compact('projects', 'manageWallets'));

    }

    public function userProject(Request $request)
    {
        $user_id = Auth::user()->id;
        if($request->type == 'pending')
            $projects = Project::where(['status' => 2, 'user_id' => $user_id])->orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        else
            $projects = Project::where(['user_id' => $user_id])->orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        return view('project.index', compact('projects'));
    }

    public function pendingProject(Request $request)
    {
        $manageWallets = UserXeedwallet::get();
        $projects = Project::where([['status', '!=', 1]])->orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        return view('project.admin-project', compact('projects' , 'manageWallets'));


        // $managePlans = ManagePlan::latest()->get();
        // return view('project.admin-project', compact('managePlans'));
    }

    public function setFeatured(Request $request)
    {
        try {
            if ($request->active == 'on') {
                Project::where('id', $request->id)->update([
                    'is_featured' => 1,
                ]);
                return response()->json(['success' => 1, 'message' => 'Active featured']);
            } else {
                Project::where('id', $request->id)->update([
                    'is_featured' => 0,
                ]);

                return response()->json(['success' => 1, 'message' => 'Disable featured']);
            }
        } catch (\Throwable $th) {
            return response()->json(['success' => 0, 'message' => 'Error set featured project']);
        }

    }

    public function activeMultipleProject(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            Project::whereIn('id', $request->strIds)->update([
                'status' => 1,
            ]);
            session()->flash('success', 'Project status has been active');
            return response()->json(['success' => 1]);
        }
    }

    public function inActiveMultipleProject(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select ID.');
            return response()->json(['error' => 1]);
        } else {
            Project::whereIn('id', $request->strIds)->update([
                'status' => 0,
            ]);
            session()->flash('success', 'Project Status Has Been Deactive');
            return response()->json(['success' => 1]);
        }
    }

    public function search(Request $request)
    {
        $search = $request->all();


        $projects = Project::orderBy('id', 'DESC')->where('user_id', $this->user->id)
            ->when(isset($search['name']), function ($query) use ($search) {
                return $query->where('title', 'LIKE', $search['name']);
            })
            ->paginate(config('basic.paginate'));

        return view($this->theme . 'project.index', compact('projects'));
    }






    public function createProject()
    {
        $title = 'Add Project';

        $data['increment'] = 1;
        //dd($this->checkProjectPermission());
        // dd(Auth::user()->getTable());
        if(Auth::user()->getTable() == 'users')
            if($this->checkProjectPermission() == 0)
                return view('permission.no_create_project');

        return view('project.create', $data, compact('title'));
    }


    // clone project

    public function cloneProject($id)
    {

        $project = Project::find($id);


        try {
            if ($project) {

                $newProject = $project->replicate();
                $newProject->title = $project->title . ' clone';
                $newProject->slug = $project->slug . '-clone';

                $newProject->save();

                session()->flash('message', 'Project clone successfully.');
                return redirect()->route('admin.projects');

            }
            else
                exit('Project not found');
        }
        catch (\Throwable $th) {
            exit('Project not clone');
        }




       // return view('project.create', $data, compact('title'));
    }


    public function editProject($slug) {
        //dd(Auth::user()->getTable());
        if(Auth::user()->getTable() == 'users')
            if(!$this->checkProjectPermission())
                return view('permission.no_create_project');

        $findProject = Project::where('slug', $slug)->first();
        if(!$findProject)
            return abort(404);
        else {
            $user_id = Auth::user()->id ?? 0;
            if($user_id != $findProject->user_id && Auth::user()->getTable() == 'users')
                return abort(401);
        }
        $title = $findProject->title;
        $data['increment'] = 1;
        return view('project.edit', $data, compact('title', 'slug', 'findProject'));
    }


}
