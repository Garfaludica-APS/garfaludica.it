<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Enums;

enum MealType: string
{
	case BREAKFAST = 'breakfast';
	case LUNCH = 'lunch';
	case DINNER = 'dinner';
}
