<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Member::create([
			'id' => 1,
			'name' => 'Pierluigi Pellizzer',
			'email' => 'pgpelz@libero.it',
		]);
		Member::create([
			'id' => 2,
			'name' => 'Simone Bertagni',
			'email' => 'awbertag@gmail.com',
		]);
		Member::create([
			'id' => 3,
			'name' => 'Riccardo Evangelisti',
			'email' => 'bosoco@gmail.com',
		]);
		Member::create([
			'id' => 5,
			'name' => 'Lorenzo Tortelli',
			'email' => 'zephyr2005@hotmail.it',
		]);
		Member::create([
			'id' => 6,
			'name' => 'Nicola Rossi',
			'email' => 'n.rossi1904@gmail.com',
		]);
		Member::create([
			'id' => 7,
			'name' => 'Christian Pilli',
			'email' => 'pillichristian128@gmail.com',
		]);
		Member::create([
			'id' => 8,
			'name' => 'Gian Marco Pennacchi',
			'email' => 'pennacchigian@gmail.com',
		]);
		Member::create([
			'id' => 9,
			'name' => 'Davide Bonini',
			'email' => 'davidebonini113@gmail.com',
		]);
		Member::create([
			'id' => 10,
			'name' => 'Niccolò Scatena',
			'email' => 'speedjack95@gmail.com',
		]);
		Member::create([
			'id' => 18,
			'name' => 'Donatella Vecchies',
			'email' => 'donatella.vecchies@libero.it',
		]);
		Member::create([
			'id' => 24,
			'name' => 'Alessandro Donati',
			'email' => 'adonati1982@gmail.com',
		]);
		Member::create([
			'id' => 33,
			'name' => 'Alessandra Salvi',
			'email' => 'ale.salvi23@gmail.com',
		]);
		Member::create([
			'id' => 36,
			'name' => 'Stefano Brunetti',
			'email' => 'stefanobrunetti@gmail.com',
		]);
		Member::create([
			'id' => 37,
			'name' => 'Lucia Cavani',
			'email' => 'lucia.cavani@hotmail.it',
		]);
		Member::create([
			'id' => 48,
			'name' => 'Alice Donati',
			'email' => 'alicedonati@blu.it',
		]);
		Member::create([
			'id' => 49,
			'name' => 'Marco Miele',
			'email' => 'marco.vulc2014@gmail.com',
		]);
		Member::create([
			'id' => 50,
			'name' => 'Flavio Conticello',
			'email' => 'flavio-conti@hotmail.it',
		]);
		Member::create([
			'id' => 51,
			'name' => 'Irene Petitto',
			'email' => 'irenepetitto@yahoo.it',
		]);
		Member::create([
			'id' => 56,
			'name' => 'Livio Biagioni',
			'email' => 'livio.biagioni@gmail.com',
		]);
	}
}
