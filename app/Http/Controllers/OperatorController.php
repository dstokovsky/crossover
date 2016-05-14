<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Repositories\UserRepository;
use App\User;

class OperatorController extends Controller
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
        return view('users.index', ['users' => $this->users->operators(), 
            'password' => true, 'phone' => false, 'url' => 'operators', 
            'button' => 'Add Operator', 'sendPassCode' => false]);
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
            'password' => 'required|min:6|confirmed',
        ]);
        
        if (empty($user->id)) {
            $operator = User::create($request->all());
            $operator->assignRole('operator');
            $message = 'New lab operator has been successfully created.';
        } else {
            $user->update($request->all());
            $message = 'Operator record has been successfully updated.';
        }
        Session::flash('message', $message);
        
        return redirect('/operators');
    }
    
    public function view(Request $request, User $user)
    {
        return view('users.view', ['user' => $user, 'url' => 'operators', 'sendPassCode' => false]);
    }
    
    public function edit(Request $request, User $user)
    {
        return view('users.edit', ['user' => $user, 'url' => 'operators', 'sendPassCode' => false, 
            'button' => 'Save', 'password' => true, 'phone' => false]);
    }
    
    /**
     * Destroy the given operator.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return Response
     */
   public function destroy(Request $request, User $user)
   {
       $messageType = 'message';
       $message = 'Operator ' . $user->name . ' has been successfully removed.';
        if ($user->id !== 1 && $request->user()->id !== $user->id) {
            $user->delete();
        } else {
            $messageType = 'danger';
            $message = 'It is prohibited to delete main system admin or yourself.';
        }
        Session::flash($messageType, $message);
        
        return redirect('/operators');
   }
}
