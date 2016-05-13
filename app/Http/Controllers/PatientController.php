<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\UserRepository;
use App\User;

class PatientController extends Controller
{
    /**
     *
     * @var UserRepository
     */
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }
    
    /**
     * Display a list of all of the users.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('users.index', ['users' => $this->users->patients(), 
            'password' => false, 'phone' => true, 'url' => 'patients', 
            'button' => 'Add Patient', 'sendPassCode' => true]);
    }
    
    /**
     * Create a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => empty($user->id) ? 'required|email|max:255|unique:users' : 
                "required|email|max:255|unique:users,email,$user->id",
            'phone' => 'required|phone:US',
        ]);
        
        if (empty($user->id)) {
            $patient = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            $patient->assignRole('patient');
        } else {
            $user->update($request->all());
        }
        
        return redirect('/patients');
    }
    
    public function view(Request $request, User $user)
    {
        return view('users.view', ['user' => $user, 'url' => 'patients', 'sendPassCode' => true]);
    }
    
    public function edit(Request $request, User $user)
    {
        return view('users.edit', ['user' => $user, 'url' => 'patients', 'sendPassCode' => true, 
            'button' => 'Save', 'password' => false, 'phone' => true]);
    }
    
    public function update(Request $request, User $user)
    {
        return redirect('/patients/' . $user->id . '/view');
    }
    
    public function send(Request $request, User $user)
    {
        return redirect('/reports');
    }
    
    /**
     * Destroy the given patient.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return Response
     */
   public function destroy(Request $request, User $user)
   {
       $user->delete();
       return redirect('/patients');
   }
}
