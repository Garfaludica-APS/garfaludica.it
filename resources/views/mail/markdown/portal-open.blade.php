<x-mail::message :message="$message" :logoPath="$logoPath">
# {{ __('Le prenotazioni sono ora aperte!') }}

{{ __('Ciao!') }}

{{ __('Ricevi questa email in quanto hai chiesto di essere avvisato quando aprivano le prenotazioni per l\'evento GobCon 2025 Garfagnana. È arrivato il momento! Le prenotazioni sono adesso aperte!') }}

{{ __('Premi il pulsante qui sotto per iniziare la prenotazione, oppure visita gobcon.garfaludica.it') }}

<x-mail::button :url="$booking->getSignedUrl()">
    {{ __('Book Now!') }}
</x-mail::button>

{{ __('If the button does not work, copy and paste the following link in your browser\'s address bar: :link', ['link' => $booking->getSignedUrl()]) }}

{{ __('If you have any questions, please do not hesitate to contact us.') }}

{{ __('Thanks') }},

Garfaludica APS
</x-mail::message>
