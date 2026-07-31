<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Office;
use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Districts
        $districts = [
            ['name' => 'Bansalan East District', 'code' => 'BE01', 'office_type' => 'District'],
            ['name' => 'Bansalan West District', 'code' => 'BW02', 'office_type' => 'District'],
            ['name' => 'Hagonoy I District', 'code' => 'HI03', 'office_type' => 'District'],
            ['name' => 'Hagonoy II District', 'code' => 'HII4', 'office_type' => 'District'],
            ['name' => 'Kiblawan North District', 'code' => 'KN05', 'office_type' => 'District'],
            ['name' => 'Kiblawan South District', 'code' => 'KS06', 'office_type' => 'District'],
        ];

        foreach ($districts as $d) {
            Office::firstOrCreate(['code' => $d['code']], $d);
        }

        // 2. Seed Schools
        $schools = [
            ['name' => 'Bansalan Central ES', 'code' => 'SCH-1011', 'office_type' => 'School', 'school_id' => '1011'],
            ['name' => 'Villa Doneza Central ES', 'code' => 'SCH-1012', 'office_type' => 'School', 'school_id' => '1012'],
            ['name' => 'Guihing Central ES', 'code' => 'SCH-2021', 'office_type' => 'School', 'school_id' => '2021'],
        ];

        foreach ($schools as $s) {
            Office::firstOrCreate(['code' => $s['code']], $s);
        }

        // 3. Seed Division Offices
        $divisionOffices = [
            ['name' => 'Admin Section', 'code' => 'DO-ADMIN', 'office_type' => 'Division Office'],
            ['name' => 'Supply Section', 'code' => 'DO-SUPPLY', 'office_type' => 'Division Office'],
            ['name' => 'ICT Section', 'code' => 'DO-ICT', 'office_type' => 'Division Office'],
            ['name' => 'HR Section', 'code' => 'DO-HR', 'office_type' => 'Division Office'],
            ['name' => 'School Governance & Operations Division', 'code' => 'DO-SGOD', 'office_type' => 'Division Office'],
            ['name' => 'Curriculum Implementation Division', 'code' => 'DO-CID', 'office_type' => 'Division Office'],
            ['name' => 'Records Section', 'code' => 'DO-RECORDS', 'office_type' => 'Division Office'],
        ];

        foreach ($divisionOffices as $o) {
            Office::firstOrCreate(['code' => $o['code']], $o);
        }
    }
}
