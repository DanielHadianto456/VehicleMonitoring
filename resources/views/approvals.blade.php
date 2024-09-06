<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Approval') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach (App\Models\ordersModel::with(['driverDetails', 'vehicleDetails', 'approverDetails'])->get() as $item)
                        <div class="" style="padding: 1px">
                            <div
                                class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <a href="#">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        Approval Request</h5>
                                </a>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Admin consent status:
                                    {{ $item->admin_consent }}
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Approver consent status:
                                    {{ $item->approver_consent }}
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Nama Driver:
                                    {{ $item->driverDetails->name }}
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Nama Kendaraan:
                                    {{ $item->vehicleDetails->name }}
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Nama penyetuju:
                                    {{ $item->approverDetails->name }}
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Status Driver:
                                    {{ $item->driverDetails->status }}
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Status Kendaraan:
                                    {{ $item->vehicleDetails->status }}

                                </p>

                                @if ($item->admin_consent === 'pending' || $item->approver_consent === 'pending')
                                    @if (Auth::user()->role === 'admin')
                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('approve-form-{{ $item->id_order }}').submit();"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Approve
                                        </a>

                                        <form id="approve-form-{{ $item->id_order }}"
                                            action="{{ route('admin.approve', $item->id_order) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                        </form>
                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('disapprove-form-{{ $item->id_order }}').submit();"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Disapprove
                                        </a>

                                        <form id="disapprove-form-{{ $item->id_order }}"
                                            action="{{ route('admin.disapprove', $item->id_order) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                        </form>
                                    @else
                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('approve-form-{{ $item->id_order }}').submit();"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Approve
                                        </a>

                                        <form id="approve-form-{{ $item->id_order }}"
                                            action="{{ route('approver.aprrove', $item->id_order) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                        </form>
                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('disapprove-form-{{ $item->id_order }}').submit();"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Disapprove
                                        </a>

                                        <form id="disapprove-form-{{ $item->id_order }}"
                                            action="{{ route('approver.disapprove', $item->id_order) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('PATCH')
                                        </form>
                                    @endif
                                @elseif($item->admin_consent === 'approved' && $item->approver_consent === 'approved')
                                    <x-nav-link :href="route('detailItem', $item->id_order)"  style="color: white;">See Details</x-nav-link>
                                @else
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
