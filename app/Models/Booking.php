<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Booking extends Model
{
	use SoftDeletes;
	protected $fillable = [
		'email',
		'notes',
	];
	protected $casts = [
		'expires_at' => 'datetime',
	];
	protected $appends = [
		'subtotal',
		'room_discount',
		'total',
		'discount',
		'discounted_total',
	];
	protected $hidden = [
		'discount_code_id',
		'pp_order_id',
		'signed_url',
		'manage_url',
	];

	public function discountCode(): BelongsTo
	{
		return $this->belongsTo(DiscountCode::class);
	}

	public function billingInfo(): HasOne
	{
		return $this->hasOne(BillingInfo::class);
	}

	public function roomReservations(): HasMany
	{
		return $this->hasMany(RoomReservation::class);
	}

	public function mealReservations(): HasMany
	{
		return $this->hasMany(MealReservation::class);
	}

	public function signedUrl(): Attribute
	{
		return Attribute::make(
			get: fn(): string => URL::temporarySignedRoute('gobcon.booking.index', $this->expires_at, ['booking' => $this]),
		)->shouldCache();
	}

	public function manageUrl(): Attribute
	{
		return Attribute::make(
			get: fn(): string => URL::temporarySignedRoute('gobcon.booking.manage', $this->expires_at, ['booking' => $this]),
		)->shouldCache();
	}

	public function getRouteKeyName(): string
	{
		return 'uuid';
	}

	protected static function booted(): void
	{
		parent::booted();
		static::creating(function(self $booking): void {
			$booking->uuid = Str::uuid7();
			$booking->expires_at = config('gobcon.portal_closes_at', now()->addDays(7));
			$booking->status = BookingStatus::START;
		});
		static::deleting(function(self $booking): void {
			if (\in_array($booking->status, [
				BookingStatus::COMPLETED,
				BookingStatus::FAILED,
				BookingStatus::CANCELLED,
				BookingStatus::REFUND_REQUESTED,
				BookingStatus::REFUNDED,
			], true)) {
				return;
			}
			$booking->status = BookingStatus::CANCELLED;
		});
	}

	protected function subtotal(): Attribute
	{
		return Attribute::make(
			get: fn(): float => $this->roomReservations->sum('price')
				+ $this->mealReservations->sum('price'),
		)->shouldCache();
	}

	protected function roomDiscount(): Attribute
	{
		return Attribute::make(
			get: function(): float {
				$roomReservations = $this->roomReservations;
				$mealReservations = $this->mealReservations;
				$discount = 0.0;
				foreach ($roomReservations as $reservation) {
					$includedMeals = $reservation->includedMeals;
					foreach ($includedMeals as $meal) {
						$quantity = $reservation->roomOption->capacity;
						foreach ($mealReservations as $mealReservation) {
							if ($mealReservation->meal->id === $meal->id) {
								--$quantity;
								$discount += $mealReservation->mealOption->price;
							}
							if ($quantity <= 0) {
								break;
							}
						}
					}
				}
				return $discount;
			},
		)->shouldCache();
	}

	protected function total(): Attribute
	{
		return Attribute::make(
			get: fn(): float => $this->subtotal - $this->roomDiscount,
		)->shouldCache();
	}

	protected function discount(): Attribute
	{
		return Attribute::make(
			get: function(): float {
				$discountCode = $this->discountCode;
				if ($discountCode === null)
					return 0.0;
				$discount = $discountCode->amount;
				if ($discountCode->percentual)
					$discount = ($discountCode->amount / 100);
				if ($discount > $this->total)
					$discount = $this->total;
				return round($discount, 2);
			},
		)->shouldCache();
	}

	protected function discountedTotal(): Attribute
	{
		return Attribute::make(
			get: fn(): float => $this->total - $this->discount,
		)->shouldCache();
	}

	protected function casts(): array
	{
		return [
			'expires_at' => 'datetime',
			'status' => BookingStatus::class,
		];
	}
}
