<?php

namespace Database\Seeders;

use App\Models\Occupation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $occupations = [
            'Kadı' => 'Kadı',
            'Kâtip' => 'Kâtip',
            'Şeyhülislam' => 'Şeyhülislam',
            'Reisülküttap' => 'Reisülküttap',
            'Müderris' => 'Müderris',
            'Tezkireci' => 'Tezkireci',
            'Kazasker' => 'Kazasker',
            'Nakşibendî-Müceddidî şeyhi' => 'Nakşibendî-Müceddidî şeyhi',
            'Fıkıh Alimi' => 'Fıkıh Alimi',
            'Şeyh' => 'Şeyh',
            'Şehzade' => 'Şehzade',
            'Hekim' => 'Hekim',
            'Mutasavvıf' => 'Mutasavvıf',
            'Vaiz' => 'Vaiz',
            'Müteferrika, matbaacı' => 'Müteferrika, matbaacı',
            'Alim' => 'Alim',
            'Divan Şairi' => 'Divan Şairi',
            'Kâid' => 'Kâid',
            'Hattat' => 'Hattat',
            'Divan Kâtibi' => 'Divan Kâtibi',
            'Divan tercümanı' => 'Divan tercümanı',
            'Müftü kâtibi' => 'Müftü kâtibi',
            'Hatip' => 'Hatip',
            'İstanbul' => 'İstanbul',
            'Zabit' => 'Zabit',
            'İnşaat Mühendisi' => 'İnşaat Mühendisi',
            'Halvetî-Şâbânî şeyhi' => 'Halvetî-Şâbânî şeyhi',
            'Müfettiş' => 'Müfettiş',
            'Bürokrat' => 'Bürokrat',
            'Yazar' => 'Yazar',
            'Çeşitli kurumlarda müdür' => 'Çeşitli kurumlarda müdür',
            'Berber' => 'Berber',
            'Hafız-ı kütüb' => 'Hafız-ı kütüb',
            'Muhaddis' => 'Muhaddis',
            'Müfessir' => 'Müfessir',
            'İmam' => 'İmam',
            'Muallim' => 'Muallim',
            'Asker' => 'Asker',
            'Katip' => 'Katip',
            'Defter Emini' => 'Defter Emini',
            'Tüccar' => 'Tüccar',
            'Arap dili ve edebiyatı âlimi' => 'Arap dili ve edebiyatı âlimi',
            'Müezzin' => 'Müezzin',
            'Hoca' => 'Hoca',
            'Azatlı köle' => 'Azatlı köle',
            'Ruznamçeci' => 'Ruznamçeci',
            'Denizci' => 'Denizci',
            'Kaptan' => 'Kaptan',
            'Yeniçeri' => 'Yeniçeri',
            'Rahip' => 'Rahip',
            'Cebecibaşı' => 'Cebecibaşı',
            'Kaptan-ı derya' => 'Kaptan-ı derya',
            'Zeyniyye Şeyhi' => 'Zeyniyye Şeyhi',
            'Şair' => 'Şair',
            'İmam-Hatip' => 'İmam-Hatip',
            'Papaz' => 'Papaz',
            'Çiftçi' => 'Çiftçi',
            'Dokumacı' => 'Dokumacı',
            'Yazıcı' => 'Yazıcı',
            'Mühürdar' => 'Mühürdar',
            'Müftü' => 'Müftü',
            'Naib' => 'Naib',
            'Sadrazam' => 'Sadrazam',
            'Padişah' => 'Padişah',
            'Defterdar' => 'Defterdar',
            'Paşa' => 'Paşa',
            'Tekke şeyhi' => 'Tekke şeyhi',
            'Avukat' => 'Avukat',
            'Ayan' => 'Ayan',
            'Mutasarrıf' => 'Mutasarrıf',
            'Sarraf' => 'Sarraf',
            'İlmiye Mensubu' => 'İlmiye Mensubu',
            'Debbağ' => 'Debbağ',
            'Askeriye Mensubu' => 'Askeriye Mensubu',
            'Kalemiye Mensubu' => 'Kalemiye Mensubu',
            'Elçi' => 'Elçi',
            'Beylerbeyi' => 'Beylerbeyi',
            'Kapıcıbaşı' => 'Kapıcıbaşı',
            'Degâh-ı Âlî Müteferrikası' => 'Degâh-ı Âlî Müteferrikası',
            'Coğrafyacı' => 'Coğrafyacı',
            'Astronom' => 'Astronom',
            'Filozof' => 'Filozof',
            'Dil bilimleri alimi' => 'Dil bilimleri alimi',
            'Mülazım' => 'Mülazım',
            'Mimar' => 'Mimar',
            'Zanaatkar' => 'Zanaatkar',
            'Bestekar' => 'Bestekar',
            'Matbah Emini' => 'Matbah Emini',
            'Müteferrika' => 'Müteferrika',
            'Musahip' => 'Musahip',
            'Sır katibi' => 'Sır katibi',
        ];

        $occupationsArray = [];
        $id = 1;

        foreach ($occupations as $occupation) {
            $occupationsArray[] = [
                'id' => $id,
                'name' => $occupation,
            ];
            $id++;
        }

        DB::table('occupations')->insert($occupationsArray);

    }
}
