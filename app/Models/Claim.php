<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{

    protected $table = 'claims';
    protected $guarded = ['id'];

    public function attendFiles()
    {
        return $this->hasMany(ClaimFile::class, 'claim_id', 'id')->where('type', 'attend');
    }

    public function supportFiles()
    {
        return $this->hasMany(ClaimFile::class, 'claim_id', 'id')->where('type', 'support');
    }

    public function receiptFile()
    {
        return $this->hasMany(ClaimFile::class, 'claim_id', 'id')->where('type', 'receipt');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
    
    public function detail()
    {
        return $this->belongsTo(ClaimDetail::class, 'id', 'claim_id');
    }

    public function approver()
    {
        return $this->belongsTo(Admin::class, 'id', 'approver_id');
    }

    public function manager()
    {
        return $this->belongsTo(Admin::class, 'id', 'manager_id');
    }

    public function auditTrails()
    {
        return $this->hasMany(AuditTrail::class, 'transaction_id', 'id')->orderBy('id', 'desc');
    }  

    public function paymentDate()
    {
        return Carbon::parse($this->payment_date)->format('Y-m-d');
    }

    public function generateReferenceNo()
    {
        $ref_code = Carbon::now()->format('Ymd');
        $string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomChar = $string[rand(0, strlen($string) - 1)] . $string[rand(0, strlen($string) - 1)] . $string[rand(0, strlen($string) - 1)] . $string[rand(0, strlen($string) - 1)];
        $ref_code = $ref_code . $randomChar;
        return 'CLM' . $ref_code;
    }
    
}