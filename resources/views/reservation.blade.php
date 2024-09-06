<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Place Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('order.create') }}">
                        @csrf

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <input-label for="id_vehicle" :value="__('Select Vehicle')" />
                                <select id="id_vehicle" name="id_vehicle" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach (App\Models\vehicleModel::where('status', 'unassigned')->get() as $vehicle)
                                        <option value="{{ $vehicle->id_vehicle }}">{{ $vehicle->license }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <input-label for="id_driver" :value="__('Select Driver')" />
                                <select id="id_driver" name="id_driver" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach (App\Models\driverModel::where('status', 'unassigned')->get() as $driver)
                                        <option value="{{ $driver->id_driver }}">{{ $driver->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <input-label for="id_user" :value="__('Select Approver')" />
                                <select id="id_user" name="id_user" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach (App\Models\userModel::where('role', 'approver')->get() as $user)
                                        <option value="{{ $user->id_user }}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

