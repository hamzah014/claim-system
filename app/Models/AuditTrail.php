<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    protected $table = 'audit_trails';
    protected $guarded = ['id'];  
    
    
    public function user()
    {
        if($this->user_role == 'admin'){
            return $this->belongsTo(Admin::class, 'user_id', 'id');
        }
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(Claim::class, 'transaction_id', 'id');
    }

    public function createdAt()
    {
        return Carbon::parse($this->created_at)->format('d/m/Y H:i:s');
    }
    
}