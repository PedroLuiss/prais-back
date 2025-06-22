<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Beneficiary
 *
 * @property string $id
 * @property int $run
 * @property string $verification_digit
 * @property string $first_names
 * @property string $primary_last_name
 * @property string|null $secondary_last_name
 * @property string|null $gender
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property \Illuminate\Support\Carbon|null $accreditation_date
 * @property \Illuminate\Support\Carbon|null $device_entry_date
 * @property string|null $accreditation_quality
 * @property string|null $relationship_with_index
 * @property string|null $index_run
 * @property string|null $index_verification_digit
 * @property string|null $rettig_law_victim_full_name
 * @property string|null $relationship_with_victim
 * @property string|null $has_prais_fonasa_mark
 * @property string|null $status_in_device
 * @property \Illuminate\Support\Carbon|null $transfer_date
 * @property string|null $transferred_to_prais_ss
 * @property \Illuminate\Support\Carbon|null $disaffiliation_date
 * @property \Illuminate\Support\Carbon|null $death_date
 * @property string|null $cause_of_death_diagnosis
 * @property string|null $street_name
 * @property string|null $street_number
 * @property string|null $department_number
 * @property string|null $commune
 * @property string|null $region
 * @property string|null $phone_numbers
 * @property string|null $email
 * @property string|null $civil_status
 * @property string|null $education_level
 * @property string|null $health_insurance
 * @property string|null $relevant_observation
 * @property string|null $valech_listed
 * @property string|null $exonerated_listed
 * @property int|null $age_in_years
 * @property string|null $age_group
 * @property int|null $accreditation_or_entry_year
 * @property int|null $device_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Device|null $device
 */
class Beneficiary extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'beneficiaries';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'run',
        'verification_digit',
        'first_names',
        'primary_last_name',
        'secondary_last_name',
        'gender',
        'birth_date',
        'accreditation_date',
        'device_entry_date',
        'accreditation_quality',
        'relationship_with_index',
        'index_run',
        'index_verification_digit',
        'rettig_law_victim_full_name',
        'relationship_with_victim',
        'has_prais_fonasa_mark',
        'status_in_device',
        'transfer_date',
        'transferred_to_prais_ss',
        'disaffiliation_date',
        'death_date',
        'cause_of_death_diagnosis',
        'street_name',
        'street_number',
        'department_number',
        'commune',
        'region',
        'phone_numbers',
        'email',
        'civil_status',
        'education_level',
        'health_insurance',
        'relevant_observation',
        'valech_listed',
        'exonerated_listed',
        'age_in_years',
        'age_group',
        'accreditation_or_entry_year',
        'device_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'accreditation_date' => 'date',
        'device_entry_date' => 'date',
        'transfer_date' => 'date',
        'disaffiliation_date' => 'date',
        'death_date' => 'date',
        'run' => 'integer',
        'age_in_years' => 'integer',
        'accreditation_or_entry_year' => 'integer',
        'device_id' => 'integer',
    ];

    /**
     * Get the device that the beneficiary belongs to.
     */
    // public function device(): BelongsTo
    // {
    //     return $this->belongsTo(Device::class, 'device_id');
    // }
}
