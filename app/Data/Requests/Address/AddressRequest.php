<?php

namespace App\Data\Requests\Address;

use App\Data\BaseData;
use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[OA\Schema(schema: "AddressRequest")]
class AddressRequest extends BaseData
{
    public function __construct(
        #[OA\Property(property: "phone", type: "string", example: "+79991234567")]
        #[Min(10),Max(30)]
        public string $phone,

        #[OA\Property(property: "address_text", type: "string", example: "г. Москва, ул. Ленина, д. 10")]
        #[Max(255)]
        #[MapInputName(SnakeCaseMapper::class)]
        public string $addressText,

        #[OA\Property(property: "apartment_number", type: "string", example: "25")]
        #[Max(20)]
        #[MapInputName(SnakeCaseMapper::class)]
        public ?string $apartmentNumber = null,

        #[OA\Property(property: "doorphone", type: "string", example: "25K1234")]
        #[Max(20)]
        public ?string $doorphone = null,

        #[OA\Property(property: "entrance", type: "string", example: "2")]
        #[Max(20)]
        public ?string $entrance = null,

        #[OA\Property(property: "floor", type: "string", example: "5")]
        #[Max(20)]
        public ?string $floor = null,
    ) {}
}