<?php

namespace App\Http\Controllers\Admin\Schools;

use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;

class SchoolAddressController extends Controller
{
    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepo;
    /**
     * @var CountryRepositoryInterface
     */
    private $countryRepo;
    /**
     * @var ProvinceRepositoryInterface
     */
    private $provinceRepo;

    /**
     * SchoolAddressController constructor.
     * @param AddressRepositoryInterface $addressRepository
     * @param CountryRepositoryInterface $countryRepository
     * @param ProvinceRepositoryInterface $provinceRepository
     */
    public function __construct(
        AddressRepositoryInterface $addressRepository,
        CountryRepositoryInterface $countryRepository,
        ProvinceRepositoryInterface $provinceRepository
    ) {
        $this->addressRepo = $addressRepository;
        $this->countryRepo = $countryRepository;
        $this->provinceRepo = $provinceRepository;
    }

    /**
     * Show the school's address
     *
     * @param int $schoolId
     * @param int $addressId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $schoolId, int $addressId)
    {
        return view('admin.addresses.schools.show', [
            'address' => $this->addressRepo->findAddressById($addressId),
            'schoolId' => $schoolId
        ]);
    }

    /**
     * Show the edit form
     *
     * @param int $schoolId
     * @param int $addressId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $schoolId, int $addressId)
    {
        $this->countryRepo->findCountryById(env('COUNTRY_ID', 1));
        $province = $this->provinceRepo->findProvinceById(1);

        return view('admin.addresses.schools.edit', [
            'address' => $this->addressRepo->findAddressById($addressId),
            'countries' => $this->countryRepo->listCountries(),
            'provinces' => $this->countryRepo->findProvinces(),
            'cities' => $this->provinceRepo->listCities($province->id),
            'schoolId' => $schoolId
        ]);
    }
}
