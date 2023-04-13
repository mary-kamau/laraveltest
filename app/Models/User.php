<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Addresses;
use App\Models\Posts;
use App\Events\UserCreated;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function address(){
        return $this->hasOne(Addresses::class, 'user_id', 'id');
    }

    //user has many address

    public function addresses(){
        return $this->hasMany(Addresses::class, 'user_id', 'id');
    }

    public function  posts(){
        return $this->hasMany(Posts::class);
    }

    //LARAVEL OBSERVERS & MODEL EVENTS

    //Model Events allow you to execute code in some points of the Model Lifecycle.
    //There are eleven events in the model lifecycle, these are:
        //retrieved
        //creating
        //created
        //updating
        //updated
        //saving
        //saved
        //deleting
        //deleted
        //restoring
        //restored

    //Laravel provides two ways to use these events:
        //1. Event listener
        //2. Overwrite Boot function of model
        //3. Observers
    
    //How to apply?

    //1. USING EVENT LISTENERS (to apply model lifecycle events)

    //Let's say you want to fire an event when a User is created perhaps to send a welcome email or so.

    //1. Define a protected $dispatchesEvents =[]; this property is an array that maps model lifecycle events to the Event Class.

    //For example:

    // protected $dispatchesEvents =[
    //     'created' => UserCreated::class
    // ];

    //2. Make the event class:

    //php artisan make:event UserCreated

    //3. In the Event-> UserCreated __construct method, accept User Model as such:

    // class UserCreated
    // {
    //   use Dispatchable, InteractsWithSockets, SerializesModels;
    
    //   public $user;

    //   /**
    //    * Create a new event instance.
    //    */
    //   public function __construct(User $user)
    //   {
    //     $this->user = $user;
    //   }

    //   /**
    //    * Get the channels the event should broadcast on.
    //    *
    //    * @return array<int, \Illuminate\Broadcasting\Channel>
    //    */
    //   public function broadcastOn(): array
    //   {
    //     return [
    //         new PrivateChannel('channel-name'),
    //     ];
    //   }
    // }

    //4. Handle the event by creating a listener for it as such:

        //php artisan make:listener UserCreatedListener -e UserCreated

        //In the UserCreatedListener handle() method you can create any listener you locgic needed for the application

    //5. Register the event listener in the EventServiceProvider Class (app\Providers\EventServiceProvider.php) add this in the listen array:

    //You can add Event listeners for other Model lifecycle events

    //This works best with real-time applications as the broadcastOn() method of the Event Class alllows to broadcast the data.

    //For other cases you can use the Overwriting the Model's boot method or observers.


    //2. OVERWRITE BOOT FUNCTION OF MODEL  (to apply model lifecycle events)

    protected static function booted(){
        parent::booted();

        static::created(
            function($user){
                dd("From  Boot method", $user);
            }
        ); //call then lifecycle event method e.g updated(), deleted(), restored()
        //add a closure function that accepts the model as shown above
    }

    //However if 





}