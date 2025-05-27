<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Enums;

enum BookingStatus: string
{
	case START = 'start';
	case ROOMS = 'rooms';
	case MEALS = 'meals';
	case BILLING = 'billing';
	case SUMMARY = 'summary';
	case PAYMENT = 'payment';
	case COMPLETED = 'completed';
	case FAILED = 'failed';
	case CANCELLED = 'cancelled';
	case REFUND_REQUESTED = 'refund_requested';
	case REFUNDED = 'refunded';
}
