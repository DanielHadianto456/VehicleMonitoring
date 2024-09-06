<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Approval Details') }} 
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('return.vehicle') }}">
                        @csrf

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <input type="text" name="fuel_usage">
                            </div>
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </form>
                    {{-- @foreach (App\Models\detailOrderModel::where('id_order', $id ) as $item)
                        {{$item}}
                    @endforeach --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>