<?php

use Illuminate\Support\Facades\Route;
use  App\Models\User;
use  App\Models\Addresses;
use  App\Models\Posts;
use  App\Models\Tag;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ///// ////// LARAVEL SERVICE CONTAINER ////// ///// //// //

//Add items a string here to Service Container

// app()->bind('Game', function(){
//     return 'Football';
// });

//View all Items in Service Container

// dd(app());

//To get something in the container

//Creaye Stadium class

// class Stadium {

// }

//dd(app()->make('Game'));

//Create Football class 
// class Football {
//     public function __construct(Stadium $stadium)
//     {
//         $this->stadium = $stadium;
//     }
// }
//how about returning a class and not a string?
// class Game {
//     //Suppose Game class has some dependency;
//     public function __construct(Football $football)
//     {
//         $this->football = $football;
//     }
// }

// app()->bind('Game', function(){
//     //pass Football class in new Game
//     return new Game(new Football(new Stadium));
// });

//However, a new problem arises, what if the Football Class depends upon something else?
//What if Stadium also has anpther dependency, this can become hard to manage. However, because we are using Service Container

//Whenever we want to use a new class, throughout the project everttime you'll have to use $game  = new Game;
//However using bindings you'll have implemented new Game one time and then everywhere else on your application, you just use :
    //  dd(app()->make('Game')) which returns a new instance of Game; thus you can only make changes at one point that is in the bind 
    //method and it will be applied throughout your application.
//Suppose Game class has some dependency; the sevice container will inject all dependencies in the class because of PHP Reflection Class.
//The container takes care of everything even if one is not binding anything and one can use the resolve function.
//This provides so much flexibilty that enable one to create a highly scalable project.

//dd(resolve('Game'));


//If you want to create an instance everytime you want to use some class. This creates a new instance. 
// app()->instance('Game', function () {
//     return 'Instance';
// } );
//dd(app());

//Assuming you have this:
// app()->bind('random', function(){
//     return Str::random();
// });

// app()->singleton('random', function(){
//     return Str::random();
// });

// dump(app()->make('random'));
// dump(app()->make('random'));

//This outputs two different random strings everytime the page is refreshed becuse everytime app()->make('random') is called, it executes this function  app()->bind('random', function()return Str::random();});
//However, if you want to execute it only one time ad use it on the project; use singleton as such :
    // app()->singleton('random', function(){
    //     return Str::random();
    // });
//This means it will run one time and remeber the result and whenever you call or resolve ypur binding it returns the exact same thing.

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/user', function() {


    //ONE TO ONE RELATIONSHIPS

    // Makes 15 queries to DB
    // $addresses = Addresses::all();
    // $users = User::all();

     // Add to blade template:
    // @foreach ($users as $user )
    //   @if($user->address)
    //     <h2>{{$user->name}}</h2>
    //     <p>{{ $user->address->country}}</p>
    //   @else
    //     <h2>{{$user->name}}</h2>
    //     <p>{{ $user->email }}</p>
    //   @endif
    // @endforeach
    // @foreach ($addresses as $address )
    //   <h2>{{$address->country}}</h2>
    //   <p>{{ $address->user->name}}</p>
    // @endforeach

    //return view('users.index', compact('users','addresses'));



    //Give existing user Address by : 

    //method 1
    // $user = User::find(5);
    // $user->address()->create(
    //     [
    //         "country"=> 'USA'
    //     ]
    // );

    //method 2
    //Create new user
    // $user = User::factory()->create();

    // //Create new address
    // $address = new Addresses([
    //   'country' => 'UK'
       
    // ]);

    // //associate the two
    // $address->user()->associate($user);

    // //Save
    // $address->save();
    // return view('users.index', compact('users'));

    //The above methods make multiple queries to the database which slows the application
    // Apply Eager loading with the with method on the model and pass the relationship inside the method.

    //Returns users with addresses only. Makes 2 Queries
    // $addresses = Addresses::with('user')->get();
    // @foreach ($addresses as $address )
    //   <h2>{{$address->country}}</h2>
    //   <p>{{ $address->user->name}}</p>
    // @endforeach 

    // return view('users.index', compact('addresses'));

    //Makes 9 Queries returns all users includimg those without addresses

    // $addresses = Addresses::with('user');
    // $users = User::all();

    // // Add to blade template:
    // // @foreach ($users as $user )
    // //   @if($user->address)
    // //     <h2>{{$user->name}}</h2>
    // //     <p>{{ $user->address->country}}</p>
    // //   @else
    // //     <h2>{{$user->name}}</h2>
    // //     <p>{{ $user->email }}</p>
    // //   @endif
    // // @endforeach

    // return view('users.index', compact('users','addresses'));


    //ONE TO MANY RELATIONSHIPS

    // Addresses
    // $users = User::with('addresses')->get();
    // //Give a user another address
    // $users[0]->addresses()->create([
    //     'country' => 'Nigeria'
    // ]);
    // return view('users.index', compact('users'));

    //User Posts

    //With EagerLoading

    // $users[0]->posts()->create([
    //     'title' => 'Post 3'
    // ]);
    // $users[2]->posts()->create([
    //     'title' => 'Post 4'
    // ]);
    //

    //Fetch only users that have posts

    //$users = User::has('posts')->get(); //makes 4 queries

    //$users = User::has('posts')->with('posts')->get(); //makes 2 queries
    
    //Fetch all users with or without posts

    $users = User::with('posts')->get(); //makes 2 queries

    //Fetch all users who have posts with the word title in the post title

    // $users = User::whereHas('posts', function($query){
    //     $query->where('title', 'like', '%title%');
    // })->with('posts')->get(); //makes 2 queries

    //You can query relationship absense

    // $users = User::doesntHave('posts')->with('posts')->get(); //makes 2 queries
   
    return view('users.index', compact('users'));
    
});


Route::get('/posts', function() {

    //ONE TO MANY RELATIONSHIPS

    // Posts::create([
    //     'user_id' => 1,
    //     'title' => 'post title 1'
    // ]);
    // Posts::create([
    //     'title' => 'post title 3'
    // ]);
    // $posts = Posts::get();

    //Add to blade

    // @foreach ($posts as $post )
    //   <h1>{{$post->title}}</h1>
    //   <p>{{ $post->user->name }} </p>
    // @endforeach


    // return view('posts.index', compact('posts'));


    //MANY TO MANY RELATIONSHIP

    //Cretae Tags

    // Tag::create([
    //     'name' => 'Laravel'
    // ]);
    // Tag::create([
    //     'name' => 'PHP'
    // ]);
    // Tag::create([
    //     'name' => 'Javascript'
    // ]);
    // Tag::create([
    //     'name' => 'VueJs'
    // ]);

    //Attach Post to Tag

    // $tag = Tag::first();
    // $post = Posts::first();
    // // // $post->tags()->attach($tag);

    // $post->tags->detach(1);

    //$post = Posts::with('tags')->first();


    //Attach multiple tags
    //$post->tags()->attach([2,3,4]);
    //Posts::find(2)->tags()->attach([2,3,4]);

    //dd($post); //check for tag relations and number of

    //Detach a tag
    //$post->tags()->detach([2]);

    //To update a post, first detach all tags
    //$post->tags()->detach();

    //Then call new collection of tag ids
    //$post->tags()->attach([2,3,4]);

    //You can also update a posts tag as:
    //$post->tags()->sync([1,4]);


    //ADDING AND RETRIEVING COLUMNS IN THE PIVOT TABLE

    //If you roll back last migration that cretaed the pist_tag pivot table: php artisan migrat:rollback
    // and return timestamps and make migrations again, then create a Tag and attach it to a Post, the created_at and updated_at columns of the pivot table post_tag are not filled with the values for the new entry
    // Laravel has not updated these columsn automatically, how do we enable this? In the Post model method that defines the manytomany relationship:

    // public function tags(){
    //     return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id')->withTimestamps();
    // }  

    //How do we access the created_at and updated_at columns of the pivot table? As such:

    // $post =  Posts::first();

    // dd($post->tags->first()->pivot->created_at);

    //How can we add additional columns to the pivot table? Let's add a column status and update it

    // $post = Posts::first();

    // $post->tags()->attach([
    //     1 => [
    //         'status' => 'approved'
    //     ]
    // ]);

    // To be able to access the status column, add this to the Post Model's relation method:
    // public function tags(){
    //     return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id')
    //     ->withTimestamps()
    //     ->withPivot('status');
    // }

    //HANDLE EVENTS ON ATTACH, DETACH AND SUNC IN MANY TO MANY RELATIONSHIP





    $posts = Posts::with(['user', 'tags'])->get();

    return view('posts.index', compact('posts'));








});


Route::get('/tags', function(){

    $tags = Tag::with('posts')->get();
    return view('tags.index', compact('tags'));
});