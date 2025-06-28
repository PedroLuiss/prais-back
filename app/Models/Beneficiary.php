<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    /**
     * Las situaciones represivas que pertenecen al Beneficiario.
     */
    public function repressiveSituations(): BelongsToMany
    {
        return $this->belongsToMany(
            RepressiveSituation::class,         // 1. Modelo con el que se relaciona
            'beneficiary_repressive_situation', // 2. Nombre de la tabla pivote
            'beneficiary_id',                   // 3. FK de este modelo en la tabla pivote
            'repressive_situation_id'           // 4. FK del otro modelo en la tabla pivote
        );
    }
}
