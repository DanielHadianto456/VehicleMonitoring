<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vehicle List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach (App\Models\vehicleModel::get() as $item)
                        <div class="" style="padding: 1px">
                            <div
                                class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <a href="#">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        {{ $item->name }} </h5>
                                </a>
                                {{-- <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest</p> --}}
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">License: {{$item->license}}</p>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Ownership: {{$item->owner}}</p>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">type: {{$item->type}}</p>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Status: {{$item->status}}</p>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Service Date: {{$item->service_date}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
