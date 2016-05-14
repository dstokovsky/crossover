<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use URL;
use Session;
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
            $message = 'Patient record for ' . $patient->name . ' has been successfully created.';
        } else {
            $user->update($request->all());
            $message = 'Patient record has been successfully updated.';
        }
        Session::flash('message', $message);
        
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
    
    public function send(Request $request, User $user)
    {
        $passcode = str_random();
        $user->password = $passcode;
        $user->save();
        $mailData = ['user' => $user, 'passcode' => $passcode, 'app' => config('mail.from.name')];
        Mail::send('emails.passcode', $mailData, function($message) use ($user) {
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->to($user->email, $user->name);
            $message->subject(config('mail.from.name') . ' Pass Code');
        });
        
        Session::flash('message', 'New pass code has been sent to ' . $user->name . '.');
        return redirect(URL::previous());
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
        Session::flash('message', 'Patient ' . $user->name . ' has been successfully removed.');
        return redirect('/patients');
    }
   
    public function autocomplete(Request $request)
    {
        $patients = $this->users->patients();
        $result = [];
        foreach ($patients as $patient) {
            if (stristr($patient->name, $request->term)) {
                $result[] = ['value' => $patient->email, 'label' => $patient->name, 'desc' => $patient->id];
            }
        }
        
        return $result;
    }
}
