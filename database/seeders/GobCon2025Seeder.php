<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace Database\Seeders;

use App\Enums\MealType;
use App\Enums\Menu;
use App\Models\Hotel;
use Illuminate\Database\Seeder;

class GobCon2025Seeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$hotels = Hotel::all();
		$isera = null;
		$panoramic = null;

		foreach ($hotels as $hotel) {
			switch ($hotel->name) {
				case 'Panoramic Hotel':
					$this->seedPanoramicRooms($hotel);
					$panoramic = $hotel;
					break;
				case 'Isera Refuge':
					$this->seedIseraRooms($hotel);
					$isera = $hotel;
					break;
				case 'Braccicorti Farmhouse':
					$this->seedBraccicortiRooms($hotel);
					break;
				default:
					throw new \Exception('Invalid hotel');
			}
			$hotel->meals()->create([
				'type' => MealType::BREAKFAST,
				'menu' => Menu::STANDARD,
				'price' => 0.0,
				'meal_time' => '08:00',
				'reservable' => false,
			]);
		}
		$this->seedLunches($isera);
		$this->seedDinners($panoramic);
	}

	private function seedPanoramicRooms(Hotel $hotel): void
	{
		$hotel->rooms()->create([
			'name' => [
				'en' => 'Double room',
				'it' => 'Camera matrimoniale',
			],
			'description' => [
				'en' => 'Room with double bed, for one or two people (select the right option). The room has a private bathroom. Includes breakfast and dinner.',
				'it' => 'Camera con letto matrimoniale, per una o due persone (selezionare l\'opzione giusta). La camera dispone di bagno privato. Include colazione e cena.',
			],
			'checkin_time' => '16:00',
			'checkout_time' => '11:00',
			'quantity' => 10,
			'buy_options' => [
				[
					'en' => 'FOR A SINGLE PERSON',
					'it' => 'PER UNA PERSONA',
					'people' => 1,
					'price' => 80.0,
					'included_meals' => [
						MealType::BREAKFAST,
						MealType::DINNER,
					],
				],
				[
					'en' => 'default',
					'it' => 'default',
					'people' => 2,
					'price' => 120.0,
					'included_meals' => [
						MealType::BREAKFAST,
						MealType::DINNER,
					],
				],
			],
		]);

		$hotel->rooms()->create([
			'name' => [
				'en' => 'Triple room',
				'it' => 'Camera tripla',
			],
			'description' => [
				'en' => 'Room with one double bed and one single bed, for three people (reservable also by two people: select correct option). The room has a private bathroom. Includes breakfast and dinner.',
				'it' => 'Camera con un letto matrimoniale e uno singolo, per tre persone (riservabile anche da due persone: selezionare l\'opzione corretta). La camera dispone di bagno privato. Include colazione e cena.',
			],
			'checkin_time' => '16:00',
			'checkout_time' => '11:00',
			'quantity' => 5,
			'buy_options' => [
				[
					'en' => 'default',
					'it' => 'default',
					'people' => 3,
					'price' => 165.0,
					'included_meals' => [
						MealType::BREAKFAST,
						MealType::DINNER,
					],
				],
				[
					'en' => 'FOR TWO PEOPLE',
					'it' => 'PER DUE PERSONE',
					'people' => 2,
					'price' => 130.0,
					'included_meals' => [
						MealType::BREAKFAST,
						MealType::DINNER,
					],
				],
			],
		]);

		$hotel->rooms()->create([
			'name' => [
				'en' => 'Quadruple room',
				'it' => 'Camera quadrupla',
			],
			'description' => [
				'en' => 'Room with one double bed and two single beds, for four people. The room has a private bathroom. Includes breakfast and dinner.',
				'it' => 'Camera con un letto matrimoniale e due letti singoli, per quattro persone. La camera dispone di bagno privato. Include colazione e cena.',
			],
			'checkin_time' => '16:00',
			'checkout_time' => '11:00',
			'quantity' => 8,
			'buy_options' => [
				[
					'en' => 'default',
					'it' => 'default',
					'people' => 4,
					'price' => 200.0,
					'included_meals' => [
						MealType::BREAKFAST,
						MealType::DINNER,
					],
				],
			],
		]);

		$hotel->rooms()->create([
			'name' => [
				'en' => 'Apartment for 3 people',
				'it' => 'Appartamento con 3 posti letto',
			],
			'description' => [
				'en' => 'Apartment with one double bed and one single bed, for three people (reservable also by two people: select correct option). Includes breakfast and dinner.',
				'it' => 'Appartamento a pochi passi dall\'hotel con un letto matrimoniale e un letto singolo, per tre persone (riservabile anche da due persone: selezionare l\'opzione corretta). Include colazione e cena.',
			],
			'checkin_time' => '16:00',
			'checkout_time' => '11:00',
			'quantity' => 2,
			'buy_options' => [
				[
					'en' => 'default',
					'it' => 'default',
					'people' => 3,
					'price' => 165.0,
					'included_meals' => [
						MealType::BREAKFAST,
						MealType::DINNER,
					],
				],
				[
					'en' => 'FOR TWO PEOPLE',
					'it' => 'PER DUE PERSONE',
					'people' => 2,
					'price' => 130.0,
					'included_meals' => [
						MealType::BREAKFAST,
						MealType::DINNER,
					],
				],
			],
		]);

		$hotel->rooms()->create([
			'name' => [
				'en' => 'Apartment for 4 people',
				'it' => 'Appartamento con 4 posti letto',
			],
			'description' => [
				'en' => 'Apartment with two double beds, for four people (reservable also by three people: select correct option). Includes breakfast and dinner.',
				'it' => 'Appartamento a pochi passi dall\'hotel con due letti matrimoniali, per quattro persone (riservabile anche da tre persone: selezionare l\'opzione corretta). Include colazione e cena.',
			],
			'checkin_time' => '16:00',
			'checkout_time' => '11:00',
			'quantity' => 3,
			'buy_options' => [
				[
					'en' => 'default',
					'it' => 'default',
					'people' => 4,
					'price' => 200.0,
					'included_meals' => [
						MealType::BREAKFAST,
						MealType::DINNER,
					],
				],
				[
					'en' => 'FOR THREE PEOPLE',
					'it' => 'PER TRE PERSONE',
					'people' => 3,
					'price' => 180.0,
					'included_meals' => [
						MealType::BREAKFAST,
						MealType::DINNER,
					],
				],
			],
		]);

		$hotel->rooms()->create([
			'name' => [
				'en' => 'Apartment for 6 people',
				'it' => 'Appartamento con 6 posti letto',
			],
			'description' => [
				'en' => 'Apartment with two double bed and two single beds, for six people (also reservable by five people: select correct option). Includes breakfast and dinner.',
				'it' => 'Appartamento a pochi passi dall\'hotel con due letti matrimoniali e due letti singoli, per sei persone (prenotabile anche da 5 persone: scegliere l\'opzione giusta). Include colazione e cena.',
			],
			'checkin_time' => '16:00',
			'checkout_time' => '11:00',
			'quantity' => 1,
			'buy_options' => [
				[
					'en' => 'default',
					'it' => 'default',
					'people' => 6,
					'price' => 300.0,
					'included_meals' => [
						MealType::BREAKFAST,
						MealType::DINNER,
					],
				],
				[
					'en' => 'FOR FIVE PEOPLE',
					'it' => 'PER CINQUE PERSONE',
					'people' => 5,
					'price' => 300.0,
					'included_meals' => [
						MealType::BREAKFAST,
						MealType::DINNER,
					],
				],
			],
		]);
	}

	private function seedIseraRooms(Hotel $hotel): void
	{
		$hotel->rooms()->create([
			'name' => [
				'en' => 'Tent',
				'it' => 'Tenda',
			],
			'description' => [
				'en' => 'Place for the tent for one person. The Isera Refuge has a large equipped meadow where you can camp. Tent NOT included. The price is per person, regardless of the number of tents: specify the number of people. Includes breakfast.',
				'it' => 'Posto tenda, per una persona. Il Rifugio Isera dispone di un ampio prato attrezzato nel quale è possibile accamparsi. Tenda NON inclusa. Il prezzo è a persona, indipendentemente dal numero di tende: specificare il numero di persone. Include colazione.',
			],
			'checkin_time' => '16:00',
			'checkout_time' => '11:00',
			'quantity' => 100,
			'buy_options' => [
				[
					'en' => 'default',
					'it' => 'default',
					'people' => 0,
					'price' => 15.0,
					'included_meals' => [
						MealType::BREAKFAST,
					],
				],
			],
		]);
	}

	private function seedBraccicortiRooms(Hotel $hotel): void
	{
		$hotel->rooms()->create([
			'name' => [
				'en' => 'Double room',
				'it' => 'Camera matrimoniale',
			],
			'description' => [
				'en' => 'Room with double bed, for one or two people (select the right option). The room has a private bathroom. Access to the pool is included. Includes breakfast.',
				'it' => 'Camera con letto matrimoniale, per una o due persone (selezionare l\'opzione giusta). La camera dispone di bagno privato. L\'accesso alla piscina è incluso. Include colazione.',
			],
			'checkin_time' => '16:00',
			'checkout_time' => '11:00',
			'quantity' => 4,
			'buy_options' => [
				[
					'en' => 'FOR A SINGLE PERSON',
					'it' => 'PER UNA PERSONA',
					'people' => 1,
					'price' => 80.0,
					'included_meals' => [
						MealType::BREAKFAST,
					],
				],
				[
					'en' => 'default',
					'it' => 'default',
					'people' => 2,
					'price' => 94.0,
					'included_meals' => [
						MealType::BREAKFAST,
					],
				],
			],
		]);

		$hotel->rooms()->create([
			'name' => [
				'en' => 'Apartment for 3 people',
				'it' => 'Appartamento per 3 persone',
			],
			'description' => [
				'en' => 'Apartment with a double bed and a single bed, for three people. The apartment has a kitchen. Access to the pool is included. DOES NOT include breakfast.',
				'it' => 'Appartamento con letto matrimoniale e letto singolo, per tre persone. L\'appartamento dispone di cucina. L\'accesso alla piscina è incluso. NON include colazione.',
			],
			'checkin_time' => '16:00',
			'checkout_time' => '11:00',
			'quantity' => 2,
			'buy_options' => [
				[
					'en' => 'default',
					'it' => 'default',
					'people' => 3,
					'price' => 110.0,
					'included_meals' => [
					],
				],
			],
		]);
	}

	private function seedDinners(Hotel $hotel): void
	{
		$hotel->meals()->create([
			'type' => MealType::DINNER,
			'menu' => Menu::STANDARD,
			'price' => 20.0,
			'meal_time' => '20:00',
			'reservable' => true,
		]);

		$hotel->meals()->create([
			'type' => MealType::DINNER,
			'menu' => Menu::VEGETARIAN,
			'price' => 20.0,
			'meal_time' => '20:00',
			'reservable' => true,
		]);

		$hotel->meals()->create([
			'type' => MealType::DINNER,
			'menu' => Menu::VEGAN,
			'price' => 20.0,
			'meal_time' => '20:00',
			'reservable' => true,
		]);
	}

	private function seedLunches(Hotel $hotel): void
	{
		$hotel->meals()->create([
			'type' => MealType::LUNCH,
			'menu' => Menu::STANDARD,
			'price' => 20.0,
			'meal_time' => '13:00',
			'reservable' => true,
		]);

		$hotel->meals()->create([
			'type' => MealType::LUNCH,
			'menu' => Menu::VEGETARIAN,
			'price' => 20.0,
			'meal_time' => '13:00',
			'reservable' => true,
		]);

		$hotel->meals()->create([
			'type' => MealType::LUNCH,
			'menu' => Menu::VEGAN,
			'price' => 20.0,
			'meal_time' => '13:00',
			'reservable' => true,
		]);
	}
}
