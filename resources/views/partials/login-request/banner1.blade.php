<div class="bg-yellow-100 border border-yellow-300 text-yellow-800 p-4 rounded-lg mb-6 text-center">
        <p class="font-semibold">🔒 Accedi per poter visualizzare i contenuti</p>
        <p class="text-sm">Accedi o registrati per visualizzare questo contenuto.</p>
        <div class="mt-3 flex justify-center gap-3">
            <a href="{{ route('login') }}" class="bg-primary text-white px-4 py-2 rounded-full hover:bg-primary/80">
                Accedi
            </a>
            <a href="{{ route('register') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-full hover:bg-gray-300">
                Registrati
            </a>
        </div>
    </div>