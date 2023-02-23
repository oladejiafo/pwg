<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class payment extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'application_id',
        'invoice_no',
        'invoice_id',
        'currency',
        'transaction_id',
        'bank_reference_no',
        'paid_amount'
    ];

    public static $media_collection_payment_receipt = 'client_collection_signature';
    public static $media_collection_submission_payment = 'client_collection_submission_payment';
    public static $media_collection_second_payment = 'client_collection_second_payment';


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('media_collection_payment_receipt');
        $this->addMediaCollection('media_collection_submission_payment');
        $this->addMediaCollection('media_collection_second_payment');
    }
}
