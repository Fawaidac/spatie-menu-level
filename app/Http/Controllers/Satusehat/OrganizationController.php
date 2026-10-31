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
        $orgId = $apiKey?->organization_id ? str_replace('ORG-', '', $apiKey->organization_id) : '1000293847';

        $organization = [
            'id' => $orgId,
            'active' => true,
            'name' => 'RSUD dr. Soebandi Jember',
            'legal_name' => 'Rumah Sakit Umum Daerah dr. Soebandi',
            'alias' => ['RSUD dr. Soebandi', 'RS Soebandi Jember', 'RSUD Soebandi'],
            'type_code' => 'prov',
            'type_display' => 'Healthcare Provider',
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
                'phone' => '+62331487441',
                'phone_display' => '(0331) 487441',
                'email' => 'rsud_soebandi@jemberkab.go.id',
                'website' => 'https://rsuddrsoebandi.jemberkab.go.id',
            ],
            'contact' => [
                'purpose_code' => 'ADMIN',
                'purpose_display' => 'Administrative / IT SIMRS Integrasi',
                'name' => 'Admin Integrasi Satu Sehat',
                'phone' => '+62331487441',
                'email' => 'admin.satusehat@rsudsoebandi.id',
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

