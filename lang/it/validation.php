<?php

declare(strict_types=1);

/*
 * Copyright © 2025 - Garfaludica APS - MIT License
 */

return [
	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	 */

	'accepted' => ':Attribute deve essere accettato.',
	'accepted_if' => ':Attribute deve essere accettato quando :other è :value.',
	'active_url' => ':Attribute non è un URL valido.',
	'after' => 'The :Attribute deve essere una data successiva al :date.',
	'after_or_equal' => ':Attribute deve essere una data successiva o uguale al :date.',
	'alpha' => ':Attribute può contenere solo lettere.',
	'alpha_dash' => ':Attribute può contenere solo lettere, numeri e trattini.',
	'alpha_num' => ':Attribute può contenere solo lettere e numeri.',
	'array' => ':Attribute deve essere un array.',
	'ascii' => ':Attribute deve contenere solo caratteri alfanumerici single-byte e simboli.',
	'before' => ':Attribute deve essere una data precedente al :date.',
	'before_or_equal' => ':Attribute deve essere una data precedente o uguale al :date.',
	'between' => [
		'array' => ':Attribute deve avere tra :min - :max elementi.',
		'file' => ':Attribute deve trovarsi tra :min - :max kilobyte.',
		'numeric' => ':Attribute deve trovarsi tra :min - :max.',
		'string' => ':Attribute deve trovarsi tra :min - :max caratteri.',
	],
	'boolean' => 'Il campo :attribute deve essere vero o falso.',
	'can' => 'Il campo :attribute contiene un valore non autorizzato.',
	'confirmed' => 'Il campo di conferma per :attribute non coincide.',
	'contains' => 'Il campo :attribute non contiene un valore richiesto.',
	'current_password' => 'Password non valida.',
	'date' => ':Attribute non è una data valida.',
	'date_equals' => ':Attribute deve essere una data e uguale a :date.',
	'date_format' => ':Attribute non coincide con il formato :format.',
	'decimal' => ':Attribute deve avere :decimal cifre decimali.',
	'declined' => ':Attribute deve essere rifiutato.',
	'declined_if' => ':Attribute deve essere rifiutato quando :other è :value.',
	'different' => ':Attribute e :other devono essere differenti.',
	'digits' => ':Attribute deve essere di :digits cifre.',
	'digits_between' => ':Attribute deve essere tra :min e :max cifre.',
	'dimensions' => 'Le dimensioni dell\'immagine di :attribute non sono valide.',
	'distinct' => ':Attribute contiene un valore duplicato.',
	'doesnt_end_with' => ':Attribute non può terminare con uno dei seguenti valori: :values.',
	'doesnt_start_with' => ':Attribute non può iniziare con uno dei seguenti valori: :values.',
	'email' => ':Attribute deve essere un indirizzo email valido.',
	'ends_with' => ':Attribute deve finire con uno dei seguenti valori: :values.',
	'enum' => 'Il campo :attribute non è valido.',
	'exists' => ':Attribute selezionato non è valido.',
	'extensions' => 'Il campo :attribute deve avere una delle seguenti estensioni: :values.',
	'file' => ':Attribute deve essere un file.',
	'filled' => 'Il campo :attribute deve contenere un valore.',
	'gt' => [
		'array' => ':Attribute deve contenere più di :value elementi.',
		'file' => ':Attribute deve essere maggiore di :value kilobyte.',
		'numeric' => ':Attribute deve essere maggiore di :value.',
		'string' => ':Attribute deve contenere più di :value caratteri.',
	],
	'gte' => [
		'array' => ':Attribute deve contenere un numero di elementi uguale o maggiore di :value.',
		'file' => ':Attribute deve essere uguale o maggiore di :value kilobyte.',
		'numeric' => ':Attribute deve essere uguale o maggiore di :value.',
		'string' => ':Attribute deve contenere un numero di caratteri uguale o maggiore di :value.',
	],
	'hex_color' => 'Il campo :attribute deve essere un colore esadecimale valido.',
	'image' => ':Attribute deve essere un\'immagine.',
	'in' => ':Attribute selezionato non è valido.',
	'in_array' => 'Il valore del campo :attribute non esiste in :other.',
	'integer' => ':Attribute deve essere un numero intero.',
	'ip' => ':Attribute deve essere un indirizzo IP valido.',
	'ipv4' => ':Attribute deve essere un indirizzo IPv4 valido.',
	'ipv6' => ':Attribute deve essere un indirizzo IPv6 valido.',
	'json' => ':Attribute deve essere una stringa JSON valida.',
	'list' => 'Il campo :attribute deve essere un elenco.',
	'lowercase' => ':Attribute deve contenere solo caratteri minuscoli.',
	'lt' => [
		'array' => ':Attribute deve contenere meno di :value elementi.',
		'file' => ':Attribute deve essere minore di :value kilobyte.',
		'numeric' => ':Attribute deve essere minore di :value.',
		'string' => ':Attribute deve contenere meno di :value caratteri.',
	],
	'lte' => [
		'array' => ':Attribute deve contenere un numero di elementi minore o uguale a :value.',
		'file' => ':Attribute deve essere minore o uguale a :value kilobyte.',
		'numeric' => ':Attribute deve essere minore o uguale a :value.',
		'string' => ':Attribute deve contenere un numero di caratteri minore o uguale a :value.',
	],
	'mac_address' => 'Il campo :attribute deve essere un indirizzo MAC valido.',
	'max' => [
		'array' => ':Attribute non può avere più di :max elementi.',
		'file' => ':Attribute non può essere superiore a :max kilobyte.',
		'numeric' => ':Attribute non può essere superiore a :max.',
		'string' => ':Attribute non può contenere più di :max caratteri.',
	],
	'max_digits' => ':Attribute non può contenere più di :max cifre.',
	'mimes' => ':Attribute deve essere del tipo: :values.',
	'mimetypes' => ':Attribute deve essere un file di uno dei seguenti tipi: :values.',
	'min' => [
		'array' => ':Attribute deve avere almeno :min elementi.',
		'file' => ':Attribute deve essere almeno di :min kilobyte.',
		'numeric' => ':Attribute deve essere almeno :min.',
		'string' => ':Attribute deve contenere almeno :min caratteri.',
	],
	'min_digits' => ':Attribute deve contenere almeno :min cifre.',
	'missing' => 'Il campo :attribute deve mancare.',
	'missing_if' => 'Il campo :attribute deve mancare quando :other è :value.',
	'missing_unless' => 'Il campo :attribute deve mancare a meno che :other non sia :value.',
	'missing_with' => 'Il campo :attribute deve mancare quando è presente :values.',
	'missing_with_all' => 'Il campo :attribute deve mancare quando sono presenti :values.',
	'multiple_of' => ':Attribute deve essere un multiplo di :value.',
	'not_in' => 'Il valore selezionato per :attribute non è valido.',
	'not_regex' => 'Il formato di :attribute non è valido.',
	'numeric' => ':Attribute deve essere un numero.',
	'password' => [
		'letters' => ':Attribute deve contenere almeno un carattere.',
		'mixed' => ':Attribute deve contenere almeno un carattere maiuscolo ed un carattere minuscolo.',
		'numbers' => ':Attribute deve contenere almeno un numero.',
		'symbols' => ':Attribute deve contenere almeno un simbolo.',
		'uncompromised' => ':Attribute è presente negli archivi dei dati trafugati. Per favore scegli un valore differente per :attribute.',
	],
	'present' => 'Il campo :attribute deve essere presente.',
	'present_if' => 'Il campo :attribute deve essere presente quando :other è :value.',
	'present_unless' => 'Il campo :attribute deve essere presente a meno che :other non sia :value.',
	'present_with' => 'Il campo :attribute deve essere presente quando è presente :values.',
	'present_with_all' => 'Il campo :attribute deve essere presente quando sono presenti :values.',
	'prohibited' => ':Attribute non consentito.',
	'prohibited_if' => ':Attribute non consentito quando :other è :value.',
	'prohibited_unless' => ':Attribute non consentito a meno che :other sia contenuto in :values.',
	'prohibits' => ':Attribute impedisce a :other di essere presente.',
	'regex' => 'Il formato del campo :attribute non è valido.',
	'required' => 'Il campo :attribute è obbligatorio.',
	'required_array_keys' => 'Il campo :attribute deve contenere voci per: :values.',
	'required_if' => 'Il campo :attribute è obbligatorio quando :other è :value.',
	'required_if_accepted' => ':Attribute è obbligatorio quando :other è accettato.',
	'required_if_declined' => ':Attribute è obbligatorio quando :other è rifiutato.',
	'required_unless' => 'Il campo :attribute è obbligatorio a meno che :other sia in :values.',
	'required_with' => 'Il campo :attribute è obbligatorio quando :values è presente.',
	'required_with_all' => 'Il campo :attribute è obbligatorio quando :values sono presenti.',
	'required_without' => 'Il campo :attribute è obbligatorio quando :values non è presente.',
	'required_without_all' => 'Il campo :attribute è obbligatorio quando nessuno di :values è presente.',
	'same' => ':Attribute e :other devono coincidere.',
	'size' => [
		'array' => ':Attribute deve contenere :size elementi.',
		'file' => ':Attribute deve essere :size kilobyte.',
		'numeric' => ':Attribute deve essere :size.',
		'string' => ':Attribute deve contenere :size caratteri.',
	],
	'starts_with' => ':Attribute deve iniziare con uno dei seguenti: :values.',
	'string' => ':Attribute deve essere una stringa.',
	'timezone' => ':Attribute deve essere una zona di fuso orario valida.',
	'unique' => ':Attribute è stato già utilizzato.',
	'uploaded' => ':Attribute non è stato caricato.',
	'uppercase' => ':Attribute deve contenere solo caratteri maiuscoli.',
	'url' => 'Il campo :attribute deve essere un URL valido.',
	'ulid' => ':Attribute deve essere un ULID valido.',
	'uuid' => ':Attribute deve essere un UUID valido.',

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	 */

	'custom' => [
		'attribute-name' => [
			'rule-name' => 'custom-message',
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap our attribute placeholder
	| with something more reader friendly such as "E-Mail Address" instead
	| of "email". This simply helps us make our message more expressive.
	|
	 */

	'attributes' => [],
];
