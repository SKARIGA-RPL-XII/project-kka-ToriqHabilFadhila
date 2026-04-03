# Dynamic Material Recommendation System

## Overview
Sistem rekomendasi materi pembelajaran yang dinamis berdasarkan analisis performa siswa. Rekomendasi dihasilkan secara otomatis ketika guru menganalisis performa siswa.

## Architecture

### Services

#### 1. MaterialRecommendationService
**File**: `app/Services/MaterialRecommendationService.php`

Menghasilkan rekomendasi materi pembelajaran berdasarkan metrik performa siswa.

**Metrik yang Dianalisis**:
- Nilai rata-rata (avg_score)
- Ketepatan waktu pengumpulan (on_time_rate)
- Konsistensi performa (variance)
- Tren performa (trend: meningkat/menurun/stabil)
- Performa per tipe tugas (pilihan_ganda, essay, praktik)
- Jumlah tugas pending

**Rekomendasi yang Dihasilkan**:
1. **Fundamentals & Basics** - Jika nilai < 60
2. **Core Concepts & Applications** - Jika nilai 60-75
3. **Time Management & Study Planning** - Jika on_time_rate < 70
4. **Consistent Learning Habits** - Jika variance > 20
5. **Review & Reinforcement** - Jika trend menurun
6. **Advanced Topics & Extensions** - Jika trend meningkat
7. **Improve [Type] Skills** - Untuk tipe tugas terlemah
8. **Enrichment & Specialization** - Jika nilai >= 85 dan completion >= 90
9. **Complete Pending Tasks** - Jika ada tugas pending

#### 2. FeedbackAIService
**File**: `app/Services/FeedbackAIService.php`

Menghasilkan dan menyimpan feedback AI dengan rekomendasi materi ke database.

**Proses**:
1. Analisis performa siswa menggunakan AIAnalysisService
2. Generate rekomendasi materi menggunakan MaterialRecommendationService
3. Ambil 5 submission terakhir yang sudah di-grade
4. Untuk setiap submission, generate:
   - Feedback text (spesifik untuk submission)
   - Suggestions (saran perbaikan)
   - Material recommendations (rekomendasi materi)
5. Simpan ke tabel feedback_ai

**Feedback Text**:
- Disesuaikan dengan nilai submission
- Mempertimbangkan tipe tugas (pilihan_ganda, essay, praktik)
- Memberikan penjelasan spesifik untuk setiap tipe

**Suggestions**:
- Berdasarkan nilai, ketepatan waktu, konsistensi, dan tren
- Actionable dan spesifik

**Material Recommendations**:
- Format: "• [Title]: [Description] ([Resources])"
- Setiap rekomendasi mencakup judul, deskripsi, dan sumber daya

### Controllers

#### AIController
**File**: `app/Http/Controllers/AIController.php`

**Endpoint Baru**:

1. **GET /siswa/submissions/{id}/feedback**
   - Mengambil feedback AI yang sudah disimpan
   - Response:
     ```json
     {
       "success": true,
       "data": {
         "feedback_text": "...",
         "saran": "...",
         "rekomendasi_materi": "...",
         "created_at": "..."
       }
     }
     ```

2. **GET /guru/ai/analyze/{userId}/{classId}** (Updated)
   - Sekarang juga generate dan save feedback dengan rekomendasi materi
   - Memanggil FeedbackAIService.generateAndSaveFeedback()

### Database

#### feedback_ai Table
```sql
- id_feedback (PK)
- id_submission (FK, unique)
- feedback_text (text)
- saran (text, nullable)
- rekomendasi_materi (text, nullable)
- created_at (timestamp)
```

### Seeders

#### FeedbackAISeeder
**File**: `database/seeders/FeedbackAISeeder.php`

Mengisi tabel feedback_ai dengan data dinamis menggunakan FeedbackAIService.

**Cara Menjalankan**:
```bash
php artisan db:seed --class=FeedbackAISeeder
```

## Flow Diagram

```
Guru Analisis Performa Siswa
    ↓
GET /guru/ai/analyze/{userId}/{classId}
    ↓
AIController.analyzeProgress()
    ↓
AIAnalysisService.analyzeStudentPerformance()
    ↓
FeedbackAIService.generateAndSaveFeedback()
    ├─ MaterialRecommendationService.generateMaterialRecommendations()
    ├─ Generate feedback_text untuk setiap submission
    ├─ Generate suggestions
    └─ Format recommendations
    ↓
Simpan ke feedback_ai table
    ↓
Siswa Lihat Feedback
    ↓
GET /siswa/submissions/{id}/feedback
    ↓
AIController.getSubmissionFeedback()
    ↓
Return feedback dengan rekomendasi materi
```

## Contoh Output

### Material Recommendations
```
• Fundamentals & Basics: Pelajari kembali konsep dasar dan definisi-definisi kunci dalam topik ini. Fokus pada pemahaman fundamental sebelum melanjutkan ke materi yang lebih kompleks. (Buku: Chapter 1-3 | Video: Introduction Series | Quiz: Basic Concepts)

• Time Management & Study Planning: Pelajari teknik manajemen waktu dan buat rencana belajar yang terstruktur. Identifikasi hambatan yang menyebabkan keterlambatan. (Resource: Time Management Guide | Tool: Study Planner | Workshop: Productivity Tips)

• Improve Essay Skills: Tugas essay memerlukan kemampuan menulis dan argumentasi yang kuat. Fokus pada struktur, logika, dan penggunaan bahasa yang tepat. (Guide: Essay Writing Structure | Video: Argumentation Techniques | Practice: Essay Samples)
```

### Feedback Text
```
Jawaban Anda untuk tugas 'Analisis Teks' telah dinilai. Performa Anda perlu ditingkatkan dengan nilai 55. Disarankan untuk mempelajari kembali materi ini dengan lebih teliti. Untuk soal essay, perhatikan struktur jawaban, logika argumentasi, dan penggunaan bahasa yang tepat.
```

### Suggestions
```
Baca kembali materi pembelajaran dan coba kerjakan soal latihan tambahan untuk memperkuat pemahaman. Coba buat jadwal belajar yang lebih terstruktur agar dapat mengumpulkan tugas tepat waktu. Tingkatkan konsistensi belajar Anda dengan membuat rutinitas harian yang teratur. Performa Anda menunjukkan tren menurun. Identifikasi hambatan yang Anda hadapi dan minta bantuan guru jika diperlukan.
```

## Integration Points

1. **Guru Dashboard**: Ketika guru klik "Analisis AI", sistem otomatis generate dan save feedback
2. **Siswa Dashboard**: Siswa bisa lihat feedback dengan rekomendasi materi di halaman submission detail
3. **Activity Logging**: Setiap analisis dicatat di activity_logs table

## Future Enhancements

1. Personalisasi rekomendasi berdasarkan learning style siswa
2. Tracking progress terhadap rekomendasi yang diberikan
3. Notifikasi otomatis ketika rekomendasi baru tersedia
4. Export rekomendasi dalam format PDF
5. Analisis tren rekomendasi untuk seluruh kelas
