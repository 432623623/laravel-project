<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use App\Models\BannedEmail;
use Illuminate\Http\Request;
use App\Events\OurExampleEvent;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserEmail;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{    
    public function storeAvatar(Request $request){
        $request->validate([
            'avatar'=>'required|image|max:3000'
        ]);
        $user = auth()->user();
        $filename = $user->id . "-" . uniqid() . ".jpg";
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file("avatar"));
        $imgData = $image->cover(120,120)->toJpeg();
        Storage::disk('public')->put('avatars/' . $filename, $imgData);
        $oldAvatar = $user->avatar;
        $user->avatar = $filename;
        $user->save();
        if($oldAvatar != "/fallback-avatar.jpg"){
            Storage::disk('public')->delete(str_replace("/storage/","",$oldAvatar));
        }
        return back()->with('success','congrats on new avatar');
    }
    public function showAvatarForm(){
        return view('avatar-form');
    }
    public function profile(User $user){
        $this->getSharedData($user);
        return view('profile-posts',['posts'=> $user->posts()->latest()->get()]);
    }
    public function profileFollowers(User $user){
        $this->getSharedData($user);
        return view('profile-followers',['followers'=> $user->followers()->latest()->get()]);
    }
    public function profileFollowing(User $user){
        $this->getSharedData($user);
        return view('profile-following',['followings'=> $user->following()->latest()->get()]);
    }
    private function getSharedData($user){
        $nowFollowing = 0;
        if(auth()->check()){
            $nowFollowing = Follow::where([['user_id','=',auth()->user()->id],
            ['followeduser','=',$user->id]])->count();
        }
        View::share('sharedData',['nowFollowing'=>$nowFollowing, 
        'avatar'=> $user->avatar, 'username'=>$user->username, 
        'postCount'=>$user->posts()->count(), 'followerCount'=> $user->followers()->count(), 
        'followingCount'=> $user->following()->count()]);
    }
    public function logout(){
        event(new OurExampleEvent(['username'=>auth()->user()->username, 'action'=>'logout']));
        auth()->logout();
        return redirect('/')->with('success','you are logged out');
    }
    public function showCorrectHomepage(){
        if (auth()->check()){
            return view('homepage-feed',['posts'=>auth()->user()->feedPosts()->latest()->paginate(10)]);
        }else{
           $postCount = Cache::remember('postCount', 20, function(){
            return Post::count();
           });
            return view('homepage', ['postCount'=>$postCount]);
        }
    }
    public function loginApi(Request $request){
        $incomingFields = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        if (auth()->attempt($incomingFields)){
            //$user = User::where('username', $incomingFields['username'])->first();
            $user = auth()->user();
            $token = $user->createToken('ourapptoken')->plainTextToken;
            return $token;
        }
        return 'sorry';
    }
    public function login(Request $request){
        $incomingFields = $request->validate([
            'loginusername'=>'required',
            'loginpassword'=>'required'
        ]);
        $user = User::where('username',$incomingFields['loginusername'])->first();
        if(!$user){
            return back()->with('failure','Invalid login.');
        }
        if($user->is_banned){
            return back()->with('failure','Banned user.');
        }
        if(auth()->attempt(['username'=>$incomingFields['loginusername'],
                            'password'=>$incomingFields['loginpassword']])){
            $request->session()->regenerate();
        event(new OurExampleEvent(['username'=>auth()->user()->username, 
            'action'=>'login']));
            return redirect('/')->with('success','you are logged in');
        }else{
            return back()->with('failure','invalid login');
        }
    }
    public function register(Request $request){
        $incomingFields = $request->validate([
            'username'=>['required','min:3','max:20',
                Rule::unique('users','username')],
            'email'=>['required',
                'email',
                Rule::unique('users','email'),
                function($attribute, $value, $fail){
                    if(BannedEmail::where('email',$value)->exists()){
                        $fail('This email is not allowed.');
                    }                
                }],
            'password'=>['required','min:8','confirmed']
        ]);
        $user = User::create($incomingFields);
        auth()->login($user);
/*
        Mail::to(auth()->user()->email)->send(
            new NewUserEmail([
                'name' => auth()->user()->username,
            ])
        );
*/
        return redirect('/')->with('success','thank you for creating account');
    }
    public function index(){
        $users = User::where('is_banned',false)
        ->orderBy('username')
        ->paginate(20);
        return view('users.index', compact('users'));
    }
}
