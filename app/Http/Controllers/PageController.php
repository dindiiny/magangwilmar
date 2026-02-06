<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function laboratorium()
    {
        return view('laboratorium');
    }

    public function galeri()
    {
        // Data dummy untuk galeri
        $galleryItems = [
            [
                'title' => 'Titration Set',
                'description' => 'Digunakan untuk analisis titrasi volumetrik presisi tinggi.',
                'image' => 'titration.jpg' // Placeholder
            ],
            [
                'title' => 'Hot Plate & Magnetic Stirrer',
                'description' => 'Untuk memanaskan dan mengaduk larutan secara homogen.',
                'image' => 'hotplate.jpg'
            ],
            [
                'title' => 'Oven & Desikator',
                'description' => 'Pengeringan sampel dan menjaga kelembaban rendah.',
                'image' => 'oven.jpg'
            ],
            [
                'title' => 'Analytical Balance',
                'description' => 'Timbangan analitik untuk pengukuran massa yang sangat akurat.',
                'image' => 'balance.jpg'
            ],
            [
                'title' => 'Lovibond Tintometer',
                'description' => 'Alat pengukur warna untuk analisis kualitas minyak.',
                'image' => 'lovibond.jpg'
            ],
            [
                'title' => 'Melting Point Apparatus',
                'description' => 'Menentukan titik leleh suatu zat padat.',
                'image' => 'melting.jpg'
            ],
        ];

        return view('galeri', compact('galleryItems'));
    }
}
