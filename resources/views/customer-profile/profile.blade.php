@extends('layouts.standardpage')
@section('content')
    <h1 class="text-5xl font-bold text-center text-black">
        Profilo
    </h1>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            <x-form-section submit="">
                <x-slot name="title">
                    {{ __('Abbonamento') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Gestisci il tuo abbonamento.') }}
                </x-slot>

                <x-slot name="form">
                    <!-- Name -->
                    <div class="col-span-6 sm:col-span-4">
                        @php
                            $subscription = auth()->user()->subscription('default');
                        @endphp

                        <div class="p-6 bg-white rounded-lg shadow-lg max-w-md mx-auto">
                            <!--  -->
                            @if ($subscription && $subscription->onGracePeriod())
                                <p class="mb-4 text-yellow-700 font-semibold">
                                    Abbonamento cancellato, attivo fino al {{ $subscription->ends_at?->format('d/m/Y') }}
                                </p>

                            @elseif ($subscription && $subscription->active())
                                <p class="mb-4 text-green-700 font-semibold">
                                    Abbonamento attivo
                                    @if ($subscription->onTrial())
                                        , in prova fino al {{ $subscription->trial_ends_at?->format('d/m/Y') }}
                                    @endif

                                    @if ($subscription->ends_at)
                                        , termina il {{ $subscription->ends_at?->format('d/m/Y') }}
                                    @else
                                        @php
                                            $stripeSubscription = $subscription->asStripeSubscription();
                                        @endphp

                                        @if (!empty($stripeSubscription->current_period_end))
                                            , prossimo rinnovo il
                                            {{ \Carbon\Carbon::createFromTimestamp($stripeSubscription->current_period_end)->format('d/m/Y') }}
                                        @endif
                                    @endif
                                </p>

                                <!-- Pulsante per cancellare l'abbonamento -->
                                <button type="button" onclick="cancelSubscription()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                    Cancella abbonamento
                                </button>
                                <script>
                                    function cancelSubscription() {
                                        if (!confirm('Procedendo il tuo abbonamento verrà cancellato al termine del periodo già pagato. Vuoi confemrare?')) {
                                            return;
                                        }
                                        fetch("{{ route('subscription.cancel') }}", {
                                            method: "POST",
                                            headers: {
                                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                                "Accept": "application/json",
                                            },
                                        }).then(res => {
                                            if (res.ok) {
                                                window.location.reload();
                                            } else {
                                                alert('Errore durante la cancellazione.');
                                            }
                                        });
                                    }
                                </script>

                            @else
                                <p class="mb-4 text-gray-700 font-semibold">
                                    Nessun abbonamento attivo.
                                </p>

                                <!-- Pulsante per abbonarsi -->
                                <a href="{{ route('checkout') }}"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Abbonati ora
                                </a>
                            @endif
                            <!--  -->
                        </div>
                    </div>
                </x-slot>
            </x-form-section>

            <x-section-border />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
@endsection