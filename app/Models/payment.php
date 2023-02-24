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

    public static $media_collection_payment_receipt = 'media_collection_payment_receipt';


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('media_collection_payment_receipt');
    }
}
