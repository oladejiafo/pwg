<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\CustomResetPasswordNotification;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Client extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use InteractsWithMedia;



    protected $table = 'clients';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'family_member_id',
        'name',
        'email',
        'phone_number',
        'password',
        'passport_number',
        'sales_agent_name_by_client',
        'sales_agent_phone_number_by_client',
        'country_of_residence',
        'created_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

     /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }

    public function applicantExperiences()
    {
        return $this->hasMany(applicantExperience::class, 'client_id', 'id');
    }

    public static $media_collection_main_signture = 'client_collection_signature';
    public static $media_collection_main_resume = 'client_collection_resume';
    public static $media_collection_main = 'client_passport_collection_img';
    public static $media_collection_main_residence_visa = 'client_residence_visa_copy';
    public static $media_collection_main_residence_id = 'client_collection_residence_id';
    public static $media_collection_main_schengen_visa = 'client_collection_schengen_visa';
    public static $media_collection_main_schengen_visa1 = 'client_collection_schengen_visa1';
    public static $media_collection_main_schengen_visa2 = 'client_collection_schengen_visa2';
    public static $media_collection_main_schengen_visa3 = 'client_collection_schengen_visa3';
    public static $media_collection_main_schengen_visa4 = 'client_collection_schengen_visa4';

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('client_collection_signature')->singleFile();
        $this->addMediaCollection('client_collection_resume')->singleFile();
        $this->addMediaCollection('client_passport_collection_img')->singleFile();

        // $this->addMediaCollection('client_collection_schengen_visa')->singleFile(); //

        $this->addMediaCollection('client_collection_schengen_visa')->singleFile();
        $this->addMediaCollection('client_collection_schengen_visa1')->singleFile();
        $this->addMediaCollection('client_collection_schengen_visa2')->singleFile();
        $this->addMediaCollection('client_collection_schengen_visa3')->singleFile();
        $this->addMediaCollection('client_collection_schengen_visa4')->singleFile();

        $this->addMediaCollection('client_collection_residence_id')->singleFile();
        $this->addMediaCollection('client_residence_visa_copy')->singleFile();
    }
}
