<?php

namespace App\Http\Controllers\Satusehat;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Services\SatusehatService;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{
    /**
     * Tampilkan data profil Organisasi Faskes RSUD dr. Soebandi
     * sesuai standar resource FHIR R4 Satu Sehat Kementerian Kesehatan RI.
     * Read-only: tidak ada aksi sinkronisasi dari UI,
     * sesuai halaman pages/api/organization.php di sistem PHP native.
     */
    public function index(SatusehatService $satusehat)
    {
        $fhirJson = $satusehat->getOrganization();

        $organization = null;
        $units = [];
        $rawJsonString = null;

        if ($fhirJson) {
            $organization = [
                "id"           => $fhirJson["id"] ?? null,
                "active"       => $fhirJson["active"] ?? true,
                "name"         => $fhirJson["name"] ?? "-",
                "legal_name"   => $fhirJson["name"] ?? "-",
                "type_code"    => $fhirJson["type"][0]["coding"][0]["code"] ?? null,
                "type_display" => $fhirJson["type"][0]["coding"][0]["display"] ?? null,
                "synced_at"    => $fhirJson["meta"]["lastUpdated"] ?? "-",
            ];

            $address = $fhirJson["address"][0] ?? [];
            $organization["address"] = [
                "use"         => $address["use"] ?? "work",
                "line"        => implode(", ", $address["line"] ?? []),
                "district"    => $address["district"] ?? "-",
                "city"        => $address["city"] ?? "-",
                "state"       => $address["state"] ?? "-",
                "postal_code" => $address["postalCode"] ?? "-",
                "country"     => $address["country"] ?? "ID",
                "country_name"=> "Indonesia",
            ];

            foreach ($address["extension"] ?? [] as $ext) {
                if (isset($ext["url"]) && str_contains($ext["url"], "administrativeCode")) {
                    foreach ($ext["extension"] ?? [] as $code) {
                        if ($code["url"] === "province")    $organization["province_code"] = $code["valueCode"] ?? null;
                        if ($code["url"] === "city")        $organization["city_code"] = $code["valueCode"] ?? null;
                        if ($code["url"] === "district")    $organization["district_code"] = $code["valueCode"] ?? null;
                        if ($code["url"] === "village")     $organization["village_code"] = $code["valueCode"] ?? null;
                    }
                }
            }

            $telecom = $fhirJson["telecom"][0] ?? [];
            $organization["telecom"] = [
                "phone"   => $telecom["value"] ?? "-",
                "email"   => $fhirJson["telecom"][1]["value"] ?? "-",
                "website" => "-",
            ];

            $contact = $fhirJson["contact"][0] ?? [];
            $organization["contact"] = [
                "purpose_code"        => "ADMIN",
                "purpose_display"     => "Administrative",
                "name"                => $contact["name"][0]["fullName"] ?? "-",
                "phone"               => $contact["telecom"][0]["value"] ?? "-",
                "email"               => $contact["telecom"][1]["value"] ?? "-",
            ];

            $units = [
                ["id" => $fhirJson["id"] . "-01", "name" => "Instalasi Gawat Darurat (IGD)", "type" => "Emergency Room", "status" => "Aktif", "phone" => "-"],
                ["id" => $fhirJson["id"] . "-02", "name" => "Poliklinik Umum", "type" => "Outpatient Clinic", "status" => "Aktif", "phone" => "-"],
            ];

            $rawJsonString = json_encode($fhirJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        $apiKey = null;
        $profil = DB::connection("mysql")
            ->table("ms_profil")
            ->where("id", 1)
            ->first();
        if ($profil) {
            $apiKey = new ApiKey([
                "organization_id" => $profil->organisasi_id ?? "",
                "client_key"      => $profil->client_id ?? "",
                "secret_key"      => $profil->client_secret ?? "",
                "auth_url"        => $profil->auth_url ?? "",
                "base_url"        => $profil->base_url ?? "",
                "consent_url"     => $profil->consent_url ?? "",
            ]);
        }

        return view("satusehat.organization", compact(
            "organization",
            "units",
            "rawJsonString",
            "apiKey"
        ));
    }
}
