<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('kapela')) {
            return;
        }

        $sejarahHtml = <<<'HTML'
<p>Umat Katolik Taetimu semata-mata terdiri dari orang Banam atau Amanuban. Hingga tahun 1950-an mereka semua masih menganut kepercayaan leluhur. Agama Katolik masuk ke sini melalui anak-anak jebolan sekolah Katolik. Salah seorang di antara mereka adalah <strong>Kornelis Selan</strong>. Bapa dari dua anak ini masih ingat baik akan situasi hari pertama masuk sekolah Katolik di Soe:</p><blockquote><p>“Pada tahun 1952 kami duduk di kelas I SR GMIT Lalip. Guru (N) hari-hari pukul kami. Keterlaluan. Kami tidak bisa tahan. Lalu kami cari sekolah lain. Kami bertiga: Markus Banamtuan, Benyamin Isu, dan saya, bersama orang tua ke Soe. Orang tua menghantar kami ke SR I. Betapa terkejut melihat anak-anak bangsawan. Bapa dari Markus dan kami sendiripun menjadi kecut dan rasa diri kecil. Cepat-cepat kami beralih langkah ke sekolah lain, yaitu sekolah Katolik. Kami diterima oleh guru Yohanes Lasi.”</p></blockquote><p>Selanjutnya Kornelis yang kemudian menjadi guru agama Katolik di Taetimu menceritakan:</p><blockquote><p>“Kami berkenalan dengan agama Katolik melalui sekolah ini. Lama-kelamaan kami merasa tertarik kepada agama Katolik, sampai akhirnya kami dipermandikan di kelas III SR. Orang tua tidak berkeberatan. Kami boleh memilih agama mana yang kami suka. Kawan lain tidak menamatkan SR, pulang ke kampung dan kembali kepada kekafiran. Saya sendiri berhenti di kelas V, tinggal di kampung dan berusaha tetap pada agama Katolik. Setiap hari Minggu saya pergi berdoa di gereja Katolik di Benlutu.”</p></blockquote><p>Dengan perantaraan anak-anak ini, agama Katolik mulai dikenal di kampung Taetimu. Yang duluan mengikuti jejak anak-anak ini adalah keluarga mereka sendiri. Pada tahun 1958 sudah terhitung 5 orang Katolik. Saat itu belum ada gedung gereja, sehingga pastor juga belum pernah berkunjung ke sana.</p><p>Tahun 1963 umat bertambah menjadi 11 orang. Berkat bantuan seorang pemuda Katolik dari Benlutu, <strong>Kornelis Koa</strong>, pada hari Minggu mereka dapat berdoa dan belajar agama di kampung sendiri, tanpa harus berjalan jauh ke Benlutu. Orang tua semula enggan masuk karena rasa takut. Baru sesudah tahun 1965 banyak warga mulai meminta masuk agama Katolik.</p><p>Namun, tantangan dan penolakan muncul. Calon-calon Katolik itu sempat didesak melepaskan keyakinannya, terutama saat orang tua menyerahkan <em>“pentauf”</em> (upeti) kepada Raja yang merangkap Bupati Kepala Daerah. Juru bicara kerajaan saat itu sempat mempertanyakan pilihan agama mereka:</p><blockquote><p>“Kami mendengar bahwa ada orang tua lain yang masuk agama Katolik. Keluarga kamu semua Protestan. Saya berpartai Parkindo. Kamu partai apa? Tentu partai lain. Kalau kamu anak-anak saya mengundang saya ke pesta, kita berdoa cara mana? Tentu saya berdoa cara saya, dan kamu cara lain. Mengapa kamu tidak turut saya?”</p></blockquote><p>Bagi rakyat jelata dalam tatanan feodal, ucapan tersebut dirasakan sebagai tekanan berat yang menyiratkan tuduhan melawan kehendak penguasa. Akibatnya, keluarga Seo diam-diam menarik diri dari agama Katolik, sementara keluarga lainnya tetap teguh bertahan.</p><p>Tekanan lain dialami pada tahun 1971 ketika dua keluarga dibaptis menjadi Katolik. Mereka sempat dituduh memfitnah pihak lain dan diadukan kepada Puterpra. Namun setelah penyelidikan membuktikan tuduhan tersebut tidak benar, mereka dibebaskan.</p><p>Kunjungan perdana pastor ke Taetimu terjadi pada <strong>6 Oktober 1966</strong>. Saat itu umat telah mendirikan kapela darurat sederhana. Para sesepuh dan guru agama bersikap tegas dalam membina disiplin iman umat.</p><p>Pada tahun 1976, umat Katolik Taetimu yang berjumlah 80 jiwa dengan penuh kerelaan dan gotong royong membangun rumah ibadat semi permanen: memikul tiang kayu bersama, mengangkut pasir, dan menanggung konsumsi tukang. Sebagian keluarga kemudian berpindah mencari penghidupan di tempat lain, namun persekutuan iman tetap hidup dan setia dipelihara di bawah naungan pelindung <strong>Santo Simon Petrus Rasul</strong>.</p>
HTML;

        $updateData = [
            'tipe' => 'Kapela',
            'pelindung' => 'Santo Simon Petrus Rasul',
            'latitude' => '-9.905059',
            'longitude' => '124.160423',
            'maps_url' => 'https://maps.google.com/?q=-9.905059,124.160423',
            'warna_area' => '#0284c7',
            'keterangan' => '<p>Kapela Santo Simon Petrus Rasul - Taetimu, Paroki Santo Vinsensius a Paulo Benlutu, Keuskupan Agung Kupang.</p>',
            'sejarah' => $sejarahHtml,
            'updated_at' => now(),
        ];

        // Filter out columns that don't exist yet just in case
        $validData = [];
        foreach ($updateData as $col => $val) {
            if (Schema::hasColumn('kapela', $col)) {
                $validData[$col] = $val;
            }
        }

        if (!empty($validData)) {
            DB::table('kapela')
                ->where('slug', 'santo-simon-petrus-rasul-taetimu')
                ->orWhere('nama_kapela', 'like', '%Taetimu%')
                ->update($validData);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse required for content sync
    }
};
