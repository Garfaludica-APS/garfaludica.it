<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Response;

class WebsiteUnderConstruction extends Controller
{
	/**
	 * Handle the incoming request.
	 */
	public function __invoke(Request $request): Response
	{
		return inertia('WebsiteUnderConstruction', [
			'certifiedEmailAddress' => 'garfaludica@pec.it',
			'councillorsInfo' => [
				[
					'name' => 'Riccardo Evangelisti',
					'url' => route('external.telegram.cannibalsmith'),
				],
				[
					'name' => 'Pierluigi Pellizzer',
					'url' => route('external.telegram.picarus'),
				],
			],
			'documents' => [
				[
					'name' => 'Memorandum of Association',
					'url' => Storage::url('documents/atto-costitutivo.pdf'),
				],
				[
					'name' => 'Articles of Association',
					'url' => Storage::url('documents/statuto.pdf'),
				],
				[
					'name' => 'Balance Sheet 2023',
					'url' => Storage::url('documents/bilancio-2023.pdf'),
				],
				[
					'name' => 'Balance Sheet 2024',
					'url' => Storage::url('documents/bilancio-2024.pdf'),
				],
			],
			'donateButtonId' => 'L3DCXJMNXM3PS',
			'emailAddress' => 'info@garfaludica.it',
			'iban' => 'IT46L0503470130000000003246',
			'licenseUrl' => Storage::url('documents/LICENSE.txt'),
			'logoAicsUrl' => asset('storage/images/aics-logo.png'),
			'logoFederludoUrl' => asset('storage/images/federludo-affiliate-logo.png'),
			'logoTdgUrl' => asset('storage/images/hotlink-ok/tdg-castelnuovo-garfagnana-logo.png'),
			'logoUrl' => asset('storage/images/hotlink-ok/garfaludica-logo.png'),
			'slideshowImages' => collect(Storage::disk('public')->files('images/slideshow'))->map(fn($image) => asset('storage/' . $image)),
			'officeAddress' => 'Località Braccicorti, 38/A - 55036 Pieve Fosciana (LU)',
			'presidentInfo' => [
				'name' => 'Christian Pilli',
				'phone' => '+393247460610',
				'url' => route('external.telegram.president'),
			],
			'privacyEmailAddress' => 'privacy@garfaludica.it',
			'runtsArchiveNumber' => 113019,
			'runtsDate' => '2023-06-19',
			'secretaryInfo' => [
				'name' => 'Niccolò Scatena',
				'phone' => '+393314432124',
				'url' => route('external.telegram.secretary'),
			],
			'taxIdCode' => '90011570463',
			'telephoneNumber' => '+393247460610',
			'vicePresidentInfo' => [
				'name' => 'Simone Bertagni',
				'url' => route('external.telegram.vicepresident'),
			],
		]);
	}
}
