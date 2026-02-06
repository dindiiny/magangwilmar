<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class PageContentSeeder extends Seeder
{
    public function run()
    {
        $contents = [
            [
                'section' => 'welcome',
                'title' => 'Selamat Datang di Wina Dumai',
                'content' => 'Wilmar Nabati Indonesia (Wina Dumai) adalah bagian dari Wilmar International, grup agribisnis terkemuka di Asia. Kami berkomitmen pada kualitas, keberlanjutan, dan inovasi dalam pengolahan minyak nabati. Fasilitas laboratorium kami memastikan setiap produk memenuhi standar internasional tertinggi.'
            ],
            [
                'section' => 'vision',
                'title' => 'Visi',
                'content' => 'Menjadi perusahaan agribisnis terkemuka yang berkelanjutan dan kompetitif secara global.'
            ],
            [
                'section' => 'mission',
                'title' => 'Misi',
                'content' => '<ul><li>Menghasilkan produk berkualitas tinggi.</li><li>Menjaga keberlanjutan lingkungan.</li><li>Menciptakan nilai tambah bagi pemangku kepentingan.</li></ul>'
            ]
        ];

        foreach ($contents as $content) {
            PageContent::updateOrCreate(
                ['section' => $content['section']],
                $content
            );
        }
    }
}
