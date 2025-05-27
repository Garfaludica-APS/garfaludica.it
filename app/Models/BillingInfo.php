<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillingInfo extends Model
{
	protected $fillable = [
		'first_name',
		'last_name',
		'tax_id',
		'address_line_1',
		'address_line_2',
		'city',
		'state',
		'postal_code',
		'country_code',
		'email',
		'phone',
	];
	protected $appends = [
		'full_name',
		'address',
		'full_address',
	];
	protected $hidden = [
		'booking_id',
	];

	public function booking(): BelongsTo
	{
		return $this->belongsTo(Booking::class);
	}

	public function getFullName(): string
	{
		return "{$this->first_name} {$this->last_name}";
	}

	public function getAddress(): string
	{
		if ($this->address_line_2)
			return "{$this->address_line_1}\n{$this->address_line_2}";
		return $this->address_line_1;
	}

	public function getFullAddress(): string
	{
		return $this->address . "\n"
			. $this->postal_code . ' '
			. $this->city . ', '
			. $this->state . ' '
			. $this->country_code;
	}

	protected function firstName(): Attribute
	{
		return Attribute::make(
			set: static fn(string $value) => implode(
				' ',
				array_map(
					static fn(string $part): string => mb_ucfirst(mb_strtolower($part)),
					explode(' ', mb_trim($value))
				)
			),
		);
	}

	protected function lastName(): Attribute
	{
		return Attribute::make(
			set: static fn(string $value) => implode(
				' ',
				array_map(
					static fn(string $part): string => mb_ucfirst(mb_strtolower($part)),
					explode(' ', mb_trim($value))
				)
			),
		);
	}

	protected function email(): Attribute
	{
		return Attribute::make(
			set: static fn(string $value): string => mb_strtolower(mb_trim($value)),
		);
	}

	protected function addressLine1(): Attribute
	{
		return Attribute::make(
			set: static fn(string $value): string => mb_ucfirst(mb_trim($value)),
		);
	}

	protected function addressLine2(): Attribute
	{
		return Attribute::make(
			set: static fn(?string $value): ?string => $value !== null ? mb_ucfirst(mb_trim($value)) : null,
		);
	}

	protected function city(): Attribute
	{
		return Attribute::make(
			set: static fn(string $value): string => mb_ucfirst(mb_trim($value)),
		);
	}

	protected function state(): Attribute
	{
		return Attribute::make(
			set: static fn(string $value): string => mb_ucfirst(mb_trim($value)),
		);
	}

	protected function countryCode(): Attribute
	{
		return Attribute::make(
			set: static fn(string $value): string => mb_strtoupper(mb_trim($value)),
		);
	}

	protected function taxId(): Attribute
	{
		return Attribute::make(
			set: static fn(string $value): string => mb_strtoupper(str_replace(' ', '', mb_trim($value))),
		);
	}
}
