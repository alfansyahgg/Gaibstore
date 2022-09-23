<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardUserRequest;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $validated = $request->safe()->only(['search']);

        $filters = [
            'search' => Arr::get($validated, 'search'),
            'page' => Arr::get($validated, 'page', 1),
        ];


        $can = [
            'create' => $request->user()->can('create', User::class)
        ];
        
        $users          = new User;
        $users          = $users->when($filters['search'], function($query, $value){
            $query->where(function ($query) use ($value) {
                $query->where('email', 'like', '%' . $value . '%');
            });
        })
        ->orderBy('active', 'desc')->orderBy('email', 'asc')->paginate(10)->withQueryString();

        return inertia('Dashboard/User/Index', [
            'title' => appTitle(),
            'data' => ApiResource::collection($users),
            'filters' => $filters,
            'can' => $can,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Dashboard/User/Create', [
            'title' => appTitle(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DashboardUserRequest $request)
    {
        $user            = new User();
        $user->email     = $request->input('email');
        $user->role      = $request->input('role');
        $user->password  = bcrypt($request->input('password'));
        $user->active    = $request->input('active');
        $user->save();
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $user->addMediaFromRequest('photo')->usingName(__generateString('us', Media::class, 'file_name', '7'))->toMediaCollection('user_photo');
        }
        $user->profile()->create([
            'user_id' => $user->id,
        ]);

        return redirect()->route('user.index')->with('message', 'Successfully Create ' . $user->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->getMedia('user_photo')->first();
        return inertia('Dashboard/User/Edit', [
            'title' => appTitle(),
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, DashboardUserRequest $request)
    {
        $user->email     = $request->email;
        $user->role      = $request->role;
        $user->active    = $request->active;
        if(!empty($request->password)) {
            $user->password  = bcrypt($request->password);
        }
        $user->update();
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $user->addMediaFromRequest('photo')->usingName(__generateString('us', Media::class, 'file_name', '7'))->toMediaCollection('user_photo');
        }

        return redirect()->route('user.index')->with('message', 'Successfully update ' . $user->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->profile()->delete();
        $user->delete();
        return redirect()->route('user.index')->with('message', 'user ' . $user->name . ' deleted');
    }

    /**
     * Remove the mass resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroyUsers(Request $request)
    {
        $users = $request->input('users');
        // dd($users);
        # delete the contact row by contact_id
        foreach ($users as $pid) {
            $user = User::find($pid);
            $user->delete();
        }
        # redirect to index page of contact
        return redirect()->route('user.index')->with('message', count($users) . ' Users deleted');
    }
}