<?php

namespace App\Services;

use App\Data\Requests\Address\AddressRequest;
use App\Data\Requests\Cart\AddItemData;
use App\Data\Requests\Cart\UpdateItemQuantityData;
use App\Exceptions\CartEmptyException;
use App\Exceptions\InsufficientStockException;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AddressService
{

    /**
     * Получение адресов пользователя
     * 
     * @return Collection
     */
    public function getUserAddresses(): Collection
    {
        $userId = Auth::id();

        return Address::where('user_id', $userId)->get();
    }

    /**
     * Создание адреса
     * 
     * @param AddressRequest $data
     * 
     * @return Address
     */
    public function storeAddress(AddressRequest $data): Address
    {
        return Address::create([
            'user_id' => Auth::id(),
            'phone' => $data->phone,
            'address_text' => $data->addressText,
            'apartment_number' => $data->apartmentNumber,
            'doorphone' => $data->doorphone,
            'entrance' => $data->entrance,
            'floor' => $data->floor,
        ]);
    }
    
    /**
     * Обновление адреса
     * 
     * @param AddressRequest $data
     * @param int $addressId
     * 
     * @return Address
     */
    public function updateAddress(AddressRequest $data, int $addressId): Address
    {
        $address = Address::where('user_id', Auth::id())
            ->where('id', $addressId)
            ->firstOrFail();

        $address->update([
            'user_id' => Auth::id(),
            'phone' => $data->phone,
            'address_text' => $data->addressText,
            'apartment_number' => $data->apartmentNumber,
            'doorphone' => $data->doorphone,
            'entrance' => $data->entrance,
            'floor' => $data->floor,
        ]);

        return $address;
    }

    /**
     * Удаление адреса
     * 
     * @param int $addressId
     * 
     * @return bool
     */
    public function deleteAddress(int $addressId): bool
    {
        $address = Address::where('user_id', Auth::id())
            ->where('id', $addressId)
            ->firstOrFail();

        return $address->delete();
    }
    
}