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
                    <form method="POST" action="{{ route('add.detail') }}">
                        @csrf

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <input-label for="id_order" :value="__('Select Vehicle')" />
                                <select id="id_order" name="id_order" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach (App\Models\detailOrderModel::get() as $detail)
                                        <option value="{{ $detail->id_order }}">{{ $detail->id_order }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <input-label for="id_order" :value="__('Select Vehicle')" />
                                <input type="text" name="fuel_usage" class="block mt-1 w-full">
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