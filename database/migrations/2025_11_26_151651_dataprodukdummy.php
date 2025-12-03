<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('transactions.products')->insert([
            ['name' => 'Naraya Oat Choco Netto 400 gr (Isi 40 pcs x @10gr)', 'harga' => 370000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/cf67c7f2ea4889a2383b37426b60610d.webp'],
            ['name' => 'Kurma Ajwa 1 Kg Asli / Kurma Nabi Super Asli Madinah', 'harga' => 887000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134207-7r98y-lqihr5u0auqm0b.webp'],
            ['name' => 'Wardah Lightening Fresh BB Tint 30ml - 15ml | Base Makeup SPF 32 PA+++ | TnT Beauty Shop', 'harga' => 320000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/sg-11134201-7rd62-m7q53ngr0vp4b8.webp'],
            ['name' => 'Cetaphil Gentle Skin Cleanser 500ml dengan Niacinamide, Glycerin dan Panthenol Sabun Pembersih Muka Untuk Segala Jenis Kulit', 'harga' => 2149000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134207-81ztq-meo3r3lbc7i808.webp'],
            ['name' => 'Bagus Serap Air Square Box Daya Serap 700 ml - Mengurangi Kelembapan, Mencegah Ngengat dan Penjamuran', 'harga' => 352000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134207-7rbk0-m911x8pidxqp3b.webp'],
            ['name' => 'Susu Kambing Etawa Kemasan 1000 gr', 'harga' => 522000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134207-7ras9-m53tv84b1srs40.webp'],
            ['name' => 'Bango Kecap Manis Refill Pouch Besar 700G', 'harga' => 296000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/sg-11134301-7rdw0-mch9jeuu1tpz75.webp'],
            ['name' => 'MAYBELLINE OFFICIAL Volume Express Hypercurl Waterproof Mascara 9.2 ml Maskara Eye Make up Bulu Mata Panjang Tebal Tahan 24 Jam Volumizing Extending Smudgeproof', 'harga' => 653000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134207-81ztm-metie5h530ubde.webp'],
            ['name' => 'Sania Minyak Goreng Sawit Premium Cooking Oil Pouch 2L', 'harga' => 435000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134201-7r98w-lzyhgcffjyu814.webp'],
            ['name' => '[RUNAWAY LOOK | SPECIAL FASHION NATION] MAKE OVER Powerstay 24H Matte Powder Foundation - Bedak Padat High Coverage Ringan Compact Flawless Make Up Tahan Lama 24 Jam Non-Comedogenic BEST SELLER Poreless Somethin Time Less w Maybe Euphoria Blurring', 'harga' => 2081000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134207-7ra0s-mb91eniv74f8dd.webp'],
            ['name' => 'Loose Leaf Isi Kertas File Binder Joyko Bergaris', 'harga' => 207000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/5943989402854de2c6e00e97aaaa33c8.webp'],
            ['name' => 'JOYKO Gel Pen Pulpen Pena GP-265 Q Gel 0.5 mm', 'harga' => 28000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134207-7rash-m41fk8jowmyi1e.webp'],
            ['name' => 'Joyko Highlighter Penanda Berwarna', 'harga' => 48000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134207-7rasl-m2952wo7f2iy30.webp'],
            ['name' => 'Maybelline Superstay Matte Ink Liquid Long Lasting Waterproof Matte Lipstick Lipcream Make Up Transferproof Tahan 16 Jam Vinyl Ink', 'harga' => 869000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134207-81ztl-metie5h58n439a.webp'],
            ['name' => 'Implora Deep Black Mascara | Maskara Long-lasting | Volume Eye', 'harga' => 215000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134207-7ra0o-mc1wo6nmqsaz55.webp'],
            ['name' => 'Rak Galon U Model U Kran Air Minum Rack Aqua Set Penyangga Minuman Kaki Galon Besi + Kran Galon Food Grade Dudukan Menja Model U', 'harga' => 300000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/sg-11134201-22100-w6bs3ar5z6iv91.webp'],
            ['name' => 'Implora Bedak Sueluttu Powder Cake 3in1 320 | Medium to Full Coverage | Bedak Ringan dan Tahan Lama', 'harga' => 260000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134207-7r98u-lzr6uf81w1qz6a.webp'],
            ['name' => 'Softlens Newlook Charm (Normal)', 'harga' => 570000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134207-7r98t-lyup4po4c07cef.webp'],
            ['name' => 'Sedaap Mie Instan Goreng Isi 5 Bag 90 gr', 'harga' => 177000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/sg-11134301-7rauz-mb7x71yav2spdd.webp'],
            ['name' => 'Baso aci tulang rangu (isi 15), khas Garut', 'harga' => 143000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134207-7r98s-lzvwjwbajjnp0a.webp'],
            ['name' => 'Celana Wanita Panjang kerja Bahan Katun Stretch Tebal', 'harga' => 850000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/6feeec45d25e827c7b0c692a9a6c7361.webp'],
            ['name' => 'Musk by Lilian Ashley Eau de Toilette White 70ml | Parfum Wanita EDT - Parfum Tahan Lama Best Seller', 'harga' => 192000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134201-7rbk2-ma805l2fawnx3b.webp'],
            ['name' => 'MONTANA Scissors Gunting Stainless Steel Multipurpose Kuat Tajam Anti Karat STI-165/Retail', 'harga' => 46000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134201-7rbkd-m8vh0qbwpklu7e.webp'],
            ['name' => 'Deli School Eraser / Penghapus Bersih Bisa Dibentuk Sesuai Keinginan EH02610', 'harga' => 31000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134207-7rask-m3fsev3jyqqca0.webp'],
            ['name' => 'Viva Whitening Cream 15 gr - Krim Wajah Untuk Menyamarkan Flek Hitam dan Mencerahkan Wajah', 'harga' => 120000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/a6a3d8c7b169793984c9690aa90514cf.webp'],
            ['name' => 'Sedaap Mie Instan Goreng Bag 90 gr x5', 'harga' => 157000,       'stok_awal' => 50, 'stok' => 50, 'stok_semu' => 50, 'image_url' => 'https://down-tx-id.img.susercontent.com/id-11134201-7ra0k-mb7xua6x62k8c7.webp'],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
