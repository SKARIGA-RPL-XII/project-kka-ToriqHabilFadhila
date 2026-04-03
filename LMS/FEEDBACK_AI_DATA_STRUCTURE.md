# Struktur Data Feedback AI di Database

## Tabel: feedback_ai

### Kolom-kolom:
```
- id_feedback (PK, INT)
- id_submission (FK, INT) - Link ke submission siswa
- feedback_text (TEXT) - Profil & progress siswa
- saran (TEXT) - Saran untuk improvement
- rekomendasi_materi (LONGTEXT) - Rekomendasi materi (JSON)
- created_at (TIMESTAMP)
```

## Format Data yang Disimpan

### 1. feedback_text (Profil Siswa)
Format: Plain text dengan key-value pairs

```
Profil & Progress Belajar
========================

Mata Pelajaran: XII RPL B
Nilai Terakhir: 100
Rata-rata Nilai: 100
Progress Belajar: 1 dari 1 tugas
Completion Rate: 100%
On-Time Rate: 100%
Trend: meningkat
Consistency: Sangat Konsisten
```

**Parsing di Backend:**
- Regex untuk extract setiap field
- Fallback ke default value jika tidak ditemukan
- Determine performance_status dari avg_score atau trend

### 2. saran (Saran Improvement)
Format: Plain text dengan multiple suggestions

```
Pertahankan performa Anda yang sudah baik dengan terus belajar dan berlatih secara konsisten.
```

### 3. rekomendasi_materi (Rekomendasi Materi)
Format: **JSON Array** dengan struktur terstruktur

```json
[
  {
    "title": "Materi Pengembangan Proyek RPL",
    "description": "Untuk meningkatkan keterampilan praktis dan pengembangan proyek RPL yang lebih kompleks.",
    "resources": "Video tutorial, dokumentasi, contoh kode"
  },
  {
    "title": "Desain dan Pengembangan Sistem Informasi",
    "description": "Untuk memperluas pengetahuan tentang desain dan pengembangan sistem informasi yang lebih canggih.",
    "resources": "E-book, case studies"
  },
  {
    "title": "Pengembangan Aplikasi Mobile",
    "description": "Untuk memberikan tantangan dan pengalaman praktis dalam pengembangan aplikasi mobile yang lebih kompleks.",
    "resources": "Tutorial interaktif, project templates"
  }
]
```

## Alur Penyimpanan

### 1. Guru Analisis Siswa
```
GuruController → AIController.analyzeProgress()
  ↓
FeedbackAIService.generateAndSaveFeedback()
  ↓
AIAnalysisService.analyzeStudentPerformance()
  ↓ (generate metrics)
MaterialRecommendationService.generateMaterialRecommendations()
  ↓ (return array of recommendations)
FeedbackAIService.formatRecommendations()
  ↓ (convert to JSON)
FeedbackAI::create([
  'feedback_text' => formatStudentProfile(),
  'saran' => generateSuggestions(),
  'rekomendasi_materi' => json_encode($recommendations)
])
```

### 2. Siswa Buka Rekomendasi
```
SiswaController → AIController.getRecommendations()
  ↓
FeedbackAI::where(...)->first()
  ↓ (ambil dari database)
parseFeedbackProfile($feedback->feedback_text)
  ↓ (parse text → array)
formatRecommendationsWithLinks($feedback->rekomendasi_materi, $classIds)
  ↓ (parse JSON → HTML dengan link)
return response()->json([
  'profile' => $profile,
  'recommendations' => $html
])
```

## Contoh Response ke Frontend

```json
{
  "success": true,
  "profile": {
    "subject": "XII RPL B",
    "last_scores": "100.00",
    "avg_score": 100,
    "progress": "1 dari 1 tugas",
    "performance_status": "Baik",
    "weak_topics": "Tidak ada",
    "learning_style": "Visual & Praktik",
    "available_materials": "Belum ada materi"
  },
  "recommendations": "<div class='mb-4 p-4 bg-indigo-50 rounded-lg border-l-4 border-indigo-600'><p class='font-semibold text-gray-900'>1. Materi Pengembangan Proyek RPL <a href='/siswa/materials' class='text-indigo-600 hover:text-indigo-800 font-semibold underline'>→ Akses Materi</a></p><p class='text-sm text-gray-700 mt-2'>Untuk meningkatkan keterampilan praktis...</p></div>...",
  "from_database": true
}
```

## Keuntungan Format JSON untuk rekomendasi_materi

✅ **Terstruktur**: Mudah di-parse dan di-format
✅ **Fleksibel**: Bisa tambah field baru tanpa breaking change
✅ **Konsisten**: Setiap rekomendasi punya struktur yang sama
✅ **Linkable**: Mudah match dengan material yang ada
✅ **Readable**: Bisa di-inspect langsung di database

## Query untuk Melihat Data

```sql
-- Lihat feedback terbaru untuk siswa
SELECT * FROM feedback_ai 
WHERE id_submission IN (
  SELECT id_submission FROM submissions 
  WHERE id_user = 1
)
ORDER BY created_at DESC
LIMIT 1;

-- Parse JSON recommendations
SELECT 
  id_feedback,
  JSON_EXTRACT(rekomendasi_materi, '$[0].title') as first_recommendation,
  JSON_LENGTH(rekomendasi_materi) as total_recommendations
FROM feedback_ai;
```
