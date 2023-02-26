<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ isset($item) && $item->id ? __('github.editing_github') : __('github.creating_github') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("github.label") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('github.store', isset($item) && $item->id ?? null) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $item->name ?? '')" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="url" :value="__('Url')" />
            <x-text-input id="url" name="url" type="url" class="mt-1 block w-full" :value="old('url', $item->url ?? '')" required />
            <x-input-error class="mt-2" :messages="$errors->get('url')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ isset($item) && $item->id ? __('github.update') : __('github.create') }}</x-primary-button>

            @if (session('status') === 'github-created')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('github.created') }}</p>
            @endif

            @if (session('status') === 'github-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('github.updated') }}</p>
            @endif
        </div>
    </form>
</section>
