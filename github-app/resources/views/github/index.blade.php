<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('github.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @if (empty($list))
                    <p>{{ __('github.no_entries_created') }}<a class="text-blue underline" href="/github/add">{{ __('github.add_new_repository') }}</a></p>
                    @else
                        <p><a class="text-blue underline" href="/github/add">{{ __('github.add_new_repository') }}</a></p>
                        <br/>
                        <table class="border-collapse table-auto w-full text-sm" style="width:100% !important;">
                            <thead>
                                <tr>
                                    <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-800 text-center">{{ __('github.ID') }}</th>
                                    <th width="200" class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-800 text-left">{{ __('github.Name') }}</th>
                                    <th width="300" class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-800 text-left">{{ __('github.Url') }}</th>
                                    <th width="150" class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-800 text-right">{{ __('github.Operations') }}</th>
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
                                            {{ __('github.Edit') }}
                                        </a>

                                        <form action="{{ route('github.remove', ['id' => $item->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-red">{{ __('github.Delete') }}</button>
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
