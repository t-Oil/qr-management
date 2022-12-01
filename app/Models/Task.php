<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CreatedUpdatedBy;

    protected $fillable = [
        'task_date',
        'vehicle_registration',
        'trailer_registration',
        'job_type_id',
        'partner_id',
        'product_id',
        'department_id',
        'id_card',
        'prefix',
        'first_name',
        'last_name',
        'is_active',
        'created_at',
        'qr_code'
    ];

    protected $hidden = ['id'];

    /**
     * @return array|\ArrayAccess|mixed
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'id')
            ->select('name', 'code');
    }

    /**
     * @return array|\ArrayAccess|mixed
     */
    public function jobType()
    {
        return $this->belongsTo(JobType::class, 'job_type_id', 'id')
            ->select('name', 'code');
    }

    /**
     * @return array|\ArrayAccess|mixed
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')
            ->select('name', 'code');
    }

    /**
     * @return array|\ArrayAccess|mixed
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id')
            ->select('name', 'code');
    }
}
