<?php

namespace App\Http\Controllers\Satusehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Tampilkan halaman pencarian Patient Satu Sehat FHIR R4 (berdasarkan ID atau NIK)
     * dan menampilkan respons JSON persis seperti di portal Satu Sehat Kemenkes.
     */
    public function index(Request $request)
    {
        $searchType = $request->query('type', 'nik'); // 'id' atau 'nik'
        $searchQuery = trim($request->query('q', '3509160107400100'));

        $jsonResult = null;

        if ($searchQuery !== '') {
            if (strtolower($searchType) === 'id') {
                $patientId = $searchQuery;
                $jsonResult = [
                    'resourceType' => 'Patient',
                    'id' => $patientId,
                    'meta' => [
                        'lastUpdated' => now()->subDays(2)->format('Y-m-d\TH:i:s.u\Z'),
                        'versionId' => 'MTY5MzQzNDM3Mzk0OTY4OTAwMA',
                        'profile' => [
                            'https://fhir.kemkes.go.id/r4/StructureDefinition/Patient',
                        ],
                    ],
                    'active' => true,
                    'identifier' => [
                        [
                            'system' => 'https://fhir.kemkes.go.id/id/ihs-number',
                            'use' => 'official',
                            'value' => $patientId,
                        ],
                        [
                            'system' => 'https://fhir.kemkes.go.id/id/nik',
                            'use' => 'official',
                            'value' => '3509160107400100',
                        ],
                        [
                            'system' => 'https://fhir.kemkes.go.id/id/kk',
                            'use' => 'official',
                            'value' => '3509160107400001',
                        ],
                    ],
                    'name' => [
                        [
                            'use' => 'official',
                            'text' => 'AB** HA**',
                        ],
                    ],
                    'gender' => 'male',
                    'birthDate' => '1988-07-16',
                ];
            } else {
                // Default NIK: format bundle searchset persis seperti di screenshot
                $nik = $searchQuery;
                $ihsNumber = 'P00702846568';
                $jsonResult = [
                    'entry' => [
                        [
                            'fullUrl' => "https://api-satusehat.kemkes.go.id/fhir-r4/v1/Patient/{$ihsNumber}",
                            'resource' => [
                                'active' => true,
                                'id' => $ihsNumber,
                                'identifier' => [
                                    [
                                        'system' => 'https://fhir.kemkes.go.id/id/ihs-number',
                                        'use' => 'official',
                                        'value' => $ihsNumber,
                                    ],
                                    [
                                        'system' => 'https://fhir.kemkes.go.id/id/nik',
                                        'use' => 'official',
                                        'value' => '################',
                                    ],
                                    [
                                        'system' => 'https://fhir.kemkes.go.id/id/kk',
                                        'use' => 'official',
                                        'value' => '################',
                                    ],
                                ],
                                'meta' => [
                                    'lastUpdated' => '2023-07-08T15:54:18.587221+00:00',
                                    'profile' => [
                                        'https://fhir.kemkes.go.id/r4/StructureDefinition/Patient',
                                    ],
                                    'versionId' => 'MTY4ODgzMTY1ODU4NzIyMTAwMA',
                                ],
                                'name' => [
                                    [
                                        'text' => 'AB** HA**',
                                        'use' => 'official',
                                    ],
                                ],
                                'resourceType' => 'Patient',
                            ],
                        ],
                    ],
                    'link' => [
                        [
                            'relation' => 'search',
                            'url' => "https://api-satusehat.kemkes.go.id/fhir-r4/v1/Patient/?identifier=https%3A%2F%2Ffhir.kemkes.go.id%2Fid%2Fnik%7C{$nik}",
                        ],
                        [
                            'relation' => 'first',
                            'url' => "https://api-satusehat.kemkes.go.id/fhir-r4/v1/Patient/?identifier=https%3A%2F%2Ffhir.kemkes.go.id%2Fid%2Fnik%7C{$nik}",
                        ],
                        [
                            'relation' => 'self',
                            'url' => "https://api-satusehat.kemkes.go.id/fhir-r4/v1/Patient/?identifier=https%3A%2F%2Ffhir.kemkes.go.id%2Fid%2Fnik%7C{$nik}",
                        ],
                    ],
                    'resourceType' => 'Bundle',
                    'total' => 1,
                    'type' => 'searchset',
                ];
            }
        }

        $rawJsonString = $jsonResult ? json_encode($jsonResult, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null;
        $compactJsonString = $jsonResult ? json_encode($jsonResult, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null;

        return view('satusehat.patient', compact('searchType', 'searchQuery', 'rawJsonString', 'compactJsonString', 'jsonResult'));
    }
}
