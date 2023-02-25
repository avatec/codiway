<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Github') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    {{-- @include('profile.partials.update-profile-information-form') --}}
                    @if (empty($list))
                    <p>Nie utworzono jeszcze wpisów. Kliknij <a class="text-blue underline" href="/github/add">tutaj, aby utworzyć pierwszy</a></p>
                    @else
                        <p>Kliknij <a class="text-blue underline" href="/github/add">tutaj, aby utworzyć kolejny wpis</a></p>
                        <br/>
                        <table class="border-collapse table-auto w-full text-sm" style="width:100% !important;">
                            <thead>
                                <tr>
                                    <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-800 text-center">ID</th>
                                    <th width="200" class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-800 text-left">Name</th>
                                    <th width="300" class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-800 text-left">Url</th>
                                    <th width="150" class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-800 text-right">Operacje</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-100">
                            @foreach ($list as $item)
                                <tr class="dark:border-slate-700text-slate-500 dark:text-slate-700">
                                    <td class="p-4 pl-8">{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->url }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('github.show', ['id' => $item->id]) }}" class="btn btn-blue">
                                            {{ __('Edit') }}
                                        </a>

                                        <form action="{{ route('github.remove', ['id' => $item->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red">Delete</button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
