<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    // Define the table fields that can be mass assigned
    protected $fillable = [
        'support_id',   // ID of the support ticket this message belongs to
        'sender_id',    // ID of the user who sent the message
        'recipient_id', // ID of the user who receives the message
        'message'       // The actual message content
    ];

    // Define the relationship: a support message belongs to a support ticket
    public function support()
    {
        return $this->belongsTo(Support::class, 'support_id');
    }

    // Define the relationship: a support message is sent by a user (sender)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Define the relationship: a support message is received by a user (recipient)
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
