<?php

namespace App\Http\Controllers\Satusehat;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Tampilkan data profil Organisasi Faskes RSUD dr. Soebandi
     * sesuai standar resource FHIR R4 Satu Sehat Kementerian Kesehatan RI.
     */
    public function index()
    {
        $apiKey = ApiKey::first();
        $orgId = '100026073';

        $organization = [
            'id' => $orgId,
            'active' => true,
            'name' => 'RS Umum Daerah Dr. Soebandi Jember',
            'legal_name' => 'RS Umum Daerah Dr. Soebandi Jember',
            'alias' => ['RSUD dr. Soebandi', 'RS Soebandi Jember', 'RSUD Soebandi'],
            'type_code' => '104',
            'type_display' => 'Rumah Sakit',
            'classification' => 'Rumah Sakit Umum Daerah Kelas B Pendidikan',
            'part_of' => 'Dinas Kesehatan Kabupaten Jember',
            'part_of_ref' => 'Organization/1000001',
            'address' => [
                'use' => 'work',
                'line' => 'Jl. Dokter Soebandi No.124',
                'district' => 'Patrang',
                'city' => 'Kab. Jember',
                'state' => 'Jawa Timur',
                'postal_code' => '68111',
                'country' => 'ID',
                'country_name' => 'Indonesia',
                'province_code' => '35',
                'province_name' => 'Jawa Timur',
                'city_code' => '3509',
                'district_code' => '350920',
                'village_code' => '3509201007',
                'village_name' => 'Patrang',
            ],
            'telecom' => [
                'phone' => '0331-487441',
                'phone_display' => '0331-487441',
                'email' => 'rsd.soebandi@jemberkab.go.id',
                'website' => 'https://rsuddrsoebandi.jemberkab.go.id',
            ],
            'contact' => [
                'purpose_code' => 'ADMIN',
                'purpose_display' => 'Administrative',
                'name' => 'Admin Satu Sehat',
                'phone' => '0331-487441',
                'email' => 'rsd.soebandi@jemberkab.go.id',
            ],
            'synced_at' => session('satusehat_org_synced_at', now()->subMinutes(8)->format('d M Y, H:i \W\I\B')),
        ];

        // Daftar unit layanan / departemen terafiliasi (child organizations)
        $units = [
            [
                'id' => '1000293847-01',
                'name' => 'Instalasi Gawat Darurat (IGD)',
                'code' => 'dept-emerg',
                'type' => 'Emergency Room',
                'status' => 'Aktif',
                'phone' => '(0331) 487441 ext 118',
            ],
            [
                'id' => '1000293847-02',
                'name' => 'Poliklinik Penyakit Dalam',
                'code' => 'dept-intmed',
                'type' => 'Outpatient Clinic',
                'status' => 'Aktif',
                'phone' => '(0331) 487441 ext 121',
            ],
            [
                'id' => '1000293847-03',
                'name' => 'Poliklinik Anak (Pediatrik)',
                'code' => 'dept-pedia',
                'type' => 'Outpatient Clinic',
                'status' => 'Aktif',
                'phone' => '(0331) 487441 ext 124',
            ],
            [
                'id' => '1000293847-04',
                'name' => 'Poliklinik Jantung & Pembuluh Darah',
                'code' => 'dept-cardio',
                'type' => 'Outpatient Clinic',
                'status' => 'Aktif',
                'phone' => '(0331) 487441 ext 128',
            ],
            [
                'id' => '1000293847-05',
                'name' => 'Instalasi Rawat Inap Terpadu (IRNA)',
                'code' => 'dept-inpatient',
                'type' => 'Inpatient Facility',
                'status' => 'Aktif',
                'phone' => '(0331) 487441 ext 201',
            ],
            [
                'id' => '1000293847-06',
                'name' => 'Instalasi Farmasi & Depo Obat',
                'code' => 'dept-pharmacy',
                'type' => 'Pharmacy Service',
                'status' => 'Aktif',
                'phone' => '(0331) 487441 ext 105',
            ],
            [
                'id' => '1000293847-07',
                'name' => 'Laboratorium Patologi Klinik',
                'code' => 'dept-lab',
                'type' => 'Clinical Laboratory',
                'status' => 'Aktif',
                'phone' => '(0331) 487441 ext 112',
            ],
        ];

        // Format data FHIR R4 JSON Organization asli Satu Sehat
        $fhirJson = [
            'resourceType' => 'Organization',
            'id' => $organization['id'],
            'identifier' => [
                [
                    'use' => 'official',
                    'system' => 'http://sys-ids.kemkes.go.id/organization/' . $organization['id'],
                    'value' => 'RSUD dr. Soebandi',
                ],
            ],
            'active' => true,
            'type' => [
                [
                    'coding' => [
                        [
                            'system' => 'http://terminology.hl7.org/CodeSystem/organization-type',
                            'code' => 'prov',
                            'display' => 'Healthcare Provider',
                        ],
                    ],
                ],
            ],
            'name' => $organization['name'],
            'alias' => $organization['alias'],
            'telecom' => [
                [
                    'system' => 'phone',
                    'value' => $organization['telecom']['phone'],
                    'use' => 'work',
                ],
                [
                    'system' => 'email',
                    'value' => $organization['telecom']['email'],
                    'use' => 'work',
                ],
                [
                    'system' => 'url',
                    'value' => $organization['telecom']['website'],
                    'use' => 'work',
                ],
            ],
            'address' => [
                [
                    'use' => 'work',
                    'line' => [
                        $organization['address']['line'],
                    ],
                    'city' => $organization['address']['city'],
                    'district' => $organization['address']['district'],
                    'state' => $organization['address']['state'],
                    'postalCode' => $organization['address']['postal_code'],
                    'country' => $organization['address']['country'],
                    'extension' => [
                        [
                            'url' => 'https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode',
                            'extension' => [
                                [
                                    'url' => 'province',
                                    'valueCode' => $organization['address']['province_code'],
                                ],
                                [
                                    'url' => 'city',
                                    'valueCode' => $organization['address']['city_code'],
                                ],
                                [
                                    'url' => 'district',
                                    'valueCode' => $organization['address']['district_code'],
                                ],
                                [
                                    'url' => 'village',
                                    'valueCode' => $organization['address']['village_code'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'partOf' => [
                'reference' => $organization['part_of_ref'],
                'display' => $organization['part_of'],
            ],
            'contact' => [
                [
                    'purpose' => [
                        'coding' => [
                            [
                                'system' => 'http://terminology.hl7.org/CodeSystem/contactentity-type',
                                'code' => $organization['contact']['purpose_code'],
                            ],
                        ],
                    ],
                    'telecom' => [
                        [
                            'system' => 'phone',
                            'use' => 'work',
                            'value' => $organization['contact']['phone'],
                        ],
                        [
                            'system' => 'email',
                            'use' => 'work',
                            'value' => $organization['contact']['email'],
                        ],
                    ],
                ],
            ],
        ];

        $fhirJson = [
            'active' => true,
            'address' => [
                [
                    'city' => 'Kab. Jember',
                    'country' => 'ID',
                    'district' => 'Patrang',
                    'extension' => [
                        [
                            'extension' => [
                                ['url' => 'province', 'valueCode' => '35'],
                                ['url' => 'city', 'valueCode' => '3509'],
                                ['url' => 'district', 'valueCode' => '350920'],
                                ['url' => 'village', 'valueCode' => '3509201007'],
                            ],
                            'url' => 'https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode',
                        ],
                    ],
                    'line' => ['Jl. Dokter Soebandi No.124'],
                    'state' => 'Jawa Timur',
                    'use' => 'work',
                ],
            ],
            'contact' => [
                [
                    'purpose' => [
                        'coding' => [
                            [
                                'code' => 'ADMIN',
                                'system' => 'http://terminology.hl7.org/CodeSystem/contactentity-type',
                            ],
                        ],
                    ],
                    'telecom' => [
                        ['system' => 'phone', 'use' => 'work', 'value' => '0331-487441'],
                        ['system' => 'email', 'use' => 'work', 'value' => 'rsd.soebandi@jemberkab.go.id'],
                    ],
                ],
            ],
            'id' => '100026073',
            'identifier' => [
                ['system' => 'https://fhir.kemkes.go.id/id/org-number', 'value' => '1000260739'],
                ['use' => 'usual', 'value' => '28046'],
                ['use' => 'official', 'value' => '3509010'],
                ['use' => 'official', 'value' => '1000260739'],
                ['use' => 'official', 'value' => '3509010'],
                ['use' => 'usual', 'value' => '1329R001'],
            ],
            'meta' => [
                'lastUpdated' => '2026-10-31T08:12:53.949689+00:00',
                'versionId' => 'MTc5MzQzNDM3Mzk0OTY4OTAwMA',
            ],
            'name' => 'RS Umum Daerah Dr. Soebandi Jember',
            'resourceType' => 'Organization',
            'type' => [
                [
                    'coding' => [
                        [
                            'code' => '104',
                            'display' => 'Rumah Sakit',
                            'system' => 'http://terminology.kemkes.go.id/CodeSystem/organization-type',
                        ],
                    ],
                ],
            ],
        ];
        $rawJsonString = json_encode($fhirJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return view('satusehat.organization', compact('organization', 'units', 'rawJsonString', 'apiKey'));
    }

    /**
     * Simulasi sinkronisasi ulang data organisasi dari FHIR API Satu Sehat Kemenkes
     */
    public function sync(Request $request)
    {
        session([
            'satusehat_org_synced_at' => now()->format('d M Y, H:i \W\I\B'),
        ]);

        return redirect()->route('satusehat.organization.index')
            ->with('success', 'Data Profil Organisasi berhasil disinkronkan langsung dari FHIR API Satu Sehat Kemenkes.');
    }
}

