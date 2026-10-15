@extends('layouts.app')
@section('title', 'Statistik & Demografi Umat Paroki - ' . ($globalNamaParoki ?? 'St. Vinsensius a Paulo Benlutu'))

@section('content')
<!-- Page Header / Breadcrumb Konoha Style -->
<section class="page-header">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 12px; color: #ffffff;">Potret Keluarga Besar Umat Kita</h1>
        <p style="font-size: 1rem; color: rgba(255,255,255,0.85); margin-bottom: 18px; max-width: 680px; margin-left: auto; margin-right: auto;">
            Mari mengenal lebih dekat keluarga besar Paroki St. Vinsensius a Paulo Benlutu melalui rangkuman data umat, wilayah pelayanan, dan kehidupan menggereja kita bersama.
        </p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="display: inline-flex; list-style: none; padding: 0; margin: 0 auto; gap: 8px; background: transparent; justify-content: center; align-items: center; flex-wrap: wrap;">
                <li class="breadcrumb-item" style="background: rgba(255,255,255,0.22); padding: 6px 18px; border-radius: 25px; font-size: 0.85rem;">
                    <a href="/" style="color: white; text-decoration: none; font-weight: 500;"><i class="fa-solid fa-house me-1" style="font-size: 0.75rem;"></i> Beranda</a>
                </li>
                <li class="breadcrumb-separator" style="color: rgba(255,255,255,0.75); font-size: 0.7rem; display: inline-flex; align-items: center;">
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li class="breadcrumb-item active" style="background: var(--primary-orange, #ff9800); color: white; padding: 6px 18px; border-radius: 25px; font-size: 0.85rem; font-weight: 700;">
                    Statistik
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- Content Section Konoha Style -->
<section class="content-section" style="padding: 50px 0 80px; background: #f4faf9;">
    <div class="container">
        
        <!-- TOP KPI CARDS (7 Summary Counters Matching Superadmin) -->
        <div class="row g-3 mb-5">
            <!-- 1. Total Jiwa Umat -->
            <div class="col-6 col-md-4 col-xl">
                <div style="background: #ffffff; border-radius: 20px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid var(--primary-teal, #00897b); display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #64748b;">
                            Jumlah Umat
                        </span>
                        <div style="width: 38px; height: 38px; border-radius: 12px; background: rgba(0,137,123,0.1); color: var(--primary-teal, #00897b); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                    <div>
                        <h2 style="font-size: 1.7rem; font-weight: 900; color: #0f172a; margin: 0; line-height: 1.1;">
                            {{ number_format((int) ($totalUmat ?? 0), 0, ',', '.') }}
                            <span style="font-size: 0.75rem; font-weight: 600; color: #64748b;">Jiwa</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- 2. Kepala Keluarga (KK) -->
            <div class="col-6 col-md-4 col-xl">
                <div style="background: #ffffff; border-radius: 20px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #2563eb; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #64748b;">
                            Keluarga Katolik
                        </span>
                        <div style="width: 38px; height: 38px; border-radius: 12px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="fa-solid fa-house-chimney-user"></i>
                        </div>
                    </div>
                    <div>
                        <h2 style="font-size: 1.7rem; font-weight: 900; color: #0f172a; margin: 0; line-height: 1.1;">
                            {{ number_format((int) ($totalKK ?? 0), 0, ',', '.') }}
                            <span style="font-size: 0.75rem; font-weight: 600; color: #64748b;">KK</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- 3. Komunitas Basis (KUB) -->
            <div class="col-6 col-md-4 col-xl">
                <div style="background: #ffffff; border-radius: 20px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #10b981; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #64748b;">
                            Komunitas Basis (KUB)
                        </span>
                        <div style="width: 38px; height: 38px; border-radius: 12px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="fa-solid fa-people-group"></i>
                        </div>
                    </div>
                    <div>
                        <h2 style="font-size: 1.7rem; font-weight: 900; color: #0f172a; margin: 0; line-height: 1.1;">
                            {{ number_format((int) ($totalKUB ?? 0), 0, ',', '.') }}
                            <span style="font-size: 0.75rem; font-weight: 600; color: #64748b;">KUB</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- 4. Wilayah Rohani -->
            <div class="col-6 col-md-4 col-xl">
                <div style="background: #ffffff; border-radius: 20px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #6366f1; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #64748b;">
                            Wilayah Pelayanan
                        </span>
                        <div style="width: 38px; height: 38px; border-radius: 12px; background: #eef2ff; color: #6366f1; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="fa-solid fa-map-location-dot"></i>
                        </div>
                    </div>
                    <div>
                        <h2 style="font-size: 1.7rem; font-weight: 900; color: #0f172a; margin: 0; line-height: 1.1;">
                            {{ number_format((int) ($totalWilayah ?? 0), 0, ',', '.') }}
                            <span style="font-size: 0.75rem; font-weight: 600; color: #64748b;">Wilayah</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- 5. Kapela & Stasi -->
            <div class="col-6 col-md-4 col-xl">
                <div style="background: #ffffff; border-radius: 20px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #8b5cf6; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #64748b;">
                            Stasi &amp; Kapela
                        </span>
                        <div style="width: 38px; height: 38px; border-radius: 12px; background: #f5f3ff; color: #8b5cf6; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="fa-solid fa-church"></i>
                        </div>
                    </div>
                    <div>
                        <h2 style="font-size: 1.7rem; font-weight: 900; color: #0f172a; margin: 0; line-height: 1.1;">
                            {{ number_format((int) ($totalKapela ?? 0), 0, ',', '.') }}
                            <span style="font-size: 0.75rem; font-weight: 600; color: #64748b;">Stasi</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- 6. Imam Putra Paroki -->
            <div class="col-6 col-md-4 col-xl">
                <div style="background: #ffffff; border-radius: 20px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #a855f7; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #64748b;" title="Pastor yang berasal dari paroki kita">
                            Imam Asal Paroki
                        </span>
                        <div style="width: 38px; height: 38px; border-radius: 12px; background: #faf5ff; color: #9333ea; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="fa-solid fa-cross"></i>
                        </div>
                    </div>
                    <div>
                        <h2 style="font-size: 1.7rem; font-weight: 900; color: #0f172a; margin: 0; line-height: 1.1;">
                            {{ number_format((int) ($totalImam ?? 0), 0, ',', '.') }}
                            <span style="font-size: 0.75rem; font-weight: 600; color: #64748b;">Imam</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- 7. Biarawan & Biarawati -->
            <div class="col-6 col-md-4 col-xl">
                <div style="background: #ffffff; border-radius: 20px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-top: 4px solid #14b8a6; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #64748b;" title="Putra-putri paroki yang membiara">
                            Suster, Bruder &amp; Frater
                        </span>
                        <div style="width: 38px; height: 38px; border-radius: 12px; background: #f0fdfa; color: #0d9488; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                            <i class="fa-solid fa-dove"></i>
                        </div>
                    </div>
                    <div>
                        <h2 style="font-size: 1.7rem; font-weight: 900; color: #0f172a; margin: 0; line-height: 1.1;">
                            {{ number_format((int) ($totalBiarawan ?? 0), 0, ',', '.') }}
                            <span style="font-size: 0.75rem; font-weight: 600; color: #64748b;">Jiwa</span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>


        <!-- ROW 1 CHARTS: GENDER RATIO & AGE DEMOGRAPHICS -->
        <div class="row g-4 mb-4">
            
            <!-- Chart: Rasio Gender (Laki-laki vs Perempuan) -->
            <div class="col-lg-5">
                <div style="background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 5px 22px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
                            <div>
                                <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--primary-teal, #00897b);">
                                    Umat Laki-laki &amp; Perempuan
                                </span>
                                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 2px 0 0;">
                                    Perbandingan jumlah umat pria dan wanita
                                </h3>
                            </div>
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(0,137,123,0.1); color: var(--primary-teal, #00897b); display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                                <i class="fa-solid fa-venus-mars"></i>
                            </div>
                        </div>

                        <!-- Canvas Container -->
                        <div style="position: relative; height: 230px; margin: 10px 0 20px;">
                            <canvas id="genderDonutChart"></canvas>
                        </div>
                    </div>

                    <!-- Gender Stats Details -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                        <div style="background: #eff6ff; border: 1px solid #dbeafe; border-radius: 14px; padding: 12px 14px; text-align: center;">
                            <span style="font-size: 0.72rem; font-weight: 700; color: #1d4ed8; text-transform: uppercase; display: block; margin-bottom: 2px;">
                                <i class="fa-solid fa-mars me-1"></i> Laki-laki
                            </span>
                            <div style="font-size: 1.35rem; font-weight: 900; color: #1e3a8a;">
                                {{ number_format($genderStats['pria'] ?? 0) }}
                            </div>
                            <span style="font-size: 0.72rem; font-weight: 700; color: #3b82f6;">
                                {{ $genderStats['pria_percent'] ?? 50 }}% dari Total
                            </span>
                        </div>

                        <div style="background: #fdf2f8; border: 1px solid #fce7f3; border-radius: 14px; padding: 12px 14px; text-align: center;">
                            <span style="font-size: 0.72rem; font-weight: 700; color: #be185d; text-transform: uppercase; display: block; margin-bottom: 2px;">
                                <i class="fa-solid fa-venus me-1"></i> Perempuan
                            </span>
                            <div style="font-size: 1.35rem; font-weight: 900; color: #831843;">
                                {{ number_format($genderStats['wanita'] ?? 0) }}
                            </div>
                            <span style="font-size: 0.72rem; font-weight: 700; color: #ec4899;">
                                {{ $genderStats['wanita_percent'] ?? 50 }}% dari Total
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart: Piramida Usia Demografi -->
            <div class="col-lg-7">
                <div style="background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 5px 22px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
                            <div>
                                <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--primary-orange, #ff9800);">
                                    Rentang Usia Umat
                                </span>
                                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 2px 0 0;">
                                    Dari anak-anak hingga lansia di paroki kita
                                </h3>
                            </div>
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(255,152,0,0.12); color: var(--primary-orange, #ff9800); display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                                <i class="fa-solid fa-chart-simple"></i>
                            </div>
                        </div>

                        <!-- Canvas Container -->
                        <div style="position: relative; height: 230px; margin: 10px 0 20px;">
                            <canvas id="ageBarChart"></canvas>
                        </div>
                    </div>

                    <!-- Age Grid Summary -->
                    <div class="row g-2 pt-3" style="border-top: 1px solid #f1f5f9;">
                        @foreach($usiaStats as $u)
                            <div class="col-6 col-md-3">
                                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px 10px; text-align: center; height: 100%; display: flex; flex-direction: column; justify-content: center; min-width: 0;">
                                    <span style="font-size: 0.74rem; font-weight: 700; color: #475569; display: flex; align-items: center; justify-content: center; gap: 5px; margin-bottom: 4px; line-height: 1.25; word-wrap: break-word;">
                                        <i class="fa-solid {{ $u['icon'] }}" style="color: {{ $u['color'] }}; font-size: 0.8rem;"></i>
                                        <span>{{ $u['label'] }}</span>
                                    </span>
                                    <div style="font-size: 1.2rem; font-weight: 900; color: #0f172a; line-height: 1.1; margin: 2px 0;">
                                        {{ number_format($u['count']) }}
                                        <span style="font-size: 0.68rem; font-weight: 600; color: #64748b;">Jiwa</span>
                                    </div>
                                    <div style="margin-top: 4px; display: flex; align-items: center; justify-content: center; gap: 4px; flex-wrap: wrap;">
                                        <span style="display: inline-block; padding: 2px 7px; border-radius: 9999px; font-size: 0.68rem; font-weight: 800; background: {{ $u['color'] }}18; color: {{ $u['color'] }}; border: 1px solid {{ $u['color'] }}33;">
                                            {{ $u['percent'] }}%
                                        </span>
                                        @if(!empty($u['range']))
                                            <span style="font-size: 0.68rem; font-weight: 600; color: #94a3b8;">
                                                {{ $u['range'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>


        <!-- ROW 2 CHARTS: SAKRAMEN & STATUS PERKAWINAN -->
        <div class="row g-4 mb-4">
            
            <!-- Chart: Pencapaian Sakramen -->
            <div class="col-lg-6">
                <div style="background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 5px 22px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; height: 100%;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
                        <div>
                            <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #0284c7;">
                                Penerimaan Sakramen
                            </span>
                            <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 2px 0 0;">
                                Jumlah umat yang telah menerima sakramen gereja
                            </h3>
                        </div>
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                            <i class="fa-solid fa-water"></i>
                        </div>
                    </div>

                    <!-- Canvas Container -->
                    <div style="position: relative; height: 250px; margin-bottom: 20px;">
                        <canvas id="sakramenRadarChart"></canvas>
                    </div>

                    <!-- Sakramen Badges List -->
                    <div class="row g-2 pt-3" style="border-top: 1px solid #f1f5f9;">
                        <div class="col-6">
                            <div style="display: flex; align-items: center; justify-content: space-between; background: #f0fdf4; border: 1px solid #dcfce7; border-radius: 10px; padding: 8px 12px;">
                                <span style="font-size: 0.78rem; font-weight: 700; color: #166534;"><i class="fa-solid fa-droplet text-emerald-500 me-1"></i> Sudah Dibaptis</span>
                                <strong style="font-size: 0.95rem; color: #14532d;">{{ number_format($sakramenCount['baptis'] ?? 0) }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="display: flex; align-items: center; justify-content: space-between; background: #eff6ff; border: 1px solid #dbeafe; border-radius: 10px; padding: 8px 12px;">
                                <span style="font-size: 0.78rem; font-weight: 700; color: #1e40af;"><i class="fa-solid fa-bread-slice text-blue-500 me-1"></i> Komuni Pertama</span>
                                <strong style="font-size: 0.95rem; color: #1e3a8a;">{{ number_format($sakramenCount['komuni'] ?? 0) }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="display: flex; align-items: center; justify-content: space-between; background: #fefce8; border: 1px solid #fef08a; border-radius: 10px; padding: 8px 12px;">
                                <span style="font-size: 0.78rem; font-weight: 700; color: #854d0e;"><i class="fa-solid fa-fire text-amber-500 me-1"></i> Sakramen Krisma</span>
                                <strong style="font-size: 0.95rem; color: #713f12;">{{ number_format($sakramenCount['krisma'] ?? 0) }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="display: flex; align-items: center; justify-content: space-between; background: #fdf2f8; border: 1px solid #fce7f3; border-radius: 10px; padding: 8px 12px;">
                                <span style="font-size: 0.78rem; font-weight: 700; color: #9d174d;"><i class="fa-solid fa-ring text-pink-500 me-1"></i> Sakramen Perkawinan</span>
                                <strong style="font-size: 0.95rem; color: #831843;">{{ number_format($sakramenCount['perkawinan'] ?? 0) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart: Status Perkawinan Umat -->
            <div class="col-lg-6">
                <div style="background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 5px 22px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
                            <div>
                                <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #d97706;">
                                    Status Pernikahan
                                </span>
                                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 2px 0 0;">
                                    Gambaran ikatan pernikahan umat
                                </h3>
                            </div>
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                                <i class="fa-solid fa-ring"></i>
                            </div>
                        </div>

                        <!-- Canvas Container -->
                        <div style="position: relative; height: 240px; margin-bottom: 16px;">
                            <canvas id="marriagePieChart"></canvas>
                        </div>
                    </div>

                    <!-- Marriage Badges List (Fully Responsive) -->
                    <div class="row g-2 pt-3" style="border-top: 1px solid #f1f5f9;">
                        @foreach($statusKawinStats as $m)
                            <div class="col-4 col-sm-4">
                                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 6px; text-align: center; height: 100%; display: flex; flex-direction: column; justify-content: center; min-width: 0;">
                                    <span style="font-size: 0.72rem; font-weight: 700; color: #475569; display: block; margin-bottom: 3px; line-height: 1.25; word-wrap: break-word; overflow-wrap: break-word;">
                                        @if(!empty($m['icon']))
                                            <i class="fa-solid {{ $m['icon'] }} me-1" style="color: {{ $m['color'] }}; font-size: 0.7rem;"></i>
                                        @endif
                                        {{ $m['label'] }}
                                    </span>
                                    <div style="font-size: 1.2rem; font-weight: 900; color: #0f172a; line-height: 1.1; margin: 2px 0;">
                                        {{ number_format($m['count']) }}
                                        <span style="font-size: 0.68rem; font-weight: 600; color: #64748b;">Jiwa</span>
                                    </div>
                                    <div style="margin-top: 3px;">
                                        <span style="display: inline-block; padding: 2px 8px; border-radius: 9999px; font-size: 0.68rem; font-weight: 800; background: {{ $m['color'] }}18; color: {{ $m['color'] }}; border: 1px solid {{ $m['color'] }}33;">
                                            {{ $m['percent'] }}%
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>


        <!-- ROW 3: SEBARAN WILAYAH ROHANI & DISTRIBUSI PROFESI / PEKERJAAN -->
        <div class="row g-4 mb-4">
            
            <!-- Table: Sebaran Wilayah Rohani Pastoral -->
            <div class="col-lg-7">
                <div style="background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 5px 22px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
                            <div>
                                <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #4f46e5;">
                                    Sebaran Umat per Wilayah
                                </span>
                                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 2px 0 0;">
                                    Data KUB, keluarga, dan jumlah umat di tiap wilayah
                                </h3>
                            </div>
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: #eef2ff; color: #4f46e5; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                                <i class="fa-solid fa-map-location-dot"></i>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="font-size: 0.82rem;">
                                <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; font-size: 0.75rem; text-transform: uppercase; color: #64748b;">
                                    <tr>
                                        <th style="padding: 10px 12px; border-radius: 10px 0 0 10px;">Nama Wilayah</th>
                                        <th style="padding: 10px 12px; text-align: center;">Jumlah KUB</th>
                                        <th style="padding: 10px 12px; text-align: right;">Jumlah KK</th>
                                        <th style="padding: 10px 12px; text-align: right;">Total Jiwa</th>
                                        <th style="padding: 10px 12px; text-align: right; border-radius: 0 10px 10px 0;">Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($wilayahStats as $w)
                                        @php
                                            $wUmat = $w['umat_count'] ?? 0;
                                            $wPercent = $w['percent'] ?? round(($wUmat / max(1, $totalUmat)) * 100);
                                        @endphp
                                        <tr style="border-bottom: 1px solid #f1f5f9;">
                                            <td style="padding: 12px; font-weight: 700; color: #1e293b;">
                                                <div style="display: flex; align-items: center; gap: 8px;">
                                                    <div style="width: 24px; height: 24px; border-radius: 6px; background: #eef2ff; color: #4f46e5; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; flex-shrink: 0;">
                                                        <i class="fa-solid fa-cross"></i>
                                                    </div>
                                                    <span>{{ $w['nama_wilayah'] }}</span>
                                                </div>
                                            </td>
                                            <td style="padding: 12px; text-align: center; font-weight: 600; color: #475569;">
                                                {{ $w['kub_count'] ?? 0 }} KUB
                                            </td>
                                            <td style="padding: 12px; text-align: right; font-weight: 700; color: #334155;">
                                                {{ number_format($w['kk_count'] ?? 0) }} KK
                                            </td>
                                            <td style="padding: 12px; text-align: right; font-weight: 800; color: #0f172a;">
                                                {{ number_format($wUmat) }} Jiwa
                                            </td>
                                            <td style="padding: 12px; text-align: right;">
                                                <span style="display: inline-block; padding: 3px 8px; border-radius: 6px; font-size: 0.72rem; font-weight: 700; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                                    {{ $wPercent }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" style="text-align: center; padding: 24px; color: #94a3b8;">
                                                Belum ada data wilayah pastoral tersinkronisasi.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 14px; border-top: 1px solid #f1f5f9; font-size: 0.75rem; color: #64748b; margin-top: 10px;">
                        <span><i class="fa-solid fa-circle-info me-1"></i> Total terdata: {{ count($wilayahStats) }} Wilayah Pastoral</span>
                        <span style="font-weight: 700; color: #0f172a;">Total: {{ number_format($totalUmat) }} Jiwa Umat</span>
                    </div>
                </div>
            </div>

            <!-- Progress: Distribusi Profesi & Pekerjaan Umat -->
            <div class="col-lg-5">
                <div style="background: #ffffff; border-radius: 20px; padding: 28px; box-shadow: 0 5px 22px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
                            <div>
                                <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #0284c7;">
                                    Pekerjaan &amp; Keseharian Umat
                                </span>
                                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 2px 0 0;">
                                    Berbagai bidang karya dan mata pencaharian umat sehari-hari
                                </h3>
                            </div>
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            @foreach($pekerjaanStats as $p)
                                <div>
                                    <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.82rem; margin-bottom: 6px;">
                                        <span style="font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                                            <i class="fa-solid {{ $p['icon'] ?? 'fa-briefcase' }}" style="color: {{ $p['color'] ?? '#0284c7' }}; width: 16px;"></i>
                                            {{ $p['nama'] }}
                                        </span>
                                        <span style="font-weight: 800; color: #0f172a;">
                                            {{ number_format($p['count']) }} Jiwa 
                                            <span style="font-weight: 600; color: #64748b; font-size: 0.75rem;">({{ $p['percentage'] }}%)</span>
                                        </span>
                                    </div>
                                    <div style="height: 8px; width: 100%; background: #f1f5f9; border-radius: 9999px; overflow: hidden;">
                                        <div style="height: 100%; width: {{ $p['percentage'] }}%; background: {{ $p['color'] ?? '#0284c7' }}; border-radius: 9999px; transition: width 0.5s ease-in-out;"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div style="padding-top: 14px; border-top: 1px solid #f1f5f9; font-size: 0.75rem; color: #64748b; margin-top: 16px; display: flex; align-items: center; justify-content: space-between;">
                        <span><i class="fa-solid fa-chart-pie me-1"></i> Data Pekerjaan Umat Paroki</span>
                        <span style="font-weight: 700; color: #0284c7;">5 Sektor Utama</span>
                    </div>
                </div>
            </div>

        </div>


        <!-- ROW 4: PANGGILAN HIDUP BAKTI DARI KELUARGA UMAT (IMAM, BIARAWAN & BIARAWATI) -->
        <div style="background: #ffffff; border-radius: 24px; padding: 32px; box-shadow: 0 5px 22px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; margin-bottom: 24px;">
            <!-- Header Banner -->
            <div style="display: flex; flex-direction: column; md:flex-row; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 26px; padding-bottom: 20px; border-bottom: 1px solid #f1f5f9;">
                <div>
                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; background: #faf5ff; color: #9333ea; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px; border: 1px solid #f3e8ff; margin-bottom: 8px;">
                        <i class="fa-solid fa-cross"></i> Panggilan Hidup Membiara &amp; Imamat
                    </span>
                    <h3 style="font-size: 1.35rem; font-weight: 900; color: #0f172a; margin: 0 0 6px;">
                        Putra-Putri Paroki dalam Pelayanan Gereja
                    </h3>
                    <p style="font-size: 0.85rem; color: #64748b; margin: 0; max-width: 720px; line-height: 1.5;">
                        Putra dan putri terbaik dari keluarga umat Paroki Benlutu yang mempersembahkan hidupnya untuk melayani Tuhan sebagai Pastor, Suster, Bruder, dan Frater.
                    </p>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 12px; background: #faf5ff; border: 1px solid #e9d5ff; color: #7e22ce; font-size: 0.8rem; font-weight: 800;">
                        <i class="fa-solid fa-cross"></i> {{ $totalImam }} Imam
                    </span>
                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 12px; background: #f0fdfa; border: 1px solid #ccfbf1; color: #0f766e; font-size: 0.8rem; font-weight: 800;">
                        <i class="fa-solid fa-dove"></i> {{ $totalBiarawan }} Biarawan/wati
                    </span>
                </div>
            </div>

            <!-- Two Sub-Cards: Imam vs Biarawan/wati -->
            <div class="row g-4">
                
                <!-- 1. Imam Asal Keluarga Umat -->
                <div class="col-lg-6">
                    <div style="background: #faf5ff; border-radius: 18px; padding: 22px; border: 1px solid #f3e8ff; height: 100%;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #ede9fe;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 36px; height: 36px; border-radius: 10px; background: #9333ea; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                                    <i class="fa-solid fa-cross"></i>
                                </div>
                                <div>
                                    <h4 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin: 0;">Imam / Pastor Asal Paroki</h4>
                                    <span style="font-size: 0.72rem; color: #6b21a8; font-weight: 600;">Pastor yang berasal dari keluarga umat paroki kita</span>
                                </div>
                            </div>
                            <span style="background: #ede9fe; color: #581c87; font-weight: 800; font-size: 0.75rem; padding: 4px 10px; border-radius: 8px;">
                                {{ $totalImam }} Jiwa
                            </span>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @forelse($imamList as $im)
                                <div style="background: #ffffff; border-radius: 14px; padding: 14px; border: 1px solid #ede9fe; display: flex; align-items: center; justify-content: space-between; gap: 14px; box-shadow: 0 2px 8px rgba(147,51,234,0.04);">
                                    <div style="display: flex; align-items: center; gap: 12px; min-width: 0;">
                                        <div style="width: 46px; height: 46px; border-radius: 12px; background: #f3e8ff; border: 1px solid #e9d5ff; overflow: hidden; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                            <img
                                                src="{{ !empty($im['foto']) ? asset($im['foto']) : asset('images/default-pastor.jpg') }}"
                                                alt="{{ $im['nama_lengkap'] }}"
                                                style="width: 100%; height: 100%; object-fit: cover;"
                                                onerror="this.src='{{ asset('images/pastor-avatar.svg') }}'"
                                            />
                                        </div>
                                        <div style="min-width: 0;">
                                            <div style="font-weight: 800; color: #0f172a; font-size: 0.88rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $im['status_panggilan'] ?? 'Imam / Pastor' }}
                                            </div>
                                            <div style="font-size: 0.75rem; font-weight: 700; color: #7e22ce; margin-top: 2px;">
                                                {{ $im['nama_ordo_kongregasi'] ?? 'Keuskupan / Ordo' }}
                                                @if(!empty($im['tempat_tugas_biara']))
                                                     <span style="font-weight: 500; color: #64748b;">• {{ $im['tempat_tugas_biara'] }}</span>
                                                @endif
                                            </div>
                                            <div style="font-size: 0.72rem; color: #64748b; margin-top: 2px; display: flex; align-items: center; gap: 4px;">
                                                <i class="fa-solid fa-house-chimney-user" style="font-size: 0.65rem;"></i>
                                                <span>Asal: <strong>{{ $im['nama_kub'] ?? 'KUB' }}</strong> ({{ $im['nama_stasi'] ?? 'Pusat Paroki' }})</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="text-align: right; flex-shrink: 0;">
                                        @if(!empty($im['tahap_panggilan']))
                                            <span style="background: #f3e8ff; color: #6b21a8; font-weight: 800; font-size: 0.72rem; padding: 4px 10px; border-radius: 6px; display: inline-block;">
                                                {{ $im['tahap_panggilan'] }}
                                            </span>
                                        @else
                                            <span style="background: #f3e8ff; color: #6b21a8; font-weight: 800; font-size: 0.72rem; padding: 4px 10px; border-radius: 6px; display: inline-block;">
                                                Imam
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 24px 16px; background: #ffffff; border-radius: 14px; border: 1px dashed #e9d5ff; color: #94a3b8; font-size: 0.8rem;">
                                    <i class="fa-solid fa-cross" style="font-size: 1.5rem; color: #d8b4fe; margin-bottom: 8px; display: block;"></i>
                                    Belum ada data imam asal paroki yang tercatat saat ini. Mari kita doakan bersama agar tumbuh benih-benih panggilan imamat dari keluarga-keluarga di paroki kita.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- 2. Biarawan / Biarawati Asal Keluarga Umat -->
                <div class="col-lg-6">
                    <div style="background: #f0fdfa; border-radius: 18px; padding: 22px; border: 1px solid #ccfbf1; height: 100%;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #99f6e4;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 36px; height: 36px; border-radius: 10px; background: #0d9488; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                                    <i class="fa-solid fa-hands-praying"></i>
                                </div>
                                <div>
                                    <h4 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin: 0;">Biarawan, Biarawati &amp; Frater</h4>
                                    <span style="font-size: 0.72rem; color: #0f766e; font-weight: 600;">Suster, Bruder, Frater, dan Novis dari keluarga umat kita</span>
                                </div>
                            </div>
                            <span style="background: #ccfbf1; color: #115e59; font-weight: 800; font-size: 0.75rem; padding: 4px 10px; border-radius: 8px;">
                                {{ $totalBiarawan }} Jiwa
                            </span>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @forelse($biarawanList as $b)
                                <div style="background: #ffffff; border-radius: 14px; padding: 14px; border: 1px solid #ccfbf1; display: flex; align-items: center; justify-content: space-between; gap: 14px; box-shadow: 0 2px 8px rgba(13,148,136,0.04);">
                                    <div style="display: flex; align-items: center; gap: 12px; min-width: 0;">
                                        <div style="width: 46px; height: 46px; border-radius: 12px; background: #e6fffa; border: 1px solid #99f6e4; overflow: hidden; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                            <img
                                                src="{{ !empty($b['foto']) ? asset($b['foto']) : asset('images/avatar-default.jpg') }}"
                                                alt="{{ $b['status_panggilan'] ?? 'Biarawan/ti' }}"
                                                style="width: 100%; height: 100%; object-fit: cover;"
                                                onerror="this.src='{{ asset('images/perempuan.jpg') }}'"
                                            />
                                        </div>
                                        <div style="min-width: 0;">
                                            <div style="font-weight: 800; color: #0f172a; font-size: 0.88rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $b['status_panggilan'] ?? 'Biarawan / Biarawati' }}
                                            </div>
                                            <div style="font-size: 0.75rem; font-weight: 700; color: #0f766e; margin-top: 2px;">
                                                {{ $b['nama_ordo_kongregasi'] ?? 'Kongregasi / Tarekat' }}
                                                @if(!empty($b['tempat_tugas_biara']))
                                                    <span style="font-weight: 500; color: #64748b;">• {{ $b['tempat_tugas_biara'] }}</span>
                                                @endif
                                            </div>
                                            <div style="font-size: 0.72rem; color: #64748b; margin-top: 2px; display: flex; align-items: center; gap: 4px;">
                                                <i class="fa-solid fa-house-chimney-user" style="font-size: 0.65rem;"></i>
                                                <span>Asal: <strong>{{ $b['nama_kub'] ?? 'KUB' }}</strong> ({{ $b['nama_stasi'] ?? 'Pusat Paroki' }})</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="text-align: right; flex-shrink: 0;">
                                        @if(!empty($b['tahap_panggilan']))
                                            <span style="background: #ccfbf1; color: #115e59; font-weight: 800; font-size: 0.72rem; padding: 4px 10px; border-radius: 6px; display: inline-block;">
                                                {{ $b['tahap_panggilan'] }}
                                            </span>
                                        @else
                                            <span style="background: #ccfbf1; color: #115e59; font-weight: 800; font-size: 0.72rem; padding: 4px 10px; border-radius: 6px; display: inline-block;">
                                                Hidup Bakti
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 24px 16px; background: #ffffff; border-radius: 14px; border: 1px dashed #99f6e4; color: #94a3b8; font-size: 0.8rem;">
                                    <i class="fa-solid fa-hands-praying" style="font-size: 1.5rem; color: #5eead4; margin-bottom: 8px; display: block;"></i>
                                    Belum ada data suster, bruder, atau frater asal paroki yang tercatat saat ini. Semoga Tuhan senantiasa menggerakkan hati orang muda kita untuk menjawab panggilan-Nya.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- ROW 3: SEBARAN TERITORI PER KUB -->
        @if(count($sebaranStats ?? []) > 0)
        <div style="background: #ffffff; border-radius: 20px; padding: 30px; box-shadow: 0 5px 22px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px;">
                <div>
                    <span style="font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--primary-teal, #00897b);">
                        Data Umat di Tiap KUB
                    </span>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 2px 0 0;">
                        Rincian jumlah umat di masing-masing Komunitas Basis
                    </h3>
                </div>
                <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(0,137,123,0.1); color: var(--primary-teal, #00897b); display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
            </div>

            <!-- Canvas Horizontal Bar Chart -->
            <div style="position: relative; height: 280px;">
                <canvas id="kubHorizontalBarChart"></canvas>
            </div>
        </div>
        @endif

        <!-- Share Buttons -->
        <div style="margin-top: 30px; background: #ffffff; border-radius: 20px; padding: 25px 35px; box-shadow: 0 5px 22px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
            @include('partials.share-buttons', ['title' => 'Statistik & Demografi Umat - ' . ($globalNamaParoki ?? 'Paroki')])
        </div>

    </div>
</section>

<!-- Include Chart.js via CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. GENDER DONUT CHART ---
    const ctxGender = document.getElementById('genderDonutChart');
    if (ctxGender) {
        new Chart(ctxGender, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki (Pria)', 'Perempuan (Wanita)'],
                datasets: [{
                    data: [{{ $genderStats['pria'] ?? 50 }}, {{ $genderStats['wanita'] ?? 50 }}],
                    backgroundColor: ['#2563eb', '#ec4899'],
                    hoverBackgroundColor: ['#1d4ed8', '#db2777'],
                    borderWidth: 3,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { family: 'Inter', size: 12, weight: '600' },
                            padding: 16,
                            usePointStyle: true,
                        }
                    }
                }
            }
        });
    }

    // --- 2. AGE DISTRIBUTION BAR CHART ---
    const ctxAge = document.getElementById('ageBarChart');
    if (ctxAge) {
        const ageLabels = {!! json_encode(array_column($usiaStats, 'label')) !!};
        const ageCounts = {!! json_encode(array_column($usiaStats, 'count')) !!};
        const ageColors = {!! json_encode(array_column($usiaStats, 'color')) !!};

        new Chart(ctxAge, {
            type: 'bar',
            data: {
                labels: ageLabels,
                datasets: [{
                    label: 'Jumlah Jiwa',
                    data: ageCounts,
                    backgroundColor: ageColors,
                    borderRadius: 8,
                    borderSkipped: false,
                    maxBarThickness: 45
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { family: 'Inter', size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Inter', size: 11, weight: '600' } }
                    }
                }
            }
        });
    }

    // --- 3. SAKRAMEN RADAR / BAR CHART ---
    const ctxSakramen = document.getElementById('sakramenRadarChart');
    if (ctxSakramen) {
        new Chart(ctxSakramen, {
            type: 'bar',
            data: {
                labels: ['Sudah Dibaptis', 'Komuni Pertama', 'Sakramen Krisma', 'Sakramen Perkawinan'],
                datasets: [{
                    label: 'Penerima Sakramen',
                    data: [
                        {{ $sakramenCount['baptis'] ?? 0 }},
                        {{ $sakramenCount['komuni'] ?? 0 }},
                        {{ $sakramenCount['krisma'] ?? 0 }},
                        {{ $sakramenCount['perkawinan'] ?? 0 }}
                    ],
                    backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ec4899'],
                    borderRadius: 8,
                    maxBarThickness: 38
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { family: 'Inter', size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Inter', size: 11, weight: '600' } }
                    }
                }
            }
        });
    }

    // --- 4. MARRIAGE DOUGHNUT CHART ---
    const ctxMarriage = document.getElementById('marriagePieChart');
    if (ctxMarriage) {
        const marrLabels = {!! json_encode(array_column($statusKawinStats, 'label')) !!};
        const marrCounts = {!! json_encode(array_column($statusKawinStats, 'count')) !!};
        const marrColors = {!! json_encode(array_column($statusKawinStats, 'color')) !!};

        new Chart(ctxMarriage, {
            type: 'doughnut',
            data: {
                labels: marrLabels,
                datasets: [{
                    data: marrCounts,
                    backgroundColor: marrColors,
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '66%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { family: 'Inter', size: 11, weight: '600' },
                            padding: 12,
                            usePointStyle: true,
                            boxWidth: 8
                        }
                    }
                }
            }
        });
    }

    // --- 5. KUB HORIZONTAL BAR CHART ---
    const ctxKub = document.getElementById('kubHorizontalBarChart');
    if (ctxKub) {
        const kubLabels = {!! json_encode(array_column($sebaranStats, 'nama')) !!};
        const kubCounts = {!! json_encode(array_column($sebaranStats, 'count')) !!};

        new Chart(ctxKub, {
            type: 'bar',
            data: {
                labels: kubLabels,
                datasets: [{
                    label: 'Jumlah Umat (Jiwa)',
                    data: kubCounts,
                    backgroundColor: 'rgba(0, 137, 123, 0.85)',
                    hoverBackgroundColor: 'rgba(0, 137, 123, 1)',
                    borderRadius: 6,
                    maxBarThickness: 24
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { family: 'Inter', size: 11 } }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { family: 'Inter', size: 11, weight: '600' } }
                    }
                }
            }
        });
    }

});
</script>
@endsection
