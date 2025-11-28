<?php

namespace App\Data\Models;

use App\Data\BaseData;
use App\Models\Address;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "AddressData",
    required: ["id", "phone"]
)]
class AddressData extends BaseData
{
    public function __construct(
        #[OA\Property(property: "id", type: "integer", example: 1)]
        public int $id,

        #[OA\Property(property: "phone", type: "string", example: "+79991234567")]
        public string $phone,

        #[OA\Property(property: "address_text", type: "string", example: "г. Москва, ул. Ленина, д. 10")]
        public string $addressText,

        #[OA\Property(property: "apartment_number", type: "string", example: "25")]
        public ?string $apartmentNumber,

        #[OA\Property(property: "doorphone", type: "string", example: "25K1234")]
        public ?string $doorphone,

        #[OA\Property(property: "entrance", type: "string", example: "2")]
        public ?string $entrance,

        #[OA\Property(property: "floor", type: "string", example: "5")]
        public ?string $floor,
    ) {}

}